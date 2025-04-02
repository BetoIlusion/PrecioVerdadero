<!-- resources/views/inventario/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inventario') }}
            </h2>
            <a 
            
                {{-- href="{{ route('inventario.create') }}" --}}
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Nuevo Producto
            </a>
        </div>
    </x-slot>
    <!-- Resto del código sigue igual -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Tabla de productos -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($productos as $producto)
                                    <tr x-data="{ showModal: false }">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button 
                                                @click="showModal = true"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                Ver Detalles
                                            </button>

                                            <!-- Componente Modal -->
                                            <x-modal id="modal-{{ $producto->id }}">
                                                <div class="p-6">
                                                    <h3 class="text-lg font-medium text-gray-900">Detalles del Producto</h3>
                                                    <div class="mt-4">
                                                        <p><strong>ID:</strong> {{ $producto->id }}</p>
                                                        <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
                                                        <!-- Agrega más campos según tu modelo Producto -->
                                                    </div>
                                                    <div class="mt-6">
                                                        <button 
                                                            @click="showModal = false"
                                                            class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                                                            Cerrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </x-modal>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>