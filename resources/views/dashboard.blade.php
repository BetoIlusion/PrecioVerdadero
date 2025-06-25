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
    <!-- ...existing code... -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg">
            <!-- Lista de productos -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 shadow-lg">
                    <thead class="bg-gradient-to-r from-indigo-500 to-blue-500">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-2/12">Nombre</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-2/12">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($productos as $index => $producto)
                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-50' }} hover:bg-blue-100 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-2/12">
                                    {{ $producto->producto ? $producto->producto->nombre : 'Producto no encontrado' }}
                                </td>
                                <td class="px-6 py-4 w-2/12">
                                    <div class="flex flex-wrap gap-2 justify-center items-center">
                                        <!-- Modificar -->
                                        <form action="{{ route('producto.modificar', $producto->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="number" name="precio" step="0.01" value="{{ $producto->precio }}" class="w-20 px-2 py-1 border rounded" required>
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded shadow transition duration-150" title="Modificar">
                                                Modificar
                                            </button>
                                        </form>
                                        <!-- Mantener -->
                                        <form action="{{ route('producto.mantener', $producto->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded shadow transition duration-150" title="Mantener">
                                                Mantener
                                            </button>
                                        </form>
                                        <!-- Promediar -->
                                        <form action="{{ route('producto.promediar', $producto->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow transition duration-150" title="Promediar">
                                                Promediar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
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
<!-- ...existing code... -->
    <!-- Modal -->
    <div id="productModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 md:w-1/2">
            <h2 id="modalTitle" class="text-lg font-semibold mb-4"></h2>
            <form id="productForm" action="" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="formMethod" name="_method">
                <input type="hidden" id="productId" name="id">

                <!-- Campo para seleccionar producto existente o crear nuevo -->
                <div>
                    <label for="existing_product" class="block text-sm font-medium text-gray-700">Usar producto existente</label>
                    <select id="existing_product" name="existing_product" onchange="toggleNewProductFields(this)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Seleccionar --</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Campos para nuevo producto -->
                <div id="new-product-fields">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label for="marca" class="block text-sm font-medium text-gray-700">Marca</label>
                        <input type="text" id="marca" name="marca" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="disponibilidad" class="block text-sm font-medium text-gray-700">Disponibilidad</label>
                        <input type="checkbox" id="disponibilidad" name="disponibilidad" class="mt-1" checked>
                    </div>
                    <!-- Campos de usuario_productos (si applies) -->
                    <div>
                        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                        <input type="number" id="precio" name="precio" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label for="existe" class="block text-sm font-medium text-gray-700">Existe</label>
                        <input type="checkbox" id="existe" name="existe" class="mt-1" checked>
                    </div>
                    <div>
                        <label for="id_estado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="id_estado" name="id_estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach (\App\Models\EstadoProducto::all() as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(product = null) {
            console.log('Opening modal with product:', product); // Depuración
            const modal = document.getElementById('productModal');
            const form = document.getElementById('productForm');
            const methodInput = document.getElementById('formMethod');
            const modalTitle = document.getElementById('modalTitle');
            const newProductFields = document.getElementById('new-product-fields');
            const existingProductSelect = document.getElementById('existing_product');
            const nombreInput = document.getElementById('nombre');
            const marcaInput = document.getElementById('marca');
            const disponibilidadInput = document.getElementById('disponibilidad');
            const precioInput = document.getElementById('precio');
            const existeInput = document.getElementById('existe');
            const idEstadoSelect = document.getElementById('id_estado');
            const productIdInput = document.getElementById('productId');

            // Reset form
            form.reset();
            methodInput.value = product ? 'PUT' : 'POST';
            form.action = product ? '{{ url('productos') }}/' + product.id : '{{ route('productos.store') }}';
            modalTitle.textContent = product ? 'Editar Producto' : 'Crear Producto';
            newProductFields.style.display = 'block';
            existingProductSelect.value = '';
            existingProductSelect.disabled = product ? true : false;

            if (product) {
                productIdInput.value = product.id;
                nombreInput.value = product.nombre || '';
                marcaInput.value = product.marca || '';
                disponibilidadInput.checked = product.disponibilidad || false;
                // Los campos de usuario_productos (precio, existe, id_estado) no se llenan aquí
                // porque se gestionan por separado. Ajusta si necesitas.
            } else {
                productIdInput.value = '';
                nombreInput.removeAttribute('disabled');
                marcaInput.removeAttribute('disabled');
                disponibilidadInput.removeAttribute('disabled');
                nombreInput.setAttribute('required', 'required');
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('productModal').classList.add('hidden');
        }

        function toggleNewProductFields(select) {
            const newProductFields = document.getElementById('new-product-fields');
            newProductFields.style.display = select.value ? 'none' : 'block';
            const inputs = newProductFields.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.disabled = select.value ? true : false;
                if (select.value) {
                    input.removeAttribute('required');
                } else if (input.id === 'nombre') {
                    input.setAttribute('required', 'required');
                }
            });
        }

        // Opcional: Añadir evento para abrir modal al cargar (para testing)
        // document.querySelectorAll('.open-modal-btn').forEach(btn => {
        //     btn.addEventListener('click', () => openModal(JSON.parse(btn.dataset.product)));
        // });
    </script>
</x-app-layout>