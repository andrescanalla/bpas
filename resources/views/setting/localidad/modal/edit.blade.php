<div class="modal fade" id="modal-edit-{{$localidad->id}}" role="dialog">
  <div class="modal-dialog" role="document">
    {!!Form::open(['method'=>'PATCH','action'=>['SettingLocalidadController@update', $localidad->id],'autocomplete'=>'off'])!!}
      <div class="modal-content">
        <div class="modal-header" style="background-color:#F3EA5D">
          
          <h3 class="modal-title" style="text-align: center">Editar Localidad</h3>
        </div>
      
        <div class="modal-body">  
                <div class="row" style="margin-bottom:10px">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">  
                <label>Localidad:</label>
                  <input id="nombre" value="{{$localidad->nombreLocalidad}}" class="form-control">
                  </div>
                </div>             
                
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <label>Latitud:</label>                     
                        <input name="lat" value="{{$localidad->lat}}" class="form-control" id="lat">                    
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">  
                        <div class="form-group">
                          <label class="control-label">Departamento</label>
                          <select type="text" name="departamento" class="form-control">
                            @foreach ($departamentos as $departamento)                           
                            @if($localidad->departamento_id==$departamento->id)
                            <option value="{{$departamento->id}}" selected>{{$departamento->nombre}}</option>
                            @else
                            <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                            @endif
                            @endforeach 
                          </select> 
                         
                        </div>
                        </div>
                    
                </div>
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Longitud:</label>
                    <input name="lng" value="{{$localidad->lng}}" class="form-control" id="lng">              
                                       
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Buscar en mapa:</label>
                      <button type="button" class="form-control btn btn-default" onclick="changeMap()">buscar por lat long..</button>             
                                       
                    </div>
                    
                </div>
                <div class="row" style="margin-bottom:10px">
                  <div id="map" style="height: 80vh">
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
