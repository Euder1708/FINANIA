<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md font-medium hover:bg-blue-100 transition">+ {{ __('Nuevo Usuario') }}</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-shadow hover:shadow-md">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 align-middle table-auto border border-gray-200 rounded-md overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-64">{{ __('Nombre') }}</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-40">{{ __('Rol') }}</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-56">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap">{{ $user->id }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div class="truncate max-w-xs sm:max-w-sm md:max-w-md">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center">
                                            @if($user->rol === 'admin')
                                                <span class="inline-flex items-center px-2 py-1 rounded text-indigo-700 bg-indigo-50">{{ __('Administrador') }}</span>
                                            @elseif($user->rol === 'user')
                                                <span class="inline-flex items-center px-2 py-1 rounded text-blue-700 bg-blue-50">{{ __('Usuario') }}</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded text-gray-700 bg-gray-50">{{ $user->rol }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200">{{ __('Editar') }}</a>
                                                @if(auth()->id() !== $user->id)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este usuario?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-md bg-red-50 text-red-700 hover:bg-red-100">{{ __('Eliminar') }}</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-sm text-gray-500">{{ __('Sin usuarios') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
