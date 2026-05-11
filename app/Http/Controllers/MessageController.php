<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Return list of users this user can contact based on role hierarchy
     */
    private function getContactableUsers(): \Illuminate\Database\Eloquent\Collection
    {
        $user = auth()->user();

        return match($user->role) {
            // Pemilik bisa kontak semua manajer
            'pemilik' => User::where('role', 'manajer')->with('store')->get(),

            // Manajer bisa kontak pemilik + supervisor di cabangnya
            'manajer' => User::where('role', 'pemilik')
                ->orWhere(fn($q) => $q->where('role', 'supervisor')->where('store_id', $user->store_id))
                ->with('store')->get(),

            // Supervisor bisa kontak manajer cabangnya + kasir/gudang di cabangnya
            'supervisor' => User::where(fn($q) => $q->where('role', 'manajer')->where('store_id', $user->store_id))
                ->orWhere(fn($q) => $q->whereIn('role', ['kasir', 'gudang'])->where('store_id', $user->store_id))
                ->with('store')->get(),

            // Kasir dan gudang bisa kontak supervisor di cabangnya
            'kasir', 'gudang' => User::where('role', 'supervisor')
                ->where('store_id', $user->store_id)
                ->with('store')->get(),

            default => collect(),
        };
    }

    public function inbox()
    {
        $user = auth()->user();
        $messages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = Message::where('receiver_id', $user->id)->whereNull('read_at')->count();

        return view('pages.messages.inbox', compact('messages', 'unreadCount'));
    }

    public function sent()
    {
        $user = auth()->user();
        $messages = Message::where('sender_id', $user->id)
            ->with('receiver')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('pages.messages.sent', compact('messages'));
    }

    public function compose(Request $request)
    {
        $contacts = $this->getContactableUsers();
        $selectedReceiverId = $request->query('to');
        return view('pages.messages.compose', compact('contacts', 'selectedReceiverId'));
    }

    public function send(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject'     => 'required|string|max:255',
            'body'        => 'required|string|max:5000',
        ]);

        // Validate receiver is in contactable list
        $contactableIds = $this->getContactableUsers()->pluck('id');
        if (!$contactableIds->contains($request->receiver_id)) {
            return back()->withErrors(['receiver_id' => 'Anda tidak memiliki izin untuk mengirim pesan ke pengguna ini.']);
        }

        Message::create([
            'sender_id'   => $user->id,
            'receiver_id' => $request->receiver_id,
            'subject'     => $request->subject,
            'body'        => $request->body,
        ]);

        return redirect()->route('messages.sent')->with('success', 'Pesan berhasil dikirim.');
    }

    public function show(Message $message)
    {
        $user = auth()->user();
        if ($message->receiver_id !== $user->id && $message->sender_id !== $user->id) {
            abort(403);
        }

        // Mark as read if receiver
        if ($message->receiver_id === $user->id) {
            $message->markAsRead();
        }

        $contacts = $this->getContactableUsers();

        return view('pages.messages.show', compact('message', 'contacts'));
    }

    public function reply(Request $request, Message $message)
    {
        $user = auth()->user();
        // Can only reply if receiver or sender
        if ($message->receiver_id !== $user->id && $message->sender_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $replyTo = $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;

        // Check contactable
        $contactableIds = $this->getContactableUsers()->pluck('id');
        if (!$contactableIds->contains($replyTo)) {
            return back()->withErrors(['body' => 'Anda tidak memiliki izin untuk membalas pesan ini.']);
        }

        Message::create([
            'sender_id'   => $user->id,
            'receiver_id' => $replyTo,
            'subject'     => 'Re: ' . $message->subject,
            'body'        => $request->body,
        ]);

        return redirect()->route('messages.inbox')->with('success', 'Balasan berhasil dikirim.');
    }

    public function destroy(Message $message)
    {
        $user = auth()->user();
        if ($message->receiver_id !== $user->id && $message->sender_id !== $user->id) {
            abort(403);
        }
        $message->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
