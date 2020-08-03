@extends('layouts.app')

@section('content')
<div class="container-fluid mis_eventos"  style="margin-top: 5vh;">
    @include('inc.sidebar')
    
    @if ($errors->has('confirmed'))
        <div class="alert alert-success" role="alert">
            {{ $errors->first('confirmed') }}
        </div>
    @endif
    
    
    <div class="row ">
        <div class="col-md-12">
            <h1 class="mb-5" style="padding-top:20px; ">Gestion Eventos</h1>
            <table id="administradores" class="table table-striped table-bordered " style="width:100%">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Imagen</th>
                        <th>Nombre Evento</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($eventos as $evento)
                        <tr>
                            <td class="align-middle">{{ $evento->id_evento }}</td>
                            <td class="align-middle"><img src="{{ asset($evento->foto) }}" style="width: 120px; height: 120px; border-radius: 25%;"></td>
                            <td class="align-middle">{{ $evento->titulo_e }}</td>
                            <td class="align-middle">{{ $evento->fecha_ini }}</td>
                            <td class="align-middle">{{ $evento->fecha_fin }}</td>
                            <td class="align-middle">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminar_evento_{{ $evento->id_evento }}">Eliminar</button>
                                                                
                            </td>
                            @include('inc.eliminar_evento')
                            
                        </tr>
                        
                    @endforeach
                </tbody>    
            </table>
        </div>
    </div>
</div>
@endsection