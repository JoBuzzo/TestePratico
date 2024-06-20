<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (count($purchases) > 0)
                        <table class="w-full text-center border">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3">#</th>
                                    <th class="px-6 py-3">Cliente</th>
                                    <th class="px-6 py-3">Produtos</th>
                                    <th class="px-6 py-3">Parcelas</th>
                                    <th class="px-6 py-3">Total</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                    <tr class="border border-gray-200">
                                        <td class="px-6 py-3">{{ $purchase->id }}</td>
                                        <td class="px-6 py-3">{{ $purchase->client->name }}</td>
                                        <td class="px-6 py-3">{{ $purchase->products_count }}</td>
                                        <td class="px-6 py-3">{{ $purchase->parcels_count }}</td>
                                        <td class="px-6 py-3">R$ {{ $purchase->total }}</td>
                                        <td class="px-6 py-3">
                                            <a href="{{ route('purchase.show', $purchase) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                Visualizar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-lg">
                            Não há compras registradas.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
