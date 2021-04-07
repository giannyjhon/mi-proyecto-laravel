<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialty;

class SpecialtyController extends Controller
{
  // public function __construct()
  // {
  //   $this->middleware('auth');
  // }
    public function index()
    {
      $specialties =  Specialty::all();
      return view('specialties.index', compact('specialties'));
    }

    public function create()
    {
      return view('specialties.create');
    }


  private function performVlidation(Request $request)
  {
    $rules = [
      'name' => 'required|min:3',
      'description' => 'required|min:3'
    ];
    $messages = [
      'name.required' => 'Es necesario Ingresar un Nombre',
      'name.min' => 'El Nombre debe tener al menos 3 Caracteres',
      'description.required' => 'Es necesario Ingresar la Descripción',
      'description.min' => 'La Descripción debe tener al menos 3 Caracteres',
    ];
    $this->validate($request, $rules, $messages);
  }
    public function store(Request $request)
    {
    //  dd($request->all());
   $this->performVlidation($request);
    $specialty = new Specialty();
    $specialty->name = $request->input('name');
    $specialty->description = $request->input('description');
    $specialty->save();//guardamos
    $notification = 'La Especialidad '.$specialty->name.' se Ha Registrado Correctamente!';
    return redirect('/specialties')->with(compact('notification'));
    }

    public function edit(Specialty $specialty)
    {
      return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
    //  dd($request->all());
  $this->performVlidation($request);
  //  $specialty = new Specialty();
    $specialty->name = $request->input('name');
    $specialty->description = $request->input('description');
    $specialty->save();//actualizamos
    $notification = 'La Especialidad '.$specialty->name.' se Ha Actualizado Correctamente!';
    return redirect('/specialties')->with(compact('notification'));
    }

    public function destroy(Specialty $specialty)
    {
      $deletename = $specialty->name;
      $specialty->delete();
      $notification = 'La Especialidad '.$deletename.' se Ha Eliminado Correctamente!';
      return redirect('/specialties')->with(compact('notification'));
    }
}
