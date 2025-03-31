
<x-guest-layout>
    @php
        $backgroundImage = asset('images/fondo_comida.jpg');
        $logoImage = asset('images/logo_pv.png');
    @endphp

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $backgroundImage }}')">
        <div class="w-full max-w-xs px-6 py-6 bg-white bg-opacity-90 backdrop-blur-lg rounded-xl shadow-lg">
            <!-- Logo compacto -->
            <div class="flex justify-center mb-4">
                <img src="{{ $logoImage }}" class="w-12 h-12 object-contain" alt="Logo Gourmet" />
            </div>

            <h1 class="text-xl font-bold text-center text-gray-800 mb-1">Bienvenido</h1>
            <p class="text-center text-gray-600 text-sm mb-5">Ingresa a tu cuenta</p>

            <x-validation-errors class="mb-3 bg-red-50 p-2 rounded text-sm" />

            @if (session('status'))
                <div class="mb-3 p-2 bg-green-50 text-green-700 rounded text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-3">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 text-sm font-medium" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <x-input id="email" class="block w-full pl-7 text-sm" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" placeholder="tu@email.com" />
                    </div>
                </div>

                <div>
                    <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 text-sm font-medium" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <x-input id="password" class="block w-full pl-7 text-sm" type="password" name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" class="rounded text-amber-600 h-3 w-3" />
                        <span class="ml-1 text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-amber-600 hover:text-amber-800" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <x-button class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 text-sm rounded-md font-medium">
                    {{ __('Log in') }}
                </x-button>

                <div class="text-center text-xs text-gray-600 mt-3">
                    ¿No tienes cuenta? <a href="{{ route('register') }}"
                        class="text-amber-600 hover:text-amber-800">Regístrate</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
