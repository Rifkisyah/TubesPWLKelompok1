<aside class="fixed inset-y-0 left-0 w-64 sidebar-gradient z-30">
    <div class="p-6 border-b border-white border-opacity-10">
        <h1 class="text-white text-xl font-bold tracking-wide">
            <i class="fas fa-store mr-2"></i>JayMart
        </h1>
        <p class="text-blue-200 text-xs mt-1">Sistem Manajemen Mini Market</p>
    </div>

    <nav class="mt-4 px-3 space-y-1 overflow-y-auto" style="max-height: calc(100vh - 130px);">
        {{-- Dashboard: semua role --}}
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
            <i class="fas fa-tachometer-alt w-5 mr-3"></i> Dashboard
        </a>

        {{-- ========== PEMILIK ========== --}}
        @if(auth()->user()->isOwner())
            <a href="{{ route('stores.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('stores.*') ? 'nav-active' : '' }}">
                <i class="fas fa-building w-5 mr-3"></i> Cabang Toko
            </a>
            <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('transactions.*') ? 'nav-active' : '' }}">
                <i class="fas fa-cash-register w-5 mr-3"></i> Transaksi <span class="ml-auto text-xs bg-blue-800 rounded px-1">Lihat</span>
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('products.*') ? 'nav-active' : '' }}">
                <i class="fas fa-box w-5 mr-3"></i> Produk <span class="ml-auto text-xs bg-blue-800 rounded px-1">Lihat</span>
            </a>
            <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('categories.*') ? 'nav-active' : '' }}">
                <i class="fas fa-tags w-5 mr-3"></i> Kategori <span class="ml-auto text-xs bg-blue-800 rounded px-1">Lihat</span>
            </a>
            <a href="{{ route('stock.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('stock.*') ? 'nav-active' : '' }}">
                <i class="fas fa-warehouse w-5 mr-3"></i> Stok <span class="ml-auto text-xs bg-blue-800 rounded px-1">Lihat</span>
            </a>
            <div class="pt-3 mt-3 border-t border-white border-opacity-10">
                <p class="px-4 text-xs text-blue-300 uppercase tracking-wider mb-2">Laporan</p>
                <a href="{{ route('reports.revenue') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.revenue') ? 'nav-active' : '' }}">
                    <i class="fas fa-chart-bar w-5 mr-3"></i> Pendapatan Cabang
                </a>
                <a href="{{ route('reports.transactions') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.transactions') ? 'nav-active' : '' }}">
                    <i class="fas fa-file-invoice-dollar w-5 mr-3"></i> Laporan Transaksi
                </a>
                <a href="{{ route('reports.stock') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.stock') ? 'nav-active' : '' }}">
                    <i class="fas fa-clipboard-list w-5 mr-3"></i> Laporan Stok
                </a>
                // FIXME
                {{-- <a href="{{ route('reports.integrity') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.integrity') ? 'nav-active' : '' }}">
                    <i class="fas fa-shield-alt w-5 mr-3"></i> Integritas Data
                    @php $intCount = \App\Models\Product::count(); @endphp
                </a> --}}
                // FIXME
            </div>
            <div class="pt-3 mt-3 border-t border-white border-opacity-10">
                <p class="px-4 text-xs text-blue-300 uppercase tracking-wider mb-2">Pengaturan</p>
                <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('users.*') ? 'nav-active' : '' }}">
                    <i class="fas fa-users-cog w-5 mr-3"></i> Manajemen User
                </a>
            </div>
        @endif

        {{-- ========== MANAJER ========== --}}
        @if(auth()->user()->isManager())
            <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('transactions.*') ? 'nav-active' : '' }}">
                <i class="fas fa-cash-register w-5 mr-3"></i> Transaksi <span class="ml-auto text-xs bg-blue-800 rounded px-1">Lihat</span>
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('products.*') ? 'nav-active' : '' }}">
                <i class="fas fa-box w-5 mr-3"></i> Produk <span class="ml-auto text-xs bg-blue-800 rounded px-1">Lihat</span>
            </a>
            <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('categories.*') ? 'nav-active' : '' }}">
                <i class="fas fa-tags w-5 mr-3"></i> Kategori <span class="ml-auto text-xs bg-blue-800 rounded px-1">Lihat</span>
            </a>
            <a href="{{ route('stock.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('stock.*') ? 'nav-active' : '' }}">
                <i class="fas fa-warehouse w-5 mr-3"></i> Stok <span class="ml-auto text-xs bg-blue-800 rounded px-1">Lihat</span>
            </a>
            <div class="pt-3 mt-3 border-t border-white border-opacity-10">
                <p class="px-4 text-xs text-blue-300 uppercase tracking-wider mb-2">Laporan</p>
                <a href="{{ route('reports.revenue') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.revenue') ? 'nav-active' : '' }}">
                    <i class="fas fa-chart-bar w-5 mr-3"></i> Pendapatan
                </a>
                <a href="{{ route('reports.transactions') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.transactions') ? 'nav-active' : '' }}">
                    <i class="fas fa-file-invoice-dollar w-5 mr-3"></i> Laporan Transaksi
                </a>
                <a href="{{ route('reports.stock') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.stock') ? 'nav-active' : '' }}">
                    <i class="fas fa-clipboard-list w-5 mr-3"></i> Laporan Stok
                </a>
            </div>
            <div class="pt-3 mt-3 border-t border-white border-opacity-10">
                <p class="px-4 text-xs text-blue-300 uppercase tracking-wider mb-2">Kelola Tim</p>
                <a href="{{ route('supervisors.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('supervisors.*') ? 'nav-active' : '' }}">
                    <i class="fas fa-user-tie w-5 mr-3"></i> Kelola Supervisor
                </a>
            </div>
        @endif

        {{-- ========== SUPERVISOR ========== --}}
        @if(auth()->user()->isSupervisor())
            <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('transactions.*') ? 'nav-active' : '' }}">
                <i class="fas fa-cash-register w-5 mr-3"></i> Transaksi
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('products.*') ? 'nav-active' : '' }}">
                <i class="fas fa-box w-5 mr-3"></i> Produk
            </a>
            <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('categories.*') ? 'nav-active' : '' }}">
                <i class="fas fa-tags w-5 mr-3"></i> Kategori
            </a>
            <a href="{{ route('stock.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('stock.*') ? 'nav-active' : '' }}">
                <i class="fas fa-warehouse w-5 mr-3"></i> Stok
            </a>
            <div class="pt-3 mt-3 border-t border-white border-opacity-10">
                <p class="px-4 text-xs text-blue-300 uppercase tracking-wider mb-2">Laporan</p>
                <a href="{{ route('reports.revenue') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.revenue') ? 'nav-active' : '' }}">
                    <i class="fas fa-chart-bar w-5 mr-3"></i> Pendapatan
                </a>
                <a href="{{ route('reports.transactions') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.transactions') ? 'nav-active' : '' }}">
                    <i class="fas fa-file-invoice-dollar w-5 mr-3"></i> Laporan Transaksi
                </a>
                <a href="{{ route('reports.stock') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('reports.stock') ? 'nav-active' : '' }}">
                    <i class="fas fa-clipboard-list w-5 mr-3"></i> Laporan Stok
                </a>
            </div>
            <div class="pt-3 mt-3 border-t border-white border-opacity-10">
                <p class="px-4 text-xs text-blue-300 uppercase tracking-wider mb-2">Kelola Staff</p>
                <a href="{{ route('staff.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('staff.*') ? 'nav-active' : '' }}">
                    <i class="fas fa-users w-5 mr-3"></i> Kasir & Gudang
                </a>
            </div>
        @endif

        {{-- ========== KASIR ========== --}}
        @if(auth()->user()->isCashier())
            <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('transactions.*') ? 'nav-active' : '' }}">
                <i class="fas fa-cash-register w-5 mr-3"></i> Transaksi
            </a>
        @endif

        {{-- ========== GUDANG ========== --}}
        @if(auth()->user()->isWarehouse())
            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('products.*') ? 'nav-active' : '' }}">
                <i class="fas fa-box w-5 mr-3"></i> Produk
            </a>
            <a href="{{ route('stock.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('stock.*') ? 'nav-active' : '' }}">
                <i class="fas fa-warehouse w-5 mr-3"></i> Stok
            </a>
        @endif

        {{-- ========== MESSAGES — semua role ========== --}}
        <div class="pt-3 mt-3 border-t border-white border-opacity-10">
            <p class="px-4 text-xs text-blue-300 uppercase tracking-wider mb-2">Komunikasi</p>
            <a href="{{ route('messages.inbox') }}" class="flex items-center px-4 py-3 text-sm text-gray-200 rounded-lg nav-hover {{ request()->routeIs('messages.*') ? 'nav-active' : '' }}">
                <i class="fas fa-envelope w-5 mr-3"></i> Pesan
                @php $unread = auth()->user()->unreadMessagesCount(); @endphp
                @if($unread > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-0.5">{{ $unread }}</span>
                @endif
            </a>
        </div>
    </nav>
</aside>
