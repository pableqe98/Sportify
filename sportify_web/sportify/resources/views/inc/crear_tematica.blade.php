<div id="crear_tematica" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Crear Tematica</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            </div>

            <div class="modal-body">
                
                <div class="row">
                   
                        <div class="col-md-12 my-5">
                            <form action="{{ route($rutaCrearTematica) }}" method="POST">
                                @csrf
                                <h4>Nombre de tematica</h4>
                                <div class="row">
                                    <div class="col-4">

                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control  mx-auto" id="nombre_tematica" name="nombre_tematica" required>
                                        <button type="submit" class="btn btn-primary my-3" style="width: 100%" >
                                            Crear
                                        </button>
                                    </div>
                                    
                                    <div class="col-4">

                                    </div>
                                </div>
                                
                            
                            </form>
                        </div>
                                            
                   
                    
                    
                </div>
            </div>
        </div>
  
    </div>
  </div>