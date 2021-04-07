<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  //  return view('welcome');
  return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
  //especialidad
  Route::get('/specialties', 'SpecialtyController@index');
  Route::get('/specialties/create', 'SpecialtyController@create');//formulario de registro
  Route::get('/specialties/{specialty}/edit', 'SpecialtyController@edit');

  Route::post('/specialties', 'SpecialtyController@store');//envio formulario registro
  Route::put('/specialties/{specialty}/update', 'SpecialtyController@update');
  Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy');

  //doctores doctors
  Route::resource('doctors', 'DoctorController');
  //pacientes patients
  Route::resource('patients', 'PatientController');

//charts
  Route::get('/charts/appointments/line','ChartController@appointments');
  Route::get('/charts/doctors/column','ChartController@doctors');
  Route::get('/charts/doctors/column/data','ChartController@doctorsJson');
});

Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function () {
      Route::get('/schedule', 'ScheduleController@edit');
      Route::post('/schedule', 'ScheduleController@store');

});

Route::middleware('auth')->group(function(){
//registrar citas medicas
  Route::get('/appoinments/create', 'AppoinmentController@create');
  Route::post('/appoinments', 'AppoinmentController@store');
  //ver citas que el paciente tiene
  Route::get('/appoinments', 'AppoinmentController@index');
  Route::get('/appoinments/{appointment}', 'AppoinmentController@show');

  Route::get('/appoinments/{appointment}/cancel', 'AppoinmentController@showCancelForm');
  Route::post('/appoinments/{appointment}/cancel', 'AppoinmentController@postCancel');

Route::post('/appoinments/{appointment}/confirm', 'AppoinmentController@postConfirm');
  //rutas que responden en formato JsonSerializable
  Route::get('/specialties/{specialty}/doctors', 'Api\SpecialtyController@doctors');
    Route::get('/schedule/hours', 'Api\ScheduleController@hours');
});
