<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Compra
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="flex flex-col gap-10 p-6 text-gray-900">

                    <div class="flex justify-between">
                        <span class="text-lg font-semibold">{{ $purchase->client->name }}</span>
                        <span class="font-semibold">{{ $purchase->client->cpf }}</span>
                    </div>

                    <div class="flex flex-col w-full">
                        <div class="flex items-center justify-between w-full ">
                            <h1 class="text-lg font-semibold">Produtos</h1>
                            <div>
                                <span class="text-sm font-bold">Total:</span>
                                <span class="text-sm font-medium">R$ {{ $purchase->total }}</span>
                            </div>
                        </div>

                        <table>
                            <tr class="text-sm font-bold border border-gray-200 whitespace-nowrap">
                                <th class="py-2 ">Cliente</th>
                                <th class="px-3 py-2">Preço/unidade
                                    ({{ date('d/m/Y', strtotime($purchase->created_at)) }})</th>
                                <th class="px-3 py-2">Quantidade</th>
                                <th class="px-3 py-2">SubTotal</th>
                            </tr>
                            @foreach ($purchase->products as $product)
                                <tr class="text-center border border-gray-200 whitespace-nowrap">
                                    <td class="py-2 ">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-2">
                                        R$ {{ $product->pivot->price }}
                                    </td>
                                    <td class="px-6 py-2">
                                        {{ $product->pivot->quantity }}
                                    </td>
                                    <td class="px-6 py-2">
                                        R$ {{ $product->pivot->quantity * $product->pivot->price }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>



                    <div class="flex items-start justify-between" x-data="app">
                        <form class="w-full" @submit.prevent="createParcels()">
                            <div class="flex flex-col gap-10 ">
                                <div class="flex flex-col">
                                    <label for="parcels">Quantidade de parcelas</label>
                                    <input type="number" id="parcels" class="p-2 border-gray-200 rounded-md w-44"
                                        min="1" x-model="parcels">

                                    <label for="valueParcel">Valor da parcela</label>
                                    <input type="text" id="valueParcel" class="p-2 border-gray-200 rounded-md w-44"
                                        disabled :value="getParcelPrice()">
                                </div>

                                <div>
                                    <x-primary-button type="submit">Parcelar</x-primary-button>
                                </div>
                            </div>


                        </form>

                        <table class="w-full">
                            <thead>
                                <tr class="text-sm font-bold border border-gray-200 whitespace-nowrap">
                                    <th class="py-2 ">Data</th>
                                    <th class="py-2 ">Valor</th>
                                    <th class="py-2 ">Forma de pagamento</th>
                                </tr>
                            </thead>
                                <template x-for="(parcel, index) in listParcels" :key="index">
                                    <tr class="h-10 text-center border border-gray-200 whitespace-nowrap">
                                        <td class="px-6 text-center" x-text="parcel.date"></td>
                                        <td class="px-6 text-center" x-text="parcel.value"></td>
                                        <td class="px-6 text-center" x-text="parcel.payment"></td>
                                    </tr>
                                </template>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('app', () => ({
            totalPrice: @js($purchase->total),
            parcels: 1,
            listParcels: [],

            createParcels() {
                this.listParcels = [];

                let parcelValue = this.getParcelPrice();

                let currentDate = new Date();

                for (let i = 0; i < this.parcels - 1; i++) {
                    currentDate.setMonth(currentDate.getMonth() + 1);

                    this.listParcels.push({
                        date: this.formatDate(currentDate),
                        value: parcelValue,
                        payment: 'Boleto',
                    });
                }

                currentDate.setMonth(currentDate.getMonth() + 1);
                this.listParcels.push({
                    date: this.formatDate(currentDate),
                    value: (this.totalPrice - (this.parcels - 1) * parcelValue).toFixed(2),
                    payment: 'Boleto',
                });

            },
            getParcelPrice() {
                return parseFloat((this.totalPrice / this.parcels).toFixed(2));
            },

            formatDate(date) {
                return (date.getDate()).toString().padStart(2, '0') + '/' + (date.getMonth() + 1).toString().padStart(2, '0') + '/' + date.getFullYear();
            },
        }))
    })
</script>
