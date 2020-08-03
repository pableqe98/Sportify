@extends('layouts.app')

@section('content')
<div class="container-fluid mis_eventos"  style="margin-top: 5vh;">
    @include('inc.sidebar')
    
    @if ($errors->has('confirmed'))
        <div class="alert alert-success" role="alert">
            {{ $errors->first('confirmed') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-4">
                
            <button type="button" class="btn btn-primary" style="height: 6vh; width: 20vw; font-size: large;" data-toggle="modal" data-target="#crear_tematica">Crear Tematica</button>
            @include('inc.crear_tematica')
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <h1 class="mb-5" style="padding-top:20px; ">Gestion Tematicas</h1>
            <table id="administradores" class="table table-striped table-bordered " style="width:100%">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Nombre Tematica</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tematicas as $tematica)
                        <tr>
                            <td class="align-middle">{{ $tematica->id_tematica }}</td>
                            <td class="align-middle">{{ $tematica->nombre_tematica }}</td>
                            <td class="align-middle">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminar_tematica_{{ $tematica->id_tematica }}">Eliminar</button>
                                                                
                            </td>
                            @include('inc.eliminar_tematica')
                            
                        </tr>
                        
                    @endforeach
                </tbody>    
            </table>
        </div>
    </div>
</div>
@endsection