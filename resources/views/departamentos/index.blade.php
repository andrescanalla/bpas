@extends ('layouts.admin')


@section ('titulo') 
<div class="row">
  <div class="col-lg-9 col-md-8 col-sm-6 col-xs-6" id="nombre">        
  Departamentos
  </div>
  <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
    
  </div>
  
  </div>

@endsection

@section ('contenido')   
<div class="row">
  <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
  <div class="panel panel-default">
    <div class="table-responsive">
      <table class="table table-condensed table-hover" id="table" style="margin-bottom:0px">
        <thead style="background-color:#f5f5f5">
          <th>id</th>  
          <th>Departamento</th>
          <th>Implementador</th>  
          <th>Localidades</th>         
          <th>Actividades</th>          
          <th>Detalle</th>
        </thead>
        @php $nx=0;@endphp                
        @foreach ($departamentos as $departamento)
        @php $nx++;@endphp
        
        <tr id="{{$departamento->nombreDepartamento}}" name="no">
          <td>{{$departamento->id}}</td>                
          <td>{{$departamento->nombreDepartamento}}</td>
          <td>{{$departamento->nombreImplementador}} {{$departamento->apellido}}</td>
          <td>{{$departamento->cantidad_localidades}}</td>
          <td style="min-width: 110px;">
            <div class="row">
            <div class="progress">
              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$departamento->pre}}" aria-valuemin="0" aria-valuemax="{{$departamento->cantidad_localidades}}" style="width: {{$departamento->pre/$departamento->cantidad_localidades*100}}%">
              {{$departamento->pre}} Presentaciones 
              </div>             
            </div>              
            </div>
            <div class="row">
            <div class="progress">
              <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{$departamento->entre}}" aria-valuemin="0" aria-valuemax="{{$departamento->cantidad_localidades}}" style="width: {{$departamento->entre/$departamento->cantidad_localidades*100}}%">
              {{$departamento->entre}} Entrevistas 
              </div>             
            </div>  
            </div>
            <div class="row">
            <div class="progress">
              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{$departamento->info}}" aria-valuemin="0" aria-valuemax="{{$departamento->cantidad_localidades}}" style="width: {{$departamento->info/$departamento->cantidad_localidades*100}}%">
              {{$departamento->info}} Informes 
              </div>             
            </div>
            </div>
          </td>
          
          <td style="text-align: center;">            
           <a href="departamentos/{{$departamento->id}}"> <button class="btn btn-link pull-right" data-toggle="modal" data-target="#eModal{{$nx}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-info-circle" aria-hidden="true"></i> </button>   </a>        
          </td>
        </tr>
        
        @endforeach
        
      </table>
    </div>
  </div>
  </div>
  <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
  <div class="panel panel-default" id="map" style="height: 80vh">
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
      var zonas=[];

      function initMap() {
        var sydney = new google.maps.LatLng(-32.962671, -61.058544);        
        infowindow = new google.maps.InfoWindow();
        var zona = new google.maps.KmlLayer({
            url: 'https://bpas.herokuapp.com/zona_sur.kml'
          });   
        var rosario = new google.maps.KmlLayer({
            url: 'https://bpas.herokuapp.com/rosario.kml'
          }); 
        rosario.setMap(null)
        zonas.push(rosario);         
        var san_lorenzo = new google.maps.KmlLayer({
            url: 'https://bpas.herokuapp.com/san_lorenzo.kml'
          });  
        san_lorenzo.setMap(null);
        zonas.push(san_lorenzo);
        var general_lopez = new google.maps.KmlLayer({
            url: 'https://bpas.herokuapp.com/general_lopez.kml'
          }); 
        general_lopez.setMap(null)
        zonas.push(general_lopez);
        var belgrano = new google.maps.KmlLayer({
            url: 'https://bpas.herokuapp.com/belgrano.kml'
          }); 
        belgrano.setMap(null)
        zonas.push(belgrano);
        var iriondo = new google.maps.KmlLayer({
            url: 'https://bpas.herokuapp.com/iriondo.kml'
          }); 
        iriondo.setMap(null)
        zonas.push(iriondo);
        var caseros = new google.maps.KmlLayer({
            url: 'https://bpas.herokuapp.com/caseros.kml'
          }); 
        caseros.setMap(null)
        zonas.push(caseros);
        var constitucion = new google.maps.KmlLayer({
            url: 'https://bpas.herokuapp.com/constitucion.kml'
          }); 
        constitucion.setMap(null)
        zonas.push(constitucion);    

        var markers = [];   
        map = new google.maps.Map(
            document.getElementById('map'), {              
              zoom: 8,                             
              streetViewControl: false,
              rotateControl: false,
              mapTypeControl: true,         
              fullscreenControl:false              
            }
        );            
        zona.setMap(map);
        setTimeout(function() {
          map.setZoom(8);
          map.set;
          },
        300); 
        ros=document.getElementById("Rosario")
        ros.addEventListener("click", function() {myFunction(rosario, ros.id.toLowerCase())}); 
        console.log('ros', ros.id.toLowerCase());

        bel=document.getElementById("Belgrano")
        bel.addEventListener("click", function() {myFunction(belgrano, bel.id.toLowerCase())}); 
        console.log('bel', bel.id.toLowerCase());

        san=document.getElementById("San Lorenzo")
        san.addEventListener("click", function() {myFunction(san_lorenzo, san.id.toLowerCase())}); 
        console.log('san', san.id.toLowerCase());

        cas=document.getElementById("Caseros")
        cas.addEventListener("click", function() {myFunction(caseros, cas.id.toLowerCase())}); 
        console.log('cas', cas.id.toLowerCase());

        gen=document.getElementById("General Lopez")
        gen.addEventListener("click", function() {myFunction(general_lopez, gen.id.toLowerCase())}); 
        console.log('gen', gen.id.toLowerCase());

        ir=document.getElementById("Iriondo")
        ir.addEventListener("click", function() {myFunction(iriondo, ir.id.toLowerCase())}); 
        console.log('ir', ir.id.toLowerCase());

        con=document.getElementById("Constitucion")
        con.addEventListener("click", function() {myFunction(constitucion, con.id.toLowerCase())}); 
        console.log('con', con.id.toLowerCase());
        
          

        function myFunction(depto, string) {
          
            if(depto.getMap()!==null){
              console.log('zona not null'); 
              clearMarkers();            
              clearDepartamentos();
              zona.setMap(map);
              setTimeout(function() {
          map.setZoom(8);
          map.set;
          },
        300); 
            }
            else{  
              clearMarkers();            
              clearDepartamentos();
              zona.setMap(null);                      
              mark(string,'presentacion');
              mark(string,'entrevista');    
              mark(string,'informe');
              depto.setMap(map);
                           
           
            
           
          }
        }

        

        function mark(departamento, filtro){
            url='https://bpas.herokuapp.com/api/localidades'
            $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',                    
                    data: {departamento:departamento,filtro:filtro}
                  })
                  .done(function(data) {
                    data.forEach( function(valor, indice, array) {                     
                      var request = {
                        query: valor.nombreLocalidad+', santa fe, argentina',
                        fields: ['name', 'geometry'],
                      };
                      service = new google.maps.places.PlacesService(map);
                      service.findPlaceFromQuery(request, function(results, status) {
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                          for (var i = 0; i < results.length; i++) {
                            createMarker(results[i],filtro);
                            console.log(results[i].name, results[i].geometry.location)
                          }
                          
                        }
                      });
                    });                           
                    
                  })
            
        }

        function createMarker(place, filtro) {
        if(filtro=='presentacion'){
            var marker = new google.maps.Marker({
              map: map,
              position: place.geometry.location,
              icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/green-dot.png"
              }          
            });
        }
        if(filtro=='entrevista'){
            var marker = new google.maps.Marker({
              map: map,
              position: place.geometry.location,
              icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/orange-dot.png"
              }          
            });
        }
        if(filtro=='informe'){
            var marker = new google.maps.Marker({
              map: map,
              position: place.geometry.location,
              icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
              }          
            });
        }
        
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(place.name+' - '+filtro);
          infowindow.open(map, this);
        });
        markers.push(marker);
      }
       // Sets the map on all markers in the array.
       function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }
      // Sets the map on all markers in the array.
      function setMapOnAllDeptos(map) {
        for (var i = 0; i < zonas.length; i++) {
          zonas[i].setMap(map);
        }
      }
      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Removes the deptos from the map, but keeps them in the array.
      function clearDepartamentos() {
        setMapOnAllDeptos(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

        
        
      }
      
      
      

      
    </script>
@endpush
@push ('script')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5yelEdpNJh8mu-yZYfeBXWpVlVPckLEs&libraries=places&callback=initMap" sync defer></script>
    

@endpush
  


@endsection
