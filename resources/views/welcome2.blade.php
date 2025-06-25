
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Simplificado</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card-hover:hover {
            transform: translateY(-30px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-glow:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.7);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #b4c1fe 0%, #a0b0fe 100%);
        }
    </style>
</head>

<body class="bg-black min-h-screen flex flex-col">
    <!-- Header -->
<header class="py-3 px-8 fixed top-0 left-0 w-full z-20 flex justify-between items-center bg-gradient-to-b from-white/30 via-white/10 to-transparent backdrop-blur-md">
    <div class="flex items-center">
        <img id="dynamicImage" src="{{ asset('images/logo_pv.gif') }}" alt="Mi Animación"
            class="h-24 w-auto rounded-lg shadow-lg bg-white p-2 border border-gray-200 transition-all duration-500 ease-in-out hover:scale-105">
    </div>
    
    @if (Route::has('login'))
    <div class="text-right space-x-4">
        @auth
            <a href="{{ url('/dashboard') }}" class="font-semibold text-white hover:text-gray-300 transition-colors duration-300">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="font-semibold text-white hover:text-gray-300 transition-colors duration-300">Log in</a>
        @endauth
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const img = document.getElementById('dynamicImage');
            img.onload = function() {
                const gifDuration = 5000; // Ajusta según la duración real de tu GIF
                setTimeout(() => {
                    img.src = "{{ asset('images/logo_pv.png') }}";
                    img.alt = "Imagen Estática";
                    img.classList.remove('border-gray-200');
                    img.classList.add('border-gray-300');
                }, gifDuration);
            };
        });
    </script>
</header>

    

    <!-- Espaciador para evitar solapamiento -->
    <div class="h-28"></div>

    <!-- Contenido principal -->
    <main class="flex-grow bg-cover bg-center bg-no-repeat"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/fondo_comida.jpg') }}')">
        <div class="container mx-auto px-4 py-8">
            <!-- Texto introductorio -->
            <div class="text-center mb-12 max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold text-orange-50 mb-4">Bienvenido</h1>
                <p class="text-gray-100">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua.
                </p>
            </div>

            <!-- Cards -->
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto mb-12">
               
                <!-- Card Azul -->
                <a href="{{ route('register', ['tipo' => 'mercader']) }}" class="card-hover card-glow transition-all duration-300 ease-in-out">
                    <div class="bg-blue-600 rounded-xl p-6 text-white h-64 flex flex-col relative overflow-hidden">
                        <h2 class="text-2xl font-semibold mb-3">Mercader</h2>
                        <p class="mb-4 flex-grow">Ingresa tus productos y refleja el valor verdadero en el mercado</p>
                        <div class="absolute bottom-4 right-4 bg-blue-700 backdrop-blur-md p-2 rounded-full">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </a>


                <!-- Card Amarillo -->
                <a href="{{ route('register', ['tipo' => 'cliente']) }}" class="card-hover card-glow transition-all duration-300 ease-in-out">
                    <div class="bg-yellow-500 rounded-xl p-6 text-gray-900 h-64 flex flex-col relative overflow-hidden">
                        <h2 class="text-2xl font-semibold mb-3">Cliente</h2>
                        <p class="mb-4 flex-grow">Únete para que obtener las mejores recetas , ve el precio de tu producto en el mercado
                        </p>
                        <div class="absolute bottom-4 right-4 bg-yellow-600 backdrop-blur-md p-2 rounded-full">
                            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Botón ancho debajo -->
            <div class="text-center">
                <a href="#"
                    class="inline-block bg-indigo-600 text-white px-12 py-4 rounded-full text-lg font-semibold hover:bg-indigo-700 transition-colors duration-300">
                    Descarga la app ahora mismo
                </a>
            </div>
            <div class="h-12"></div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-4 text-center">
        <p>© 2025 Tu Empresa. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
