<?php

namespace App\Services;

use OpenAI;

class ChatbotService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }

    public function enviarMensaje($mensaje)
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo', // o 'gpt-4-turbo', 'gpt-4o', etc.
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un asistente amigable integrado en un sistema Laravel.'],
                ['role' => 'user', 'content' => $mensaje],
            ],
        ]);

        return $response['choices'][0]['message']['content'];
    }
}
