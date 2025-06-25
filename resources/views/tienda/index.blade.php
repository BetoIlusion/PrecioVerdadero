<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Tiendas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Formulario para crear actividad -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Crear Actividad</h3>
                    <form id="form-actividad" method="POST" action="{{ route('actividad.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700">Mercader:</label>
                            <select name="id_usuario_mercader" class="w-full border border-gray-300 rounded px-3 py-2" required>
                                @foreach(\App\Models\User::role('mercader')->get() as $mercader)
                                    <option value="{{ $mercader->id }}">{{ $mercader->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Cliente:</label>
                            <select name="id_usuario_cliente" class="w-full border border-gray-300 rounded px-3 py-2" required>
                                @foreach(\App\Models\User::role('cliente')->get() as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Tipo de Actividad:</label>
                            <select name="id_tipo_actividad" class="w-full border border-gray-300 rounded px-3 py-2" required>
                                @foreach(\App\Models\TipoActividad::all() as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Crear Actividad</button>
                    </form>
                    <div id="form-success" class="hidden mt-4 text-green-600 font-semibold"></div>
                </div>

                @if($tiendas->isEmpty())
                    <p>No tienes tiendas registradas.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tiendas as $tienda)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tienda->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tienda->tipo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($tienda->ubicacion)
                                            {{ $tienda->ubicacion->direccion }}
                                        @else
                                            Sin ubicación
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="openEditModal({{ $tienda->id }}, '{{ $tienda->nombre }}', '{{ $tienda->tipo }}')"
                                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                            Editar
                                        </button>
                                        <button onclick="openUbicacionModal({{ $tienda->id }}, {{ $tienda->ubicacion ? $tienda->ubicacion->id : 'null' }}, {{ $tienda->ubicacion ? $tienda->ubicacion->latitud : 'null' }}, {{ $tienda->ubicacion ? $tienda->ubicacion->longitud : 'null' }}, '{{ $tienda->ubicacion ? $tienda->ubicacion->direccion : '' }}')"
                                                class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded">
                                            {{ $tienda->ubicacion ? 'Editar Ubicación' : 'Agregar Ubicación' }}
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

                <button onclick="openCreateModal()" class="mt-6 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Crear Tienda</button>
            </div>
        </div>
    </div>

    @include('tienda.modal')

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $('#form-actividad').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: this.action,
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#form-success').text(response.message).removeClass('hidden');
                    $('#form-actividad').trigger('reset');
                    setTimeout(() => $('#form-success').addClass('hidden'), 5000);
                },
                error: function (xhr) {
                    alert('Error al crear la actividad: ' + xhr.responseJSON.message);
                }
            });
        });
    </script>
</x-app-layout>