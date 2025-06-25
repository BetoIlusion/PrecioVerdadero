<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between items-center">
            {{ __('Productos') }}
            <x-button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white">
                {{ __('Crear Producto') }}
            </x-button>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg">
                <!-- Lista de productos -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 shadow-lg">
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
                            @forelse($productos as $index => $producto)
                                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#d4daf7]' }} hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-1/12">{{ $producto->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-2/12">{{ $producto->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-2/12">{{ $producto->marca ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 w-2/12">{{ $producto->disponibilidad ? 'Disponible' : 'No disponible' }}</td>
                                    <td class="px-6 py-4 text-sm font-medium w-2/12 text-right">
                                        <x-button onclick="openModal({{ $producto->toJson() }})" class="bg-indigo-600 hover:bg-indigo-700 text-white mr-2">
                                            Modificar
                                        </x-button>
                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline-block">
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

    <!-- Modal -->
    <div id="productModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900">Crear Producto</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <form id="productForm" action="{{ route('productos.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="productId">
                <div class="mb-4">
                    <label for="existing_product" class="block text-sm font-medium text-gray-700">Seleccionar Producto Existente (opcional)</label>
                    <select name="existing_product" id="existing_product" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="toggleNewProductFields(this)">
                        <option value="">Crear nuevo producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }} ({{ $producto->marca ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                    @error('existing_product') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div id="new-product-fields">
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('nombre') }}">
                        @error('nombre') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="marca" class="block text-sm font-medium text-gray-700">Marca</label>
                        <input type="text" name="marca" id="marca" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('marca') }}">
                        @error('marca') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="disponibilidad" class="block text-sm font-medium text-gray-700">Disponibilidad</label>
                        <input type="checkbox" name="disponibilidad" id="disponibilidad" value="1" class="mt-1" {{ old('disponibilidad') ? 'checked' : '' }}>
                        @error('disponibilidad') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" name="precio" id="precio" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('precio') }}" required>
                    @error('precio') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="existe" class="block text-sm font-medium text-gray-700">Existe</label>
                    <input type="checkbox" name="existe" id="existe" value="1" class="mt-1" {{ old('existe') ? 'checked' : '' }}>
                    @error('existe') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="id_estado" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="id_estado" id="id_estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Seleccione un estado</option>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->id }}" {{ old('id_estado') == $estado->id ? 'selected' : '' }}>{{ $estado->nombre }}</option>
                        @endforeach
                    </select>
                    @error('id_estado') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white">
                        {{ __('Guardar') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(product = null) {
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
                nombreInput.value = product.nombre;
                marcaInput.value = product.marca || '';
                disponibilidadInput.checked = product.disponibilidad;
                // Note: usuario_productos fields (precio, existe, id_estado) are not populated for edit
                // as they are managed separately. Adjust if needed to fetch and populate.
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
    </script>
</x-app-layout>