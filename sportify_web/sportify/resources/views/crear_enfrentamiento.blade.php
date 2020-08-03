@extends('layouts.app')

@section('content')

<div >
    <a href="{{ url($volver) }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>

<div class="container-fluid mis_eventos"  style="margin-top: 5vh;">
    @include('inc.sidebar')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Enfrentamiento</div>

                <div class="card-body">
                    @if ( Auth::guard('individual')->check() )
                        <form method="POST" action="{{ route('individual.accion_crear_enfrentamiento', ['id' => $evento]) }}" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ url('entidad/crear-enfrentamiento/'. $evento) }}" enctype="multipart/form-data">
                    @endif

                        @csrf

                        @if ($errors->has('confirmed'))
                                <div class="alert alert-success" role="alert">
                                    {{ $errors->first('confirmed') }}
                                </div>
                        @endif

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="participante1">Participante 1</label>
                            </div>
                            <select class="custom-select" id="participante1" name="participante1">
                                @foreach ($participantes as $participante)
                                    @if ($tipo_participantes == 'EQUIPO')
                                        <option value="{{ $participante->id_equipo }}">{{ $participante->nombre_equipo }}</option>
                                    @else
                                        <option value="{{ $participante->id_usuario }}">{{ $participante->nombre_u }}</option>
                                    @endif
                                    
                                @endforeach
                              
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="participante2">Participante 2</label>
                            </div>
                            <select class="custom-select" id="participante2" name="participante2">
                                @foreach ($participantes as $participante)
                                    @if ($tipo_participantes == 'EQUIPO')
                                        <option value="{{ $participante->id_equipo }}">{{ $participante->nombre_equipo }}</option>
                                    @else
                                        <option value="{{ $participante->id_usuario }}">{{ $participante->nombre_u }}</option>
                                    @endif
                                    
                                @endforeach
                              
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right">Fecha</label>

                            <div class="col-md-6">
                                <input id="fecha" type="date" name="fecha" value="{{ old('fecha') }}" required>

                            </div>
                        </div>

                        <input type="text" id="tipo_enfrentamiento" name="tipo_enfrentamiento" value="{{ $tipo_enfrentamiento }}" style="display: none;">
                        <input type="text" id="tipo_participantes" name="tipo_participantes" value="{{ $tipo_participantes }}" style="display: none;">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear Enfrentamiento
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