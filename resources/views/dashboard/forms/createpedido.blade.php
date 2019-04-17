                              
 <input type="hidden" class="form-control" name="tipo" value="4">
 <div class="form-group" style="padding-bottom:0">
	  <label >Importancia</label>     
	  {!! Form::select('todo',['1' => 'Normal', '2' => 'Media', '3' => 'Alta'],'1',['class'=>'form-control'])!!}
	  <label >Usuario</label>                                              
	  <input class="form-control" name="usuario" type="text" required value="" placeholder="Usuario">                                     
	  <label for="message-text">Comentarios</label>
	  <textarea class="form-control" name="comentarios" rows="4" placeholder="Comentarios ..."></textarea>                                   
</div>