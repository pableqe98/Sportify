@extends('layouts.app')

@section('content')
<div >
    <a href="{{  url()->previous() }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>
<div class="container-fluid mis_eventos"  >
    @include('inc.sidebar')
    
        <div class="col-12">
            <h1 >{{ $usuario->nombre_u }}</h1>
            <div class="container-fluid" >
                <div class="row">
                    <div class="col-6 my-3">
                        
                        
                        <div class="my-3" >
                            <span class="font-weight-bold">Descripción: </span>
                            <p class="border border-primary rounded" style="min-height: 150px;">{{ $usuario->descripcion_u }}</p>
                        </div>
                        @if ($usuario->tipo_u == 'INDIVIDUAL')
                        <div class="my-3">
                            <span class="font-weight-bold" >Nombre Completo: </span>{{ $usuario->nombre_completo }}
                        </div>
                        <div class="my-3">
                            <span class="font-weight-bold" >Fecha Nacimiento: </span>{{ $usuario->fecha_nac }}
                        </div>
                        <div class="my-3">
                            <span class="font-weight-bold" >Valoracion: </span>{{ $usuario->puntuacion }}
                        </div>
                           
                        @else
                        <div class="my-3">
                            <span class="font-weight-bold">Nombre Empresa: </span>{{ $usuario->nombre_completo }}
                        </div>
                        <div class="my-3">
                            <span class="font-weight-bold">Direccion: </span>{{ $usuario->direccion }}
                        </div>
                            
                        @endif
                        <div class="my-3">
                            <span class="font-weight-bold">Email: </span>{{ $usuario->email }}
                        </div>
                        <div class="my-3">
                            <span class="font-weight-bold">Telefono: </span>{{ $usuario->tlf_u }}
                        </div>
                        <div class="my-3">
                            <span class="font-weight-bold">Tipo Usuario: </span>{{ $usuario->tipo_u }}
                        </div>
                        
                        
                    </div> 
                    <div class="col-6 " >
                        <div class="row">
                            <img class="ml-auto" src="{{ asset($usuario->foto_perf) }}" alt="Imagen usuario" style="width: 500px; height: 500px;">
                        </div>
                        
                    </div>
                </div>
                
            </div>            
        </div>
    
</div>
@endsection