<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanzaAccount;
use App\Models\FinanzaCategory;
use App\Models\FinanzaTransaction;
use App\Models\FinanzaBudget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenAI;
use App\Models\ChatbotConversation;

class FinanzaController extends Controller
{
    // Página de inicio: resumen de ingresos/gastos
    public function home()
    {
        $user = Auth::user();
        $query = FinanzaTransaction::query();

        // Si no es admin, filtrar por usuario
        if ($user->rol !== 'admin') {
            $query->where('created_by', $user->id);
        }

        $totalIncome = (clone $query)->where('type','credit')->sum('amount');
        $totalExpense = (clone $query)->where('type','debit')->sum('amount');
        $recent = $query->orderBy('occurred_at','desc')->limit(10)->get();

        return view('finanza.home', compact('totalIncome','totalExpense','recent'));
    }

    // Historial paginado
    public function history(Request $request)
    {
        $user = Auth::user();
        $query = FinanzaTransaction::query();

        // Si no es admin, filtrar por usuario
        if ($user->rol !== 'admin') {
            $query->where('created_by', $user->id);
        }

        $q = $query->orderBy('occurred_at','desc')->paginate(25);
        return view('finanza.history', compact('q'));
    }

    // Metas (CRUD básico - index y store shown)
    public function goals()
    {
        $user = Auth::user();
        $query = FinanzaBudget::with('category');

        // Si no es admin, filtrar por usuario (asumiendo que budgets tienen created_by)
        if ($user->rol !== 'admin') {
            $query->where('created_by', $user->id);
        }

        $budgets = $query->orderBy('start_date','desc')->get();
        return view('finanza.goals', compact('budgets'));
    }

    public function storeGoal(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:finanza_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $data['created_by'] = Auth::id();
        FinanzaBudget::create($data);
        return redirect()->route('finanza.goals')->with('success', 'Meta de ahorro creada correctamente.');
    }

    // Página para agregar transacción
    public function addTransaction()
    {
        return view('finanza.add-transaction');
    }

    // Método para almacenar transacción
    public function storeTransaction(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:credit,debit',
            'category_id' => 'required|exists:finanza_categories,id',
            'account_id' => 'required|exists:finanza_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'occurred_at' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        $data['created_by'] = Auth::id();
        FinanzaTransaction::create($data);
        return redirect()->route('finanza.home')->with('success', 'Transacción agregada correctamente.');
    }

    // Vista del chatbot
    public function chatbotView()
    {
        return view('finanza.chatbot');
    }

    // Endpoint para chatbot IA con OpenAI
    public function chatbot(Request $request)
    {
        $text = $request->input('message');
        $user = Auth::user();

        try {
            // Intentar usar OpenAI primero
            $client = \OpenAI::client(config('services.openai.api_key'));

            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini', // Modelo con mejores límites
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente virtual inteligente y útil como ChatGPT. Responde de manera natural, amigable y en español a cualquier pregunta o tema que el usuario mencione. Sé conversacional, informativo y útil. Si no sabes algo específico, admítelo y ofrece alternativas. Mantén las respuestas concisas pero completas.'],
                    ['role' => 'user', 'content' => $text]
                ],
                'max_tokens' => 500,
                'temperature' => 0.8,
            ]);

            $reply = $response->choices[0]->message->content;

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            \Log::info('OpenAI error: ' . $errorMessage);

            // Manejar específicamente rate limit
            if (str_contains(strtolower($errorMessage), 'rate limit')) {
                $reply = "Lo siento, he alcanzado el límite de solicitudes a mi servicio de IA por ahora. Esto es temporal y se resolverá en unos minutos. Mientras tanto, puedo ayudarte con consejos generales o preguntas sobre finanzas. ¿Qué te gustaría saber?";
            } else {
                // Para otros errores, usar respuestas predefinidas
                $reply = $this->generateChatbotResponse($text);
            }
        }

        // Guardar la conversación en la base de datos
        ChatbotConversation::create([
            'user_id' => $user->id,
            'user_message' => $text,
            'bot_response' => $reply,
        ]);

        return response()->json(['reply' => $reply]);
    }

    private function generateChatbotResponse($message)
    {
        $message = strtolower($message);

        // Respuestas más inteligentes y variadas
        if (str_contains($message, 'hola') || str_contains($message, 'hi') || str_contains($message, 'hello')) {
            return "¡Hola! Soy un asistente virtual inteligente. ¿En qué puedo ayudarte hoy?";
        } elseif (str_contains($message, 'como estas') || str_contains($message, 'cómo estás')) {
            return "Estoy funcionando perfectamente, gracias por preguntar. ¿Y tú? ¿Qué necesitas?";
        } elseif (str_contains($message, 'gracias') || str_contains($message, 'thank')) {
            return "¡De nada! Siempre estoy aquí para ayudarte.";
        } elseif (str_contains($message, 'adiós') || str_contains($message, 'bye') || str_contains($message, 'chau')) {
            return "¡Hasta luego! Que tengas un excelente día.";
        } elseif (str_contains($message, 'tiempo') || str_contains($message, 'clima')) {
            return "No tengo acceso directo al clima, pero te recomiendo usar aplicaciones como Weather App o consultar sitios web de meteorología.";
        } elseif (str_contains($message, 'noticias') || str_contains($message, 'news')) {
            return "Para estar al día con las noticias, te sugiero visitar sitios confiables como BBC, CNN, El País o Google News.";
        } elseif (str_contains($message, 'ayuda') || str_contains($message, 'help')) {
            return "Claro, estoy aquí para ayudarte. Puedo conversar sobre cualquier tema: tecnología, consejos, preguntas generales, etc.";
        } elseif (str_contains($message, 'chiste') || str_contains($message, 'joke')) {
            $jokes = [
                "¿Por qué el libro de matemáticas estaba triste? Porque tenía demasiados problemas.",
                "¿Qué hace una abeja en el gimnasio? ¡Zumba!",
                "¿Por qué los pájaros no usan Facebook? Porque ya tienen Twitter."
            ];
            return $jokes[array_rand($jokes)] . " ¿Quieres otro?";
        } elseif (str_contains($message, 'edad') || str_contains($message, 'old')) {
            return "Como IA, no tengo edad en el sentido humano, pero estoy diseñado para aprender y mejorar constantemente.";
        } elseif (str_contains($message, 'ahorr') || str_contains($message, 'saving')) {
            return "¡Excelente tema! Para ahorrar dinero, te recomiendo: 1) Crear un presupuesto mensual, 2) Establecer metas de ahorro específicas, 3) Automatizar transferencias a una cuenta de ahorros, 4) Revisar gastos innecesarios. ¿Quieres consejos más específicos?";
        } elseif (str_contains($message, 'finanz') || str_contains($message, 'money') || str_contains($message, 'dinero')) {
            return "Las finanzas personales son importantes. Puedo ayudarte con consejos sobre ahorro, presupuesto, inversiones básicas, etc. ¿Qué aspecto te interesa más?";
        } elseif (str_contains($message, 'tecnolog') || str_contains($message, 'tech')) {
            return "¡Me encanta hablar de tecnología! ¿Quieres saber sobre tendencias actuales, consejos para elegir dispositivos, o algo específico?";
        } elseif (str_contains($message, 'consej') || str_contains($message, 'advice')) {
            return "Estoy aquí para dar consejos útiles. ¿Sobre qué tema necesitas orientación? Puedo ayudar con finanzas, productividad, salud, etc.";
        } else {
            // Respuestas más variadas para mensajes no reconocidos
            $responses = [
                "¡Hola! Soy un asistente virtual. Puedo conversar sobre diversos temas. ¿Qué te gustaría hablar?",
                "Estoy aquí para ayudarte. ¿Sobre qué quieres que hablemos?",
                "¡Dime! ¿En qué puedo asistirte hoy?",
                "Soy un chatbot inteligente. ¿Qué pregunta tienes para mí?",
                "¡Hola! ¿Qué tema te interesa discutir?"
            ];
            return $responses[array_rand($responses)];
        }
    }

    private function extractAmount($message)
    {
        // Buscar patrones de montos numéricos (ej. 1000, 1,000, 1000.50, $1000)
        preg_match('/\$?(\d{1,3}(?:,\d{3})*(?:\.\d{2})?|\d+(?:\.\d{2})?)/', $message, $matches);
        if ($matches) {
            // Limpiar comas y convertir a float
            $amount = str_replace(',', '', $matches[1]);
            return (float) $amount;
        }
        return null;
    }

    private function isIncomeRelated($message)
    {
        $lowerMessage = strtolower($message);
        $incomeKeywords = ['salario', 'sueldo', 'ingreso', 'ganar', 'pago', 'cobrar', 'recibir'];
        foreach ($incomeKeywords as $keyword) {
            if (str_contains($lowerMessage, $keyword)) {
                return true;
            }
        }
        return false;
    }
}
