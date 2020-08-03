<div id="eliminar_admin_{{ $admin->id_admin }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">¿Deseas eliminar a Admin {{ $admin->id_admin }} ? </h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            </div>

            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-12 my-5">
                        
                            <form action="{{ route($rutaEliminarAdmin) }}" method="POST" class="mx-auto my-3">
                                @csrf
                                <input type="text" name="id_admin" value="{{ $admin->id_admin }}" style="display: none;">
                                
                                <div class="row">
                                    <button type="submit" class="btn btn-danger btn-lg mx-auto" >
                                        Eliminar
                                    </button>
                                </div>
                            </form>
                        
                            
                        
                    </div>
                    
                </div>
            </div>
        </div>
  
    </div>
</div>