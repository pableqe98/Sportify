@extends('layouts.app')

@section('content')

<div >
    @if ($user_type == 'admin')
        
    @else
        <a href="{{ url()->previous() }}" style="font-size: 45px">
            <i class="fas fa-arrow-alt-circle-left" style="bac"></i>
        </a>
    @endif
    
</div>

<div class="container-fluid" id='contenido-registro'>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $register_type }}</div>

                <div class="card-body">

                    @if($user_type == 'individual')
                        <form method="POST" action="{{ route('individual.register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre Usuario</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="n_completo" class="col-md-4 col-form-label text-md-right">Nombre Completo</label>

                                <div class="col-md-6">
                                    <input id="n_completo" type="text" class="form-control @error('n_completo') is-invalid @enderror" name="n_completo" value="{{ old('n_completo') }}" required autocomplete="n_completo" autofocus>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirma contraseña</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripcion</label>

                                <div class="col-md-6">
                                    <textarea id="descripcion" rows="10" cols="60" name="descripcion" value="{{ old('descripcion') }}" autofocus>
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto" class="col-md-4 col-form-label text-md-right">Foto de perfil</label>

                                <div class="col-md-6">
                                    <input id="foto" type="file" class="form-control" name="foto">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tlf" class="col-md-4 col-form-label text-md-right">Teléfono</label>

                                <div class="col-md-6">
                                    <input id="tlf" type="text" class="form-control @error('tlf') is-invalid @enderror" name="tlf" value="{{ old('tlf') }}" required autofocus>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fecha" class="col-md-4 col-form-label text-md-right">Fecha de nacimiento</label>

                                <div class="col-md-6">
                                    <input id="fecha" type="date" class="" name="fecha" value="{{ old('fecha') }}" required autofocus>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deportes" class="col-md-4 col-form-label text-md-right">Deportes que te interesan</label>

                                <div class="col-md-6">
                                    @foreach ($tematicas as $tematica)
                                    <input type="checkbox" name="interesado[]" value="{{ $tematica->id_tematica }}"> {{ $tematica->nombre_tematica }} <br/>
                                    @endforeach
                                    
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Registrar
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    @elseif($user_type == 'entidad')
                        <form method="POST" action="{{ route('entidad.register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre Usuario</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                    <input id="nombre_ent" type="text" class="form-control @error('nombre_ent') is-invalid @enderror" name="nombre_ent" value="{{ old('nombre_ent') }}" required autocomplete="nombre_ent" autofocus>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirma contraseña</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripcion</label>

                                <div class="col-md-6">
                                    <textarea id="descripcion" rows="10" cols="60" name="descripcion" value="{{ old('descripcion') }}" autofocus>
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto" class="col-md-4 col-form-label text-md-right">Foto de perfil</label>

                                <div class="col-md-6">
                                    <input id="foto" type="file" class="form-control" name="foto">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tlf" class="col-md-4 col-form-label text-md-right">Teléfono</label>

                                <div class="col-md-6">
                                    <input id="tlf" type="text" class="form-control @error('tlf') is-invalid @enderror" name="tlf" value="{{ old('tlf') }}" required autofocus>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="direccion_ent" class="col-md-4 col-form-label text-md-right">Dirección</label>

                                <div class="col-md-6">
                                    <input id="direccion_ent" type="text" class="form-control @error('direccion_ent') is-invalid @enderror" name="direccion_ent" value="{{ old('direccion_ent') }}" required autofocus>

                                </div>
                            </div>

                            

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Registrar
                                    </button>
                                </div>
                            </div>
                            
                        </form>

                    @elseif($user_type == 'admin')

                        <form method="POST" action="{{ route('admin.register') }}">
                            @csrf
                            @if ($errors->has('confirmed'))
                                <div class="alert alert-success" role="alert">
                                    {{ $errors->first('confirmed') }}
                                </div>
                            @endif
                            
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirma contraseña</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="tlf" class="col-md-4 col-form-label text-md-right">Teléfono</label>

                                <div class="col-md-6">
                                    <input id="tlf" type="text" class="form-control @error('tlf') is-invalid @enderror" name="tlf" value="{{ old('tlf') }}" required autofocus>

                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Registrar
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
