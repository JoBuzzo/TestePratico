<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Compra
        </h2>
    </x-slot>

    <div class="py-12" x-data="app">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 w-full ">
                    <form action="{{ route('purchase.store') }}" method="POST" class="w-full flex flex-col gap-10">
                        @csrf
                        <div class="flex w-full gap-10 items-center">
                            <div class="relative w-64">
                                <button @click="dropdownClients = !dropdownClients" type="button"
                                    class="border p-2.5 rounded-r-md w-full text-start"
                                    x-text=" selectedClient.name ?? 'Selecione um Cliente'">
                                </button>

                                <div class="absolute bg-gray-100 w-full top-12 border rounded-md" x-cloak
                                    x-show="dropdownClients" @click.outside="dropdownClients = false">
                                    <input type="text" class="w-full p-2 rounded-md border-gray-200 mb-1"
                                        x-model="searchClient" placeholder="Buscar Clientes">
                                    <ul class="flex flex-col w-full overflow-y-scroll gap-1 max-h-44">
                                        <template x-for="client in filteredClients()" :key="client.id">
                                            <li class="w-full">
                                                <button @click="selectedClient = client" type="button"
                                                    :class="{
                                                        'bg-gray-200': selectedClient.id === client.id,
                                                    }"
                                                    class="p-2 rounded w-full flex flex-col items-start">
                                                    <span x-text="client.name"
                                                        class="overflow-hidden text-ellipsis whitespace-nowrap w-32 "></span>
                                                    <span x-text="client.cpf"></span>
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            <div class="relative flex">
                                <span x-text="'Total: R$ '+totalPrice"
                                    class="border-l border-y p-2.5 rounded-l-md w-36"></span>
                                <button @click="dropdownProducts = !dropdownProducts" type="button"
                                    class="border p-2.5 rounded-r-md">
                                    Selecione os produtos
                                </button>

                                <div class="absolute bg-gray-100 w-full top-12 border rounded-md"
                                    x-show="dropdownProducts" @click.outside="dropdownProducts = false" x-cloak>
                                    <input type="text" class="w-full p-2 rounded-md border-gray-200 mb-1"
                                        x-model="searchProduct" placeholder="Buscar produtos">
                                    <ul class="flex flex-col w-full overflow-y-scroll gap-1 max-h-44">
                                        <template x-for="(product, index) in filteredProducts()" :key="index">
                                            <li class="w-full">
                                                <button @click="addProduct(product, index)" type="button"
                                                    :class="{
                                                        'bg-gray-200': isSelected(product),
                                                    }"
                                                    class="p-2 rounded w-full flex justify-between items-center">
                                                    <span x-text="product.name"></span>
                                                    <span x-text="'R$ ' + product.price"></span>
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            <input type="date" name="date" id="date" class=" p-2 rounded-md border-gray-200">


                            <input type="hidden" name="client_id" :value="selectedClient.id">
                            <input type="hidden" name="total_price" :value="totalPrice">
                            <input type="hidden" name="products" :value="JSON.stringify(selectedProducts.map(p => p))">
                        </div>
                        <div class="w-1/2 max-h-64 overflow-y-scroll">
                            <template x-for="(product, index) in selectedProducts" :key="index">
                                <div
                                    class="border border-gray-200 p-2 rounded-md flex justify-between w-full items-center">
                                    <div class="flex gap-10">
                                        <span x-text="product.name"></span>
                                        <span x-text="'R$ ' + product.price"></span>
                                    </div>
                                    <div>
                                        <button @click="removeProduct(product)" type="button"
                                            class="border p-2 rounded-md">
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div>
                            <x-primary-button type="submit">Cadastrar</x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('app', () => ({
                products: @json($products),
                clients: @json($clients),
                selectedProducts: [],
                selectedClient: {
                    id: null,
                    name: null,
                    cpf: null,
                },
                searchClient: '',
                searchProduct: '',
                dropdownProducts: false,
                dropdownClients: false,
                totalPrice: 0.0,
                addProduct(product) {
                    this.selectedProducts.push(product);
                    this.totalPrice = (this.totalPrice + product.price).toFixed(2);
                    this.totalPrice = parseFloat(this.totalPrice);
                },
                removeProduct(product, index) {
                    this.selectedProducts.splice(index, 1);

                    this.totalPrice = ( (this.totalPrice).toFixed(2) - (product.price).toFixed(2) ).toFixed(2);
                    this.totalPrice = parseFloat(this.totalPrice);
                },
                isSelected(product) {
                    return this.selectedProducts.some(p => p.id == product.id);
                },

                filteredClients() {
                    return this.clients.filter(
                        client => client.name.startsWith(this.searchClient)
                    )
                },
                filteredProducts() {
                    return this.products.filter(
                        product => product.name.startsWith(this.searchProduct)
                    )
                }
            }))
        })
    </script>



</x-app-layout>
