<?php

use App\Http\Controllers\EventoController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('eventos.index');
})->name('home');

Route::post('/eventos/{evento}/inscribir', [EventoController::class, 'inscribir'])
    ->name('eventos.inscribir')
    ->middleware(['auth']);

Route::resource('eventos', EventoController::class)->middleware(['auth', 'verified']);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
