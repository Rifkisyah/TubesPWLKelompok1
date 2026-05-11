<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =============================================
    // STORES — hanya pemilik (full CRUD)
    // =============================================
    Route::resource('stores', StoreController::class)->middleware('role:pemilik');

    // =============================================
    // PRODUCTS — kasir tidak bisa; pemilik & manajer hanya read;
    //            supervisor & gudang full CRUD
    // =============================================
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('role:supervisor,gudang');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->missing(fn() => redirect()->route('products.index'));
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('role:supervisor,gudang');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('role:supervisor,gudang');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('role:supervisor,gudang');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('role:supervisor,gudang'); 

    // =============================================
    // CATEGORIES — kasir & gudang tidak bisa akses;
    //              pemilik & manajer hanya index;
    //              supervisor full CRUD
    // =============================================
    Route::get('/categories', [ProductCategoryController::class, 'index'])->name('categories.index')->middleware('role:pemilik,manajer,supervisor');
    Route::get('/categories/create', [ProductCategoryController::class, 'create'])->name('categories.create')->middleware('role:supervisor');
    Route::post('/categories', [ProductCategoryController::class, 'store'])->name('categories.store')->middleware('role:supervisor');
    Route::get('/categories/{category}/edit', [ProductCategoryController::class, 'edit'])->name('categories.edit')->middleware('role:supervisor');
    Route::put('/categories/{category}', [ProductCategoryController::class, 'update'])->name('categories.update')->middleware('role:supervisor');
    Route::delete('/categories/{category}', [ProductCategoryController::class, 'destroy'])->name('categories.destroy')->middleware('role:supervisor');

    // =============================================
    // TRANSACTIONS — gudang tidak bisa;
    //               pemilik & manajer hanya read;
    //               kasir & supervisor bisa create
    // =============================================
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index')->middleware('role:pemilik,manajer,supervisor,kasir');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create')->middleware('role:kasir,supervisor');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store')->middleware('role:kasir,supervisor');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show')->middleware('role:pemilik,manajer,supervisor,kasir');

    // =============================================
    // STOCK — kasir tidak bisa;
    //         pemilik & manajer hanya read;
    //         gudang & supervisor bisa create
    // =============================================
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index')->middleware('role:pemilik,manajer,supervisor,gudang');
    Route::get('/stock/movements', [StockController::class, 'movements'])->name('stock.movements')->middleware('role:pemilik,manajer,supervisor,gudang');
    Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create')->middleware('role:supervisor,gudang');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store')->middleware('role:supervisor,gudang');

    // =============================================
    // REPORTS
    // =============================================
    Route::middleware('role:pemilik,manajer,supervisor')->group(function () {
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
        Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    });
    Route::get('/reports/integrity', [ReportController::class, 'integrity'])->name('reports.integrity')->middleware('role:pemilik');

    // =============================================
    // USERS — hanya pemilik (full CRUD)
    // =============================================
    Route::resource('users', UserController::class)->middleware('role:pemilik');

    // =============================================
    // SUPERVISORS — manajer mengelola supervisor cabangnya
    // =============================================
    Route::resource('supervisors', SupervisorController::class)->middleware('role:manajer');

    // =============================================
    // STAFF (kasir & gudang) — supervisor mengelola staff cabangnya
    // =============================================
    Route::resource('staff', StaffController::class)->middleware('role:supervisor');

    // =============================================
    // MESSAGES — semua role bisa akses
    // =============================================
    Route::get('/messages', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');
    Route::get('/messages/compose', [MessageController::class, 'compose'])->name('messages.compose');
    Route::post('/messages', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});
