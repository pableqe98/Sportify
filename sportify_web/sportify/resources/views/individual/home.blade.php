@extends('layouts.app')

@section('content')
<div class="container-fluid mis_eventos"  style="margin-top: 5vh;">
    @include('inc.sidebar')
    
        <div class="col-12">
            <h1 style="padding-top:3vh; ">Inicio</h1>

            <!-- filtro segun si me interesan o todos -->
            <div class="row">
                <div class="col-md-3 ">
                    <input type="text" id="cadena_busqueda" class="form-control" onkeyup="myFunction()" placeholder="Busca por nombre...">
                </div>
                <div class="col-md-6 ">
                    
                </div>
                <div class="col-md-3">
                    <div style="font-weight: bold;"> Eventos a mostrar:</div>
                    <select id="filtro" class="form-control" data-target=".info">
                        <option data-show=".interesado">Mis temáticas</option>
                        <option data-show=".todos">Todos</option>
                    </select>
                </div>

            </div>
            

            <div class="info container-fluid" >
                <div class="interesado hide row" id="eventos_preferidos">
                        @foreach ($eventos_interesado as $evento)
                        <div class="col-sm-3 mt-3 tarjeta">
                            <div class="card bg-light">
                                
                                    <img class="card-img-top img-fluid" src="{{ asset($evento->foto) }}" alt="Imagen evento">
                                    <div class="card-body">
                                    <h5 class="card-title text-center">{{ $evento->titulo_e }}</h5>
                                        
                                    <a href="{{ url('individual/evento/'.$evento->id_evento) }}" class="btn btn-primary">Ver evento</a>
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                </div>
                <div class="todos hide row" id="eventos_todos">
                    @foreach ($eventos_todos as $evento)
                    <div class="col-lg-3 col-sm-12 tarjeta">
                        <div class="card bg-light">
                            
                                
                                    <img class="card-img-top" src="{{ asset($evento->foto) }}" alt="Imagen evento">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">{{ $evento->titulo_e }}</h5>
                                        
                                    <a href="{{ url('individual/evento/'.$evento->id_evento) }}" class="btn btn-primary">Ver evento</a>
                                    
                                </div>
                            
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>            
        </div>
    
</div>
@endsection
