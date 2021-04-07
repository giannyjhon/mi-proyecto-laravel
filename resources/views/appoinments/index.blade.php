@extends('layouts.panel')

@section('content')


          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Mis Citas</h3>
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

                {{-- Tabs --}}

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active"  data-toggle="pill" href="#confirmed-appointments" role="tab">
              Mis Proximas citas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"  data-toggle="pill" href="#pending-appointments" role="tab"  >
              Citas por Confirmar</a>
        </li>

        <li class="nav-item">
            <a class="nav-link"  data-toggle="pill" href="#old-appointments" role="tab"  >
              Historial de Citas</a>
        </li>
    </ul>

            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="confirmed-appointments" role="tabpanel" aria-labelledby="home-tab">
                @include('appoinments.tables.confirmed')
                </div>
                <div class="tab-pane fade" id="pending-appointments" role="tabpanel" aria-labelledby="profile-tab">
                @include('appoinments.tables.pending')
                </div>
                <div class="tab-pane fade" id="old-appointments" role="tabpanel" aria-labelledby="profile-tab">
                @include('appoinments.tables.old')
                </div>
            </div>


          </div>

@endsection
