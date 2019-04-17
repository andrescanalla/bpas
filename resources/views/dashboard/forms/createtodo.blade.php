                    
   	  <input type="hidden" class="form-control" name="tipo" value="1">                     
      <div class="form-group">
          <label >Importancia</label>     
          {!! Form::select('todo',['1' => 'Normal', '2' => 'Media', '3' => 'Alta'],'1',['class'=>'form-control'])!!}                                     
          <label for="message-text">Tarea</label>
         <textarea class="form-control" name="comentarios" rows="4" placeholder="Comentarios ..."></textarea>                                   
      </div> 