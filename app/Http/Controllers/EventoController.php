<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evento;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;

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
        $users = User::all();
        return view('eventos.evento-show', compact('eventos', 'users'));
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

    public function actualizarUsersEvento(Request $request, Evento $evento)
    {
        $evento->users()->sync($request->user_id);
        return redirect()->route('evento.show', $evento);
    }
}
