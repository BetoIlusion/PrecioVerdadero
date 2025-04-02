<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Super Productos Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('productos.store') }}" method="POST">
                    @csrf

                    <!-- Tipo de Producto -->
                    <div class="mb-4">
                        <label for="tipo_producto" class="block text-gray-700 font-bold mb-2">Tipo de Producto</label>
                        <select id="tipo_producto" name="tipo_producto"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="" selected>Seleccione un tipo</option>
                            @foreach ($TipoProducto as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subtipo de Producto (Se llena dinámicamente con JavaScript) -->
                    <div class="mb-4">
                        <label for="subtipo_producto" class="block text-gray-700 font-bold mb-2">Subtipo de
                            Producto</label>
                        <select id="subtipo_producto" name="subtipo_producto"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="" selected>Seleccione un subtipo</option>
                        </select>
                    </div>

                    <!-- Agregar jQuery -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#tipo_producto').change(function() {
                                var tipo_id = $(this).val(); // Obtener el ID del tipo de producto seleccionado

                                if (tipo_id) {
                                    $.ajax({
                                        url: '/subtipos/' + tipo_id, // Ruta en Laravel
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                            $('#subtipo_producto').empty(); // Limpiar opciones anteriores
                                            $('#subtipo_producto').append(
                                                '<option value="">Seleccione un subtipo</option>');

                                            // Agregar nuevas opciones
                                            $.each(data, function(key, value) {
                                                $('#subtipo_producto').append('<option value="' + value
                                                    .id + '">' + value.sub_tipo + '</option>');
                                            });
                                        }
                                    });
                                } else {
                                    $('#subtipo_producto').empty();
                                    $('#subtipo_producto').append('<option value="">Seleccione un subtipo</option>');
                                }
                            });
                        });
                    </script>


                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre del Producto</label>
                        <input type="text" id="nombre" name="nombre"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <!-- Marca -->
                    <div class="mb-4">
                        <label for="marca" class="block text-gray-700 font-bold mb-2">Marca</label>
                        <input type="text" id="marca" name="marca"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <!-- Disponibilidad -->
                    <div class="mb-4">
                        <label for="disponibilidad" class="block text-gray-700 font-bold mb-2">Disponibilidad</label>
                        <select id="disponibilidad" name="disponibilidad"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="disponible">Disponible</option>
                            <option value="no_disponible">No Disponible</option>
                        </select>
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="mb-4">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para cargar los subtipos dinámicamente -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tipoSelect = document.getElementById("tipo_producto");
            const subtipoSelect = document.getElementById("subtipo_producto");

            tipoSelect.addEventListener("change", function() {
                const tipoId = this.value;
                subtipoSelect.innerHTML =
                '<option value="">Seleccione un subtipo</option>'; // Limpiar opciones

                if (tipoId) {
                    fetch(`/api/subtipos/${tipoId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(subtipo => {
                                const option = document.createElement("option");
                                option.value = subtipo.id;
                                option.textContent = subtipo.nombre;
                                subtipoSelect.appendChild(option);
                            });
                        });
                }
            });
        });
    </script>
</x-app-layout>
