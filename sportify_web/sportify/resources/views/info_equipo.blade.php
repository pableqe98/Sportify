@extends('layouts.app')

@section('content')
<div >
    <a href="{{  route('individual.mis_equipos') }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>
<div class="container-fluid mis_eventos"  >
    @include('inc.sidebar')
    
        <div class="col-12">
            <h1 >{{ $equipo->nombre_equipo}}</h1>
            <div class="container-fluid" >
                <div class="row">
                    <div class="col-6 my-3">
                        
                        
                        <div class="my-3" >
                            <span class="font-weight-bold">Descripción: </span>
                            <p class="border border-primary rounded" style="min-height: 150px;">{{ $equipo->descripcion_equipo }}</p>
                        </div>
                         
                        <h3 class="font-weight-bold">Integrantes: </h3>
                        <table id="integrantes" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Info</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($participantes as $jugador)
                                    <tr>
                                        <td class="align-middle"><img src="{{ $jugador->foto_perf }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                                        <td class="align-middle">{{ $jugador->nombre_u }}</td>
                                        <td class="align-middle">{{ $jugador->email }}</td>
                                    </tr>
                                @endforeach
                                    
                            </tbody>   
                       </table>
                    
                       <button type="button" class="btn btn-primary btn-lg btn-block my-3" data-toggle="modal" data-target="#invitarEquipo">Invitar</button>
                      
                       @include('inc.invitar_equipo_modal')
                        
                    </div> 
                    <div class="col-6 " >
                        <div class="row">
                            <img class="ml-auto" src="{{ asset($equipo->logo_equipo) }}" alt="Imagen evento" style="width: 500px; height: 500px;">
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-danger btn-lg " style="width:25vw; position: absolute; right: 0px;" data-toggle="modal" data-target="#desapuntarse">Desapuntarse</button>

                            @include('inc.confirmar_dejar_equipo')
                        </div>
                        
                    </div>
                </div>
                
            </div>            
        </div>
    
</div>
@endsection