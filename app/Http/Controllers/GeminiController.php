<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeminiController extends Controller
{
   public function consultarGemini(Request $request)
{
  $apiKey = env('GEMINI_API_KEY');
        $mensaje = $request->input('message', 'Hola');

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $postData = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $mensaje]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        $respuesta = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sin respuesta';

        return response()->json([
            'mensaje_enviado' => $mensaje,
            'respuesta' => $respuesta
        ]);
    }
}
