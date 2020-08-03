@extends('layouts.app')

@section('content')
<div class="container-fluid mis_eventos"  >
    @include('inc.sidebar')
    
        <div class="col-12">
            <div class="row">
                <h1 >{{ $evento->titulo_e}}</h1>
                @if (Auth::guard('individual')->check() )
                    @if ($evento->id_usuario_creador == Auth::guard('individual')->user()->id_individual)
                    
                        <a  href="{{ url($edit_evento) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        
                    @endif
                @else
                    @if ($evento->id_usuario_creador == Auth::guard('entidad')->user()->id_entidad)
                    
                        <a  href="{{ url($edit_evento) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        
                    @endif
                @endif
            </div>
            
           
            <div class="container-fluid" >
                <div class="row">
                    <div class="col-6 my-3">
                        <span class="font-weight-bold">Fecha Inicio: </span> <span>{{ $evento->fecha_ini }}</span> <span class="font-weight-bold">| Fecha Final: </span>{{ $evento->fecha_fin }}
                        
                        <div class="my-3" >
                            <span class="font-weight-bold">Descripción: </span>
                            <p class="border border-primary rounded" style="min-height: 300px;">{{ $evento->descripcion_e }}</p>
                        </div>
                        <span class="font-weight-bold">Tematica: </span>{{ $tematica }}
                        <br>
                        <span class="font-weight-bold">Participantes actuales: </span>{{ $evento->n_participantes }}
                        <br>
                        <span class="font-weight-bold">Mínimo participantes: </span>{{ $evento->min_participantes }}
                        <br>
                        <span class="font-weight-bold">Máximo participantes: </span>{{ $evento->max_participantes }}
                        <div>
                            @if ($apuntado == "si")
                                <a href="{{ url($rutaChat) }}" class="btn btn-primary btn-lg my-3" role="button" style="width:25vw;">Chat evento</a>
                            @endif

                            @if (Auth::guard('individual')->check() )
                                @if ($evento->id_usuario_creador == Auth::guard('individual')->user()->id_individual)
                                    @if ($acabado == 'no')
                                        <form method="GET" action="{{ url($rutaCrearEnfrentamiento) }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="text" id="tipo_enfrentamiento" name="tipo_enfrentamiento" value="{{ $evento->tipo }}" style="display: none;">
                                            <input type="text" id="tipo_participantes" name="tipo_participantes" value="{{ $evento->tipo_participantes }}" style="display: none;">
                                            <button type="submit" style="width:25vw;" class="btn btn-primary btn-lg my-3">
                                                Crear Enfrentamiento
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @else
                                @if ($evento->id_usuario_creador == Auth::guard('entidad')->user()->id_entidad)
                                    @if ($acabado == 'no')
                                        <form method="GET" action="{{ url($rutaCrearEnfrentamiento) }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="text" id="tipo_enfrentamiento" name="tipo_enfrentamiento" value="{{ $evento->tipo }}" style="display: none;">
                                            <input type="text" id="tipo_participantes" name="tipo_participantes" value="{{ $evento->tipo_participantes }}" style="display: none;">
                                            <button type="submit" style="width:25vw;" class="btn btn-primary btn-lg my-3">
                                                Crear Enfrentamiento
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endif

                            

                            @if (Auth::guard('individual')->check() )
                                @if ($evento->id_usuario_creador == Auth::guard('individual')->user()->id_individual)
                                    
                                    
                                    @if($equipamiento == null)
                                        @if($empezado == 'si')
                                            <div style="margin-top: 0.5rem;">
                                                <button type="button" class="btn btn-secondary btn-lg"  style="width:25vw; position: absolute; left: 15px;" disabled>No puedes alquilar equipamiento</button>
                                            </div>
                                        @else
                                            <form method="GET" action="{{ url($rutaListaEntidades) }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="text" id="tipo_eleccion" name="tipo_eleccion" value="equipamiento" style="display: none;">
                                                <input type="text" id="evento" name="evento" value="{{ $evento->id_evento }}" style="display: none;">
                                                <button type="submit" style="width:25vw;" class="btn btn-primary btn-lg my-3">
                                                    Buscar Equipamiento
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <div class="row">
                                            <div class="col-7 my-1 ">
                                                <h3 class="font-weight-bold">Equipamiento reservado: </h3>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <span>{{ $equipamiento->nombre_e }} {{ $equipamiento->id_equipamiento }} - {{ $entidad_pista->name }}</span> 
                                                    </div>
                                                  </div>
                                                
                                                
                                            </div>
                                            
                                        </div>
                                    @endif

                                    @if($pista == null)
                                        
                                        @if($empezado == 'si')
                                            <div  style="margin-top: 4.5rem;">
                                                <button type="button" class="btn btn-secondary btn-lg"  style="width:25vw; position: absolute; left: 15px;" disabled>No puedes alquilar pista</button>
                                            </div>
                                        @else
                                            <form method="GET" action="{{ url($rutaListaEntidades) }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="text" id="tipo_eleccion" name="tipo_eleccion" value="pista" style="display: none;">
                                                <input type="text" id="evento" name="evento" value="{{ $evento->id_evento }}" style="display: none;">
                                                <button type="submit" style="width:25vw;" class="btn btn-primary btn-lg my-3">
                                                    Buscar Pista
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <div class="row">
                                            <div class="col-7 my-1 ">
                                                <h3 class="font-weight-bold">Pista reservada: </h3>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <span>Pista {{ $pista->id_pista }} - {{ $entidad_pista->name }}</span> 
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                            
                                        </div>
                                    @endif
                      
                                @endif
                            
                            @endif
                        </div>
                    </div> 
                    <div class="col-6 " >
                        <div class="row">
                            <img class="ml-auto" src="{{ asset($evento->foto) }}" alt="Imagen evento" style="width: 500px; height: 500px;">
                        </div>
                        <div class="row my-2">
                            
                            @if(Auth::guard('entidad')->check() )

                            @elseif ($acabado == "si")
                                <button type="button" class="btn btn-secondary btn-lg " style="width:25vw; position: absolute; right: 0px;" disabled>Acabado</button>
                                
                            @elseif ($apuntado == "si")
                                <button type="button" class="btn btn-danger btn-lg " style="width:25vw; position: absolute; right: 0px;" data-toggle="modal" data-target="#desapuntarse">Desapuntarse</button>

                                @include('inc.confirmar_desapuntar_modal')
                            @elseif($empezado == 'si')
                                <button type="button" class="btn btn-secondary btn-lg"  style="width:25vw; position: absolute; right: 0px;" >Ya no puedes apuntarte</button>
                            
                            @elseif($apuntado == "lleno")
                                <button type="button" class="btn btn-secondary btn-lg " style="width:25vw; position: absolute; right: 0px;" disabled>Lleno</button>

                            @elseif($apuntado == "no" and $empezado == 'no')
                                <button type="button" class="btn btn-primary btn-lg"  style="width:25vw; position: absolute; right: 0px;" data-toggle="modal" data-target="#apuntarse">Apuntarse</button>
                                
                                @include('inc.apuntarse_modal')

                            @endif
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-7 my-5 ">

                        <div class="my-5">
                            <hr  style="border-color:black; ">
                        </div>
                        <!-- Mostrando clasificacion -->
                        @if ($tipo_integrantes == 'INDIVIDUAL')
                            @if ($evento->tipo == 'LIGA')
                                
                                <h3 class="font-weight-bold">Clasificación Liga: </h3>
                                <table id="clasificacion" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Puntos</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($integrantes as $usuario)
                                            @if ($usuario->puntos > 0)
                                                <tr>
                                                    <td class="align-middle"><img src="{{ asset($usuario->foto_perf) }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                                                    <td class="align-middle">{{ $usuario->nombre_u }}</td>
                                                    <td class="align-middle">{{ $usuario->puntos }}</td>
                                                    
                                                </tr>
                                            @endif
                                        
                                        @endforeach
                                    </tbody>    
                                </table>
                            @elseif($evento->tipo == 'TORNEO')
                                <h3 class="font-weight-bold">Posiciones Torneo: </h3>
                                <table id="clasificacion" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Fase</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($integrantes as $usuario)
                                            @if ($usuario->posicion != '')
                                                <tr>
                                                    <td class="align-middle"><img src="{{ asset($usuario->foto_perf) }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                                                    <td class="align-middle">{{ $usuario->nombre_u }}</td>
                                                    <td class="align-middle">{{ $usuario->posicion }}</td>
                                                    
                                                </tr>
                                            @endif
                                        
                                        @endforeach
                                    </tbody>    
                                </table>
                            @else
                                <h3 class="font-weight-bold">Puntuaciones: </h3>
                                <table id="clasificacion" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Puntuacion</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($integrantes as $usuario)
                                        <tr>
                                            <td class="align-middle"><img src="{{ asset($usuario->foto_perf) }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                                            <td class="align-middle">{{ $usuario->nombre_u }}</td>
                                            <td class="align-middle">{{ $usuario->anotados }}</td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>    
                                </table>
                            @endif
                        @else
                            @if ($evento->tipo == 'LIGA')
                                <h3 class="font-weight-bold">Clasificación Liga: </h3>
                                <table id="integrantes" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Puntos</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($integrantes as $equipo)
                                        <tr>
                                            <td class="align-middle"><img src="{{ asset($equipo->logo_equipo) }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                                            <td class="align-middle">{{ $equipo->nombre_equipo }}</td>
                                            <td class="align-middle">{{ $equipo->puntos }}</td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>    
                                </table>
                            @elseif($evento->tipo == 'TORNEO')
                                <h3 class="font-weight-bold">Posiciones Torneo: </h3>
                                <table id="integrantes" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Fase</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($integrantes as $equipo)
                                        <tr>
                                            <td class="align-middle"><img src="{{ asset($equipo->logo_equipo) }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                                            <td class="align-middle">{{ $equipo->nombre_equipo }}</td>
                                            <td class="align-middle">{{ $equipo->posicion }}</td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>    
                                </table>
                            @else
                                <h3 class="font-weight-bold">Puntuaciones: </h3>
                                <table id="integrantes" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Puntuacion</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($integrantes as $equipo)
                                        <tr>
                                            <td class="align-middle"><img src="{{ asset($equipo->logo_equipo) }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                                            <td class="align-middle">{{ $equipo->nombre_equipo }}</td>
                                            <td class="align-middle">{{ $equipo->anotados }}</td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>    
                                </table>
                            @endif






                        @endif
                        
                        <div class="my-5">
                            <hr  style="border-color:black; ">
                        </div>

                        <!-- Mostrando enfrentamientos -->
                        <h3 class="font-weight-bold">Enfrentamientos: </h3>
                                <table id="enfrentamientos" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Equipo 1</th>
                                            <th>Puntuacion 1</th>
                                            <th>Puntuacion 2</th>
                                            <th>Equipo 2</th>
                                            <th>Fecha</th>
                                            @if (Auth::guard('entidad')->check())
                                               
                                                @if ($evento->id_usuario_creador == Auth::guard('entidad')->user()->id_entidad)
                                                    <th>
                                                        Poner Resultado
                                                    </th>
                                                @endif
                                                
                                            @elseif(Auth::guard('individual')->check())

                                                @if ($evento->id_usuario_creador == Auth::guard('individual')->user()->id_individual)
                                                    <th>
                                                        Poner Resultado
                                                    </th>
                                                @endif
                                                
                                            @endif

                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($enfrentamientos as $enfrentamiento)
                                                <tr>
                                                    <td class="align-middle">{{ $enfrentamiento->nombre1 }}</td>
                                                    <td class="align-middle">{{ $enfrentamiento->puntos_1 }}</td>
                                                    <td class="align-middle">{{ $enfrentamiento->puntos_2 }}</td>
                                                    <td class="align-middle">{{ $enfrentamiento->nombre2 }}</td>
                                                    <td class="align-middle">{{ $enfrentamiento->fecha }}</td>
                                                    @if (Auth::guard('entidad')->check())
                                               
                                                        @if ($evento->id_usuario_creador == Auth::guard('entidad')->user()->id_entidad)
                                                            <td class="align-middle">
                                                                <form method="GET" action="{{ url($rutaModificarEnfrentamiento) }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="text" id="tipo_enfrentamiento" name="tipo_enfrentamiento" value="{{ $evento->tipo }}" style="display: none;">
                                                                    <input type="text" id="tipo_participantes" name="tipo_participantes" value="{{ $evento->tipo_participantes }}" style="display: none;">
                                                                    <input type="text" id="particpante1" name="particpante1" value="{{ $enfrentamiento->participante_1 }}" style="display: none;">
                                                                    <input type="text" id="particpante2" name="particpante2" value="{{ $enfrentamiento->participante_2 }}" style="display: none;">
                                                                    
                                                                    <button type="submit"  class="btn btn-primary ">
                                                                        Establecer Resultado
                                                                    </button>
                                                                </form>
                                                            </rd>
                                                        @endif
                                                        
                                                    @elseif(Auth::guard('individual')->check())

                                                        @if ($evento->id_usuario_creador == Auth::guard('individual')->user()->id_individual)
                                                        <td class="align-middle">
                                                            <form method="GET" action="{{ url($rutaModificarEnfrentamiento) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="text" id="tipo_enfrentamiento" name="tipo_enfrentamiento" value="{{ $evento->tipo }}" style="display: none;">
                                                                <input type="text" id="tipo_participantes" name="tipo_participantes" value="{{ $evento->tipo_participantes }}" style="display: none;">
                                                                <input type="text" id="particpante1" name="particpante1" value="{{ $enfrentamiento->participante_1 }}" style="display: none;">
                                                                <input type="text" id="particpante2" name="particpante2" value="{{ $enfrentamiento->participante_2 }}" style="display: none;">
                                                                
                                                                <button type="submit" class="btn btn-primary ">
                                                                    Establecer Resultado
                                                                </button>
                                                            </form>
                                                        </rd>
                                                        @endif
                                                        
                                                    @endif
                                                </tr>
                                        @endforeach
                                    </tbody>    
                                </table>


                        <div class="my-5">
                            <hr  style="border-color:black; ">
                        </div>
                                
                        <!-- Mostrando integrantes/participantes -->
                        <h3 class="font-weight-bold">Integrantes: </h3>
                        
                            @if ($tipo_integrantes == 'INDIVIDUAL')
                                <table id="integrantes" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Valoracion</th>
                                            @if ($acabado == 'si' and !(Auth::guard('entidad')->check() ))
                                                <th>Puntuar</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($integrantes as $usuario)
                                        <tr>
                                            <td class="align-middle"><img src="{{ asset($usuario->foto_perf) }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                                            <td class="align-middle">{{ $usuario->nombre_u }}</td>
                                            <td class="align-middle">{{ $usuario->puntuacion }}</td>
                                            @if ($acabado == 'si' and $usuario->id_usuario == $identificador and !(Auth::guard('entidad')->check() ))
                                                <td class="align-middle"><button type="button" class="btn btn-secondary" disabled>Puntua</button></td>
                                            @elseif($acabado == 'si' and !(Auth::guard('entidad')->check() ))
                                                <td class="align-middle"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puntuar">Puntua</button></td>
                                                @include('inc.puntuar_modal')
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>    
                                </table>
                        
                            @else
                                <table id="integrantes" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Nº de Miembros</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($integrantes as $equipo)
                                        <tr>
                                            <td class="align-middle"><img src="{{ asset($equipo->logo_equipo) }}" style="width: 60px; height: 60px; border-radius: 25%;"></td>
                                            <td class="align-middle">{{ $equipo->nombre_equipo }}</td>
                                            <td class="align-middle">{{ $equipo->n_miembros }}</td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>    
                                </table>
                            
                            @endif
                         
                        
                    </div> 
                    <div class="col-1 my-5 ">
                    </div>
                    <div class="col-4 my-5 " >
                        <div class="row">
                            <h3 class="font-weight-bold">Ubicación: </h3>
                        </div>
                        <div class="row">
                            <iframe width="100%" height="380vh" frameborder="2" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{ $evento->latitud }},{{ $evento->longitud }}&amp;key=AIzaSyAyArVWjT0pmIxGoMSaK_FzGdHwSfsb6ws"></iframe>   
                        </div>
                    
                    </div>
                </div>
            </div>            
        </div>
    
</div>
@endsection

@section('script')
    
@endsection