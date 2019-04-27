<div class="modal fade modal-slide-in-rigth" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$visita->id}}">
  {{Form::open(['action'=>array('VisitaController@destroy',$visita->id),'method'=>'delete'])}}
    <div class="modal-dialog  modal-sm">
      <div class="modal-content">
          <div class="modal-header" style="background-color:#F4364C">            
            <h4 class="modal-title" style="text-align: center">Eliminar Visita </h4>            
          </div>
          <div class="modal-body">
            <div class="row"> 
              <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12"> 
                Esta Seguro que quiere eliminar la Visita del <b>{{$visita->fecha->format('d/m/Y')}}</b> 
                a la localidad de <b>{{$visita->nombreLocalidad}}</b> con el tipo de visita  <b>{{$visita->nombreTipoVisita}}</b> 
                <input type="hidden" name="searchText" value="{{$searchText}}" class="form-control"> 
                <input type="hidden" name="page" value="{{$visitas->currentPage()}}" class="form-control">
              </div>
            </div> 
            <div class="row" style="margin-top:15px"> 
              <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12"> 
                <label>!!!Importante!!</label>
                La visita tambien se eliminara del Google Calendar
              </div>
            </div>           

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-defaul" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </div>
      </div> 
    </div>
  {{Form::Close()}}
</div>
