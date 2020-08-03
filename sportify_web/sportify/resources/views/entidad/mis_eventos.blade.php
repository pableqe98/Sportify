@extends('layouts.app')

@section('content')

<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">
    @include('inc.sidebar')
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 style="padding-top:20px; ">Mis Eventos</h1>
            <div class="col-md-4">
                
                <a role="button" class="btn btn-primary " href="{{ route('entidad.crear_evento') }}">Crear Evento</a>
                
            </div>

            <div class="row  ">
                @foreach ($mis_eventos as $evento)
                <div class="col-lg-3 col-sm-12">
                    <div class="card bg-light">
                        <img class="card-img-top" src="{{ asset($evento->foto) }}" alt="Imagen evento">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $evento->titulo_e }}</h5>
                            
                            <a href="{{ url('entidad/evento/'.$evento->id_evento) }}" class="btn btn-primary">Ver evento</a>
                        </div>
                    
                    </div>
                </div>
                @endforeach
          </div>
            
        </div>
    </div>
    
</div>
  
@endsection