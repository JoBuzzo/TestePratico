<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Editar Compra
        </h2>
    </x-slot>

    <div class="py-12" x-data="app">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="w-full p-6 text-gray-900 ">
                    <div>
                        <div class="flex items-center justify-between mb-10 ">
                            <div class="flex font-bold items-centertext-xl">
                                <button @click="stepper = 1" class="p-2 border rounded-l-md w-36"
                                    :class="{ 'bg-gray-200': stepper === 1 }">
                                    Itens
                                </button>

                                <button @click="stepper = 2" class="p-2 border w-36 rounded-r-md"
                                    :class="{ 'bg-gray-200': stepper === 2 }">
                                    Pagamento
                                </button>
                            </div>

                            <form action="{{ route('purchase.update', $purchase) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="client_id" :value="selectedClient.id">
                                <input type="hidden" name="products" :value="JSON.stringify(selectedProducts)">
                                <input type="hidden" name="parcels" :value="JSON.stringify(listParcels)">
                                <input type="hidden" name="total_price" :value="calculeTotalPrice()">
                                <template x-if="canSubmit === true">
                                    <x-primary-button>Salvar</x-primary-button>
                                </template>
                            </form>
                        </div>

                        <div x-show="stepper === 1" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-1/2">
                            <x-steppers.create-purchase />
                        </div>

                        <div x-show="stepper === 2" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-x-1/2">
                            <x-steppers.payment />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('app', () => ({
                stepper: 1,
                totalPrice: 0,
                products: @json($products),
                clients: @json($clients),
                selectedProducts: @json($selectedProducts),
                selectedClient: @json($purchase->client),
                searchClient: '',
                searchProduct: '',
                dropdownProducts: false,
                dropdownClients: false,
                canSubmit: false,

                createProducts() {
                    if (this.selectedClient.id === null || this.selectedProducts.length === 0) {
                        alert('Preencha todos os campos');
                        return;
                    }
                    this.stepper = 2;
                },
                calculeTotalPrice() {

                    this.totalPrice = 0;
                    this.selectedProducts.forEach(product => {
                        this.totalPrice = parseFloat(((product.price * product.quantity) + this
                            .totalPrice).toFixed(2));
                    });

                    return parseFloat(this.totalPrice).toFixed(2);

                },
                addProduct(product) {

                    if (this.selectedProducts.filter(p => p.id === product.id).length === 0) {
                        product.quantity = 1;
                        this.selectedProducts.push(product);
                        this.canSubmit = false;
                    }
                },
                isModifiedQuantity() {
                    this.canSubmit = false;
                },
                removeProduct(product, index) {
                    this.selectedProducts.splice(index, 1);
                    this.canSubmit = false;
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
                },

                parcels: @json(count($listParcels)),
                listParcels: @json($listParcels),
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
                    this.canSubmit = true;
                },
                getParcelPrice() {
                    return parseFloat((this.totalPrice / this.parcels).toFixed(2));
                },
                formatDate(date) {
                    return (date.getDate()).toString().padStart(2, '0') + '/' + (date.getMonth() + 1)
                        .toString().padStart(2, '0') + '/' + date.getFullYear();
                },
                updateParcels(event, index) {
                    let newValue = parseFloat(event.target.value);

                    if (isNaN(newValue) || newValue < 0 || newValue > this.totalPrice) {
                        alert('Por favor, insira um número válido');
                        return;
                    }

                    this.listParcels[index].value = newValue;


                    let totalRemaining = this.totalPrice - newValue;


                    let parcelsRemaining = this.listParcels.length - 1;

                    if (parcelsRemaining === 1) {
                        this.listParcels[this.listParcels.length - 1].value = parseFloat(totalRemaining
                            .toFixed(2));
                    } else {

                        let newValueParcels = totalRemaining / parcelsRemaining;


                        for (let i = 0; i < this.listParcels.length; i++) {
                            if (i !== index && i !== this.listParcels.length - 1) {
                                this.listParcels[i].value = parseFloat(newValueParcels.toFixed(2));
                            }
                        }

                        let sumOfValues = this.listParcels.reduce((sum, parcel, i) => {
                            return i === this.listParcels.length - 1 ? sum : sum + parcel.value;
                        }, 0);

                        let lastParcelValue = this.totalPrice - sumOfValues;

                        this.listParcels[this.listParcels.length - 1].value = parseFloat(lastParcelValue
                            .toFixed(2));
                    }
                }
            }))
        })
    </script>

</x-app-layout>
