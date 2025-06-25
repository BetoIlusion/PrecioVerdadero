<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Botón Productos -->

                    <a href="{{ route('tipo-producto.index') }}">
                        <x-button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md">
                            <span class="text-lg">Tipo Productos</span>
                        </x-button>
                    </a>
                    

                    <!-- Botón Estadísticas -->
                       <a href="{{ route('productos.index') }}">
                    <x-button class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md">
                        <span class="text-lg">Productos</span>
                    </x-button>
                    </a>

                    <!-- Botón Detalles -->
                    <x-button class="w-full bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md">
                        <span class="text-lg">Detalles</span>
                    </x-button>

                    <!-- Botón Otros -->
                    <x-button class="w-full bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-md">
                        <span class="text-lg">Otros</span>
                    </x-button>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
