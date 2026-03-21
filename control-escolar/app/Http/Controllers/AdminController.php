<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Horario;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\User;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.dashboard');
    }

    public function indexMaterias()
    {
        $materias = Materia::all();
        return view('admin.materias')->with('materias', $materias);
    }

    public function saveMateria(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|max:255|unique:materias',
        ]);

        $nuevaMateria = new Materia();
        $nuevaMateria->nombre = $request->nombre;
        $nuevaMateria->clave = $request->clave;
        $nuevaMateria->save();

        return redirect()->route('materias')->with('success', 'Materia registrada exitosamente');
    }

    public function deleteMateria($id)
    {
        $materiaeliminar = Materia::find($id);
        if ($materiaeliminar != null)
            $materiaeliminar->delete();
        else 
            return redirect()->back()->withErrors('Materia no encontrada');

        return redirect()->back();
        
    }

    public function editMateria($id)
    {
        $materia = Materia::find($id);
        return view('admin.modificaMateria')->with('materia', $materia);
    }

    public function updateMateria(Request $request,$id)
    {
        $materiaEditar = Materia::find($id);
        if ($materiaEditar != null){
            $materiaEditar->nombre=$request->nombre;
            $materiaEditar->clave=$request->clave;
            $materiaEditar->save();
        } else {
            return redirect()->back()->withErrors('Materia no encontrada');
        }
        return redirect('/materias');

    }

    // Horarios
    public function indexHorarios()
    {
        $horarios = Horario::with('materia', 'user')->get();
        $materias = Materia::all();
        $users = User::all();
        return view('admin.horarios')->with(['horarios' => $horarios, 'materias' => $materias, 'users' => $users]);
    }

    public function saveHorario(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'materia_id' => 'required|exists:materias,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $nuevoHorario = new Horario();
        $nuevoHorario->user_id = $request->user_id;
        $nuevoHorario->materia_id = $request->materia_id;
        $nuevoHorario->hora_inicio = $request->hora_inicio;
        $nuevoHorario->hora_fin = $request->hora_fin;
        $nuevoHorario->save();

        return redirect()->route('horarios')->with('success', 'Horario registrado exitosamente');
    }

    public function deleteHorario($id)
    {
        $horarioEliminar = Horario::find($id);
        if ($horarioEliminar != null)
            $horarioEliminar->delete();
        else 
            return redirect()->back()->withErrors('Horario no encontrado');

        return redirect()->back();
    }

    public function editHorario($id)
    {
        $horario = Horario::find($id);
        $materias = Materia::all();
        $users = User::all();
        return view('admin.modificaHorario')->with(['horario' => $horario, 'materias' => $materias, 'users' => $users]);
    }

    public function updateHorario(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'materia_id' => 'required|exists:materias,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horarioEditar = Horario::find($id);
        if ($horarioEditar != null){
            $horarioEditar->user_id = $request->user_id;
            $horarioEditar->materia_id = $request->materia_id;
            $horarioEditar->hora_inicio = $request->hora_inicio;
            $horarioEditar->hora_fin = $request->hora_fin;
            $horarioEditar->save();
        } else {
            return redirect()->back()->withErrors('Horario no encontrado');
        }
        return redirect('/horarios');
    }

    // Grupos
    public function indexGrupos()
    {
        $grupos = Grupo::with('horario.materia', 'horario.user')->get();
        $horarios = Horario::with('materia', 'user')->get();
        return view('admin.grupos')->with(['grupos' => $grupos, 'horarios' => $horarios]);
    }

    public function saveGrupo(Request $request)
    {
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
            'nombre' => 'required|string|max:255',
        ]);

        $nuevoGrupo = new Grupo();
        $nuevoGrupo->horario_id = $request->horario_id;
        $nuevoGrupo->nombre = $request->nombre;
        $nuevoGrupo->save();

        return redirect()->route('grupos')->with('success', 'Grupo registrado exitosamente');
    }

    public function deleteGrupo($id)
    {
        $grupoEliminar = Grupo::find($id);
        if ($grupoEliminar != null)
            $grupoEliminar->delete();
        else 
            return redirect()->back()->withErrors('Grupo no encontrado');

        return redirect()->back();
    }

    public function editGrupo($id)
    {
        $grupo = Grupo::find($id);
        $horarios = Horario::with('materia', 'user')->get();
        return view('admin.modificaGrupo')->with(['grupo' => $grupo, 'horarios' => $horarios]);
    }

    public function updateGrupo(Request $request, $id)
    {
        $grupoEditar = Grupo::find($id);
        if ($grupoEditar != null){
            $grupoEditar->horario_id = $request->horario_id;
            $grupoEditar->nombre = $request->nombre;
            $grupoEditar->save();
        } else {
            return redirect()->back()->withErrors('Grupo no encontrado');
        }
        return redirect('/grupos');
    }

    // Inscripciones
    public function indexInscripciones()
    {
        $inscripciones = Inscripcion::with('user', 'grupo')->get();
        $users = User::all();
        $grupos = Grupo::all();
        return view('admin.inscripciones')->with(['inscripciones' => $inscripciones, 'users' => $users, 'grupos' => $grupos]);
    }

    public function saveInscripcion(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        $nuevaInscripcion = new Inscripcion();
        $nuevaInscripcion->user_id = $request->user_id;
        $nuevaInscripcion->grupo_id = $request->grupo_id;
        $nuevaInscripcion->save();

        return redirect()->route('inscripciones')->with('success', 'Inscripción registrada exitosamente');
    }

    public function deleteInscripcion($id)
    {
        $inscripcionEliminar = Inscripcion::find($id);
        if ($inscripcionEliminar != null)
            $inscripcionEliminar->delete();
        else 
            return redirect()->back()->withErrors('Inscripción no encontrada');

        return redirect()->back();
    }

    public function editInscripcion($id)
    {
        $inscripcion = Inscripcion::find($id);
        $users = User::all();
        $grupos = Grupo::all();
        return view('admin.modificaInscripcion')->with(['inscripcion' => $inscripcion, 'users' => $users, 'grupos' => $grupos]);
    }

    public function updateInscripcion(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        $inscripcionEditar = Inscripcion::find($id);
        if ($inscripcionEditar != null){
            $inscripcionEditar->user_id = $request->user_id;
            $inscripcionEditar->grupo_id = $request->grupo_id;
            $inscripcionEditar->save();
        } else {
            return redirect()->back()->withErrors('Inscripción no encontrada');
        }
        return redirect('/inscripciones');
    }

    // Calificaciones
    public function indexCalificaciones()
    {
        $calificaciones = Calificacion::with('user', 'materia')->get();
        $users = User::all();
        $materias = Materia::all();
        return view('admin.calificaciones')->with(['calificaciones' => $calificaciones, 'users' => $users, 'materias' => $materias]);
    }

    public function saveCalificacion(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'materia_id' => 'required|exists:materias,id',
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        $nuevaCalificacion = new Calificacion();
        $nuevaCalificacion->user_id = $request->user_id;
        $nuevaCalificacion->materia_id = $request->materia_id;
        $nuevaCalificacion->calificacion = $request->calificacion;
        $nuevaCalificacion->save();

        return redirect()->route('calificaciones')->with('success', 'Calificación registrada exitosamente');
    }

    public function deleteCalificacion($id)
    {
        $calificacionEliminar = Calificacion::find($id);
        if ($calificacionEliminar != null)
            $calificacionEliminar->delete();
        else 
            return redirect()->back()->withErrors('Calificación no encontrada');

        return redirect()->back();
    }

    public function editCalificacion($id)
    {
        $calificacion = Calificacion::find($id);
        $users = User::all();
        $materias = Materia::all();
        return view('admin.modificaCalificacion')->with(['calificacion' => $calificacion, 'users' => $users, 'materias' => $materias]);
    }

    public function updateCalificacion(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'materia_id' => 'required|exists:materias,id',
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        $calificacionEditar = Calificacion::find($id);
        if ($calificacionEditar != null){
            $calificacionEditar->user_id = $request->user_id;
            $calificacionEditar->materia_id = $request->materia_id;
            $calificacionEditar->calificacion = $request->calificacion;
            $calificacionEditar->save();
        } else {
            return redirect()->back()->withErrors('Calificación no encontrada');
        }
        return redirect('/calificaciones');
    }
}
