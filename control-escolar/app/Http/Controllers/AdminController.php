<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materia;

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
}
