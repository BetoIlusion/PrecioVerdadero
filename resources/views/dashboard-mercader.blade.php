<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mercader') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Caja de Notificaciones -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="bg-blue-500 px-6 py-4 text-white font-bold text-lg">
                    Notificaciones
                </div>
                <div class="p-6">
                    @php
                        $notificaciones = collect([
                            (object) [
                                'id' => 1,
                                'tipo' => 'alerta',
                                'mensaje' => 'El precio del producto X ha cambiado drásticamente.',
                            ],
                            (object) [
                                'id' => 2,
                                'tipo' => 'info',
                                'mensaje' => 'Se ha actualizado la información del proveedor Y.',
                            ],
                            (object) [
                                'id' => 3,
                                'tipo' => 'otro',
                                'mensaje' => 'Tienes una nueva solicitud pendiente de revisión.',
                            ],
                        ]);
                    @endphp

                    <ul class="divide-y divide-gray-200">
                        @forelse($notificaciones as $notificacion)
                            <li class="py-4 flex justify-between items-center">
                                <div class="flex items-start gap-3">
                                    @if ($notificacion->tipo === 'alerta')
                                        <span class="text-red-600 font-semibold">⚠️</span>
                                    @elseif($notificacion->tipo === 'info')
                                        <span class="text-blue-600 font-semibold">ℹ️</span>
                                    @else
                                        <span class="text-gray-600 font-semibold">🔔</span>
                                    @endif
                                    <p>{{ $notificacion->mensaje }}</p>
                                </div>
                                <button onclick="abrirModal({{ $notificacion->id }})"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded transition duration-200">
                                    Ver detalles
                                </button>
                            </li>
                        @empty
                            <li class="py-4 text-gray-500">No hay notificaciones.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Caja de Productos Sugeridos -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="bg-green-500 px-6 py-4 text-white font-bold text-lg">
                    Selección de Producto
                </div>
                <div class="p-6">
                    @php
                        $productos = \App\Models\Producto::all();
                    @endphp

                    <div class="mb-4">
                        <select id="productoSelect"
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            onchange="mostrarDetalleProducto()">
                            <option value="">-- Selecciona un producto --</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}" data-detalle="{{ $producto->detalle }}">
                                    {{ $producto->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="detalleProductoBox"
                        class="bg-gray-50 p-4 rounded border border-gray-200 mb-4 hidden">
                        <strong>Detalle:</strong>
                        <p id="detalleProductoTexto" class="mt-1 text-sm text-gray-700"></p>
                    </div>

                    <div class="flex flex-wrap gap-2 justify-end">
                        <form id="formProducto1" method="POST"
                            action="{{ route('usuario-producto.actualizar') }}">
                            @csrf
                            <input type="hidden" name="producto_id" id="productoId1">
                            <input type="hidden" name="tipo" value="accion1">
                            <button type="submit"
                                class="bg-indigo-500 hover:bg-indigo-700 text-white px-4 py-2 rounded transition duration-200">
                                Acción 1
                            </button>
                        </form>
                        <form id="formProducto2" method="POST"
                            action="{{ route('usuario-producto.actualizar') }}">
                            @csrf
                            <input type="hidden" name="producto_id" id="productoId2">
                            <input type="hidden" name="tipo" value="accion2">
                            <button type="submit"
                                class="bg-purple-500 hover:bg-purple-700 text-white px-4 py-2 rounded transition duration-200">
                                Acción 2
                            </button>
                        </form>
                        <form id="formProducto3" method="POST"
                            action="{{ route('usuario-producto.actualizar') }}">
                            @csrf
                            <input type="hidden" name="producto_id" id="productoId3">
                            <input type="hidden" name="tipo" value="accion3">
                            <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white px-4 py-2 rounded transition duration-200">
                                Acción 3
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="modalNotificacion"
        class="fixed z-10 inset-0 overflow-y-auto hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all">
            <h3 class="text-lg font-bold mb-4">Detalles de la Notificación</h3>
            <div id="modalContenido" class="mb-4 text-gray-700">
                <!-- Contenido dinámico -->
            </div>
            <div class="flex justify-end space-x-2">
                <form id="formAccion1" method="POST" action="">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Acción 1</button>
                </form>
                <form id="formAccion2" method="POST" action="">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">Acción 2</button>
                </form>
                <button onclick="cerrarModal()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        function abrirModal(id) {
            document.getElementById('modalNotificacion').classList.remove('hidden');
            document.getElementById('modalContenido').innerHTML = 'ID de notificación: ' + id;

            // Configura las acciones de los formularios
            document.getElementById('formAccion1').action = '/notificaciones/accion1/' + id;
            document.getElementById('formAccion2').action = '/notificaciones/accion2/' + id;
        }

        function cerrarModal() {
            document.getElementById('modalNotificacion').classList.add('hidden');
        }

        function mostrarDetalleProducto() {
            const select = document.getElementById('productoSelect');
            const selected = select.options[select.selectedIndex];

            const id = selected.value;
            const detalle = selected.getAttribute('data-detalle');

            const detalleBox = document.getElementById('detalleProductoBox');
            const detalleTexto = document.getElementById('detalleProductoTexto');

            if (id) {
                detalleBox.classList.remove('hidden');
                detalleTexto.textContent = detalle;

                document.getElementById('productoId1').value = id;
                document.getElementById('productoId2').value = id;
                document.getElementById('productoId3').value = id;
            } else {
                detalleBox.classList.add('hidden');
                detalleTexto.textContent = '';
            }
        }
    </script>
</x-app-layout>