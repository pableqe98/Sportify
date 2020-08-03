<div id="verInvitaciones" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Invitaciones</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            </div>

            <div class="modal-body">
                
                <div class="row">
                    
                        <div class="col-md-12  my-5">
                           
                                <!-- Muestro la lista de usuarios -->
                                <div class="row">
                                    <div id="lista_invitaciones" class=" mx-auto">
                                        @foreach ($invitaciones as $equipo)
                                            
                                            <form method="POST" action="{{ url("/individual/invitaciones/".$equipo->id_equipo) }}" class="mx-auto my-3">
                                                @csrf
                                                <span style="font-size: large; font-weight: bold;">{{ $equipo->nombre_equipo }}</span>
                                                <input type="submit" class="btn btn-success" name="aceptar" value ="Aceptar">
                                                <input type="submit" class="btn btn-danger" name="negar" value ="Negar">
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    
                                </div>

                        
                        </div>
                    
                    
                    
                </div>
            </div>
        </div>
  
    </div>
  </div>