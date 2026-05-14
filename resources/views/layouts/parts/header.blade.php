<header class="bg-white border-b px-6 py-4 flex justify-between items-center sticky top-0 z-20">
    <div>
        <h2 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
        <p class="text-sm text-gray-500">@yield('page-subtitle', '')</p>
    </div>

    <div class="flex items-center gap-4">
        <div class="text-right">
            <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-500">
                {{ ucfirst(auth()->user()->role) }}
                @if(auth()->user()->store)
                    - {{ auth()->user()->store->store_name }}
                @endif
            </p>
        </div>
        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
            <i class="fas fa-user text-blue-600"></i>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Logout">
                <i class="fas fa-sign-out-alt text-lg"></i>
            </button>
        </form>
    </div>
</header>
