@extends('layouts.app')

@section('content')
<div >
    @if (Auth::guard('individual')->check() )
    <a href="{{ url('individual/evento/'.$evento->id_evento) }}" style="font-size: 45px">
    @else
    <a href="{{ url('entidad/evento/'.$evento->id_evento) }}" style="font-size: 45px">
    @endif
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>

<div class="container-fluid mis_eventos"  style="margin-top: 5vh;">
    @include('inc.sidebar')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Modificar Evento</div>

                <div class="card-body">
                    @if (Auth::guard('individual')->check() )
                    <form method="POST" action="{{ url('/individual/modificar-evento/'.$evento->id_evento) }}" enctype="multipart/form-data">
                    @else
                    <form method="POST" action="{{ url('/entidad/modificar-evento/'.$evento->id_evento) }}" enctype="multipart/form-data">
                    @endif
                    
                        @csrf

                        @if ($errors->has('confirmed'))
                                <div class="alert alert-success" role="alert">
                                    {{ $errors->first('confirmed') }}
                                </div>
                        @endif

                        <div class="form-group row">
                            <label for="titulo" class="col-md-4 col-form-label text-md-right">Titulo</label>

                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control" name="titulo" value="{{ $evento->titulo_e }}" >

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripcion</label>

                            <div class="col-md-6">
                                <textarea id="descripcion" rows="10" cols="60" name="descripcion" >
                                    {{ $evento->descripcion_e }}
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_ini" class="col-md-4 col-form-label text-md-right">Fecha inicio</label>

                            <div class="col-md-6">
                                <input id="fecha_ini" type="date" class="" name="fecha_ini" value="{{ $evento->fecha_ini }}" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_fin" class="col-md-4 col-form-label text-md-right">Fecha final</label>

                            <div class="col-md-6">
                                <input id="fecha_fin" type="date" class="" name="fecha_fin" value="{{$evento->fecha_fin }}" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_part" class="col-md-4 col-form-label text-md-right">Tipo de Participantes</label>

                            <div class="col-md-6">
                                <select id="tipo_part" name="tipo_part">
                                    <option {{ $evento->tipo_participantes == 'INDIVIDUAL' ? "selected" : '' }} value="INDIVIDUAL">Individual</option>
                                    <option {{ $evento->tipo_participantes == 'EQUIPO' ? "selected" : '' }} value="EQUIPO">Equipo</option>
                                  </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="foto" class="col-md-4 col-form-label text-md-right">Foto de evento</label>

                            <div class="col-md-6">
                                <input id="foto" type="file" value="{{ $evento->foto }}" class="form-control" name="foto">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">Tipo de Evento</label>

                            <div class="col-md-6">
                                <select id="tipo" name="tipo">
                                    <option {{ $evento->tipo == 'LIGA' ? "selected" : '' }} value="LIGA">Liga</option>
                                    <option {{ $evento->tipo == 'TORNEO' ? "selected" : '' }} value="TORNEO">Torneo</option>
                                    <option {{ $evento->tipo == 'UNICO' ? "selected" : '' }} value="UNICO">Unico</option>
                                   
                                    
                                  </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deportes" class="col-md-4 col-form-label text-md-right">Temática:</label>

                            <div class="col-md-6">
                                @foreach ($tematicas as $tematica)
                                <input type="radio"  name="tematica_elegida" value="{{ $tematica->id_tematica }}" {{ $evento->id_tematica == $tematica->id_tematica ? "checked" : '' }}> {{ $tematica->nombre_tematica }} <br/>
                                @endforeach
                                
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Modificar Evento
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

@section('script')
    
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyArVWjT0pmIxGoMSaK_FzGdHwSfsb6ws&callback=initMap"
async defer></script>
@endsection