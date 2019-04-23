@extends ('layouts.admin')


@section ('titulo') 
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6" id="nombre">        
  {{$localidades->nombreLocalidad}}    
  </div>
  <div class="col-lg-4 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
    @include('localidades.search')      
  </div>
  
  </div>

@endsection

@section ('contenido')   
<div class="row">
  <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Informacion Localidad</div>
                <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <label>Departamento:</label>
                      {{$localidades->nombreDepartamento}}
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Implementador:</label>
                      {{$localidades->nombreImplementador}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <label>Fecha Info:</label>
                      {{$info->fecha}}
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-check form-check-inline">                    
                    @if($info->ordenanza==0)
                    <input type="checkbox" class="form-check-input" disabled>
                   
                    @elseif($info->ordenanza==1)
                    <input type="checkbox" class="control-form" checked disabled>
                    @else
                      {{$info->ordenanza}}
                    @endif
                    <label class="form-check-label" >Ordenanza </label>
                    </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-check form-check-inline">                    
                    @if($info->veedor==0)
                    <input type="checkbox" class="form-check-input" disabled>
                   
                    @elseif($info->veedor==1)
                    <input type="checkbox" class="control-form" checked disabled>
                    @else
                      {{$info->veedor}}
                    @endif
                    <label class="form-check-label" >Veedor </label>
                    </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-check form-check-inline">                    
                    @if($info->problema==0)
                    <input type="checkbox" class="form-check-input" disabled>
                   
                    @elseif($info->problema==1)
                    <input type="checkbox" class="control-form" checked disabled>
                    @else
                      {{$info->problema}}
                    @endif
                    <label class="form-check-label" >Problema </label>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Metros Sin Aplicacion:</label>
                      {{$info->sin_aplicacion}} metros
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Metros Con Aplicacion Controlada:</label>
                      {{$info->aplicacion_controlada}} metros
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                    <label>Comentarios:</label>
                    <textarea class="form-control" disabled>{{$info->comentarios}} </textarea>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="panel panel-default">
                    <div class="panel-heading">Informacion Visitas</div>
                    <div class="panel-body">
                      <div class="row">
                          <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Presentacion Progrma</label>
                            {{$localidades->presentacion}}
                          </div>
                          <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Entrevista</label>
                            {{$localidades->entrevista}}
                          </div>
                          <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                          <label>Informe</label>
                            {{$localidades->informe}}
                          </div>
                          <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Cantidad de Visitas</label>
                            {{count($visitas)}}
                          </div>
                      </div>                
                      <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
                          <div class="table-responsive">
                              <table class="table table-condensed table-hover" id="ex" style="margin-bottom:0px">
                                <thead>
                                  <th>Fecha</th>
                                
                                  <th>Tipo de visita</th>
                                  <th>detalle</th>
                                  <th>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-link pull-right" data-toggle="modal" data-target="#btnModal" style="padding-top:0;padding-bottom:0"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                  </th>
                                </thead>
                                @php $nx=0;@endphp                
                                @foreach ($visitas as $to)
                                @php $nx++;@endphp
                                
                                @if ($to->idTipoVisita=="1")                 
                                  @if($to->fecha < $today) 
                                  <tr class="danger text-muted">
                                  @else
                                  <tr class="danger">
                                  @endif 
                                  
                                @elseif ($to->idTipoVisita=="2"||$to->idTipoVisita=="3") 
                                  @if($to->fecha < $today)
                                    <tr class="warning text-muted">
                                  @else
                                  <tr class="warning">
                                  @endif
                                @elseif ($to->idTipoVisita=="4") 
                                  @if($to->fecha < $today)
                                    <tr class="info text-muted">
                                  @else
                                  <tr class="info">
                                  @endif
                                              
                                @else
                                  @if($to->fecha < $today)
                                    <tr class="text-muted">
                                  @else
                                  <tr>
                                  @endif
                                  
                                @endif            
                                  <td class="container-fluid">{{$to->fecha}}</td>
                                  
                                  <td> {{$to->nombreTipoVisita}} </td> 
                                  <td> {{$to->comentarios}} </td>                  
                                  <td>
                                    <button class="btn btn-link pull-right" data-toggle="modal" data-target="#eModal{{$nx}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-trash" aria-hidden="true"></i>
                                    <button class="btn btn-link pull-right" data-toggle="modal" data-target="#eModal{{$nx}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-pencil" aria-hidden="true"></i>
                                    
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
    </div> 
  </div>
  
  <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
      
      <div id="map" style="height: 80vh">
      </div>
  </div>
</div>
@push ('script')
<script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var map;
      var service;
      var infowindow;

      function initMap() {
        var sydney = new google.maps.LatLng(-32.947, -60.675);
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
@push ('scripts')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAogC7YQOSHhhUyPif_s64K8HMH9zxZYpU&libraries=places&callback=initMap" async defer></script>
    
<!-- <script>

$(document).ready(function() {
  $('#table').DataTable( {
    "paging":   false,
     "info":   false,
    "searching": false,
    "order": [[ 0, "asc" ]],
    "columnDefs": [ 
            
            {
                "targets": [ 7 ],
                "orderable": false,
            }    
        ]
    } );
} );



</script> -->
@endpush

@endsection
