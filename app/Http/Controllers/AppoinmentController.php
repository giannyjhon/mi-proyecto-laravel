<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ScheduleServiceInterface;
use App\Specialty;
use App\Appoinment;
use App\CancelledAppointment;
use Carbon\Carbon;
use Validator;

class AppoinmentController extends Controller
{

  public function index()
  {
    $role= auth()->user()->role;
    //pacientes
      if ($role == 'admin'){

        $pendingAppointments = Appoinment::where('status', 'Reservada')
        ->paginate(10);
        $confirmedAppointments = Appoinment::where('status', 'Confirmada')
        ->paginate(10);
        $oldAppointments = Appoinment::whereIn('status', ['Atendida','Cancelada'])
        ->paginate(10);
        // return view('appoinments.index', compact('pendingAppointments',
        // 'confirmedAppointments', 'oldAppointments', 'role'));

      }elseif($role== 'doctor'){
//doctor
      $pendingAppointments = Appoinment::where('status', 'Reservada')
      ->where('doctor_id', auth()->id())
      ->paginate(7);
      $confirmedAppointments = Appoinment::where('status', 'Confirmada')
      ->where('doctor_id', auth()->id())
      ->paginate(7);
      $oldAppointments = Appoinment::whereIn('status', ['Atendida','Cancelada'])
      ->where('doctor_id', auth()->id())
      ->paginate(7);
      // return view('appoinments.index', compact('pendingAppointments',
      // 'confirmedAppointments', 'oldAppointments', 'role'));

    }elseif ($role=='patient'){
      //pacientes
      $pendingAppointments = Appoinment::where('status', 'Reservada')
      ->where('patient_id', auth()->id())
      ->paginate(7);
      $confirmedAppointments = Appoinment::where('status', 'Confirmada')
      ->where('patient_id', auth()->id())
      ->paginate(7);
      $oldAppointments = Appoinment::whereIn('status', ['Atendida','Cancelada'])
      ->where('patient_id', auth()->id())
      ->paginate(7);
      // return view('appoinments.index', compact('pendingAppointments',
      // 'confirmedAppointments', 'oldAppointments', 'role'));
    }

    return view('appoinments.index', compact('pendingAppointments',
    'confirmedAppointments', 'oldAppointments', 'role'));

  }

  public function show(Appoinment $appointment){
    $role= auth()->user()->role;
      return view('appoinments.show', compact('appointment', 'role'));
  }
    public function create(ScheduleServiceInterface $scheduleService)
    {
      $specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if($specialtyId){
          $specialty = Specialty::find($specialtyId);
          $doctors =$specialty->users;
        }else{
          $doctors = collect();
        }

        $date = old('scheduled_date');
        $doctorId = old('doctor_id');

        if($date && $doctorId){
          $intervals = $scheduleService->getAvailableInterval($date, $doctorId);
        }else{
          $intervals = null;
        }

      return view('appoinments.create', compact('specialties', 'doctors', 'intervals'));
    }

    public function store(Request $request, ScheduleServiceInterface $scheduleService )
    {

      //validaciones
      $rules =[
        'description' => 'required',
        'specialty_id' => 'exists:specialties,id',
        'doctor_id' => 'exists:users,id',
        //'scheduled_date' => 'required',
        'scheduled_time'=> 'required'
      ];

      $messages = [
        'scheduled_time.required' => 'Por Favor Seleccione una hora valida'
      //  'scheduled_date.required' => 'Por Favor Seleccione una Fecha valida'
      ];
    $validator =  Validator::make($request->all(), $rules, $messages);

      $validator->after(function ($validator) use ($request, $scheduleService){
          $date = $request->input('scheduled_date');
          $doctorId = $request->input('doctor_id');
          $scheduled_time = $request->input('scheduled_time');
          //dd($scheduled_time, $doctorId, $date);
          if($date && $doctorId && $scheduled_time){
            $start = new Carbon($scheduled_time);
          }else{
            return;
          }
         if(!$scheduleService->isAvailableInterval($date, $doctorId, $start)){
           $validator->errors()
                  ->add('available_time', 'La hora seleecionada ya se encuentra
                  reservada por otro paciente!');
         }
      });

      if($validator->fails()){
        return back()
               ->withErrors($validator)
               ->withInput();
      }

      $data = $request->only([
        'description',
        'specialty_id',
        'doctor_id',
        'scheduled_date',
        'scheduled_time',
        'type'
      ]);
      $data['patient_id']= auth()->id();
      //cambiar formato de hora
      $carbonTime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
      $data['scheduled_time']=$carbonTime->format('H:i:s');
    //  dd($data);
      Appoinment::create($data);
      $notification = 'La cita se ha registrado Correctamente!';
      return back()->with(compact('notification'));
      //return redirect('/appointments');
    }

    public function showCancelForm(Appoinment $appointment)
    {

    if($appointment->status=='Confirmada'){
      $role= auth()->user()->role;
    return view('appoinments.cancel', compact('appointment', 'role'));
     }
    // dd($appointment->status);
     return redirect('/appoinments');
    }

    public function postCancel(Appoinment $appointment, Request $request)
    {
  //   dd('entra');

    if($request->has('justification')){
      $cancellation = new CancelledAppointment();
      $cancellation->justification = $request->input('justification');
      $cancellation->cancelled_by_id = auth()->id();

      $appointment->cancellation()->save($cancellation);
}
      $appointment->status = 'Cancelada';
      $appointment->save();//actualiza

      $notification = 'La cita se ha Cancelado Correctamente';
      return redirect('/appoinments')->with(compact('notification'));

    }


    public function postConfirm(Appoinment $appointment, Request $request)
    {
      $appointment->status = 'Confirmada';
      $appointment->save();//actualiza

      $notification = 'La cita se ha Confirmado Correctamente';
      return redirect('/appoinments')->with(compact('notification'));
    }
}
