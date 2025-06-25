<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\EstadoProducto;
use App\Models\UsuarioProducto;

use Illuminate\Support\Facades\Log;
use App\Models\Usuario;
use App\Models\Tienda;
use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Notification;
use App\Models\Sugerencia;
use App\Models\HistorialProducto;
use Illuminate\Support\Facades\Http;



class DashboardController extends Controller
{
    // En app/Http/Controllers/DashboardController.php
    public function linkApk()
    {
        return redirect()->away('https://drive.google.com/drive/folders/191OrE3BQFsW0_ox2QBCRZJtKsebAzqa8?usp=sharing');
    }
    public function index()
    {

        $user = auth()->user();
        $useri = User::find($user->id);
        // 1. Ahora añadimos with('producto') para cargar la relación
        $productos = $useri->usuarioProductos()->with('producto')->get();

        return view('dashboard', compact('productos'));
    }
    
public function analizarPromediosYNotificar()
{
    $ahora = now();
    $haceUnMinuto = $ahora->copy()->subMinute();
    $haceDosMinutos = $ahora->copy()->subMinutes(2);

    $usuarioProductos = UsuarioProducto::with('producto')
        ->where('existe', true)
        ->get();

    foreach ($usuarioProductos as $usuarioProducto) {
        $promedioActual = HistorialProducto::where('id_usuario_producto', $usuarioProducto->id)
            ->where('updated_at', '>=', $haceUnMinuto)
            ->avg('precio');

        $promedioAnterior = HistorialProducto::where('id_usuario_producto', $usuarioProducto->id)
            ->whereBetween('updated_at', [$haceDosMinutos, $haceUnMinuto])
            ->avg('precio');

        if (!is_null($promedioActual) && !is_null($promedioAnterior)) {
            $variacion = abs($promedioActual - $promedioAnterior);

            if ($variacion > 0.01) {
                $nombreProducto = $usuarioProducto->producto->nombre ?? 'producto desconocido';
                $prompt = "El promedio de precio del producto '{$nombreProducto}' en el último minuto es {$promedioActual}. El promedio del minuto anterior era {$promedioAnterior}. Analiza la tendencia y predice el precio futuro o da un consejo relevante.";

                try {
                    $respuesta = $this->procesarPromptConGemini($prompt);
                    $respuestaTexto = $respuesta['respuesta'] ?? 'No se pudo obtener respuesta de la IA.';
                } catch (\Exception $e) {
                    Log::error('Error al procesar el prompt con Gemini', [
                        'mensaje' => $e->getMessage()
                    ]);
                    $respuestaTexto = 'No se pudo procesar la sugerencia debido a un error interno.';
                }

                Sugerencia::create([
                    'sugerencia' => $respuestaTexto,
                    'existe' => true,
                    'id_usuario_producto' => $usuarioProducto->id,
                    'id_producto' => $usuarioProducto->id_producto,
                ]);

                Notification::create([
                    'user_id' => $usuarioProducto->id_usuario,
                    'message' => $respuestaTexto,
                    'read' => false,
                ]);
            }
        }
    }

    return response()->json(['status' => 'ok']);
}

public function procesarPromptConGemini($prompt)
{
    Log::info('Iniciando análisis del prompt con Google Gemini');
    try {
        // Validación básica
        if (empty($prompt) || !is_string($prompt) || strlen($prompt) > 4000) {
            throw new \Exception('Prompt inválido o demasiado largo.');
        }
        Log::debug('Prompt recibido y validado.');

        // Obtener clave API desde archivo de configuración
        $apiKey = config('app.google_api_key');
        if (!$apiKey) {
            Log::error('Falta GOOGLE_API_KEY en .env o en config/app.php');
            throw new \Exception('Google API Key no configurada');
        }
        Log::debug('Clave API cargada correctamente desde configuración.');

        // URL del modelo Gemini
        $model = 'gemini-1.5-flash-latest';
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        // Armar payload de solicitud
        $payload = [
            'contents' => [[
                'parts' => [[ 'text' => $prompt ]]
            ]],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 32,
                'topP' => 1,
                'maxOutputTokens' => 1024
            ],
            'safetySettings' => [
                ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE']
            ]
        ];

        Log::info("Enviando solicitud a Gemini API: {$model}");

        // Ejecutar la solicitud POST a Gemini
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(60)->post($apiUrl, $payload);

        Log::info("Respuesta recibida. Status: " . $response->status());

        if ($response->failed()) {
            Log::error('Error de Gemini API', ['body' => $response->body()]);
            throw new \Exception('Falló la llamada a Gemini API');
        }

        $data = $response->json();
        $respuestaGenerada = data_get($data, 'candidates.0.content.parts.0.text');

        if (!$respuestaGenerada) {
            Log::warning('Gemini no devolvió contenido útil.');
            return ['error' => 'La respuesta fue vacía o bloqueada.'];
        }

        Log::info('Texto generado por Gemini recibido con éxito.');
        return ['respuesta' => $respuestaGenerada];
    } catch (\Exception $e) {
        Log::error('Excepción procesando prompt con Gemini', [
            'mensaje' => $e->getMessage(),
            'archivo' => $e->getFile(),
            'linea' => $e->getLine(),
        ]);
        return [
            'error' => 'Ocurrió un error al procesar el prompt.',
            'mensaje' => $e->getMessage()
        ];
    }
}


    public function mantener($id)
    {
        $usuarioProducto = UsuarioProducto::findOrFail($id);
        HistorialProducto::create([
            'precio' => $usuarioProducto->precio,
            'fecha' => now(),
            'id_usuario_producto' => $usuarioProducto->id,
            'id_estado_producto' => $usuarioProducto->id_estado,
        ]);
        return back()->with('success', 'Precio mantenido y registrado en historial.');
    }

    public function modificar(Request $request, $id)
    {
        $request->validate(['precio' => 'required|numeric|min:0']);
        $usuarioProducto = UsuarioProducto::findOrFail($id);
        $usuarioProducto->precio = $request->precio;
        $usuarioProducto->save();

        // Registrar en historial
        HistorialProducto::create([
            'precio' => $usuarioProducto->precio,
            'fecha' => now(),
            'id_usuario_producto' => $usuarioProducto->id,
            'id_estado_producto' => $usuarioProducto->id_estado,
        ]);
        return back()->with('success', 'Precio modificado y registrado en historial.');
    }

    public function promediar($id)
    {
        $usuarioProducto = UsuarioProducto::findOrFail($id);
        $promedio = HistorialProducto::where('id_usuario_producto', $usuarioProducto->id)
            ->where('updated_at', '>=', now()->subMinute())
            ->avg('precio');
        if ($promedio) {
            $usuarioProducto->precio = $promedio;
            $usuarioProducto->save();
            HistorialProducto::create([
                'precio' => $promedio,
                'fecha' => now(),
                'id_usuario_producto' => $usuarioProducto->id,
                'id_estado_producto' => $usuarioProducto->id_estado,
            ]);
        }
        return back()->with('success', 'Precio promediado y registrado en historial.');
    }
}
