@extends ('layouts.admin')


@section ('titulo') 
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">        
   Editar {{$localidad->nombreLocalidad}}    
  </div>
  <div class="col-lg-4 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
      
  </div>
  
  </div>

@endsection

@section ('contenido') 

<div class="row">
  <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                Informacion Localidad
               </div>
                {!!Form::open(['method'=>'PATCH','action'=>['SettingLocalidadController@update', $localidad->id],'autocomplete'=>'off'])!!}
                <div class="panel-body">
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <label>Nombre:</label>
                      <input name="nombre" id="nombre" value="{{$localidad->nombreLocalidad}}" class="form-control">
                    </div>
                    
                </div>
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <label>Latitud:</label>                     
                        <input name="lat" value="{{$localidad->lat}}" class="form-control" id="lat">                    
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">  
                        <div class="form-group">
                          <label class="control-label">Departamento</label>
                          <select type="text" name="departamento" class="form-control">
                            @foreach ($departamentos as $departamento)                           
                            @if($localidad->departamento_id==$departamento->id)
                            <option value="{{$departamento->id}}" selected>{{$departamento->nombre}}</option>
                            @else
                            <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                            @endif
                            @endforeach 
                          </select> 
                         
                        </div>
                        </div>
                    
                </div>
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Longitud:</label>
                    <input name="lng" value="{{$localidad->lng}}" class="form-control" id="lng">              
                                       
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Buscar en mapa:</label>
                      <button type="button" class="form-control btn btn-default" onclick="changeMap()">buscar por lat long..</button>             
                                       
                    </div>
                    
                </div>
                <div class="row" style="margin-top:30px">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="pull-right">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Guardar</button>  
                </div>
                </div>

                </div>
                
               
                </div>
                {!!Form::close()!!}    
            </div>
        </div>
    </div>
   
  </div>
  
  <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
      
      <div id="map" style="height: 80vh">
      </div>
  </div>
</div>
@push ('scripts')
<script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var map;
      var service;
      var infowindow;

      function initMap() {
        var sydney = new google.maps.LatLng(-32.962671, -61.058544);
        var localidad = document.getElementById("nombre").value;
        console.log("loc:", localidad);
        
        

        infowindow = new google.maps.InfoWindow();

        map = new google.maps.Map(
            document.getElementById('map'), {
              center: sydney, 
              zoom: 13,              
              streetViewControl: false,
              rotateControl: false,
              fullscreenControl:false              
              });

        var request = {
          query: localidad+', santa fe, argentina',
          fields: ['name', 'geometry', 'formatted_address','type'],
        };

        service = new google.maps.places.PlacesService(map);

        service.findPlaceFromQuery(request, function(results, status) {
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
              createMarker(results[i]);              
            }

            map.setCenter(results[0].geometry.location);
            document.getElementById('lat').value=results[0].geometry.location.lat().toFixed(6) ; 
            document.getElementById('lng').value=results[0].geometry.location.lng().toFixed(6) ; 
              
          }
        });
      }

      function changeMap(){
        lat= document.getElementById('lat').value;
        lng= document.getElementById('lng').value;
        var newMap = new google.maps.LatLng(lat, lng);      

            map.setCenter(newMap);
            var marker = new google.maps.Marker({
                map: map,
                position:newMap,
            });
      }

      function createMarker(place) {
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });
        console.log('as:',place);

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(place.name);
          infowindow.open(map, this);
        });
      }
    </script>
@endpush
@push ('script')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3q64KPI7g7xjoc_vC-w9k4U_OFCtKNek&libraries=places&callback=initMap" sync defer></script>
    

@endpush

@endsection
