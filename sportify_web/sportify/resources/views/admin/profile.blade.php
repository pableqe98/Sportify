@extends('layouts.app')


@section('content')
<div class="container"  style="margin-top: 5vh;">
    
    @include('inc.sidebar')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 style="padding-top:20px; text-align:center; ">Perfil</h1>
            <form method="POST" action="{{  route($updateRoute) }}" enctype="multipart/form-data">
                @csrf

                @if ($errors->has('confirmed'))
                            <div class="alert alert-success" role="alert">
                                {{ $errors->first('confirmed') }}
                            </div>
                @elseif ($errors->has('incorrecto'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('incorrecto') }}
                            </div>
                @endif


                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                
                <div class="form-group row">
                    <label for="tlf" class="col-md-4 col-form-label text-md-right">Teléfono</label>

                    <div class="col-md-6">
                        <input id="tlf" type="text" class="form-control @error('tlf') is-invalid @enderror" name="tlf" value="{{ $tlf }}" required>

                    </div>
                </div>


                <div class="form-group row mx-auto">
                    <h5>Rellenar si quieres cambiar la contraseña</h5>
                </div>

                <div class="form-group row">
                    <label for="current-password" class="col-md-4 col-form-label text-md-right">Contraseña Actual</label>

                    <div class="col-md-6">
                        <input id="current-password" type="password" class="form-control @error('current-password') is-invalid @enderror" name="current-password" >

                        @error('current-password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña Nueva</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirma contraseña nueva</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>
<!--    ----------------------------------------------------------------------  -->
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Actualizar
                        </button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>

</div>
@endsection