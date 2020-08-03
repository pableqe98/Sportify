@extends('layouts.app')

@section('content')

<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">
    @include('inc.sidebar')
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 style="padding-top:20px; ">Mis Pistas</h1>
            <div class="col-md-4">
                
                <a role="button" class="btn btn-primary " href="{{ route('entidad.crear_pista') }}">Añadir Pista</a>
                
            </div>

            <div class="row  ">
                @foreach ($mis_pistas as $pista)
                <div class="col-lg-3 col-sm-12">
                    <div class="card bg-light">
                        
                        <div class="card-body">
                            <h5 class="card-title text-center">Pista {{ $pista->id_pista }}</h5>
                            
                            <a href="{{ url('entidad/pista/'.$pista->id_pista) }}" class="btn btn-primary">Ver pista</a>
                        </div>
                    
                    </div>
                </div>
                @endforeach
          </div>
            
        </div>
    </div>
    
</div>
  
@endsection