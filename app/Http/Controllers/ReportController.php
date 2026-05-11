<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\StockMovement;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $user = auth()->user();

        // Accessible by pemilik, manajer, supervisor
        if (!in_array($user->role, ['pemilik', 'manajer', 'supervisor'])) {
            abort(403);
        }

        $query = Transaction::with(['user', 'store', 'items.product']);

        if (!$user->isOwner()) {
            $query->where('store_id', $user->store_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
        $totalRevenue = $transactions->sum('total_amount');

        return view('pages.reports.transactions', compact('transactions', 'totalRevenue'));
    }

    public function stock(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['pemilik', 'manajer', 'supervisor'])) {
            abort(403);
        }

        $query = StockMovement::with(['product', 'store', 'user']);

        if (!$user->isOwner()) {
            $query->where('store_id', $user->store_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->orderBy('created_at', 'desc')->get();

        return view('pages.reports.stock', compact('movements'));
    }

    /**
     * Laporan Pendapatan Per Cabang (accessible by pemilik, manajer, supervisor)
     */
    public function revenue(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['pemilik', 'manajer', 'supervisor'])) {
            abort(403);
        }

        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to ?? now()->toDateString();

        $storeQuery = Store::query();
        if (!$user->isOwner()) {
            $storeQuery->where('id', $user->store_id);
        }

        $stores = $storeQuery->get();

        $revenueData = [];
        foreach ($stores as $store) {
            $currentRevenue = Transaction::where('store_id', $store->id)
                ->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo)
                ->sum('total_amount');

            $prevStart = now()->subMonth()->startOfMonth()->toDateString();
            $prevEnd   = now()->subMonth()->endOfMonth()->toDateString();
            $prevRevenue = Transaction::where('store_id', $store->id)
                ->whereDate('created_at', '>=', $prevStart)
                ->whereDate('created_at', '<=', $prevEnd)
                ->sum('total_amount');

            $change = $prevRevenue > 0
                ? round((($currentRevenue - $prevRevenue) / $prevRevenue) * 100, 1)
                : ($currentRevenue > 0 ? 100 : 0);

            $transactionCount = Transaction::where('store_id', $store->id)
                ->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo)
                ->count();

            $revenueData[] = [
                'store'             => $store,
                'current_revenue'   => $currentRevenue,
                'prev_revenue'      => $prevRevenue,
                'change_percent'    => $change,
                'transaction_count' => $transactionCount,
                'trend'             => $change >= 0 ? 'up' : 'down',
            ];
        }

        // Sort by current revenue descending
        usort($revenueData, fn($a, $b) => $b['current_revenue'] - $a['current_revenue']);

        $totalCurrentRevenue = array_sum(array_column($revenueData, 'current_revenue'));

        return view('pages.reports.revenue', compact('revenueData', 'totalCurrentRevenue', 'dateFrom', 'dateTo'));
    }

    /**
     * Laporan Integritas Data (hanya pemilik)
     */
    public function integrity()
    {
        if (!auth()->user()->isOwner()) {
            abort(403, 'Hanya Pemilik yang dapat mengakses laporan integritas data.');
        }

        $products = Product::with(['store', 'category'])->get();

        $alerts = [];
        foreach ($products as $product) {
            $stockIn = StockMovement::where('product_id', $product->id)
                ->where('type', 'masuk')
                ->sum('quantity');

            $stockOut = StockMovement::where('product_id', $product->id)
                ->where('type', 'keluar')
                ->sum('quantity');

            $sold = DB::table('transaction_items')
                ->where('product_id', $product->id)
                ->sum('quantity');

            $calculatedStock = $stockIn - $stockOut - $sold;
            $discrepancy = $product->stock - $calculatedStock;

            $alerts[] = [
                'product'          => $product,
                'stock_in'         => $stockIn,
                'stock_out'        => $stockOut,
                'sold'             => $sold,
                'calculated_stock' => $calculatedStock,
                'recorded_stock'   => $product->stock,
                'discrepancy'      => $discrepancy,
                'is_suspicious'    => $discrepancy != 0,
            ];
        }

        $suspiciousCount = count(array_filter($alerts, fn($a) => $a['is_suspicious']));

        return view('pages.reports.integrity', compact('alerts', 'suspiciousCount'));
    }
}
