@extends('layouts.panel')

@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection


@section('content')


          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Modificar Médico</h3>
                </div>
                <div class="col text-right">
                  <a href="{{url('doctors')}}" class="btn btn-sm btn-default">Cancelar y Volver</a>
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
              <form action="{{url('doctors/'.$doctor->id)}}" method="post">
                @csrf
                @method ('PUT')
                <div class="form-group">
                  <label for="name">Nombre del Médico</label>
                  <input type="text" name="name" class="form-control" value="{{old('name', $doctor->name)}}" >
                </div>
                <div class="form-group">
                  <label for="email">E-mail</label>
                  <input type="text" name="email" class="form-control" value="{{old('email', $doctor->email)}}">
                </div>
                <div class="form-group">
                  <label for="dni">DNI</label>
                  <input type="text" name="dni" class="form-control" value="{{old('dni', $doctor->dni)}}">
                </div>
                <div class="form-group">
                  <label for="address">Dirección</label>
                  <input type="text" name="address" class="form-control" value="{{old('address', $doctor->address)}}">
                </div>
                <div class="form-group">
                  <label for="address">Telefono</label>
                  <input type="text" name="phone" class="form-control" value="{{old('phone', $doctor->phone)}}">
                </div>
                <div class="form-group">
                  <label for="password">Contraseña</label>
                  <input type="text" name="password" class="form-control" value="">
                  <p>Ingrese un valor solo si desea modificar la contraseña</p>
                </div>
                <div class="form-group">
                  <label for="specialties">Especialidades</label>
                  <select class="form-control selectpicker" name="specialties[]" id="specialties"
                  data-style="btn-outline-success" multiple title="Seleccione una o Varias Especialidades">
                    @foreach ($specialties as $specialty)
                    <option value="{{$specialty->id}}">{{$specialty->name}}</option>
                    @endforeach
                  </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </form>
            </div>

          </div>

@endsection

@section('scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
  $(document).ready(()=>{
    $('#specialties').selectpicker('val', @json($specialty_ids));
  });

</script>
@endsection
