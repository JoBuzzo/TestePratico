<div>
    <div class="flex flex-col gap-10 p-6 text-gray-900">

        <div class="flex justify-between" x-show="selectedClient.id !== null" x-cloak>
            <span class="text-lg font-semibold" x-text="'Cliente: ' + selectedClient.name "></span>
            <span class="font-semibold" x-text="'CPF: ' + selectedClient.cpf"></span>
        </div>

        <div class="flex flex-col w-full" x-show="selectedProducts.length > 0" x-cloak>
            <div class="flex items-center justify-between w-full ">
                <h1 class="text-lg font-semibold">Produtos</h1>
                <div>
                    <span class="text-sm font-bold">Total:</span>
                    <span class="text-sm font-medium" x-text="'R$ ' + totalPrice"></span>
                </div>
            </div>

            <table>
                <tr class="text-sm font-bold border border-gray-200 whitespace-nowrap">
                    <th class="py-2 ">Cliente</th>
                    <th class="px-3 py-2">Preço/unidade</th>
                    <th class="px-3 py-2">Quantidade</th>
                    <th class="px-3 py-2">SubTotal</th>
                </tr>
                <template x-for="product in selectedProducts" :key="product.id">
                    <tr class="text-center border border-gray-200 whitespace-nowrap">
                        <td class="py-2" x-text="product.name"></td>
                        <td class="px-6 py-2" x-text="'R$ ' + product.price"></td>
                        <td class="px-6 py-2" x-text="product.quantity"></td>
                        <td class="px-6 py-2" x-text="'R$ ' + product.price * product.quantity"></td>
                    </tr>
                </template>
            </table>

        </div>
        <div class="flex items-start justify-between" x-show="totalPrice > 0" x-cloak>
            <form class="w-full" @submit.prevent="createParcels()">
                <div class="flex flex-col gap-10 ">
                    <div class="flex gap-2">
                        <div class="flex flex-col">
                            <label for="parcels">Parcelas</label>
                            <input type="number" id="parcels" class="w-20 p-2 border-gray-200 rounded-md"
                                min="1" x-model="parcels">
                        </div>
                        <div class="flex flex-col">
                            <label for="valueParcel">Valor</label>
                            <input type="text" id="valueParcel" class="w-20 p-2 border-gray-200 rounded-md" disabled
                                :value="getParcelPrice()">
                        </div>
                    </div>

                    <div>
                        <x-primary-button type="submit">Parcelar</x-primary-button>
                    </div>
                </div>

            </form>

            <table class="w-full mt-6">
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

    <div x-show="selectedClient.id === null || selectedProducts.length === 0" class="p-6" x-cloak>
        <p>Por favor preencha os itens!</p>
    </div>
</div>
