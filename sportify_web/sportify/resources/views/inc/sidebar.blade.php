<!-- Sidebar -->
<nav id="sidebar" >

    <div id="dismiss">
        <i class="fas fa-arrow-left"></i>
    </div>
    <div >
    <a id="edit-profile" href="{{ route($edit_profile) }}">
            <i class="fas fa-edit"></i>
        </a>
    </div>
    

    <div class="sidebar-header">
        @if ( $imagen != null )
            <img src="{{ asset($imagen) }}" style="width: 40px; height: 40px; border-radius: 50%;">
        @endif
        <h4>{{ $nombre }}</h4>
    </div>

    <ul class="list-unstyled components">
        <h5>{{ $cabecera_sidebar }}</h5>
        <li>
            <a class="sidebar-link" href="{{ route($home) }}">Inicio</a>
                
        </li>
        @if( Auth::guard('individual')->check()  )
            <li>
                <a class="sidebar-link" href="{{ route('individual.mis_eventos') }}">Mis Eventos</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('individual.ver_calendario') }}">Calendario</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('individual.mis_amigos') }}">Amigos</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('individual.mis_equipos') }}">Mis Equipos</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('individual.foros') }}">Foros</a>
            </li>
        @elseif(Auth::guard('entidad')->check())
            <li>
                <a class="sidebar-link" href="{{ route('entidad.mis_eventos') }}">Mis Eventos</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('entidad.mis_equipamientos') }}">Equipamiento</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('entidad.mis_pistas') }}">Pistas</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('entidad.ver_calendario') }}">Calendario</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('entidad.foros') }}">Foros</a>
            </li>
        @elseif(Auth::guard('admin')->check())
            <li>
                <a class="sidebar-link" href="{{ route('admin.eventos') }}">Gestion Eventos</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('admin.usuarios') }}">Gestion Usuarios</a>
            <li>
                <a class="sidebar-link" href="{{ route('admin.tematicas') }}">Gestion Tematicas</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('admin.equipos') }}">Gestion Equipos</a>
            </li>
            <li>
                <a class="sidebar-link" href="{{ route('admin.admins') }}">Gestion Administradores</a>
            </li>
                
        @endif 
        
        
        <li>
            <a href="{{ route($logoutRoute) }}"  class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Salir
            </a>
            <form id="logout-form" action="{{ route($logoutRoute) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</nav>
