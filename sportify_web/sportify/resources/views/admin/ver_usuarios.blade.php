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
            <h1 class="mb-5" style="padding-top:20px; ">Gestion Usuarios</h1>
            <table id="administradores" class="table table-striped table-bordered " style="width:100%">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Ver perfil</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td class="align-middle">{{ $usuario->id_usuario }}</td>
                            <td class="align-middle"><img src="{{ asset($usuario->foto_perf) }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                            <td class="align-middle">{{ $usuario->nombre_u }}</td>
                            <td class="align-middle">{{ $usuario->email }}</td>
                            <td class="align-middle">{{ $usuario->tipo_u }}</td>
                            <td class="align-middle">
                                <a role="button" class="btn btn-primary " href="{{ url($rutaVerUsuario . $usuario->id_usuario) }}">Ver perfil</a>
                                                                
                            </td>
                            <td class="align-middle">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminar_usuario_{{ $usuario->id_usuario }}">Eliminar</button>
                                                                
                            </td>
                            @include('inc.eliminar_usuario')
                            
                        </tr>
                        
                    @endforeach
                </tbody>    
            </table>
        </div>
    </div>
</div>
@endsection