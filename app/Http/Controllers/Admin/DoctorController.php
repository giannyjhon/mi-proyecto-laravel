<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Specialty;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //se listan todos
    //  $doctors = User::doctors()->get();paginate(5)
    //se pagina en 5 en 5
    $doctors = User::doctors()->paginate(5);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $specialties = Specialty::all();
         return view('doctors.create', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //dd($request->all());
      $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'dni' => 'digits:8',
        'address' => 'nullable|min:5',
        'phone' => 'nullable|min:6'
      ];
        $this->validate($request, $rules);


      $user =  User::create(
          $request->only('name', 'email', 'dni', 'address', 'phone')
          +[
            'role'=> 'doctor',
            'password' => bcrypt($request->input('password'))
          ]

      );
      $user->specialties()->attach($request->input('specialties'));
      $notification = 'El Médico se ha Resgistrado Correctamente';
      return redirect('/doctors')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $doctor = User::doctors()->findOrFail($id);
    $specialties = Specialty::all();
    $specialty_ids = $doctor->specialties()->pluck('specialties.id');
        return view('doctors.edit', compact('doctor', 'specialties', 'specialty_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'dni' => 'digits:8',
        'address' => 'nullable|min:5',
        'phone' => 'nullable|min:6'
      ];
        $this->validate($request, $rules);

        $user = User::doctors()->findOrFail($id);
        $data = $request->only('name', 'email', 'dni', 'address', 'phone');
        $password = $request->input('password');
        if($password)
        $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();
        //para actualizar las especialidades
        $user->specialties()->sync($request->input('specialties'));
      $notification = 'El Médico se ha Modificado Correctamente';
      return redirect('/doctors')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
      $deletename = $doctor->name;
      $doctor->delete();
      $notification = 'El Médico '.$deletename.' se Ha Eliminado Correctamente!';
      return redirect('/doctors')->with(compact('notification'));
    }
}
