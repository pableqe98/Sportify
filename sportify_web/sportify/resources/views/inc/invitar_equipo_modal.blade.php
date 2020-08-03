<div id="invitarEquipo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Invitar</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            </div>

            <div class="modal-body">
                
                <div class="row">
                    
                        <div class="col-md-12  mb-5">
                           
                            <div class="row">
                                <input class="form-control mb-4 col-md-4 ml-2" id="filtroNombre" type="text" placeholder="Buscar...">
                            </div>
                                <!-- Muestro la lista de usuarios -->
                                <div class="row">
                                    <div id="lista_usuarios" class="btn-group-lg btn-group-vertical col-md-6 mx-auto pre-scrollable">
                                        @foreach ($usuarios as $usuario)
                                            <button type="button" value="{{ $usuario->id_usuario }}" class="btn btn-secondary">{{ $usuario->nombre_u }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <form method="POST" action="{{ url($rutaInvitarEquipo) }}" class="mx-auto my-3">
                                        @csrf
                                        <input type="text" id="usuario_seleccionado" name="usuario_seleccionado" value="" style="display: none;">
    
                                        <button type="submit" class="btn btn-primary">
                                            Invitar a Equipo
                                        </button>
                                    </form>
                                </div>

                        
                        </div>
                    
                    
                    
                </div>
            </div>
        </div>
  
    </div>
  </div>