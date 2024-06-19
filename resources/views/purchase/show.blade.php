<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Compra
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 w-full ">
                    {{ $purchase->total }}
                    {{ $purchase->date }}
                    <div>
                        @foreach ($purchase->products as $product)
                            <div>
                                {{ $product->name }}
                                {{ $product->price }}
                                {{ $product->quantity }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
