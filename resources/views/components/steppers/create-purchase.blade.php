<form @submit.prevent="createProducts()" method="POST" class="flex flex-col w-full gap-10 justify-between">

    <div class="flex items-center w-full gap-10">
        <div class="relative flex flex-col w-64">
            <span>Clientes</span>
            <button @click="dropdownClients = !dropdownClients" type="button"
                class="border p-2.5 rounded-md w-full text-start"
                x-text=" selectedClient.name ?? 'Selecione um Cliente'">
            </button>

            <div class="absolute w-full bg-white border rounded-md top-[71px]" x-cloak x-show="dropdownClients"
                @click.outside="dropdownClients = false; searchClient = ''">
                <input type="text" class="w-full p-2 mb-1 border-gray-200 rounded-md" x-model="searchClient"
                    placeholder="Buscar Clientes">
                <ul class="flex flex-col w-full gap-1 overflow-y-scroll max-h-44">
                    <template x-for="client in filteredClients()" :key="client.id">
                        <li class="w-full">
                            <div @click="selectedClient = client; console.log(selectedClient)" type="button"
                                :class="{
                                    'bg-gray-200': selectedClient.id === client.id,
                                }"
                                class="flex flex-col items-start w-full p-2 rounded cursor-pointer">
                                <span x-text="client.name"
                                    class="w-32 overflow-hidden text-ellipsis whitespace-nowrap"></span>
                                <span x-text="client.cpf"></span>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        <div class="relative flex flex-col">
            <span>Produtos</span>
            <div class="flex cursor-pointer" @click="dropdownProducts = !dropdownProducts">
                <span x-text="'Total: R$ '+calculeTotalPrice()"
                    class="border-l border-y p-2.5 rounded-l-md w-36"></span>
                <span  class="border p-2.5 rounded-r-md">
                    Selecione os produtos
                </span>
            </div>

            <div class="absolute w-full bg-white border rounded-md top-[71px]" x-show="dropdownProducts"
                @click.outside="dropdownProducts = false; searchProduct = ''" x-cloak>
                <input type="text" class="w-full p-2 mb-1 border-gray-200 rounded-md" x-model="searchProduct"
                    placeholder="Buscar produtos">
                <ul class="flex flex-col w-full gap-1 overflow-y-scroll max-h-44">
                    <template x-for="product in filteredProducts()" :key="product.id">
                        <li class="w-full">
                            <button @click="addProduct(product)" type="button"
                                :class="{
                                    'bg-gray-200': isSelected(product),
                                }"
                                class="flex items-center justify-between w-full p-2 rounded">
                                <span x-text="product.name"></span>
                                <span x-text="'R$ ' + product.price"></span>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
    <div class="w-1/2 overflow-y-scroll max-h-64">
        <template x-for="(selectedProduct, index) in selectedProducts" :key="index">
            <div class="flex items-center justify-between w-full p-2 border border-gray-200 rounded-md">
                <div class="flex justify-between w-full px-5">
                    <span x-text="selectedProduct.name"></span>
                    <span x-text="'R$ ' + selectedProduct.price"></span>
                </div>
                <div class="flex gap-2">
                    <input type="number" x-model="selectedProduct.quantity" class="w-16 p-2 border-gray-200 rounded-md"
                        min="1">
                    <button @click="removeProduct(product)" type="button"
                        class="p-2 font-bold text-white border rounded-md bg-rose-500">
                        Remover
                    </button>
                </div>
            </div>
        </template>
    </div>
    <div>
        <x-primary-button>Registrar Compra</x-primary-button>
    </div>

</form>
