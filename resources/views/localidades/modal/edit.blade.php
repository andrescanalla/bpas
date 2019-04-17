<div class="modal fade" id="modal-edit-{{$visita->id}}" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    {!!Form::open(['method'=>'PATCH','action'=>['LocalidadController@update', $visita->id],'autocomplete'=>'off'])!!}
      <div class="modal-content">
        <div class="modal-header" style="background-color:#F3EA5D">
          
          <h3 class="modal-title" style="text-align: center">Editar Localidad</h3>
        </div>
      
        <div class="modal-body">       
          <div class="row">
            <div class="col-lg-5 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label>Localidad: </label>
                <input type="text" name="nombre" required value="{{$visita->nombre}}" class="form-control" placeholder="Fecha ...">
                <input type="hidden" name="searchText" value="{{$searchText}}" class="form-control"> 
                <input type="hidden" name="page" value="{{$localidades->currentPage()}}" class="form-control">                    
              </div>
            </div>
            <div class="col-lg-7 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Departamento</label>
                <select type="text" name="departamento_id" class="form-control">
                @foreach ($departamentos as $implementador)
                @if($visita->idDepartamento==$implementador->id)
                <option value="{{$implementador->id}}" selected>{{$implementador->nombre}}</option>
                @else
                <option value="{{$implementador->id}}">{{$implementador->nombre}}</option>
                @endif
                @endforeach
                </select>                                      
              </div>
            </div>
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="usuario">Municipio </label>
                            
                </div>
            </div>
                         
          </div>
        </div>
        <div class="modal-footer" style="background-color:#F3EA5D">                                
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>               
      </div>
    {!!Form::close()!!}    
  </div>
</div>