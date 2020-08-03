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

                <div class="image-upload ml-auto">
                    <label for="foto">
                        @if ($imagen)
                            <img src="{{ asset($imagen) }}" style="width: 180px; height: 180px; border-radius: 50%;">
                        @else
                            <img src="http://goo.gl/pB9rpQ" style="width: 180px; height: 180px; border-radius: 50%;">
                        @endif
                    </label>
                
                    <input id="foto" name="foto" type="file"/>
                    <span>Haz click en la imagen para elegir una nueva</span>
                </div>



                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Nombre Usuario</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $nombre_usuario }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nombre_ent" class="col-md-4 col-form-label text-md-right">Nombre Empresa</label>

                    <div class="col-md-6">
                        <input id="nombre_ent" type="text" class="form-control @error('nombre_ent') is-invalid @enderror" name="nombre_ent" value="{{ $nombre_ent }}" required autocomplete="nombre_ent" autofocus>

                    </div>
                </div>

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
                    <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripcion</label>

                    <div class="col-md-6">
                        <textarea id="descripcion" rows="10" cols="60" name="descripcion"  autofocus>
                            {{ $descripcion }}
                        </textarea>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="tlf" class="col-md-4 col-form-label text-md-right">Teléfono</label>

                    <div class="col-md-6">
                        <input id="tlf" type="text" class="form-control @error('tlf') is-invalid @enderror" name="tlf" value="{{ $tlf }}" required autofocus>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="direccion_ent" class="col-md-4 col-form-label text-md-right">Dirección</label>

                    <div class="col-md-6">
                        <input id="direccion_ent" type="text" class="form-control @error('direccion_ent') is-invalid @enderror" name="direccion_ent" value="{{ $direccion }}" required autofocus>

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