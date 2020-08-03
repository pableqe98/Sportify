@extends('layouts.app')

@section('content')
<div >
    <a href="{{ url()->previous() }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>

<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">
    @include('inc.sidebar')
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 style="padding-top:20px; ">Mis Amigos</h1>

            <div class="row">
                <div class="col-md-4">
                
                    <a role="button" class="btn btn-warning " data-toggle="modal" data-target="#invitarAmigo">Añadir amigo</a>
                    @include('inc.invitar_amigo_modal')
                    
                </div>

                <div class="col-md-6">
                </div>
                <div class="col-md-2">
                
                    
                    @if ($solicitudes->isEmpty())
                        <button type="button" class="btn btn-secondary" disabled>Sin solicitudes</button>
                    @else
                        <a role="button" class="btn btn-warning " data-toggle="modal" data-target="#verSolicitudes">Solicitudes pendientes</a>
    
                        @include('inc.ver_solicitudes_modal')
                    @endif
                </div>

            </div>
            

            <div class="row  ">
                <div class="col-md-3"></div>
                <div class="list-group col-md-6">
                    @foreach ($mis_amigos as $amigo)
                        <div  class="list-group-item list-group-item-action  align-items-start ">

                            <img src="{{ asset($amigo->foto) }}" style="width: 130px; height: 130px;" alt="Imagen de {{ $amigo->nombre_completo_i }}">
                            <span class="mb-1" style="font-size: 2rem">{{ $amigo->nombre_completo_i }}</span>
                                
                        </div>
                    @endforeach
                </div>
                <div class="col-md-3"></div>
            </div>
            
        </div>
    </div>
    
</div>
  
@endsection