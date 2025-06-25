<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Notificaciones</h3>
                <div class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mensaje</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse (auth()->user()->notifications()->orderBy('created_at', 'desc')->get() as $notification)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $notification->message }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form action="{{ route('notification.markAsRead', $notification->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-800">Marcar como leído</button>
                                        </form>
                                        <form action="{{ route('notification.destroy', $notification->id) }}" method="POST" class="inline ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta notificación?')" class="text-red-600 hover:text-red-800">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No hay notificaciones.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Productos asociados al usuario -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg">
                <!-- Lista de productos -->
                <div class="overflow-x-auto">
                    <table class="min-dw-full divide-y divide-gray-200 shadow-lg">
                        <thead style="background-color: #5271ff;">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-1/12">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Marca</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Disponibilidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-2/12">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($productos as $index => $usuarioProducto)
                                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#d4daf7]' }} hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-1/12">{{ $usuarioProducto->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-2/12">
                                        @if ($usuarioProducto->producto)
                                            {{ $usuarioProducto->producto->nombre }}
                                        @else
                                            <span class="text-red-500">Producto no encontrado (ID: {{ $usuarioProducto->id_producto }})</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-2/12">
                                        @if ($usuarioProducto->producto)
                                            {{ $usuarioProducto->producto->marca ?? 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-2/12">
                                        @if ($usuarioProducto->producto)
                                            {{ $usuarioProducto->producto->disponibilidad ? 'Disponible' : 'No disponible' }}
                                        @else
                                            Desconocido
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium w-2/12 text-right">
                                        <x-button onclick="openModal({{ $usuarioProducto->producto ? $usuarioProducto->producto->toJson() : '{}' }})" class="bg-indigo-600 hover:bg-indigo-700 text-white mr-2">
                                            Modificar
                                        </x-button>
                                        <!-- Botón Mantener -->
                                        <form action="{{ route('producto.mantener', $usuarioProducto->id) }}" method="POST" class="inline ml-2">
                                            @csrf
                                            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">Mantener</button>
                                        </form>

                                        @if ($usuarioProducto->promedio > 0)
                                            <form action="{{ route('producto.promediar', $usuarioProducto->id) }}" method="POST" class="inline ml-2">
                                                @csrf
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                                    Promediar (Bs. {{ number_format($usuarioProducto->promedio, 2) }})
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-red-500">Sin historial</span>
                                        @endif

                                        <form action="{{ route('productos.destroy', $usuarioProducto->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" class="bg-red-600 hover:bg-red-700 text-white" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                                Eliminar
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No hay productos disponibles.
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