<!-- Modal para Crear/Editar Tienda -->
<div id="modal-tienda" class="fixed z-50 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4" id="modal-title">Crear Tienda</h3>

            <form id="form-tienda" method="POST" action="{{ route('tienda.store') }}">
                @csrf
                <!-- Aquí se insertará dinámicamente @method('PUT') -->
                <div id="method-field"></div>

                <input type="hidden" name="id" id="tienda-id">

                <div class="mb-4">
                    <label class="block text-gray-700">Nombre:</label>
                    <input type="text" name="nombre" id="tienda-nombre" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Tipo:</label>
                    <input type="text" name="tipo" id="tienda-tipo" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts para controlar el modal -->
<script>
    function openCreateModal() {
        document.getElementById('modal-title').innerText = 'Crear Tienda';
        document.getElementById('form-tienda').action = "{{ route('tienda.store') }}";

        // Limpiar campos
        document.getElementById('tienda-id').value = '';
        document.getElementById('tienda-nombre').value = '';
        document.getElementById('tienda-tipo').value = '';

        // Eliminar cualquier method anterior
        const oldMethod = document.querySelector('#form-tienda input[name="_method"]');
        if (oldMethod) oldMethod.remove();

        document.getElementById('modal-tienda').classList.remove('hidden');
    }

    function openEditModal(id, nombre, tipo) {
    document.getElementById('modal-title').innerText = 'Editar Tienda';
    document.getElementById('form-tienda').action = "{{ route('tienda.update', ':id') }}".replace(':id', id);

    // Eliminar cualquier method anterior
    const oldMethod = document.querySelector('#form-tienda input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    // Agregar el método PUT
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    document.getElementById('form-tienda').appendChild(methodInput);

    // Llenar campos
    document.getElementById('tienda-id').value = id;
    document.getElementById('tienda-nombre').value = nombre;
    document.getElementById('tienda-tipo').value = tipo;

    document.getElementById('modal-tienda').classList.remove('hidden');
}

    function closeModal() {
        document.getElementById('modal-tienda').classList.add('hidden');
    }
</script>

