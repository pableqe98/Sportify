<div id="desapuntarse" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">¿Deseas desapuntarte del evento?</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            </div>

            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-12 my-5">
                        <div class="row">
                            <form action="{{ url($rutaDesapuntarse) }}" method="POST" class="mx-auto my-3">
                                @csrf
    
                                @if ($tipo_integrantes == 'INDIVIDUAL')
                                    <input type="text" id="tipo" name="tipo" value="INDIVIDUAL" style="display: none;">
                                @else
                                    <input type="text" id="tipo" name="tipo" value="EQUIPO" style="display: none;">
                                @endif
    
                                <button type="submit" class="btn btn-danger" >
                                    Desapuntarme
                                </button>
                                
                            </form>
                        </div>
                        
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
  
    </div>
  </div>