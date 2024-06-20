<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Criar Produto
        </h2>
    </x-slot>

    <div class="py-12" x-data="app">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="w-full p-6 text-gray-900 ">
                    <form action="{{ route('product.store') }}" method="POST" class="w-1/3 flex flex-col gap-2">
                        @csrf
                        <div class="flex flex-col">
                            <label for="name">Nome do Produto</label>
                            <input type="text" name="name" id="name"
                                class="border border-gray-200 rounded-md">
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="price">Preço</label>
                            <input type="text" name="price" id="price"
                                class="border border-gray-200 rounded-md">
                            @error('price')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-primary-button>Criar</x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
