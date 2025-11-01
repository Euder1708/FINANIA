<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Total Ingresos</h3>
                            <p class="text-3xl font-bold">${{ number_format($totalIncome, 2) }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Total Gastos</h3>
                            <p class="text-3xl font-bold">${{ number_format($totalExpense, 2) }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Balance</h3>
                            <p class="text-3xl font-bold ${{ $totalIncome - $totalExpense >= 0 ? 'text-green-200' : 'text-red-200' }}">
                                ${{ number_format($totalIncome - $totalExpense, 2) }}
                            </p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Metas de Ahorro</h3>
                            <p class="text-purple-100">Gestiona tus objetivos financieros</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('finanza.goals') }}" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver Metas
                        </a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Historial Completo</h3>
                            <p class="text-cyan-100">Revisa todas tus transacciones</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('finanza.history') }}" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver Historial
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Transacciones Recientes</h3>
                        <a href="{{ route('finanza.history') }}" class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            Ver todas →
                        </a>
                    </div>

                    @if($recent->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent as $transaction)
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg hover:from-gray-100 hover:to-gray-200 transition-all duration-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center
                                                {{ $transaction->type === 'credit' ? 'bg-emerald-100' : 'bg-rose-100' }}">
                                                <svg class="w-6 h-6 {{ $transaction->type === 'credit' ? 'text-emerald-600' : 'text-rose-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $transaction->type === 'credit' ? 'M12 6v6m0 0v6m0-6h6m-6 0H6' : 'M20 12H4' }}"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $transaction->description }}</p>
                                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($transaction->occurred_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-semibold {{ $transaction->type === 'credit' ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $transaction->type === 'credit' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }}
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $transaction->type === 'credit' ? 'Ingreso' : 'Gasto' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-24 w-24 text-gray-400">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay transacciones recientes</h3>
                            <p class="mt-1 text-sm text-gray-500">Comienza agregando tu primera transacción financiera.</p>
                            <div class="mt-6">
                                <a href="{{ route('finanza.addTransaction') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Agregar Transacción
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        // Chatbot functionality
        document.getElementById('open-chatbot').addEventListener('click', function() {
            document.getElementById('chatbot-modal').classList.remove('hidden');
        });

        document.getElementById('close-chatbot').addEventListener('click', function() {
            document.getElementById('chatbot-modal').classList.add('hidden');
        });

        document.getElementById('send-chat').addEventListener('click', async function() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            if (!message) return;

            // Disable send button
            const sendButton = document.getElementById('send-chat');
            sendButton.disabled = true;
            sendButton.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';

            // Add user message
            const messagesDiv = document.getElementById('chat-messages');
            messagesDiv.innerHTML += '<div class="text-right mb-4"><div class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg shadow-sm max-w-xs break-words">' + message + '</div></div>';
            input.value = '';

            // Show typing indicator
            const typingIndicator = document.getElementById('typing-indicator');
            typingIndicator.classList.remove('hidden');

            // Scroll to bottom
            messagesDiv.scrollTop = messagesDiv.scrollHeight;

            // Send to server
            try {
                const response = await fetch('/finanza/chatbot', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: message })
                });
                const data = await response.json();

                // Hide typing indicator
                typingIndicator.classList.add('hidden');

                // Add bot response with avatar
                messagesDiv.innerHTML += '<div class="mb-4"><div class="flex items-start space-x-3"><div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div><div class="inline-block bg-gradient-to-r from-purple-50 to-purple-100 text-purple-800 px-4 py-2 rounded-lg shadow-sm border border-purple-200 max-w-2xl break-words">' + data.reply + '</div></div></div>';
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            } catch (error) {
                // Hide typing indicator
                typingIndicator.classList.add('hidden');
                console.error('Error:', error);
                messagesDiv.innerHTML += '<div class="mb-4"><div class="flex items-start space-x-3"><div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg></div><div class="inline-block bg-gradient-to-r from-red-50 to-red-100 text-red-800 px-4 py-2 rounded-lg shadow-sm border border-red-200 max-w-2xl break-words">Lo siento, hubo un error al procesar tu mensaje. Por favor, intenta de nuevo.</div></div></div>';
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            } finally {
                // Re-enable send button
                sendButton.disabled = false;
                sendButton.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>';
            }
        });

        // Enter key for chat
        document.getElementById('chat-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('send-chat').click();
            }
        });

        // Close modal when clicking outside
        document.getElementById('chatbot-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                document.getElementById('close-chatbot').click();
            }
        });
    </script>
</x-app-layout>
