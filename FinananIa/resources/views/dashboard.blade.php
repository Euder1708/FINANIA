<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('Has iniciado sesión') }}
                </div>
                <div class="px-6 pb-6">
                    @php($esSecretaria = \Illuminate\Support\Str::lower(trim(Auth::user()->rol ?? '')) === 'secretaria')
                    @if($esSecretaria)
                        @if(!empty($conteos))
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                                <div class="p-4 bg-indigo-50 rounded-md">
                                    <div class="text-sm text-gray-600">{{ __('Total de llaves') }}</div>
                                    <div class="mt-1 text-2xl font-semibold text-indigo-700">{{ $conteos['total'] }}</div>
                                </div>
                                <div class="p-4 bg-green-50 rounded-md">
                                    <div class="text-sm text-gray-600">{{ __('Disponibles') }}</div>
                                    <div class="mt-1 text-2xl font-semibold text-green-700">{{ $conteos['disponibles'] }}</div>
                                </div>
                                <div class="p-4 bg-amber-50 rounded-md">
                                    <div class="text-sm text-gray-600">{{ __('Prestadas') }}</div>
                                    <div class="mt-1 text-2xl font-semibold text-amber-700">{{ $conteos['prestadas'] }}</div>
                                </div>
                            </div>
                        @endif
                        @if(!empty($llaves) && $llaves->count())
                            <div class="overflow-x-auto mb-6">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Código') }}</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Descripción') }}</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($llaves as $llave)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $llave->codigo }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-700">{{ $llave->descripcion }}</td>
                                                <td class="px-4 py-2 text-sm">
                                                    @if($llave->estado === 'disponible')
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-green-700 bg-green-50">{{ __('Disponible') }}</span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-amber-700 bg-amber-50">{{ __('Prestada') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                            <a href="{{ route('prestamos.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 transition w-full">{{ __('Préstamos') }}</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-2">
                            <a href="{{ route('llaves.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 transition w-full">{{ __('Llaves') }}</a>
                            <a href="{{ route('docentes.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 transition w-full">{{ __('Docentes') }}</a>
                            <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 transition w-full">{{ __('Usuarios') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
