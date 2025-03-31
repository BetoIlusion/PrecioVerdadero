
<x-guest-layout>
    @php
        $backgroundImage = asset('images/fondo_comida.jpg');
        $logoImage = asset('images/logo_pv.png');
    @endphp

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $backgroundImage }}')">
        <div class="w-full max-w-xs px-6 py-6 bg-white bg-opacity-90 backdrop-blur-lg rounded-xl shadow-lg">
            <div class="flex justify-center mb-4">
                <img src="{{ $logoImage }}" class="w-12 h-12 object-contain" alt="Logo Gourmet" />
            </div>

            <h1 class="text-xl font-bold text-center text-gray-800 mb-1">Regístrate</h1>
            <p class="text-gray-700 text-sm font-medium mb-1">Tipo de registro: {{ request()->query('tipo') }}</p>

            <x-validation-errors class="mb-3 bg-red-50 p-2 rounded text-sm" />

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf
                
                <div>
                    <x-label for="name" value="{{ __('Nombre') }}" class="text-gray-700 text-sm font-medium" />
                    <x-input id="name" class="block w-full text-sm" type="text" name="name" :value="old('name')" required autofocus placeholder="Tu nombre" />
                </div>

                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 text-sm font-medium" />
                    <x-input id="email" class="block w-full text-sm" type="email" name="email" :value="old('email')" required placeholder="tu@email.com" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Contraseña') }}" class="text-gray-700 text-sm font-medium" />
                    <x-input id="password" class="block w-full text-sm" type="password" name="password" required placeholder="••••••••" />
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" class="text-gray-700 text-sm font-medium" />
                    <x-input id="password_confirmation" class="block w-full text-sm" type="password" name="password_confirmation" required placeholder="••••••••" />
                </div>

                <input id="tipo" type="hidden" name="tipo" value="{{ request()->query('tipo') }}">

                
                <x-button class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 text-sm rounded-md font-medium">
                    {{ __('Registrarse') }}
                </x-button>
                
                <div class="text-center text-xs text-gray-600 mt-3">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-800">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>