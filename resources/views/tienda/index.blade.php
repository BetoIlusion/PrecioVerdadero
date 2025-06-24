<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Tienda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                {{-- Aquí tu contenido dinámico --}}
                @if(session('success'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                @if($tiendas->isEmpty())
                    <p>No tienes tiendas registradas.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tiendas as $tienda)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tienda->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tienda->tipo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
<button onclick="openEditModal({{ $tienda->id }}, '{{ $tienda->nombre }}', '{{ $tienda->tipo }}')"
        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
    Editar
</button>
                                        <form action="{{ route('tienda.destroy', $tienda->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Estás seguro?')" class="text-red-500 hover:text-red-700">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <!-- Botón para abrir el modal -->
                <button onclick="openCreateModal()" class="mt-6 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Crear Tienda</button>
            </div>
        </div>
    </div>

    {{-- Incluye aquí los modales --}}
    @include('tienda.modal')

</x-app-layout>
