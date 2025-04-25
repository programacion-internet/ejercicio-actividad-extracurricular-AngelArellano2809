<?php

namespace App\Http\Controllers;

use App\Models\ArchivoEvento;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Gate;

class ArchivoEventoController extends Controller
{
    public function index(Evento $evento)
    {
        if (!$evento->users->contains(auth()->id())) {
            abort(403, 'No estás inscrito en este evento');
        }

        $query = $evento->archivos();
        
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        $archivos = $query->get();

        return view('eventos.show', compact('evento', 'archivos'));
    }

    public function upload(Request $request, Evento $evento)
    {
        Gate::authorize('upload', $evento);
        
        $request->validate([
            'archivo' => 'required|file|max:10240' // Máximo 10MB
        ]);

        if ($request->file('archivo')->isValid()) {
            $file = $request->file('archivo');
            
            $nombreHash = $file->store('archivos_eventos/' . $evento->id);
            
            ArchivoEvento::create([
                'nombre_original' => $file->getClientOriginalName(),
                'nombre_hash' => $nombreHash,
                'tamaño' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'evento_id' => $evento->id,
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->back()->with('success', 'Archivo subido correctamente');
    }

    public function download(Evento $evento, ArchivoEvento $archivo)
    {
        Gate::authorize('view', $archivo);
        return Storage::download($archivo->nombre_hash, $archivo->nombre_original);
    }

    public function delete(Evento $evento, ArchivoEvento $archivo)
    {
        Gate::authorize('delete', $archivo);

        Storage::delete($archivo->nombre_hash);
        $archivo->delete();

        return redirect()->back()->with('success', 'Archivo eliminado');
    }
}