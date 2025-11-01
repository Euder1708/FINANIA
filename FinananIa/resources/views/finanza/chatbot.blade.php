<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asistente Financiero IA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Chatbot Asistente</h3>
                        <a href="{{ route('finanza.home') }}" class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            ← Volver al Inicio
                        </a>
                    </div>

                    <!-- Chat Messages Container -->
                    <div id="chat-messages" class="h-96 overflow-y-auto bg-gray-50 p-4 rounded-lg mb-4 min-h-0">
                        <div class="text-sm text-gray-600 mb-4">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-purple-600">FinanIA AI</span>
                            </div>
                            ¡Hola! Soy un asistente virtual. ¿En qué puedo ayudarte hoy?
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <div class="flex space-x-2">
                        <input type="text" id="chat-input" class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Escribe tu mensaje...">
                        <button id="send-chat" class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-6 py-3 rounded-lg text-sm hover:from-purple-600 hover:to-purple-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Typing Indicator -->
                    <div id="typing-indicator" class="hidden mt-3 text-sm text-gray-500">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-purple-500 rounded-full animate-bounce"></div>
                            <div class="w-3 h-3 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-3 h-3 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <span>FinanIA AI está pensando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chatbot functionality
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
                const response = await fetch('/api/chat', {
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
    </script>
</x-app-layout>
