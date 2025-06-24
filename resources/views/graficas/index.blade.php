<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gráficas de Precios - Mercader') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Caja de Selección de Producto -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="bg-blue-500 px-6 py-4 text-white font-bold text-lg">
                    Selección de Producto
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <select id="productoSelect"
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            onchange="actualizarGrafica()">
                            <option value="">-- Selecciona un producto --</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Caja de Gráfica -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="bg-green-500 px-6 py-4 text-white font-bold text-lg">
                    Historial de Precios
                </div>
                <div class="p-6">
                    <canvas id="precioChart" class="w-full h-96"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let precioChart;

        function inicializarGrafica(labels = [], precios = []) {
            const ctx = document.getElementById('precioChart').getContext('2d');

            // Destroy existing chart if it exists
            if (precioChart) {
                precioChart.destroy();
            }

            precioChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Precio a través del tiempo',
                        data: precios,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Precio'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Fecha y Hora'
                            }
                        }
                    }
                }
            });
        }

        function actualizarGrafica() {
            const productoId = document.getElementById('productoSelect').value;

            if (!productoId) {
                inicializarGrafica(); // Initialize empty chart
                return;
            }

            // Fetch price history via AJAX
            fetch(`/graficas/precios/${productoId}`)
                .then(response => response.json())
                .then(data => {
                    inicializarGrafica(data.labels, data.precios);
                })
                .catch(error => {
                    console.error('Error fetching price history:', error);
                    inicializarGrafica(); // Initialize empty chart on error
                });
        }

        // Initialize empty chart on page load
        document.addEventListener('DOMContentLoaded', () => {
            inicializarGrafica();
        });
    </script>
</x-app-layout>