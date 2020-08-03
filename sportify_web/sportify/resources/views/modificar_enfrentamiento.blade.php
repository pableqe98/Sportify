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
                <div class="card-header">Resultado Enfrentamiento</div>

                <div class="card-body">
                    @if (Auth::guard('individual')->check() )
                        <form method="POST" action="{{ route('individual.accion_modificar_enfrentamiento', ['id' => $evento]) }}" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ route('entidad.accion_modificar_enfrentamiento', ['id' => $evento]) }}" enctype="multipart/form-data">
                    @endif

                        @csrf

                        @if ($errors->has('confirmed'))
                                <div class="alert alert-success" role="alert">
                                    {{ $errors->first('confirmed') }}
                                </div>
                        @endif


                        @if ($tipo_enfrentamiento == 'LIGA' or $tipo_enfrentamiento == 'UNICO')
                            @if($tipo_participantes == 'EQUIPO')
                                <div class="input-group input-group-lg my-2">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroup-sizing-lg">Marcador {{ $participante1->nombre_equipo }}</span>
                                    </div>
                                    <input type="number" class="form-control" id="puntuacion1" name="puntuacion1" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                </div>

                                <div class="input-group input-group-lg my-2">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroup-sizing-lg">Marcador {{ $participante2->nombre_equipo }}</span>
                                    </div>
                                    <input type="number" class="form-control" id="puntuacion2" name="puntuacion2" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                </div>
                            @else
                                <div class="input-group input-group-lg my-2">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroup-sizing-lg">Marcador {{ $participante1->nombre_u }}</span>
                                    </div>
                                    <input type="number" class="form-control" id="puntuacion1" name="puntuacion1" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                </div>

                                <div class="input-group input-group-lg my-2">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroup-sizing-lg">Marcador {{ $participante2->nombre_u }}</span>
                                    </div>
                                    <input type="number" class="form-control" id="puntuacion2" name="puntuacion2" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                </div>
                            @endif
                            
                        @elseif ($tipo_enfrentamiento == 'TORNEO')

                            @if($tipo_participantes == 'EQUIPO'){
                                <div class="input-group input-group-lg my-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Marcador {{ $participante1->nombre_equipo }}</span>
                                    </div>
                                    <input type="number" class="form-control" id="puntuacion1" name="puntuacion1" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                    
                                </div>
                                <div class="input-group input-group-lg my-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Fase a la que pasa/se queda</span>
                                    </div>
                                    <input type="text" class="form-control" id="fase1" name="fase1" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                    
                                </div>

                                

                                <div class="input-group input-group-lg my-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Marcador {{ $participante2->nombre_equipo }}</span>
                                    </div>
                                    <input type="number" class="form-control" id="puntuacion2" name="puntuacion2" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                    
                                </div>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Fase a la que pasa/se queda</span>
                                    </div>
                                    <input type="text" class="form-control" id="fase2" name="fase2" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                    
                                </div>
                            @else
                                <div class="input-group input-group-lg my-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Marcador {{ $participante1->nombre_u }}</span>
                                    </div>
                                    <input type="number" class="form-control" id="puntuacion1" name="puntuacion1" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                    
                                </div>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Fase a la que pasa/se queda</span>
                                    </div>
                                    <input type="text" class="form-control" id="fase1" name="fase1" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                    
                                </div>

                                

                                <div class="input-group input-group-lg my-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Marcador {{ $participante2->nombre_u }}</span>
                                    </div>
                                    <input type="number" class="form-control" id="puntuacion2" name="puntuacion2" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                    
                                </div>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Fase a la que pasa/se queda</span>
                                    </div>
                                    <input type="text" class="form-control" id="fase2" name="fase2" aria-label="Large" aria-describedby="inputGroup-sizing-sm" required>
                                    
                                </div>
                            @endif
                        
                            
                        @endif

                        @if($tipo_participantes == 'EQUIPO')
                            <input type="text" id="participante1" name="participante1" value="{{ $participante1->id_equipo }}" style="display: none;">
                            <input type="text" id="participante2" name="participante2" value="{{ $participante2->id_equipo }}" style="display: none;">
                            
                        @else
                            <input type="text" id="participante1" name="participante1" value="{{ $participante1->id_usuario }}" style="display: none;">
                            <input type="text" id="participante2" name="participante2" value="{{ $participante2->id_usuario }}" style="display: none;">
                            
                        @endif
                        

                        <input type="text" id="tipo_enfrentamiento" name="tipo_enfrentamiento" value="{{ $tipo_enfrentamiento }}" style="display: none;">
                        <input type="text" id="tipo_participantes" name="tipo_participantes" value="{{ $tipo_participantes }}" style="display: none;">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Establecer resultado
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