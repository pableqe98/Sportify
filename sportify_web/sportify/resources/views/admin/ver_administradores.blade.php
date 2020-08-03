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
            
            <a role="button" class="btn btn-primary btn-lg" style="height: 6vh; width: 20vw; font-size: large;" href="{{ route('admin.register') }}">Crear Administrador</a>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-12">
            <h1 class="mb-5" style="padding-top:20px; ">Gestion Administradores</h1>
            <table id="administradores" class="table table-striped table-bordered " style="width:100%">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($administradores as $admin)
                        <tr>
                            <td class="align-middle">{{ $admin->id_admin }}</td>
                            <td class="align-middle">{{ $admin->email }}</td>
                            <td class="align-middle">{{ $admin->tlf_a }}</td>
                            <td class="align-middle">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminar_admin_{{ $admin->id_admin }}">Eliminar</button>
                                                                
                            </td>
                            @include('inc.eliminar_admin')
                            
                        </tr>
                        
                    @endforeach
                </tbody>    
            </table>
        </div>
    </div>
</div>
@endsection
