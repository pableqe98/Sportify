@extends('layouts.app')

@section('content')
<div >
    <a href="{{ url()->previous() }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>

<div class="container-fluid mis_eventos"  style="margin-top: 5vh;">
    @include('inc.sidebar')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Equipo</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('individual.accion_crear_equipo') }}" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->has('confirmed'))
                                <div class="alert alert-success" role="alert">
                                    {{ $errors->first('confirmed') }}
                                </div>
                        @endif

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre Equipo</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripcion</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" rows="10" cols="60" name="descripcion" value="{{ old('descripcion') }}">
                                </textarea>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="foto" class="col-md-4 col-form-label text-md-right">Logo</label>

                            <div class="col-md-6">
                                <input id="foto" type="file" class="form-control" name="foto">

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear Equipo
                                </button>
                            </div>
                        </div>

                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection