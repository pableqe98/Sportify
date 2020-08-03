@extends('layouts.app')

@section('content')
<div >
    <a href="{{ route('entidad.mis_equipamientos') }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>

<div class="container-fluid mis_eventos"  style="margin-top: 5vh;">
    @include('inc.sidebar')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Equipamiento</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('entidad.accion_crear_equipamiento') }}" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->has('confirmed'))
                                <div class="alert alert-success" role="alert">
                                    {{ $errors->first('confirmed') }}
                                </div>
                        @endif

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre de Equipamiento</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" placeholder="Raqueta, balón,..." name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="n_equipamiento" class="col-md-4 col-form-label text-md-right">Número de Equipamiento</label>

                            <div class="col-md-6">
                                <input id="n_equipamiento" type="number" class="form-control" name="n_equipamiento" value="{{ old('n_equipamiento') }}" required autocomplete="n_equipamiento">

                            </div>
                        </div>

                        <div class="form-group row">
                            <h3>Selecciona desde que día hasta que día quieres dar de alta el equipamiento</h3>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_ini" class="col-md-4 col-form-label text-md-right">Fecha inicio</label>

                            <div class="col-md-6">
                                <input id="fecha_ini" type="date" class="" name="fecha_ini" value="{{ old('fecha_ini') }}" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_fin" class="col-md-4 col-form-label text-md-right">Fecha final</label>

                            <div class="col-md-6">
                                <input id="fecha_fin" type="date" class="" name="fecha_fin" value="{{ old('fecha_fin') }}" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <h3>Selecciona desde que hora hasta que hora quieres dar de alta el equipamiento <span style="color: red">(*)</span></h3>
                        </div>

                        <div class="form-group row">
                            <label for="hora_ini" class="col-md-4 col-form-label text-md-right">Hora inicio</label>

                            <div class="col-md-6">
                                <input type="time" id="hora_ini" class="form-control" name="hora_ini"  required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hora_fin" class="col-md-4 col-form-label text-md-right">Hora final</label>

                            <div class="col-md-6">
                                <input type="time" id="hora_fin" class="form-control" name="hora_fin" required>

                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="deportes" class="col-md-4 col-form-label text-md-right">Temática:</label>

                            <div class="col-md-6">
                                @foreach ($tematicas as $tematica)
                                    <input type="radio" name="tematica_elegida" value="{{ $tematica->id_tematica }}"> {{ $tematica->nombre_tematica }} <br/>
                                @endforeach
                                
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear Equipamiento
                                </button>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-top: 5vh;">
                            <p>(*) Se harán divisiones de 1 hora entre los rangos dados para cada día señalado.</p>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection