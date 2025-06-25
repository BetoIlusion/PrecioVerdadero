<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden">
                <div class="p-8 sm:p-12 text-center">
                    
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 flex items-center justify-center bg-green-100 dark:bg-green-900/50 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">
                        ¡Tu cuenta ha sido creada!
                    </h3>

                    <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed max-w-2xl mx-auto mb-8">
                        Estamos encantados de tenerte a bordo. Para comenzar, descarga nuestra aplicación móvil y explora el precio de los productos del mercado desde tu teléfono.
                    </p>

                    <a href="{{ route('download.app') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-transform duration-300 hover:scale-105 shadow-lg">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Descargar la Aplicación
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>