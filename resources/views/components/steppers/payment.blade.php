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
                    <th class="py-2 ">Produto</th>
                    <th class="px-3 py-2">Preço/unidade</th>
                    <th class="px-3 py-2">Quantidade</th>
                    <th class="px-3 py-2">SubTotal</th>
                </tr>
                <template x-for="product in selectedProducts" :key="product.id">
                    <tr class="text-center border border-gray-200 whitespace-nowrap">
                        <td class="py-2" x-text="product.name"></td>
                        <td class="px-6 py-2" x-text="'R$ ' + product.price"></td>
                        <td class="px-6 py-2" x-text="product.quantity"></td>
                        <td class="px-6 py-2" x-text="'R$ ' + (product.price * product.quantity).toFixed(2)"></td>
                    </tr>
                </template>
            </table>

        </div>
        <div class="flex items-start justify-between" x-show="totalPrice > 0" x-cloak>
            <form class="w-full" @submit.prevent="createParcels()">
                <div class="flex flex-col gap-2 ">
                    <h1 class="mb-2 text-lg font-semibold">Parcelar</h1>
                    <div class="flex gap-2">
                        <div class="flex flex-col">
                            <label for="parcels">Parcelas</label>
                            <input type="number" id="parcels" class="w-20 p-2 border-gray-200 rounded-md"
                                min="1" x-model="parcels" @input="canSubmit = false; listParcels = []">
                        </div>
                        <div class="flex flex-col">
                            <label for="valueParcel">Valor</label>
                            <input type="text" id="valueParcel" class="w-20 p-2 border-gray-200 rounded-md" disabled
                                :value="getParcelPrice()">
                        </div>
                        <div class="flex flex-col">
                            <span>Resetar</span>
                            <button @click="refreshParcels()"
                                class="flex items-center justify-center p-2 text-sm font-semibold text-gray-700 border border-gray-200 rounded-md hover:bg-gray-100 size-11">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-ccw">
                                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                    <path d="M3 3v5h5" />
                                    <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                                    <path d="M16 16h5v5" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <x-primary-button type="submit">Gerar</x-primary-button>
                    </div>
                </div>

            </form>
            <div class="flex flex-col w-full">
                <div class="flex flex-col w-full">
                    <h1 class="text-lg font-semibold">Parcelas</h1>
                    <div class="text-xs">
                        <p>Você pode mudar o valor da parcela de entrada.
                            Precione Enter para confirmar a edição da parcela.</p>
                    </div>
                </div>
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
                            <td class="px-6 text-center" x-text="parcel.date">

                            </td>
                            <td class="px-6 text-center">
                                <span class="text-sm font-bold">R$ </span>
                                <input type="text" x-model="parcel.value" @keyup.enter="updateParcels($event, index)"
                                    class="w-20 p-2 border-0 rounded-md" :disabled="index !== 0">
                            </td>
                            <td class="px-6 text-center">
                                <select x-model="parcel.payment" class="border-0 focus:ring-0">
                                    <option>Cartão de crédito</option>
                                    <option>Boleto</option>
                                    <option>Cheque</option>
                                    <option>Pix</option>
                                </select>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>
        </div>
    </div>

    <div x-show="selectedClient.id === null || selectedProducts.length === 0" class="p-6" x-cloak>
        <p>Por favor preencha os itens!</p>
    </div>
</div>
