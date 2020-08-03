<div id="puntuar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Puntuar</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            </div>

            <div class="modal-body">
                
                <div class="row">
                    @if ($tipo_integrantes == 'INDIVIDUAL')
                        <div class="col-md-12 my-5">
                            <form action="{{ url($rutaPuntuar . $usuario->id_usuario) }}" method="POST">
                                @csrf
                                <h4>Puntuar a {{ $usuario->nombre_u }}</h4>
                                <div class="row">
                                    <div class="col-4">

                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control  mx-auto" id="nota" name="nota" min="0" max="10">
                                        <input type="number" id="acumulado" name="acumulado" style="display: none;" value="{{ $usuario->puntuacion }}">
                                        <input type="number" id="evento" name="evento" style="display: none;" value="{{ $evento->id_evento }}">
                                        <button type="submit" class="btn btn-primary my-3" style="width: 100%" >
                                            Puntuar
                                        </button>
                                    </div>
                                    
                                    <div class="col-4">

                                    </div>
                                </div>
                                
                            
                            </form>
                        </div>
                                            
                    @endif
                    
                    
                </div>
            </div>
        </div>
  
    </div>
  </div>