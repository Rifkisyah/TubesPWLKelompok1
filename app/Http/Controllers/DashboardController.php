<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Store;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $unreadMessages = $user->unreadMessagesCount();

        if ($user->isOwner()) {
            $stores = Store::withCount(['transactions', 'products'])
                ->withSum('transactions', 'total_amount')
                ->get();
            $totalTransactions = Transaction::count();
            $totalRevenue = Transaction::sum('total_amount');
            $totalProducts = Product::count();
            $lowStock = Product::where('stock', '<', 10)->count();

            $monthlyRevenue = Transaction::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Integrity check: mismatched stocks
            $integrityAlerts = DB::table('products as p')
                ->leftJoin(DB::raw('(SELECT product_id, SUM(CASE WHEN type="masuk" THEN quantity ELSE -quantity END) as movement_total FROM stock_movements GROUP BY product_id) as sm'), 'p.id', '=', 'sm.product_id')
                ->leftJoin(DB::raw('(SELECT product_id, SUM(quantity) as sold_total FROM transaction_items GROUP BY product_id) as ti'), 'p.id', '=', 'ti.product_id')
                ->select('p.id', 'p.product_name', 'p.stock',
                    DB::raw('COALESCE(sm.movement_total, 0) - COALESCE(ti.sold_total, 0) as calculated_stock'),
                    DB::raw('p.stock - (COALESCE(sm.movement_total, 0) - COALESCE(ti.sold_total, 0)) as discrepancy')
                )
                ->having('discrepancy', '!=', 0)
                ->get();

            return view('pages.dashboard', compact('stores', 'totalTransactions', 'totalRevenue', 'totalProducts', 'lowStock', 'monthlyRevenue', 'unreadMessages', 'integrityAlerts'));
        }

        $storeId = $user->store_id;
        $totalTransactions = Transaction::where('store_id', $storeId)->count();
        $totalRevenue = Transaction::where('store_id', $storeId)->sum('total_amount');
        $totalProducts = Product::where('store_id', $storeId)->count();
        $lowStock = Product::where('store_id', $storeId)->where('stock', '<', 10)->count();
        $stores = Store::where('id', $storeId)->withCount(['transactions', 'products'])->get();

        $monthlyRevenue = Transaction::where('store_id', $storeId)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $integrityAlerts = collect();

        return view('pages.dashboard', compact('stores', 'totalTransactions', 'totalRevenue', 'totalProducts', 'lowStock', 'monthlyRevenue', 'unreadMessages', 'integrityAlerts'));
    }
}
