 <div class="modal fade" id="btnpModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          {!!Form::open(['method'=>'POST','action'=>['DashController@todo']])!!}
          {{ Form::token() }}         
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="text-align: center">Nuevo Aviso Pedido</h4>
            </div>
            <div class="modal-body" style="padding-bottomt:0px">
              @include ('dashboard.forms.createpedido')           
            </div>
            <div class="success" style="padding-left:15px;padding-right:15px">
              @include ('dashboard.modal.error')
            </div>     
            <div class="modal-footer">             
              <a href="#" id="" class="btn btn-primary createpedido" data-dismiss="modal">Guardar</a>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  
            </div>
          {!!Form::close()!!}      
        </div>
        </div>
  </div>