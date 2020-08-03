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
            <h1 class="mb-5" style="padding-top:20px; ">Gestion Equipos</h1>
            <table id="administradores" class="table table-striped table-bordered " style="width:100%">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Logo</th>
                        <th>Nombre Equipo</th>
                        <th>Número Integrantes</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($equipos as $equipo)
                        <tr>
                            <td class="align-middle">{{ $equipo->id_equipo }}</td>
                            <td class="align-middle"><img src="{{ asset($equipo->logo_equipo) }}" style="width: 120px; height: 120px; border-radius: 25%;"></td>
                            <td class="align-middle">{{ $equipo->nombre_equipo }}</td>
                            <td class="align-middle">{{ $equipo->n_miembros }}</td>
                            <td class="align-middle">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminar_equipo_{{ $equipo->id_equipo }}">Eliminar</button>
                                                                
                            </td>
                            @include('inc.eliminar_equipo')
                            
                        </tr>
                        
                    @endforeach
                </tbody>    
            </table>
        </div>
    </div>
</div>
@endsection