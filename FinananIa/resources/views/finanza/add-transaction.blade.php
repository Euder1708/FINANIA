<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar Transacción') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('finanza.storeTransaction') }}">
                        @csrf

                        <!-- Tipo -->
                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Tipo de Transacción')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="credit">{{ __('Ingreso') }}</option>
                                <option value="debit">{{ __('Gasto') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('¿Qué fue?')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" placeholder="Ej: Compra de supermercado, Salario, etc." required />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Monto -->
                        <div class="mb-4">
                            <x-input-label for="amount" :value="__('Monto')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" :value="old('amount')" placeholder="0.00" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Categoría (oculta, se asigna automáticamente) -->
                        <input type="hidden" name="category_id" value="1"> <!-- Categoría por defecto -->
                        <input type="hidden" name="account_id" value="1"> <!-- Cuenta por defecto -->
                        <input type="hidden" name="occurred_at" value="{{ now()->toDateString() }}"> <!-- Fecha automática -->

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Guardar Transacción') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
