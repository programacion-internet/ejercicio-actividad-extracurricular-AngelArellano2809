<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evento;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;

use App\Mail\InscripcionConfirmada;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mostrar solo eventos futuros para todos los usuarios
        $eventos = Evento::where('fecha', '>=', now())->get();
        
        return view('eventos.evento-index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $archivos = auth()->user()->is_admin 
            ? $evento->archivos()->with('user')->get() 
            : $evento->archivos()->where('user_id', auth()->id())->get();
        
        return view('eventos.evento-show', [
            'evento' => $evento,
            'archivos' => $archivos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoRequest $request, Evento $evento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        //
    }

    public function inscribir(Request $request, Evento $evento)
    {
        Gate::authorize('inscribir', $evento);
    
        $user = $request->user();
        $evento->users()->attach($user->id);

        // Enviar correo de confirmación
        Mail::to($user->email)->send(new InscripcionConfirmada($evento, $user));

        return back()->with('success', 'Inscripción exitosa');

    }
}
