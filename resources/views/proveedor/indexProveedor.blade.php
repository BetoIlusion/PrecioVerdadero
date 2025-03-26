<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showModal: false, selectedUser: null, currentIndex: 0, statuses: ['Estado 1', 'Estado 2', 'Estado 3', 'Estado 4'] }" x-init="setInterval(() => { currentIndex = (currentIndex + 1) % statuses.length }, 5000)">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Primera sección: Lista con modal -->
            <div class="flex space-x-6">
                <!-- Espacio cuadrado a la izquierda (placeholder) -->
                <div class="w-1/3 bg-gray-100 rounded-lg p-6 flex-shrink-0">
                    <p class="text-gray-500 italic">Espacio reservado</p>
                </div>

                <!-- Lista de usuarios a la derecha -->
                <div class="w-2/3 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rol</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr class="cursor-pointer hover:bg-gray-100"
                                    @click="showModal = true; selectedUser = {{ $user->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->role ?? 'Usuario' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal inline -->
            <div x-show="showModal" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
                x-on:keydown.escape.window="showModal = false" style="display: none;">
                <div x-show="showModal" class="fixed inset-0 transform transition-all" x-on:click="showModal = false"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <div x-show="showModal"
                    class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md sm:mx-auto"
                    x-trap.inert.noscroll="showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Usuario Seleccionado</h3>
                        <p class="mt-2 text-gray-600">¿Quieres ver los detalles del usuario?</p>
                        <div class="mt-4 flex space-x-4">
                            <x-button @click="showModal = false">
                                {{ __('Cancelar') }}
                            </x-button>
                            <a href="#" x-bind:href="selectedUser ? '/user/' + selectedUser : '#'"
                                class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">
                                {{ __('Ver Detalles') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nueva sección: Lista deslizante y cuadro de estados -->
            <div class="mt-8 flex space-x-6">
                <!-- Lista deslizante a la izquierda -->
                <div
                    class="w-1/2 bg-gray-100 rounded-lg shadow-md p-4 overflow-hidden h-24 flex items-center border border-gray-300">
                    <div class="relative w-full h-full flex items-center justify-center">
                        <template x-for="(status, index) in statuses" :key="index">
                            <div x-show="currentIndex === index"
                                class="absolute w-full text-center font-medium text-lg text-gray-800"
                                style="font-family: 'Lora', serif;" x-transition:enter="ease-out duration-500"
                                x-transition:enter-start="opacity-0 -translate-y-10"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="ease-in duration-500"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-10">
                                <span x-text="status"
                                    class="block px-3 py-1 bg-teal-200 text-teal-900 rounded-md shadow-sm"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Cuadro de actualización de estados a la derecha -->
                <div class="w-1/2 bg-white rounded-lg shadow-xl p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actualización de Estados</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-700">Estado Pendiente</li>
                        <li class="text-gray-700">Estado En Progreso</li>
                        <li class="text-gray-700">Estado Completado</li>
                    </ul>
                    <div class="mt-4 flex space-x-4">
                        <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Mantener</button>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Editar</button>
                        <button class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Recordar más
                            tarde</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
