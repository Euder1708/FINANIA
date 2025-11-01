<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FinanzaController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

// Página pública de finanzas (home) - muestra login/registro a invitados
Route::get('/finanza', [FinanzaController::class, 'home'])->name('finanza.home');

Route::middleware('auth')->group(function () {
    // Dashboard: redirige a finanzas para todos
    Route::get('/dashboard', function () {
        return redirect()->route('finanza.home');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    // Finanza (todos los usuarios autenticados)
    Route::get('/finanza/add-transaction', [App\Http\Controllers\FinanzaController::class, 'addTransaction'])->name('finanza.addTransaction');
    Route::get('/finanza/history', [App\Http\Controllers\FinanzaController::class, 'history'])->name('finanza.history');
    Route::get('/finanza/goals', [App\Http\Controllers\FinanzaController::class, 'goals'])->name('finanza.goals');
    Route::get('/finanza/chatbot', [App\Http\Controllers\FinanzaController::class, 'chatbotView'])->name('finanza.chatbot');
    Route::post('/finanza/goals', [App\Http\Controllers\FinanzaController::class, 'storeGoal'])->name('finanza.goals.store');
    Route::post('/finanza/store-transaction', [App\Http\Controllers\FinanzaController::class, 'storeTransaction'])->name('finanza.storeTransaction');
    Route::post('/finanza/chatbot/message', [App\Http\Controllers\FinanzaController::class, 'chatbot'])->name('finanza.chatbot.message');
});

require __DIR__.'/auth.php';
