@extends ('layouts.admin')


@section ('titulo') 
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6" id="nombre">        
  {{$localidad->nombreLocalidad}}    
  </div>
  <div class="col-lg-4 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
    @include('localidades.searchShow')      
  </div>
  
  </div>

@endsection

@section ('contenido') 
<!-- Start modal Edit localidad --> 
@include('localidades.modal.edit') 
<!-- End modal Edit localidad-->

<!-- Start modal Create comentarios-->
@include('comentarios.modal.create') 
<!-- End modal create comentarios-->
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
                      <label>Fecha Info:</label>
                      @if(is_null($localidad->fecha_info))
                        {{$localidad->fecha_info}}
                      @else
                        {{$localidad->fecha_info->format('d/m/y')}}
                      @endif
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <div class="form-check form-check-inline">                    
                        @if($localidad->ordenanza==1)
                        <span style=" color: Green;">
                        <i class="fa fa-check" aria-hidden="true"></i>                        
                        </span>
                        @elseif(is_null($localidad->ordenanza))
                      
                        @else
                        <span style=" color: Tomato;">
                        <i class="fa fa-times" aria-hidden="true"></i>                        
                        </span>
                        @endif
                      <label class="form-check-label" >Ordenanza </label>
                      </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <label>Sin Aplicacion:</label>
                      @if(is_null($localidad->sin_aplicacion))
                      S/D  
                      @else                     
                      {{$localidad->sin_aplicacion}} metros
                      @endif                   
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <div class="form-check form-check-inline">                    
                      @if($localidad->problema==1)
                      <span style=" color: Tomato;">
                      <i class="fa fa-check" aria-hidden="true"></i>                      
                      </span>                    
                      @elseif(is_null($localidad->problema))
                      
                      @else
                      <span style=" color: Green;">
                      <i class="fa fa-times" aria-hidden="true"></i>                     
                      </span>
                      @endif
                      <label class="form-check-label" >Problema </label>
                      </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <label>Aplicacion Controlada:</label>
                          @if(is_null($localidad->aplicacion_controlada))
                          S/D
                          @else                         
                          {{$localidad->aplicacion_controlada}} metros  
                          @endif
                         
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                      <div class="form-check form-check-inline">                    
                          @if($localidad->veedor==1)
                          <span style=" color: Green;">
                          <i class="fa fa-check" aria-hidden="true"></i>
                          </span>
                          @elseif(is_null($localidad->veedor))
                        
                          @else
                          <span style=" color: Tomato;">
                          <i class="fa fa-times" aria-hidden="true"></i>
                          </span>
                          @endif
                        <label class="form-check-label" >Veedor </label>
                      </div>
                    </div>             
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                              <table class="table table-condensed table-hover" style="margin-bottom:0px; ">
                                <thead>
                                  <th>Fecha</th>                          
                                  <th>Comentarios</th>
                                  <th> <button class="btn btn-link pull-right" data-toggle="modal" data-target="#modal-create" style="padding-top:0;padding-bottom:0"><i class="fa fa-plus" aria-hidden="true"></i></button></th>
                                </thead>
                                @php $ne=0;@endphp                
                                @foreach ($comentarios as $comentario)
                                @php $ne++;@endphp                     
                               
                                  <tr>
                                  <td >{{$comentario->fecha_comentario->format('d/m/y')}}</td>                                  
                                  <td> {{$comentario->comentarios}} </td>                                                  
                                  <td style="min-width: 85px;">
                                    <button class="btn btn-link pull-right" data-toggle="modal" data-target="#modal-delete{{$ne}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-trash" aria-hidden="true"></i>
                                    <button class="btn btn-link pull-right" data-toggle="modal" data-target="#modal-edit{{$ne}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-pencil" aria-hidden="true"></i>
                                    
                                  </td>
                                </tr>
                                <!-- Start modal Edit comentarios-->
                                @include('comentarios.modal.edit') 
                                <!-- End modal Edit comentarios-->
                                <!-- Start modal delete comentarios-->
                                @include('comentarios.modal.delete') 
                                <!-- End modal delete comentarios-->
                                @endforeach
                                
                              </table>
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
                    <div class="panel-heading">
                    Informacion Visitas
                    <div class="btn-group pull-right">
                                        <button class="btn btn-link pull-right" data-toggle="modal" data-target="#btnModal" style="padding-top:0;padding-bottom:0"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                    </div>
                    <div class="panel-body">
                      <div class="row" style="margin-bottom:10px">
                          <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Presentacion Progrma</label>
                            @if($localidad->presentacion==1)
                            <span style=" color: Green;">
                            <i class="fa fa-check" aria-hidden="true"></i>                            
                            </span>
                            @else
                            <span style=" color: Tomato;">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            </span>
                            @endif
                                                       
                          </div>
                          <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Entrevista</label>
                            @if($localidad->entrevista==1)
                            <span style=" color: Green;">
                            <i class="fa fa-check" aria-hidden="true"></i>                           
                            </span>
                            @else
                            <span style=" color: Tomato;">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            </span>
                            @endif
                                                        
                          </div>
                          <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Informe</label> 
                            @if($localidad->informe==1)
                            <span style=" color: Green;">
                            <i class="fa fa-check" aria-hidden="true"></i>                            
                            </span>
                            @else
                            <span style=" color: Tomato;">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            </span>
                            @endif</td> 
                                                        
                          </div>
                          <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label>Cantidad de Visitas: </label>
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
                                  <th></th>
                                </thead>
                                @php $nx=0;@endphp                
                                @foreach ($visitas as $to)
                                @php $nx++;@endphp
                                
                                @if ($to->idTipoVisita=="1")                 
                                  @if($to->fecha < $today) 
                                  <tr class="success text-muted">
                                  @else
                                  <tr class="success">
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
                                  <td class="container-fluid">{{$to->fecha->format('d/m/y')}}</td>
                                  
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
