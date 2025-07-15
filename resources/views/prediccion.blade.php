<!DOCTYPE html>
<html>
<head>
    <title>Predicción de Precios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>🔮 Predicción de Precio por Producto</h2>

        <form action="{{ route('prediccion.consultar') }}" method="POST" class="row g-3 mt-4 mb-4">
            @csrf
            <div class="col-md-6">
                <label for="producto" class="form-label">Producto:</label>
                <select name="id_producto" id="producto" class="form-select" required>
                    <option value="">-- Selecciona un producto --</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ old('id_producto') == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="fecha" class="form-label">Fecha futura:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha') }}" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Predecir</button>
            </div>
        </form>

        @if(isset($resultado))
            <div class="alert alert-success">
                <h4>📈 Resultado de la Predicción:</h4>
                <ul>
                    <li><strong>Producto:</strong> {{ $resultado['nombre_producto'] }}</li>
                    <li><strong>Fecha futura:</strong> {{ $resultado['fecha_objetivo'] }}</li>
                    <li><strong>Precio estimado:</strong> {{ $resultado['precio_predicho'] }} Bs</li>
                    <li><strong>Datos usados:</strong> {{ $resultado['cantidad_datos_usados'] }}</li>
                </ul>
            </div>
        @endif

        @if(isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif
    </div>
</body>
</html>
