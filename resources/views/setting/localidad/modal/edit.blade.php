<div class="modal fade" id="modal-edit-{{$departamento->id}}" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    {!!Form::open(['method'=>'PATCH','action'=>['SettingDepartamentoController@update', $departamento->id],'autocomplete'=>'off'])!!}
      <div class="modal-content">
        <div class="modal-header" style="background-color:#F3EA5D">
          
          <h3 class="modal-title" style="text-align: center">Editar Departamento</h3>
        </div>
      
        <div class="modal-body">                 
          <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Departamento</label>
                <input type="text" name="nombre" value="{{$departamento->nombre}}" class="form-control" placeholder="metros desde linea 0 ...">                                             
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Cantidad de localidades</label>
                <input type="text" name="cantidad_localidades" value="{{$departamento->cantidad_localidades}}" class="form-control" placeholder="Cant. Localidades ...">                                             
              </div>
            </div>
            </div>
            <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Implementador</label>
                <input type="text" name="implementador" value="{{$departamento->implementador}}" class="form-control" placeholder="Implemanetador ...">                                             
              </div>
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