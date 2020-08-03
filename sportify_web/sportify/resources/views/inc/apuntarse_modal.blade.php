<div id="apuntarse" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Apuntarse</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            </div>

            <div class="modal-body">
                
                <div class="row">
                    @if ($tipo_integrantes == 'INDIVIDUAL')
                        <div class="col-md-12 my-5">
                            <form action="{{ url($rutaApuntarse) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary mx-auto" >
                                    Apuntarse Individual
                                </button>
                            
                            </form>
                        </div>
                    @else
                        <div class="col-md-12  my-5">
                            
                            @if($equipos == null )
                                No perteneces a ningún equipo.
                            @else
                                <!-- Muestro la lista de equipos -->
                                <div class="row">
                                    <div id="lista_equipos" class="btn-group-lg btn-group-vertical mx-auto">
                                        @foreach ($equipos as $equipo)
                                            <button type="button" value="{{ $equipo->id_equipo }}" class="btn btn-secondary">{{ $equipo->nombre_equipo }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <form method="POST" action="{{ url($rutaApuntarEquipo) }}" class="mx-auto my-3">
                                        @csrf
                                        <input type="text" id="equipo_seleccionado" name="equipo_seleccionado" value="" style="display: none;">
    
                                        <button type="submit" class="btn btn-primary">
                                            Apuntar Equipo
                                        </button>
                                    </form>
                                </div>
                                
                                
                            @endif
                        
                        </div>
                    @endif
                    
                    
                </div>
            </div>
        </div>
  
    </div>
  </div>