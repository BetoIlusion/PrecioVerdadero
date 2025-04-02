<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between items-center">
            {{ __('Tipo Producto') }}
            <x-button href="{{ route('tipo-producto.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white">
                {{ __('Crear Tipo Producto') }}
            </x-button>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg">
                <!-- Lista de tipos de productos -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 shadow-lg">
                        <thead style="background-color: #5271ff;">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/6">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/6">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-3/6">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($tiposProductos as $index => $tipoProducto)
                                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#d4daf7]' }} hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-1/6">{{ $tipoProducto->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-2/6">{{ $tipoProducto->tipo }}</td>
                                    <td class="px-6 py-4 text-sm font-medium w-3/6 text-right">
                                        <x-button href="{{ route('tipo-producto.edit', $tipoProducto->id) }}" 
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white mr-2">
                                            Modificar
                                        </x-button>
                                        <form action="{{ route('tipo-producto.destroy', $tipoProducto->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white"
                                                onclick="return confirm('¿Estás seguro de eliminar este tipo de producto?')">
                                                Eliminar
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No hay tipos de productos disponibles.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>