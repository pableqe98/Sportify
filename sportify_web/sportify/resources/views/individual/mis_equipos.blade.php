@extends('layouts.app')

@section('content')
<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">
    @include('inc.sidebar')
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 style="padding-top:20px; ">Mis Equipos</h1>

            <div class="row">
                <div class="col-md-4">
                
                    <a role="button" class="btn btn-primary " href="{{ route('individual.crear_equipo') }}">Crear Equipo</a>
                    
                </div>

                <div class="col-md-6">
                </div>
                <div class="col-md-2">
                
                    
                    @if ($invitaciones->isEmpty())
                        <button type="button" class="btn btn-secondary" disabled>Sin Invitaciones</button>
                    @else
                        <a role="button" class="btn btn-warning " data-toggle="modal" data-target="#verInvitaciones">Invitaciones pendientes</a>
    
                        @include('inc.ver_invitaciones_modal')
                    @endif
                </div>

            </div>
            

            <div class="row  ">
                @foreach ($mis_equipos as $equipo)
                <div class="col-lg-3 col-sm-12">
                    <div class="card bg-light">
                        <img class="card-img-top" src="{{ asset($equipo->logo_equipo) }}" alt="Imagen equipo">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $equipo->nombre_equipo }}</h5>
                            
                            <a href="{{ url('individual/equipo/'.$equipo->id_equipo) }}" class="btn btn-primary">Ver equipo</a>
                        </div>
                    
                    </div>
                </div>
                @endforeach
          </div>
            
        </div>
    </div>
    
</div>
  
@endsection