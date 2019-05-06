{!! Form::open(['route'=>['localidades.show', $localidad->id],'method'=>'GET','autocomplete'=>'off','role'=>'search'])!!}
<div class="form-group">
  <div class="input-group">
    <input type="text" class="form-control input-sm" name="searchText" placeholder="Buscar localidad. . ." value="{{$searchText}}">
    <span class="input-group-btn">
      <button type="submit" class="btn btn-default btn-sm">Buscar</button>
  </div>
  </div>
{{Form::close()}}
