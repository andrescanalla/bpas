<div class="modal fade" id="modal-create" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    {!!Form::open(['action'=>['ComentarioController@store', $localidad->id],'autocomplete'=>'off'])!!}
      <div class="modal-content">
        <div class="modal-header" style="background-color:#F3EA5D">          
          <h3 class="modal-title" style="text-align: center">Crear Comentario en {{$localidad->nombreLocalidad}}</h3>
        </div>      
        <div class="modal-body">       
          <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label>Fecha:</label>
                <input type="text" name="fecha_comentario" required  class="form-control" placeholder="29/01/2014 ...">
                <input type="hidden" name="searchText" value="{{$searchText}}" class="form-control">
                <input type="hidden" name="id" value="{{$localidad->id}}" class="form-control">                                     
              </div>
            </div>
            
            
           
          
            </div>
            <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
            <label>Comentarios</label>
                <textarea type="text" rows="4" name="comentarios" class="form-control" placeholder="cometarios ..."> </textarea>                                                        
            </div>
            </div>
        </div>
        <div class="modal-footer" >                                
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>               
      </div>
    {!!Form::close()!!}    
  </div>
</div>