<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Criar Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="w-full p-6 text-gray-900 ">
                    <form action="{{ route('client.store') }}" method="POST" class="flex flex-col w-1/3 gap-2">
                        @csrf
                        <div class="flex flex-col">
                            <label for="name">Nome do Cliente</label>
                            <input type="text" name="name" id="name"
                                class="border border-gray-200 rounded-md">
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf"
                                class="border border-gray-200 rounded-md">
                            @error('cpf')
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
