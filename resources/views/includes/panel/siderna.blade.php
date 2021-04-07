<ul class="nav align-items-center d-md-none">

  <li class="nav-item dropdown">
    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <div class="media align-items-center">
        <span class="avatar avatar-sm rounded-circle">
          <img alt="Image placeholder" src="{{asset('img/theme/avatar.jpg')}}">
        </span>
      </div>
    </a>
    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
      <div class=" dropdown-header noti-title">
        <h6 class="text-overflow m-0">Bienvenid@!</h6>
      </div>
      <a href="#" class="dropdown-item">
        <i class="ni ni-single-02"></i>
        <span>Mi Perfil</span>
      </a>
      <a href="#" class="dropdown-item">
        <i class="ni ni-settings-gear-65"></i>
        <span>Configuraión</span>
      </a>
      <a href="#" class="dropdown-item">
        <i class="ni ni-calendar-grid-58"></i>
        <span>Actividad</span>
      </a>
      <a href="#" class="dropdown-item">
        <i class="ni ni-support-16"></i>
        <span>Soporte</span>
      </a>
      <div class="dropdown-divider"></div>
      <a href="{{ route('logout')}}" class="dropdown-item"  onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
        <i class="ni ni-user-run"></i>
        <span>Cerrar Sesión</span>
      </a>
    </div>
  </li>
</ul>
