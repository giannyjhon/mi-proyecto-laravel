@extends('layouts.panel')

@section('content')


          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Registrar Nueva Cita</h3>
                </div>
                <div class="col text-right">
                  <a href="{{url('patients')}}" class="btn btn-sm btn-default">Cancelar y Volver</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              @if ($errors->any())
              <div class="alert alert-danger" role="alert">
                <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
              </div>
            </ul>
              @endif
              <form action="{{url('/appoinments')}}" method="post">
                @csrf

                <div class="form-group">
                  <label for="address">Fecha</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                   <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                     </div>
                 <input class="form-control datepicker" placeholder="Seleccionar fecha"
                  id="date" type="text" name="scheduled_date"
                  value="{{ old('scheduled_date', date('Y-m-d'))}}"
                 data-date-format="yyyy-mm-dd" data-date-start-date="{{date('Y-m-d')}}"
                 data-date-end-date="+30d" required>
                 </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="specialty">Especialidad</label>
                  <select class="form-control" id="specialty" name="specialty_id" required>
                    <option value="">Seleccionar Especialidad</option>
                    @foreach ($specialties as $specialty)
                    <option value="{{$specialty->id}}" @if(old('specialty_id')==$specialty->id) selected @endif>{{$specialty->name}}</option>
                    @endforeach
                  </select>
                  </div>
                  <div class="form-group col-6">
                    <label for="doctor">Médico</label>
                    <select class="form-control" id="doctor" name="doctor_id" required>
                    @foreach ($doctors as $doctor)
                    <option value="{{$doctor->id}}" @if(old('doctor_id')==$doctor->id) selected @endif>{{$doctor->name}}</option>
                    @endforeach
                    </select>
                  </div>
                 </div>

                <div class="form-group">
                  <label for="dni">Hora de Atención</label>
                  <div id="hours" class="">
                    @if ($intervals)
                      @foreach ($intervals['morning'] as $key => $interval)

                        <div class="custom-control custom-radio mb-3">
                      <input type="radio" id="intervalMorning{{$key}}"
                       name="scheduled_time" class="custom-control-input" value="{{$interval['start']}}" required>
                      <label class="custom-control-label" for="intervalMorning{{$key}}">{{$interval['start']}} - {{$interval['end']}}</label>
                    </div>
                      @endforeach

                      @foreach ($intervals['afternoon'] as $key => $interval)
                        <div class="custom-control custom-radio mb-3">
                      <input type="radio" id="intervalAfternoon{{$key}}" name="scheduled_time"
                      class="custom-control-input" value="{{$interval['start']}}" required>
                      <label class="custom-control-label" for="intervalAfternoon{{$key}}">{{$interval['start']}} - {{$interval['end']}}</label>
                    </div>
                      @endforeach
                    @else
                    <div class="alert alert-info" role="alert">
                      Selecciona un médico y una fecha para ver sus horas disponibles
                    </div>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="type">Tipo de Consulta</label>
                  <div class="custom-control custom-radio mb-3">
                     <input type="radio" id="type1" name="type" class="custom-control-input"
                     @if(old('type', 'Consulta')=='Consulta') checked @endif value="Consulta">
                   <label class="custom-control-label" for="type1" >Consulta</label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                     <input type="radio" id="type2" name="type" class="custom-control-input"
                     @if(old('type')=='Examen') checked @endif value="Examen">
                   <label class="custom-control-label" for="type2">Examen</label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                     <input type="radio" id="type3" name="type" class="custom-control-input"
                     @if(old('type')=='Operación') checked @endif value="Operación">
                   <label class="custom-control-label" for="type3">Operación</label>
                  </div>
                </div>
                <div class="form-grup">
                  <label for="description">Descripción</label>
                  <input name="description" id="description" type="text" class="form-control"
                   placeholder="Describe Brevemente la Consulta"
                   value="{{ old('description')}}" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </form>
            </div>

          </div>

@endsection

@section('scripts')
<script src="{{asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script src="{{asset('js/appoinments/create.js')}}"></script>
@endsection
