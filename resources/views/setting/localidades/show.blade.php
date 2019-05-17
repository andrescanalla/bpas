@extends ('layouts.admin')


@section ('titulo') 
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6" id="nombre">        
  {{$localidad->nombreLocalidad}}    
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
                <button class="btn btn-link pull-right" data-toggle="modal" data-target="#modal-edit" style="padding-top:0;padding-bottom:0"><i class="fa fa-pencil" aria-hidden="true"></i>
                <button class="btn btn-link pull-right" data-toggle="modal" data-target="#Modal" style="padding-top:0;padding-bottom:0"><i class="fa fa-address-book" aria-hidden="true"></i>
                </div>
                {!!Form::open(['method'=>'PATCH','action'=>['SettingLocalidadController@update', $localidad->id],'autocomplete'=>'off'])!!}
                <div class="panel-body">
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <label>Departamento:</label>
                      {{$localidad->nombreDepartamento}}
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Implementador:</label>
                      {{$localidad->nombreImplementador}}
                    </div>
                </div>
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <label>Latitud:</label>                     
                        <input value="{{$localidad->lat}}" class="form-control" id="lat">                    
                    </div>
                    
                </div>
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Longitud:</label>
                    <input value="{{$localidad->lng}}" class="form-control" id="lng">              
                                       
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
        var localidad = document.getElementById("nombre").textContent;
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
          }
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
