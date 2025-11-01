<?php

use OpenAI\Laravel\Facades\OpenAI;

$response = OpenAI::chat()->create([
    'model' => 'gpt-4o-mini',
    'messages' => [['role' => 'user', 'content' => 'Hola, quien eres?']]
]);

echo $response['choices'][0]['message']['content'];
