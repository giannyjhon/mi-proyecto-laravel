<!-- Navigation -->
<h6 class="navbar-heading text-muted">
  @if (auth()->user()->role == 'admin')
  Gestionar Datos
  @else
    Menú
  @endif
</h6>
<ul class="navbar-nav">
@include('includes.panel.menu.'.auth()->user()->role);
<hr class="my-3">
<li class="nav-item">
<a class="nav-link" href="{{ route('logout')}}" onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
<i class="ni ni-key-25 "></i> Cerrar Sesión
</a>
<form action="{{ route('logout')}}" method="POST" style="display: none;" id="formLogout">
 @csrf
  </form
</li>
</ul>
