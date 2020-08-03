@extends('layouts.app')

@section('content')
<div class="container-fluid mis_eventos"  style="margin-top: 5vh;">
    @include('inc.sidebar')
    
        <div class="col-12">
            <h1 style="padding-top:3vh; ">Inicio</h1>

            <!-- filtro segun si me interesan o todos -->
            <div class="row">
                <div class="col-md-3 ">
                    <input type="text" id="cadena_busqueda" class="form-control" onkeyup="myFunction()" placeholder="Search for names..">
                </div>
                <select id="filtro" class="form-control" data-target=".info" style="display: none;">
                    <option data-show=".todos">Todos</option>
                    <option data-show=".interesado">Mis temáticas</option>
                    
                </select>
            </div>
            

            <div class="info container-fluid" >
                <div class="todos row" id="eventos_todos">
                    @foreach ($eventos_todos as $evento)
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

