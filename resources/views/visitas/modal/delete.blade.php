<div class="modal fade modal-slide-in-rigth" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$visita->id}}">
  {{Form::open(['action'=>array('VisitaController@destroy',$visita->id),'method'=>'delete'])}}
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-lavel="Close">
              <span aria-hidden="true">x</span>
            </button>
            <h4 class="modal-title">Eliminar Visita {{$visita->nombreLocalidad}} el {{$visita->fecha}}</h4>
          </div>
          <div class="modal-body">
          Esta Seguro que quiere eliminar la Visita
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-defaul" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Confirmar</button>
          </div>
      </div> 
    </div>
  {{Form::Close()}}
</div>
