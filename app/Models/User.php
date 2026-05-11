<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role', 'store_id'];

    protected $hidden = ['password', 'remember_token'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function unreadMessagesCount(): int
    {
        return $this->receivedMessages()->whereNull('read_at')->count();
    }

    public function isOwner()
    {
        return $this->role === 'pemilik';
    }

    public function isManager()
    {
        return $this->role === 'manajer';
    }

    public function isSupervisor()
    {
        return $this->role === 'supervisor';
    }

    public function isCashier()
    {
        return $this->role === 'kasir';
    }

    public function isWarehouse()
    {
        return $this->role === 'gudang';
    }
}
