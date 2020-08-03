@extends('layouts.app')

@section('content')
<div class="container"  style="margin-top: 5vh;">
    @include('inc.sidebar')
    
    <div class="row justify-content-center">
        @if ($errors->has('confirmed'))
                                <div class="alert alert-success" role="alert">
                                    {{ $errors->first('confirmed') }}
                                </div>
                            @endif
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Inicio Administrador</div>

                <div class="card-body">
                    


                    <div class="row mt-3">
                        <div class="col-md-12">
                        <a role="button" class="btn btn-primary btn-lg" style="width: 100%;" href="{{ route('admin.register') }}">Dar de alta Administrador</a>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <a  role="button" class="btn btn-primary btn-lg" style="width: 100%;" href="{{ route('admin.usuarios') }}">Gestion Usuarios</a>
                        
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <a role="button" class="btn btn-primary btn-lg" style="width: 100%;" href="{{ route('admin.admins') }}">Gestion Administradores</a>
                        
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <a role="button" class="btn btn-primary btn-lg" style="width: 100%;" href="{{ route('admin.eventos') }}">Gestion Eventos</a>
                        
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
