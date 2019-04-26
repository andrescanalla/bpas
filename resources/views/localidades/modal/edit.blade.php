<div class="modal fade" id="modal-edit" role="dialog">
  <div class="modal-dialog" role="document">
    {!!Form::open(['method'=>'PATCH','action'=>['LocalidadController@update', $localidad->id],'autocomplete'=>'off'])!!}
      <div class="modal-content">
        <div class="modal-header" style="background-color:#F3EA5D">
          
          <h3 class="modal-title" style="text-align: center">Editar Informacion de Localidad</h3>
        </div>
      
        <div class="modal-body">       
          <div class="row">
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label>Fecha Informacion: </label>
                @if(is_null($localidad->fecha_info))
                <input type="text" name="fecha_info" required value="{{$localidad->fecha_info}}" class="form-control" placeholder="Fecha ...">
                @else
                <input type="text" name="fecha_info" required value="{{$localidad->fecha_info->format('d/m/Y')}}" class="form-control" placeholder="Fecha ...">
                @endif
                <input type="hidden" name="searchText" value="{{$searchText}}" class="form-control">                                     
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                  <label class="control-label">Posee Ordenanza</label>
                  <select type="text" name="ordenanza" class="form-control">
                
                  @if(is_null($localidad->ordenanza))
                  <option value=null selected>S/D</option>
                  <option value="0" >No</option>
                  <option value="1">Si</option>
                  @elseif($localidad->ordenanza==1)
                  <option value=null >S/D</option>
                  <option value="0">No</option>
                  <option value="1" selected>Si</option>
                  @else
                  <option value=null >S/D</option>
                  <option value="0" selected>No</option>
                  <option value="1" >Si</option>               
                  @endif
                  
                  </select>                                      
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                  <label class="control-label">Problema</label>
                  <select type="text" name="problema" class="form-control">
                
                  @if(is_null($localidad->problema))
                  <option value=null selected>S/D</option>
                  <option value="0" >No</option>
                  <option value="1">Si</option>
                  @elseif($localidad->problema==1)
                  <option value=null >S/D</option>
                  <option value="0">No</option>
                  <option value="1" selected>Si</option>
                  @else
                  <option value=null >S/D</option>
                  <option value="0" selected>No</option>
                  <option value="1" >Si</option>               
                  @endif
                  
                  </select>                                      
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                  <label class="control-label">Posee Veedor</label>
                  <select type="text" name="veedor" class="form-control">
                
                  @if(is_null($localidad->veedor))
                  <option value=null selected>S/D</option>
                  <option value="0" >No</option>
                  <option value="1">Si</option>
                  @elseif($localidad->veedor==1)
                  <option value=null >S/D</option>
                  <option value="0">No</option>
                  <option value="1" selected>Si</option>
                  @else
                  <option value=null >S/D</option>
                  <option value="0" selected>No</option>
                  <option value="1" >Si</option>               
                  @endif
                  
                  </select>                                      
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Zona Buffer Sin Aplicacion</label>
                <input type="text" name="sin_aplicacion" value="{{$localidad->sin_aplicacion}}" class="form-control" placeholder="metros desde linea 0 ...">                                             
              </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Zona de Aplicacion Controlada</label>
                <input type="text" name="aplicacion_controlada" value="{{$localidad->aplicacion_controlada}}" class="form-control" placeholder="metros desde linea 0 ...">                                             
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