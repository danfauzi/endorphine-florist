<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pelanggan - Riwayat Pesanan Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Status Buket Pesanan Kamu</h3>
                @forelse($myOrders as $order)
                    <div class="border rounded-lg p-4 mb-3 flex justify-between items-center">
                        <div>
                            <p class="font-bold text-lg">{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-500">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">{{ ucfirst($order->status) }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Kamu belum memiliki riwayat pemesanan.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout> 