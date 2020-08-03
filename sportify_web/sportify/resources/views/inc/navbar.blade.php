<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top text-center">
            

<!--Muestro una barra superior según el usuario -->
@if( Auth::guard('individual')->check()  )
                    <!-- Logo central -->
                    <div class="mx-auto order-2 ">
                        <a class="navbar-brand" href="{{ route('individual.home') }}">
                            <img src={{ asset('imgs/LogoSportify.PNG') }} alt="Logo" style="width:240px;">
                        </a>
                    </div>

                    <div class=" order-1">

                        <button type="button" id="sidebarCollapse" class="btn btn-primary">
                            @if (Auth::guard('individual')->user()->image)
                                <img src="{{ asset(Auth::guard('individual')->user()->image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                            @endif
                            {{ $nombre ?? ''}} <span class="caret"></span>
                        </button>
                       
                        
                    </div> 




@elseif(Auth::guard('admin')->check())

                    <!-- Logo central -->
                    <div class="mx-auto order-2 ">
                        <a class="navbar-brand" href="{{ route('admin.home') }}">
                            <img src={{ asset('imgs/LogoSportify.PNG') }} alt="Logo" style="width:240px;">
                        </a>
                    </div>


                    <div class=" order-1">

                        <button type="button" id="sidebarCollapse" class="btn btn-primary">
                            Admin {{ Auth::guard('admin')->user()->id_admin }} <span class="caret"></span>
                        </button>
                       
                        
                    </div>   

 
@elseif(Auth::guard('entidad')->check())

     <!-- Logo central -->
     <div class="mx-auto order-3 ">
        <a class="navbar-brand" href="{{ route('entidad.home') }}">
            <img src={{ asset('imgs/LogoSportify.PNG') }} alt="Logo" style="width:240px;">
        </a>
    </div>

    <div class=" order-1">

        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            @if (Auth::guard('entidad')->user()->image)
                <img src="{{ asset(Auth::guard('entidad')->user()->image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
            @endif
            {{ Auth::guard('entidad')->user()->name }} 
        </button>
       
        
    </div>                             
@else

                     <!-- Logo central -->
                     <div class="mx-auto order-2 ">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src={{ asset('imgs/LogoSportify.PNG') }} alt="Logo" style="width:240px;">
                        </a>
                    </div>


                    <div class="collapse navbar-collapse w-100 order-1 " id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                          <li class="nav-item">
                           
                          </li>
                        </ul>
                    
                        </div>
                    
                       
                       
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse w-100 order-3 " id="navbarSupportedContent">
                          <ul class="navbar-nav ml-auto">
                            <li class="nav-item m-2">
                                <a role="button" class="btn btn-dark " href="{{ url('/pre-login') }}">Inicia Sesión</a>
                            </li>
                            <li class="nav-item m-2">
                                <a role="button" class="btn btn-secondary " href="{{ url('/pre-register') }}">Regístrate</a>
                            </li>
                          </ul>
                        </div>
@endif              

    
  </nav>
