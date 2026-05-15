@extends('layouts.app')

@section('title', 'Laporan Pendapatan - JayMart')
@section('page-title', 'Laporan Pendapatan')

@section('content')
<div class="mb-6 bg-white rounded-xl card-shadow p-6 flex flex-col gap-6 sidebar-gradient">
    <form method="GET" class="flex gap-4 items-end flex-wrap justify-end">
        <div>
            <label class="block text-sm font-medium text-white mb-1">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="border rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-white mb-1">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="border rounded-lg px-3 py-2 text-sm">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 h-10">
            <i class="fas fa-search mr-1"></i> Tampilkan
        </button>
        <button type="button" onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 h-10">
            <i class="fas fa-print mr-1"></i> Cetak
        </button>
    </form>
    <div class="bg-white rounded-xl p-6 card-shadow">
        <p class="text-sm text-gray-500">Total Pendapatan Keseluruhan</p>
        <p class="text-2xl font-bold text-green-600 mt-1">Rp {{ number_format($totalCurrentRevenue, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">Periode: {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}</p>
    </div>
</div>

{{-- Summary Card --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">


    @if (auth()->user()->isOwner())
        <div class="bg-white rounded-xl p-6 card-shadow">
            <p class="text-sm text-gray-500">Jumlah Cabang</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ count($revenueData) }}</p>
            <p class="text-xs text-gray-400 mt-1">Cabang aktif dalam periode ini</p>
        </div>
        <div class="bg-white rounded-xl p-6 card-shadow">
            <p class="text-sm text-gray-500">Cabang Terbaik</p>
            @if(count($revenueData) > 0)
            <p class="text-lg font-bold text-purple-600 mt-1">{{ $revenueData[0]['store']->store_name }}</p>
            <p class="text-xs text-gray-400 mt-1">Rp {{ number_format($revenueData[0]['current_revenue'], 0, ',', '.') }}</p>
            @else
            <p class="text-lg text-gray-400 mt-1">-</p>
            @endif
        </div>
    @endif
</div>

{{-- Revenue Table --}}
<div class="bg-white rounded-xl card-shadow overflow-hidden mb-6">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Rincian Pendapatan Per Cabang</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Cabang</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Kota</th>
                    <th class="text-right py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Jml. Transaksi</th>
                    <th class="text-right py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Pendapatan Periode Ini</th>
                    <th class="text-right py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Bulan Lalu</th>
                    <th class="text-center py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Tren</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($revenueData as $index => $row)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs flex items-center justify-center font-bold">{{ $index + 1 }}</span>
                            <span class="font-medium text-gray-800 text-sm">{{ $row['store']->store_name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $row['store']->city }}</td>
                    <td class="py-3 px-6 text-sm text-right text-gray-700">{{ number_format($row['transaction_count']) }}</td>
                    <td class="py-3 px-6 text-right">
                        <span class="font-semibold text-gray-800 text-sm">Rp {{ number_format($row['current_revenue'], 0, ',', '.') }}</span>
                    </td>
                    <td class="py-3 px-6 text-right text-sm text-gray-500">Rp {{ number_format($row['prev_revenue'], 0, ',', '.') }}</td>
                    <td class="py-3 px-6 text-center">
                        @if($row['trend'] === 'up')
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">
                                <i class="fas fa-arrow-up"></i> {{ $row['change_percent'] }}%
                            </span>
                        @elseif($row['change_percent'] == 0)
                            <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-1 rounded-full">
                                <i class="fas fa-minus"></i> 0%
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded-full">
                                <i class="fas fa-arrow-down"></i> {{ abs($row['change_percent']) }}%
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-8 text-center text-gray-400">Tidak ada data pendapatan untuk periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Chart --}}
@if(count($revenueData) > 0)
<div class="bg-white rounded-xl card-shadow p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Perbandingan Pendapatan</h3>
    <canvas id="revenueChart" height="100"></canvas>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    const labels = @json(array_column($revenueData, 'store') ? array_map(fn($r) => $r['store']->store_name, $revenueData) : []);
    const currentData = @json(array_column($revenueData, 'current_revenue'));
    const prevData = @json(array_column($revenueData, 'prev_revenue'));

    // Rebuild labels from PHP
    const storeLabels = {!! json_encode(array_map(fn($r) => $r['store']->store_name, $revenueData)) !!};
    const currentRevenue = {!! json_encode(array_column($revenueData, 'current_revenue')) !!};
    const prevRevenue = {!! json_encode(array_column($revenueData, 'prev_revenue')) !!};

    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: storeLabels,
            datasets: [
                {
                    label: 'Periode Ini (Rp)',
                    data: currentRevenue,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                },
                {
                    label: 'Bulan Lalu (Rp)',
                    data: prevRevenue,
                    backgroundColor: 'rgba(156, 163, 175, 0.5)',
                    borderColor: 'rgba(156, 163, 175, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top' },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                    }
                }
            },
            scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } }
        }
    });
</script>
@endpush
