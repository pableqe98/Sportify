@extends('layouts.app')

@section('content')
<div >
    <a href="{{ route('individual.mis_eventos') }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>

<div class="container-fluid mis_eventos"  style="margin-top: 5vh;">
    @include('inc.sidebar')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Evento</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('individual.accion_crear_evento') }}" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->has('confirmed'))
                                <div class="alert alert-success" role="alert">
                                    {{ $errors->first('confirmed') }}
                                </div>
                        @endif

                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">Titulo</label>

                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control" name="titulo" value="{{ old('titulo') }}" required autocomplete="titulo" autofocus>

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
                            <label for="tipo_part" class="col-md-4 col-form-label text-md-right">Tipo de Participantes</label>

                            <div class="col-md-6">
                                <select id="tipo_part" name="tipo_part">
                                    <option value="INDIVIDUAL">Individual</option>
                                    <option value="EQUIPO">Equipo</option>
                                  </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="min_participantes" class="col-md-4 col-form-label text-md-right">Número Mínimo Participantes</label>

                            <div class="col-md-6">
                                <input id="min_participantes" type="number" class="form-control" name="min_participantes" value="{{ old('min_participantes') }}" required autocomplete="min_participantes">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="max_participantes" class="col-md-4 col-form-label text-md-right">Número Máximo Participantes</label>

                            <div class="col-md-6">
                                <input id="max_participantes" type="number" class="form-control" name="max_participantes" value="{{ old('max_participantes') }}" required autocomplete="max_participantes">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="n_participantes" class="col-md-4 col-form-label text-md-right">Número Actual Participantes (*)</label>

                            <div class="col-md-6">
                                <input id="n_participantes" type="number" class="form-control" name="n_participantes" value="{{ old('n_participantes') }}" required autocomplete="n_participantes">

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="foto" class="col-md-4 col-form-label text-md-right">Foto de evento</label>

                            <div class="col-md-6">
                                <input id="foto" type="file" class="form-control" name="foto" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">Tipo de Evento</label>

                            <div class="col-md-6">
                                <select id="tipo" name="tipo">
                                    <option value="UNICO">Unico</option>
                                    <option value="LIGA">Liga</option>
                                    <option value="TORNEO">Torneo</option>
                                  </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="map" class="col-md-4 col-form-label text-md-right">Ubicación</label>

                            <div class="col-md-8">
                                <div id="map" style="width: auto; height: 500px;"></div>
                                <input type="text" id="lat" name="lat" readonly="yes" style="display:none;">
                                <input type="text" id="lng" name="lng" readonly="yes" style="display:none;">
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
                                    Crear Evento
                                </button>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-top: 5vh;">
                            <p>(*) Rellenar en caso de que haya integrantes que no se vayan a apuntar mediante Sportify</p>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyArVWjT0pmIxGoMSaK_FzGdHwSfsb6ws&callback=initMap"
async defer></script>
@endsection