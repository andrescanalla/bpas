<div class="modal fade" id="modal-edit-visita" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    {!!Form::open(['method'=>'PATCH','action'=>['LocalidadController@update', $localidad->id],'autocomplete'=>'off'])!!}
      <div class="modal-content">
        <div class="modal-header" style="background-color:#F3EA5D">
          
          <h3 class="modal-title" style="text-align: center">Editar Informacion de visitas a la Localidad</h3>
        </div>
      
        <div class="modal-body">       
          <div class="row">            
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                  <label class="control-label">Presentacion Programa</label>
                  <input type="hidden" value="1" name="tipo">
                  <select type="text" name="presentacion" id="presentacion" class="form-control" onchange="entre('presentacion')">                
                      
                      @if($localidad->presentacion==1)                  
                      <option value="0">No</option>
                      <option value="1" selected>Si</option>
                      @else                  
                      <option value="0" selected>No</option>
                      <option value="1" >Si</option>               
                      @endif                  
                  </select>                                      
                </div>
            </div>
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                  <label class="control-label">Entrevista</label>
                  <select type="text" name="entrevista" id="entrevista" class="form-control" onchange="entre('entrevista')" >
                
                  
                  @if($localidad->entrevista==1)
                 
                  <option value="0">No</option>
                  <option value="1" selected>Si</option>
                  @else
                  
                  <option value="0" selected>No</option>
                  <option value="1" >Si</option>               
                  @endif
                  
                  </select>                                      
                </div>
            </div>
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
              <div class="form-group">
                  <label class="control-label">Informe</label>
                  <select type="text" name="informe" id="informe" class="form-control" onchange="entre('informe')">
                
                 
                  @if($localidad->informe==1)
                  
                  <option value="0">No</option>
                  <option value="1" selected>Si</option>
                  @else
                  
                  <option value="0" selected>No</option>
                  <option value="1" >Si</option>               
                  @endif
                  
                  </select>                                      
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
@push ('script')
<script>
      function entre(tipo){
        var val = document.getElementById(tipo).selectedIndex;
        console.log('valor:',val);
        if(tipo=="presentacion"){
          if(val==0){
            document.getElementById("entrevista").selectedIndex=0;
            document.getElementById("informe").selectedIndex=0;
          }          
        }
        if(tipo=="entrevista"){
          if(val==1){
            document.getElementById("presentacion").selectedIndex=1;
          }
          else{
            document.getElementById("informe").selectedIndex=0;
          }
        }
        if(tipo=="informe"){
          if(val==1){
            document.getElementById("presentacion").selectedIndex=1;
            document.getElementById("entrevista").selectedIndex=1;
          }          
        }
        


        
      }  
</script>
@endpush