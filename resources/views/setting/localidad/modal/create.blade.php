<div class="modal fade" id="modal-create" role="dialog">
  <div class="modal-dialog" role="document">
    {!!Form::open(['method'=>'POST','action'=>'SettingLocalidadController@store','autocomplete'=>'off'])!!}
      <div class="modal-content">
        <div class="modal-header" style="background-color:#F3EA5D">
          
          <h3 class="modal-title" style="text-align: center">Crear Localidad</h3>
        </div>      
        <div class="modal-body">                                              
            <div class="row" style="margin-bottom:10px">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label">Localidad</label>
                  <input id="nombre" name="nombre" class="form-control" placeholder="Localiad..." onchange="localidad()">
                  <input type="hidden" name="searchText" value="{{$searchText}}" class="form-control">
                </div>
                
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">  
                    <div class="form-group">
                      <label class="control-label">Departamento</label>
                      <select type="text" name="departamento" class="form-control" >
                        @foreach ($departamentos as $departamento)                           
                        
                        <option value="{{$departamento->id}}" id="Departamento {{$departamento->nombre}}">{{$departamento->nombre}}</option>
                        
                        @endforeach 
                      </select> 
                    
                    </div>
                    </div>
                
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                  <label>Latitud</label>                     
                    <input name="lat" class="form-control" id="lat">                    
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <label>Longitud</label>
                <input name="lng"  class="form-control" id="lng">              
                                  
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <label>Buscar en mapa</label>
                  <button type="button" class="form-control btn btn-default" onclick="changeMap()">buscar por lat long..</button>             
                                  
                </div>
                
            </div>
            <div class="row" style="margin-bottom:10px">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">              
                <div id="map" style="height: 50vh">
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
        
        

        infowindow = new google.maps.InfoWindow();

        map = new google.maps.Map(
            document.getElementById('map'), {
              center: sydney, 
              zoom: 13,              
              streetViewControl: false,
              rotateControl: false,
              fullscreenControl:false              
              });
       

       
      }
      function localidad(){
        var localidad = document.getElementById("nombre").value;
        console.log("locin:", localidad);
        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({'address': localidad+' ,santa fe, Argentina'}, function(results, status) {
          if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
            console.log('resultado',results[0]);
            var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location,
            });
            document.getElementById('lat').value=results[0].geometry.location.lat().toFixed(6) ; 
            document.getElementById('lng').value=results[0].geometry.location.lng().toFixed(6) ; 
            depto=document.getElementById(results[0].address_components[1].long_name);
            if(!depto){
              depto=document.getElementById('Departamento '+results[0].address_components[1].long_name);
            }
            console.log('depto', depto);
            depto.selected=true;
            document.getElementById("nombre").value=results[0].address_components[0].long_name;
            console.log(results[0].address_components[1].long_name);
            console.log('depto:', depto.selected);

          } else {
            alert('Geocode was not successful for the following reason: ' + status);
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