@extends('layouts.app')

@section('content')
<div >
    <a href="{{ url()->previous() }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>

<div class="container-fluid mis_eventos"  >
    
        <div class="col-12">
            
            <h1 >{{ $evento->titulo_e}}</h1>
            <div class="container-fluid" >
                <div class="row">
                    <div class="col-6 my-3">
                        <span class="font-weight-bold">Fecha Inicio: </span> <span>{{ $evento->fecha_ini }}</span> <span class="font-weight-bold">| Fecha Final: </span>{{ $evento->fecha_fin }}
                        
                        <div class="my-3" >
                            <span class="font-weight-bold">Descripción: </span>
                            <p class="border border-primary rounded" style="min-height: 300px;">{{ $evento->descripcion_e }}</p>
                        </div>
                        <span class="font-weight-bold">Tematica: </span>{{ $tematica }}
                        <br>
                        <span class="font-weight-bold">Participantes actuales: </span>{{ $evento->n_participantes }}
                        <br>
                        <span class="font-weight-bold">Mínimo participantes: </span>{{ $evento->min_participantes }}
                        <br>
                        <span class="font-weight-bold">Máximo participantes: </span>{{ $evento->max_participantes }}
                       
                    </div> 
                    <div class="col-6 " >
                        <div class="row">
                            <img class="ml-auto" src="{{ asset($evento->foto) }}" alt="Imagen evento" style="width: 500px; height: 500px;">
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-7 my-5 ">
                    </div>
                    <div class="col-1 my-5 ">
                    </div>
                    <div class="col-4 my-5 " >
                        <div class="row">
                            <h3 class="font-weight-bold">Ubicación: </h3>
                        </div>
                        <div class="row">
                            <iframe width="100%" height="380vh" frameborder="2" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{ $evento->latitud }},{{ $evento->longitud }}&amp;key=AIzaSyAyArVWjT0pmIxGoMSaK_FzGdHwSfsb6ws"></iframe>   
                        </div>
                    
                    </div>
                </div>
            </div>            
        </div>
    
</div>
@endsection
