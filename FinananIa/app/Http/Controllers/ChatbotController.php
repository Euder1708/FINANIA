<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        // Verificar que haya un mensaje del usuario
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json(['error' => 'No se recibió ningún mensaje.'], 400);
        }

        try {
            // Recuperar historial anterior desde la sesión
            $conversation = session('conversation', []);

            // Agregar nuevo mensaje del usuario
            $conversation[] = ['role' => 'user', 'content' => $userMessage];

            // Llamada a OpenAI con historial completo
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => array_merge([
                    [
                        'role' => 'system',
                        'content' => 'Eres FinanIA, un asistente financiero inteligente.
                        Responde de manera clara, útil y amigable.
                        Da consejos sobre ahorro, inversiones, presupuestos y hábitos financieros.
                        Si el usuario pregunta algo fuera de finanzas, puedes responder brevemente pero siempre con un enfoque educativo.'
                    ]
                ], $conversation),
            ]);

            // Obtener la respuesta del modelo
            $assistantReply = $response['choices'][0]['message']['content'] ?? 'No se recibió respuesta de la IA.';

            // Agregar respuesta del asistente al historial
            $conversation[] = ['role' => 'assistant', 'content' => $assistantReply];

            // Guardar historial en sesión
            session(['conversation' => $conversation]);

            return response()->json([
                'success' => true,
                'reply' => $assistantReply,
            ]);

        } catch (\Exception $e) {
            // Capturar errores y mostrarlos en logs para debug
            \Log::error('Error en ChatbotController: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'reply' => 'Lo siento, ocurrió un error al procesar tu mensaje. Por favor, inténtalo de nuevo más tarde.'
            ], 500);
        }
    }
}
