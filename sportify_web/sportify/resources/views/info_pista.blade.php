@extends('layouts.app')

@section('content')

@if (Auth::guard('entidad')->check() )
    <div >
        <a href="{{  route('entidad.mis_pistas') }}" style="font-size: 45px">
            <i class="fas fa-arrow-alt-circle-left"></i>
        </a>
    </div>
@endif

<div class="container-fluid mis_eventos"  >
    @include('inc.sidebar')
    
        <div class="col-12">
            
            <h1 >Pista {{ $pistas[0]->id_pista }}</h1>
            <div class="container-fluid" >
                <div class="row">
                    <div class="col-6 my-3">
                        
                        <span class="font-weight-bold">Tematica: </span>{{ $tematica->nombre_tematica }}
                        <br>
                        <span class="font-weight-bold">Ubicación: </span>{{ $pistas[0]->ubicacion_pista }}
                        <br>
                        <span class="font-weight-bold">Empresa: </span>{{ $entidad->name }}
                        <br>
                        
                    </div> 
                    <div class="col-6 " >
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 my-2 ">
                        <h3 class="font-weight-bold">Horas disponibles: </h3>
                        
                            
                                <table id="integrantes" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Dia</th>
                                            <th>Hora</th>
                                            @if ( Auth::guard('individual')->check() )
                                                <th>Alquilar</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($pistas as $pista)
                                        <tr>
                                            
                                            <td class="align-middle">{{ $pista->dia }}</td>
                                            <td class="align-middle">{{ $pista->hora }}</td>
                                            @if ( Auth::guard('individual')->check() )
                                                <td class="align-middle">
                                                    <form action={{ url('individual/lista-entidades/'.$id_evento.'/'.$entidad->id_entidad.'/'.$pista->id_pista) }} method="post">
                                                        @csrf
                                                        <input type="text" id="dia" name="dia" value="{{ $pista->dia }}" style="display: none;">
                                                        <input type="text" id="hora" name="hora" value="{{ $pista->hora }}" style="display: none;">
                                                        <button type="submit" class="btn btn-success" >Alquilar</button>
                                                    </form>
                                                    
                                                </td>
                                            @endif
                                            
                                               
                                        </tr>
                                        @endforeach
                                    </tbody>    
                                </table>
                                                    
                            
                         
                        
                    </div> 
                    
                </div>
            </div>            
        </div>
    
</div>
@endsection