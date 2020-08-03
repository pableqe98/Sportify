@extends('layouts.app')

@section('content')
<div >
    <a href="{{ url($rutaEvento) }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>

<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">
    @include('inc.sidebar')
    <div class="row justify-content-center">
        <div class="col-12">
        <h1 style="padding-top:20px; ">{{ $grupo->nombre_grupo }}</h1>         

            <div class="row  ">
                <div class="col-md-1"></div>
                <div class="list-group col-md-10">
                    @foreach ($mensajes as $mensaje)
                        
                        <div class="list-group-item list-group-item-action  align-items-start ">
                            <img src="{{ asset($mensaje->foto_usuario) }}" style="width: 60px; height: 60px; border-radius: 25%;" alt="">
                            <small>{{ $mensaje->nombre_usuario }}</small>
                            <p class="mb-1" style="font-size: 1.5rem;">{{ $mensaje->contenido_m }}</p>
                            <small>{{ $mensaje->fecha_m }} | {{ $mensaje->hora_m }}</small>
                        
                        </div>
                    @endforeach
                    
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h4 class="mt-5"> Añadir mensaje </h4>
                    <form method = "post" action = "{{ route($rutaPublicarComentario, ['id' => $grupo->id_grupo_conv]) }}" >  
                        @csrf
                        <div class = "form-group" > 
                            <textarea id='cuerpo_mensaje' class = "form-control" name = "cuerpo_mensaje" > </textarea>
                        </div>
                        <div class = "form-group" > 
                            <input type = "submit" class = "btn btn-success" value = "Enviar" />    
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
            
        </div>
    </div>
    
</div>
  
@endsection