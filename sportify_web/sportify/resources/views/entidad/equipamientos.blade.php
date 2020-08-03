@extends('layouts.app')

@section('content')

<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">
    @include('inc.sidebar')
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 style="padding-top:20px; ">Mis Equipamientos</h1>
            <div class="col-md-4">
                
                <a role="button" class="btn btn-primary " href="{{ route('entidad.crear_equipamiento') }}">Añadir Equipamiento</a>
                
            </div>

            <div class="row my-2 ">
                @foreach ($mis_equipamientos as $equipamiento)
                    <div class="col-lg-3 col-sm-12">
                        <div class="card bg-light">
                            
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $equipamiento->nombre_e }} {{ $equipamiento->id_equipamiento }}</h5>
                                
                                <a href="{{ url('entidad/equipamiento/'.$equipamiento->id_equipamiento) }}" class="btn btn-primary">Ver equipamiento</a>
                            </div>
                        
                        </div>
                    </div>
                @endforeach
          </div>
            
        </div>
    </div>
    
</div>
  
@endsection