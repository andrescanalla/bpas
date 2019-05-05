@extends ('layouts.admin')
@push ('script')

<script src="{{asset('js/Chart.bundle.min.js')}}"></script>

@endpush

@section ('titulo') 
<div class="row">
  <div class="col-lg-9 col-md-8 col-sm-6 col-xs-6" name="nombre" id="{{$departamento->nombre}}">        
  {{$departamento->nombre}}
  </div>
  <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
    
  </div>
  
  </div>

@endsection

@section ('contenido')   
<div class="row">
  <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
      <div class="col-lg-12 col-md-3 col-sm-5 col-xs-5" >     
        <div class="panel panel-default">
          <div class="panel-heading">Visitas por Departamento<i class="fa fa-bar-chart pull-right" style="padding-top:4px"></i></div>
          <div class="panel-body"> 
            
          </div>
        </div>
      </div>
    </div>

  <div class="panel with-nav-tabs panel-default" style="padding:0; margin-bottom:0">
    <div class="panel-heading" style="min-height:42px">
      <div class="pull-left">
        <ul class="nav nav-tabs">           
            <li class="active"><a href="#tab1default" data-toggle="tab">Localidades</a></li>
            <li><a href="#tab2default" data-toggle="tab" id="tab-pedido">Visitas</a></li>                         
        </ul>
      </div>   
    </div> 

    <div class="panel-body" style="padding-top:0; min-height:620px">
        <div class="tab-content"> 
          <div class="tab-pane fade in active" id="tab1default">  
            <div class="table-responsive">
              <table class="table table-condensed table-hover" id="table" style="margin-bottom:0px">
                <thead >                   
                  <th>Localidad</th>
                  <th>Presentacion</th>  
                  <th>Entrevista</th>         
                  <th>Informe</th>          
                  <th style="text-align: center;">Detalle</th>
                </thead>
                @php $nx=0;@endphp                
                @foreach ($localidades as $localidad)
                @php $nx++;@endphp
                
                <tr>                                
                  <td>{{$localidad->nombreLocalidad}}</td>
                  <td style="text-align: center;">
                  @if($localidad->presentacion==1)
                  <span style=" color: Green;">
                  <i class="fa fa-check" aria-hidden="true"></i>
                  <input type="hidden" val="1">
                  </span>
                  @else
                  <span style=" color: Tomato;">
                  <i class="fa fa-times" aria-hidden="true"></i>
                  </span>
                  @endif
                  </td>
                  <td style="text-align: center;">
                  @if($localidad->entrevista==1)
                  <span style=" color: Green;">
                  <i class="fa fa-check" aria-hidden="true"></i>
                  <input type="hidden" val="1">
                  </span>
                  @else
                  <span style=" color: Tomato;">
                  <i class="fa fa-times" aria-hidden="true"></i>
                  </span>
                  @endif</td> 
                  <td style="text-align: center;">
                  @if($localidad->informe==1)
                  <span style=" color: Green;">
                  <i class="fa fa-check" aria-hidden="true"></i>
                  <input type="hidden" val="1">
                  </span>
                  @else
                  <span style=" color: Tomato;">
                  <i class="fa fa-times" aria-hidden="true"></i>
                  </span>
                  @endif</td> 
                  
                  <td style="text-align: center;">            
                  <a href="/localidades/{{$localidad->id}}"> <button class="btn btn-link pull-right" data-toggle="modal" data-target="#eModal{{$nx}}" style="padding-top:0;padding-right:30%;padding-bottom:0"><i class="fa fa-info-circle fa-lg" aria-hidden="true"></i> </button>   </a>        
                  </td>
                </tr>
                
                @endforeach
                
              </table>
            </div>
         </div>
         </div>
    </div>

  </div>
  </div>
  <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
  <div class="row" style="margin-right:0">
      <div class="panel panel-default" id="map" style="height: 40vh">
      </div>
  </div>
  <div class="row" style="margin-right:0">
     
    <div class="panel panel-default">
      <div class="panel-heading">Visitas por Departamento<i class="fa fa-bar-chart pull-right" style="padding-top:4px"></i></div>
      <div class="panel-body"> 
         
      </div>
      </div>
  
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
       
        
        departamento=document.getElementsByName("nombre");
        departamento=departamento[0];
        console.log(departamento);
        if(departamento.id=="Belgrano"){
          myFunction(belgrano, departamento.id.toLowerCase());
        }
        if(departamento.id=="Caseros"){
          myFunction(caseros, departamento.id.toLowerCase());
        }
        if(departamento.id=="San Lorenzo"){
          myFunction(san_lorenzo, departamento.id.toLowerCase());
        }
        if(departamento.id=="General Lopez"){
          myFunction(general_lopez, departamento.id.toLowerCase());
        }
        if(departamento.id=="Rosario"){
          myFunction(rosario, departamento.id.toLowerCase());
        }
        if(departamento.id=="Iriondo"){
          myFunction(iriondo, departamento.id.toLowerCase());
        }
        if(departamento.id=="Constitucion"){
          myFunction(constitucion, departamento.id.toLowerCase());
        }
        
        setTimeout(function() {
          map.setZoom(8);
          map.set;
          },
        300); 
        

        function myFunction(depto, string) {      
              clearMarkers();            
              clearDepartamentos();                                    
              mark(string,'presentacion');
              setTimeout(function() { mark(string,'entrevista'), console.log('entrevista')}, 1000);    
              setTimeout(function() { mark(string,'informe'), console.log('informe')}, 1500);
              depto.setMap(map);         
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
                    console.log('data:',data.length, filtro);
                    data.forEach( function(valor, indice, array) {                     
                      var request = {
                        query: valor.nombreLocalidad+', santa fe, argentina',
                        fields: ['name', 'geometry'],
                      };
                      service = new google.maps.places.PlacesService(map);
                      service.findPlaceFromQuery(request, function(results, status) {
                        console.log('status', status);
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                          for (var i = 0; i < results.length; i++) {
                            createMarker(results[i],filtro);
                            console.log(results[i].name, filtro)
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
                url: "https://mt.google.com/vt/icon/name=icons/onion/SHARED-mymaps-container_4x.png,icons/onion/1502-shape_star_4x.png&highlight=00a65a,ff000000&scale=1.0"
              }          
            });
        }
        if(filtro=='entrevista'){
            var marker = new google.maps.Marker({
              map: map,
              position: place.geometry.location,
              icon: {
                url: "https://mt.google.com/vt/icon/name=icons/onion/SHARED-mymaps-container_4x.png,icons/onion/1502-shape_star_4x.png&highlight=F9A825,ff000000&scale=1.0"
              }          
            });
        }
        if(filtro=='informe'){
            var marker = new google.maps.Marker({
              map: map,
              position: place.geometry.location,
              icon: {
                url: "https://mt.google.com/vt/icon/name=icons/onion/SHARED-mymaps-container_4x.png,icons/onion/1502-shape_star_4x.png&highlight=00c0ef,ff000000&scale=1.0"
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
