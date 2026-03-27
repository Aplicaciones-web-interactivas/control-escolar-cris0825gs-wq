<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Entrega;
use App\Models\Grupo;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'maestro') {
            $tareas = Tarea::with('grupo', 'maestro')->where('maestro_id', $user->id)->get();
            return view('tareas.index_maestro', compact('tareas'));
        }

        // alumno
        $grupoIds = Inscripcion::where('user_id', $user->id)->pluck('grupo_id');
        $tareas = Tarea::whereIn('grupo_id', $grupoIds)->with('grupo', 'maestro')->get();
        return view('tareas.index_alumno', compact('tareas'));
    }

    public function create()
    {
        $user = Auth::user();
        abort_if($user->role !== 'maestro', 403);

        $grupos = Grupo::whereHas('horario', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('horario.materia')->get();

        return view('tareas.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        abort_if($user->role !== 'maestro', 403);

        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_entrega' => 'nullable|date',
        ]);

        // Verificar que el maestro sea responsable de ese grupo
        $grupo = Grupo::findOrFail($request->grupo_id);
        if ($grupo->horario->user_id !== $user->id) {
            abort(403, 'No tienes permiso para asignar tareas a este grupo.');
        }

        Tarea::create([
            'grupo_id' => $request->grupo_id,
            'maestro_id' => $user->id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_entrega' => $request->fecha_entrega,
        ]);

        return redirect()->route('tareas.index')->with('success', 'Tarea creada con éxito');
    }

    public function show($id)
    {
        $tarea = Tarea::with('grupo.horario.materia', 'maestro', 'entregas.alumno')->findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'maestro') {
            abort_if($tarea->maestro_id !== $user->id, 403);
            return view('tareas.show_maestro', compact('tarea'));
        }

        // alumno
        $inscrito = Inscripcion::where('user_id', $user->id)->where('grupo_id', $tarea->grupo_id)->exists();
        abort_unless($inscrito, 403);

        $entrega = Entrega::where('tarea_id', $tarea->id)->where('alumno_id', $user->id)->first();
        return view('tareas.show_alumno', compact('tarea', 'entrega'));
    }

    public function storeEntrega(Request $request, $id)
    {
        $user = Auth::user();
        abort_if($user->role !== 'alumno', 403);

        $tarea = Tarea::findOrFail($id);

        $inscrito = Inscripcion::where('user_id', $user->id)->where('grupo_id', $tarea->grupo_id)->exists();
        abort_unless($inscrito, 403);

        $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:10240',
        ]);

        $ruta = $request->file('archivo')->storeAs('entregas', now()->timestamp . '_' . $user->id . '_' . $request->file('archivo')->getClientOriginalName());

        $entrega = Entrega::updateOrCreate(
            ['tarea_id' => $tarea->id, 'alumno_id' => $user->id],
            ['archivo_ruta' => $ruta, 'revisada' => false, 'comentario' => null]
        );

        return redirect()->route('tareas.show', $tarea->id)->with('success', 'Entrega realizada correctamente');
    }

    public function reviewEntrega(Request $request, $tareaId, $entregaId)
    {
        $user = Auth::user();
        abort_if($user->role !== 'maestro', 403);

        $tarea = Tarea::findOrFail($tareaId);
        abort_if($tarea->maestro_id !== $user->id, 403);

        $entrega = Entrega::where('id', $entregaId)->where('tarea_id', $tareaId)->firstOrFail();

        $request->validate([
            'revisada' => 'nullable|boolean',
            'comentario' => 'nullable|string',
        ]);

        $entrega->revisada = $request->has('revisada') ? (bool)$request->revisada : true;
        $entrega->comentario = $request->comentario;
        $entrega->save();

        return redirect()->route('tareas.show', $tarea->id)->with('success', 'Entrega marcada como revisada');
    }

    public function downloadEntrega($tareaId, $entregaId)
    {
        $user = Auth::user();
        $entrega = Entrega::with('tarea')->where('id', $entregaId)->where('tarea_id', $tareaId)->firstOrFail();

        if ($user->role === 'alumno' && $entrega->alumno_id !== $user->id) {
            abort(403);
        }

        if ($user->role === 'maestro' && $entrega->tarea->maestro_id !== $user->id) {
            abort(403);
        }

        return Storage::download($entrega->archivo_ruta);
    }
}
