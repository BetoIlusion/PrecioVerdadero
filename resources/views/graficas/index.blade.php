<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gráficas de Precios - Mercader') }}
        </h2>
    </x-slot>

    <!-- Controles superiores: Botón e inputs -->
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 md:space-x-4">
            <!-- Filtros por fecha -->
            <div class="flex items-center space-x-4">
                <div>
                    <label for="fechaInicio" class="block text-sm font-medium text-gray-700">Inicio de Fecha</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="fechaFin" class="block text-sm font-medium text-gray-700">Final de Fecha</label>
                    <input type="date" id="fechaFin" name="fechaFin" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Botón de imprimir -->
            <div>
                <button onclick="window.print()"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Imprimir Reporte
                </button>
            </div>
        </div>
    </div>

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

            if (precioChart) {
                precioChart.destroy();
            }

            precioChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Precio a través del tiempo',
                        data: precios,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                        pointRadius: 4,
                        pointHoverRadius: 6
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
                inicializarGrafica();
                return;
            }

            fetch(`/graficas/precios/${productoId}`)
                .then(response => response.json())
                .then(data => {
                    inicializarGrafica(data.labels, data.precios);
                })
                .catch(error => {
                    console.error('Error fetching price history:', error);
                    inicializarGrafica();
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            inicializarGrafica();
        });
    </script>
</x-app-layout>
