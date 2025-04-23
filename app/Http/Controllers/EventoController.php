<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evento;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;

use App\Mail\InscripcionConfirmada;
use Illuminate\Support\Facades\Mail;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('eventos.evento-index', ['eventos' => Evento::all()],);
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
        // Verificar que el usuario está inscrito
        if (!auth()->user()->is_admin && !$evento->users->contains(auth()->id())) {
            abort(403, 'No estás inscrito en este evento');
        }
    
        // Obtener archivos según el tipo de usuario
        $archivosQuery = $evento->archivos();
        
        if (!auth()->user()->is_admin) {
            $archivosQuery->where('user_id', auth()->id());
        }
    
        $archivos = $archivosQuery->get();
    
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
        // Si es una petición GET, redirige al show del evento
        if ($request->isMethod('get')) {
            return redirect()->route('eventos.show', $evento);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();
        
        // Verificar si ya está inscrito
        if($evento->users()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Ya estás inscrito en este evento');
        }

        // Inscribir al usuario
        $evento->users()->attach($user->id);

        // Enviar correo de confirmación
        Mail::to($user->email)->send(new InscripcionConfirmada($evento, $user));

        return back()->with('success', 'Inscripción exitosa. Se ha enviado un correo de confirmación.');
    }
}
