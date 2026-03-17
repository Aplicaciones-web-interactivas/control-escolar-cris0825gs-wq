<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materia;
use App\Models\horario;
use App\Models\grupo;
use App\Models\User;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.dashboard');
    }

    public function indexMaterias()
    {
        $materias = materia::all();
        return view('admin.materias')->with('materias', $materias);
    }

    public function saveMateria(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|max:255|unique:materias',
        ]);

        $nuevaMateria = new materia();
        $nuevaMateria->nombre = $request->nombre;
        $nuevaMateria->clave = $request->clave;
        $nuevaMateria->save();

        return redirect()->route('materias')->with('success', 'Materia registrada exitosamente');
    }

    public function deleteMateria($id)
    {
        $materiaeliminar = materia::find($id);
        if ($materiaeliminar != null)
            $materiaeliminar->delete();
        else 
            return redirect()->back()->withErrors('Materia no encontrada');

        return redirect()->back();
        
    }

    public function editMateria($id)
    {
        $materia = materia::find($id);
        return view('admin.modificaMateria')->with('materia', $materia);
    }

    public function updateMateria(Request $request,$id)
    {
        $materiaEditar = materia::find($id);
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
        $horarios = horario::with('materia', 'user')->get();
        $materias = materia::all();
        $users = User::all();
        return view('admin.horarios')->with(['horarios' => $horarios, 'materias' => $materias, 'users' => $users]);
    }

    public function saveHorario(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'materia_id' => 'required|exists:materias,id',
            'dia' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $nuevoHorario = new horario();
        $nuevoHorario->user_id = $request->user_id;
        $nuevoHorario->materia_id = $request->materia_id;
        $nuevoHorario->dia = $request->dia;
        $nuevoHorario->hora_inicio = $request->hora_inicio;
        $nuevoHorario->hora_fin = $request->hora_fin;
        $nuevoHorario->save();

        return redirect()->route('horarios')->with('success', 'Horario registrado exitosamente');
    }

    public function deleteHorario($id)
    {
        $horarioEliminar = horario::find($id);
        if ($horarioEliminar != null)
            $horarioEliminar->delete();
        else 
            return redirect()->back()->withErrors('Horario no encontrado');

        return redirect()->back();
    }

    public function editHorario($id)
    {
        $horario = horario::find($id);
        $materias = materia::all();
        $users = User::all();
        return view('admin.modificaHorario')->with(['horario' => $horario, 'materias' => $materias, 'users' => $users]);
    }

    public function updateHorario(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'materia_id' => 'required|exists:materias,id',
            'dia' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horarioEditar = horario::find($id);
        if ($horarioEditar != null){
            $horarioEditar->user_id = $request->user_id;
            $horarioEditar->materia_id = $request->materia_id;
            $horarioEditar->dia = $request->dia;
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
        $grupos = grupo::with('horario.materia', 'horario.user')->get();
        $horarios = horario::with('materia', 'user')->get();
        return view('admin.grupos')->with(['grupos' => $grupos, 'horarios' => $horarios]);
    }

    public function saveGrupo(Request $request)
    {
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
            'nombre' => 'required|string|max:255',
        ]);

        $nuevoGrupo = new grupo();
        $nuevoGrupo->horario_id = $request->horario_id;
        $nuevoGrupo->nombre = $request->nombre;
        $nuevoGrupo->save();

        return redirect()->route('grupos')->with('success', 'Grupo registrado exitosamente');
    }

    public function deleteGrupo($id)
    {
        $grupoEliminar = grupo::find($id);
        if ($grupoEliminar != null)
            $grupoEliminar->delete();
        else 
            return redirect()->back()->withErrors('Grupo no encontrado');

        return redirect()->back();
    }

    public function editGrupo($id)
    {
        $grupo = grupo::find($id);
        $horarios = horario::with('materia', 'user')->get();
        return view('admin.modificaGrupo')->with(['grupo' => $grupo, 'horarios' => $horarios]);
    }

    public function updateGrupo(Request $request, $id)
    {
        $grupoEditar = grupo::find($id);
        if ($grupoEditar != null){
            $grupoEditar->horario_id = $request->horario_id;
            $grupoEditar->nombre = $request->nombre;
            $grupoEditar->save();
        } else {
            return redirect()->back()->withErrors('Grupo no encontrado');
        }
        return redirect('/grupos');
    }
}
