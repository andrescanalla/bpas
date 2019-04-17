<div class="modal fade" id="modal-edit-{{$visita->id}}" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    {!!Form::open(['method'=>'PATCH','action'=>['VisitaController@update', $visita->id],'autocomplete'=>'off'])!!}
      <div class="modal-content">
        <div class="modal-header" style="background-color:#F3EA5D">
          
          <h3 class="modal-title" style="text-align: center">Editar Visita</h3>
        </div>
      
        <div class="modal-body">       
          <div class="row">
            <div class="col-lg-5 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label>Fecha: </label>
                <input type="text" name="fecha" required value="{{$visita->fecha}}" class="form-control" placeholder="Fecha ...">
                <input type="hidden" name="searchText" value="{{$searchText}}" class="form-control"> 
                <input type="hidden" name="page" value="{{$visitas->currentPage()}}" class="form-control">                    
              </div>
            </div>
            <div class="col-lg-7 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                <label class="control-label">Implementador</label>
                <select type="text" name="implementador_id" class="form-control">
                @foreach ($implementadores as $implementador)
                @if($visita->idImplementador==$implementador->id)
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
                  <label for="usuario">Localidad: </label>
                  <input type="text" name="localidad" required value="{{$visita->nombreLocalidad}}" class="form-control" placeholder="Localidad ...">          
                </div>
            </div>
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label">Visita</label>
                  <select type="text" name="tipo_visita_id" class="form-control">
                  @foreach ($tipoVisitas as $tipoVisita)
                  @if($visita->idTipoVisita==$tipoVisita->id)
                  <option value="{{$tipoVisita->id}}" selected>{{$tipoVisita->nombre}}</option>
                  @else
                  <option value="{{$tipoVisita->id}}">{{$tipoVisita->nombre}}</option>
                  @endif
                  @endforeach 
                </select> 
                </div>
            </div>  
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="comentarios">Comentarios</label>
                  <textarea  rows="4" name="comentarios" value="{{$visita->comentarios}}" class="form-control" placeholder="Comentarios...">{{$visita->comentarios}}</textarea>
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