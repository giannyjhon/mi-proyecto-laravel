@extends('layouts.panel')

@section('content')


          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Cancelar Cita</h3>
                </div>
                {{-- <div class="col text-right">
                  <a href="{{url('patients/create')}}" class="btn btn-sm btn-success">Nuevo Paciente</a>
                </div> --}}
              </div>
            </div>
            <div class="card-body">
              @if (session('notification'))
              <div class="alert alert-success" role="alert">
                {{session('notification')}}
               </div>
               @endif


          @if ($role == 'patient')
          <p>Estás a punto de cancelar tu cita reservada
          con el Médico: {{$appointment->doctor->name}},
          (especialidad) {{$appointment->specialty->name}},
          para el día {{$appointment->scheduled_date}}</p>
          @elseif ($role == 'doctor')

          <p>Estás a punto de cancelar tu cita con el paciente:
         {{$appointment->patient->name}},
          (especialidad {{$appointment->specialty->name}}),
          para el día {{$appointment->scheduled_date}},
          (hora: {{$appointment->scheduled_time_12}} )
          </p>
          @else
            <p>Estás a punto de cancelar la cita reservada
            por el paciente: {{$appointment->patient->name}},
            para ser atendido por el Médico: {{$appointment->doctor->name}},
            (especialidad {{$appointment->specialty->name}}),
            el día {{$appointment->scheduled_date}},
            (hora: {{$appointment->scheduled_time_12}} )
            </p>
          @endif
<form action="{{ url('/appoinments/'.$appointment->id.'/cancel')}}"
 method="post">
    @csrf
    <div class="form-group">
      <label for="justification">Por favor cuentenos el motivo de la cancelación</label>
      <textarea required name="justification" rows="3" class="form-control"></textarea>
    </div>
  <button class="btn btn-danger" type="submit">Cancelar Cita</button>
 <a href="{{url('/appoinments')}}" class="btn btn-default"> Volver al Listado de Citas sin Cancelar</a>
 </form>
            </div>

          </div>

@endsection
