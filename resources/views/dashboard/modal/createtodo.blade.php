 <!-- Modal new to do-->
        <div class="modal fade" id="btnModal" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
              	 {!!Form::open(['method'=>'POST','action'=>['DashboardController@todo']])!!} 
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" style="text-align: center">Nueva Tarea</h4>
                </div>
                <div class="modal-body">                   
                  @include ('dashboard.forms.createtodo')            
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                {!!Form::close()!!}      
              </div>
              </div>
          </div>
