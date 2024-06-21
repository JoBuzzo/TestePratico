<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="app">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <div class="flex w-1/2 gap-2">
                            <input type="text" class="w-full p-2 mb-1 border-gray-200 rounded-md"
                                x-model="searchClient" placeholder="Filtrar por cliente">
                            <input type="text" class="w-full p-2 mb-1 border-gray-200 rounded-md"
                                x-model="searchUser" placeholder="Filtrar por vendedor">
                        </div>

                        <a href="{{ route('purchase.create') }}" class="text-indigo-600 hover:text-indigo-900">
                            Nova Compra
                        </a>
                    </div>


                    @if (count($purchases) > 0)
                        <table class="w-full text-center border">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3">#</th>
                                    <th class="px-6 py-3">Cliente</th>
                                    <th class="px-6 py-3">vendedor</th>
                                    <th class="px-6 py-3">
                                        <div class="flex items-center justify-end gap-2 cursor-pointer select-none"
                                            @click="orderProduct = !orderProduct; resetOrders('product')">
                                            Produtos
                                            <div x-show="orderProduct">
                                                <x-icon-filter-up />
                                            </div>
                                            <div x-show="!orderProduct">
                                                <x-icon-filter-down />
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3">
                                        <div class="flex items-center justify-end gap-2 cursor-pointer select-none"
                                            @click="orderParcel = !orderParcel; resetOrders('parcel')">
                                            Parcelas
                                            <div x-show="orderParcel">
                                                <x-icon-filter-up />
                                            </div>
                                            <div x-show="!orderParcel">
                                                <x-icon-filter-down />
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3">
                                        <div class="flex items-center justify-end gap-2 cursor-pointer select-none"
                                            @click="orderTotal = !orderTotal; resetOrders('total')">
                                            Total
                                            <div x-show="orderTotal">
                                                <x-icon-filter-up />
                                            </div>
                                            <div x-show="!orderTotal">
                                                <x-icon-filter-down />
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="purchase in filterPurchases()">
                                    <tr class="border border-gray-200">
                                        <td class="px-6 py-3" x-text="purchase.id"></td>
                                        <td class="px-6 py-3" x-text="purchase.client.name"></td>
                                        <td class="px-6 py-3" x-text="purchase.user.name"></td>
                                        <td class="px-6 py-3" x-text="purchase.products_count"></td>
                                        <td class="px-6 py-3" x-text="purchase.parcels_count"></td>
                                        <td class="px-6 py-3" x-text="purchase.total"></td>
                                        <td class="px-6 py-3">
                                            <a :href="'compra/' + purchase.id"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                Visualizar
                                            </a>
                                        </td>
                                    </tr>
                                </template>

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

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('app', () => ({
                    purchases: @json($purchases),
                    searchClient: '',
                    searchUser: '',
                    orderProduct: false,
                    orderParcel: false,
                    orderTotal: false,
                    resetOrders(order) {

                        if (this.orderTotal === true && order === 'total') {
                            this.orderProduct = false
                            this.orderParcel = false

                        } else if (this.orderProduct === true && order === 'product') {

                            this.orderParcel = false
                            this.orderTotal = false

                        } else if (this.orderParcel === true && order === 'parcel') {

                            this.orderTotal = false
                            this.orderProduct = false
                        }
                    },
                    filterPurchases() {

                        purchases = this.purchases.filter(
                            product => product.client.name.toLowerCase().startsWith(this.searchClient.toLowerCase())
                        )

                        purchases = purchases.filter(
                            product => product.user.name.toLowerCase().startsWith(this.searchUser.toLowerCase())
                        )

                        purchases = purchases.sort((a, b) => {
                            if (this.orderProduct) {
                                return a.products_count - b.products_count
                            }
                            if (this.orderParcel) {
                                return a.parcels_count - b.parcels_count
                            }
                            if (this.orderTotal) {
                                return a.total - b.total
                            }
                        })

                        return purchases
                    }
                }))
            })
        </script>


    </div>
</x-app-layout>
