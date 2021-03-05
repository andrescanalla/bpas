@extends ('layouts.admin')
@push ('script')
<script src="{{asset('js/Chart.bundle.min.js')}}"></script>
<script src="https://unpkg.com/@googlemaps/markerclustererplus/dist/index.min.js"></script>
@endpush

@section ('titulo')
<div class="row">
  <div class="col-lg-9 col-md-8 col-sm-6 col-xs-6" name="nombre" id="{{$departamento->nombre}}">
    Departamento {{$departamento->nombre}}
  </div>
  <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">

  </div>

</div>

@endsection

@section ('contenido')
<div class="row">
  <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
      <div class="col-lg-12 col-md-3 col-sm-5 col-xs-5">
        <div class="panel panel-default">
          <div class="panel-heading">Implementador: <b>{{$numeros->nombreImplementador}}</b> <span class="badge pull-right" style="padding-top:4px">{{$numeros->cantidad_localidades}} Localidades</span></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="padding-right:0">
                <label>Oct-18 / Nov-19<label>
              </div>
              <div class="col-lg-9 col-md-3 col-sm-5 col-xs-5">
                <div class="progress" style="margin-bottom:0">
                  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{$timebar}}" aria-valuemin="0" aria-valuemax="14" style="width: {{round($timebar/14*100),0}}%">
                    <span>{{$timebar}} meses ({{round($timebar/14*100),0}}%)</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5">
                <label>Presentaciones </label>
              </div>
              <div class="col-lg-8 col-md-3 col-sm-5 col-xs-5">
                <div class="progress" style="margin-bottom:0">
                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$numeros->pre}}" aria-valuemin="0" aria-valuemax="{{$numeros->cantidad_localidades}}" style="width: {{$numeros->pre/$numeros->cantidad_localidades*100}}%">
                    {{$numeros->pre}} Presentaciones
                  </div>
                </div>
              </div>
              <div class="col-lg-1 col-md-3 col-sm-5 col-xs-5">
                <span class="badge pull-right" style="padding-top:4px;background-color: #00a65a;"> {{round($numeros->pre/$numeros->cantidad_localidades*100)}}% <i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5">
                <label>Entrevistas </label>
              </div>
              <div class="col-lg-8 col-md-3 col-sm-5 col-xs-5">
                <div class="progress" style="margin-bottom:0">
                  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{$numeros->entre}}" aria-valuemin="0" aria-valuemax="{{$numeros->cantidad_localidades}}" style="width: {{$numeros->entre/$numeros->cantidad_localidades*100}}%">
                    {{$numeros->entre}} Entrevistas
                  </div>
                </div>
              </div>
              <div class="col-lg-1 col-md-3 col-sm-5 col-xs-5">
                <span class="badge pull-right" style="padding-top:4px;background-color: #f39c12;"> {{round($numeros->entre/$numeros->cantidad_localidades*100)}}% <i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5">
                <label>Informes</label>
              </div>
              <div class="col-lg-8 col-md-3 col-sm-5 col-xs-5">
                <div class="progress" style="margin-bottom:0">
                  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{$numeros->info}}" aria-valuemin="0" aria-valuemax="{{$numeros->cantidad_localidades}}" style="width: {{$numeros->info/$numeros->cantidad_localidades*100}}%">
                    {{$numeros->info}} Informes
                  </div>
                </div>
              </div>
              <div class="col-lg-1 col-md-3 col-sm-5 col-xs-5">
                <span class="badge pull-right" style="padding-top:4px;background-color: #00c0ef;"> {{round($numeros->info/$numeros->cantidad_localidades*100)}}% <i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="panel with-nav-tabs panel-default" style="padding:0; margin-bottom:0">
      <div class="panel-heading" style="min-height:42px">
        <div class="pull-left">
          <ul class="nav nav-tabs">

            <li class="active"><a href="#tab2default" data-toggle="tab">Visitas</a></li>
            <li><a href="#tab1default" data-toggle="tab">Localidades</a></li>
            <li><a href="#tab3default" data-toggle="tab">Contactos</a></li>
          </ul>
        </div>
      </div>

      <div class="panel-body" style="padding-top:0;">
        <div class="tab-content">
          <div class="tab-pane fade " id="tab1default">
            <div class="table-responsive">
              <table class="table table-condensed table-hover" id="table1" style="margin-bottom:0px">
                <thead>
                  <th>Nº</th>
                  <th>Localidad</th>
                  <th style="text-align: center;">Presentacion</th>
                  <th style="text-align: center;">Entrevista</th>
                  <th style="text-align: center;">Informe</th>
                  <th style="text-align: center;">+ Info</th>
                </thead>
                @php $nx=0;@endphp
                @foreach ($localidades as $localidad)
                @php $nx++;@endphp

                <tr>
                  <td>{{$nx}}</td>
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
                    @endif
                  </td>
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
                    @endif
                  </td>

                  <td style="text-align: center;">
                    <a href="/localidades/{{$localidad->id}}"> <button class="btn btn-link pull-right" data-toggle="modal" data-target="#eModal{{$nx}}" style="padding-top:0;padding-right:30%;padding-bottom:0"><i class="fa fa-info-circle" aria-hidden="true"></i> </button> </a>
                  </td>
                </tr>

                @endforeach

              </table>
            </div>
          </div>

          <div class="tab-pane fade in active" id="tab2default">
            <div class="table-responsive">
              <table class="table table-condensed table-hover" id="table2">
                <thead>
                  <th>Fecha</th>
                  <th>Localidad</th>
                  <th>Visita</th>
                  <th>Comentarios</th>
                  <th>Opciones</th>
                </thead>
                @php $n=0;@endphp
                @foreach ($visitas as $visita)
                @php $n++;@endphp
                @if ($visita->idTipoVisita=="1")
                <tr class="success">
                  @elseif ($visita->idTipoVisita=="2"||$visita->idTipoVisita=="3")
                <tr class="warning">
                  @elseif ($visita->idTipoVisita=="4")
                <tr class="info">
                  @else
                <tr>
                  @endif
                  <td>{{$visita->fecha->format('d/m/y')}}</td>
                  <td>{{$visita->nombreLocalidad}}</td>
                  <td>{{$visita->nombreTipoVisita}}</td>
                  @if($visita->fecha > $today)
                  <td> <span class="label label-info">Visita programada</span> {{$visita->comentarios}}</td>
                  @else
                  <td>{{$visita->comentarios}}</td>
                  @endif
                  <td style="min-width: 113px;">
                    <button class="btn btn-link pull-right" data-toggle="modal" data-target="#modal-delete-{{$visita->id}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-trash" aria-hidden="true"></i>
                      <button class="btn btn-link pull-right" data-toggle="modal" data-target="#modal-edit-{{$visita->id}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-pencil" aria-hidden="true"></i>
                        <a href="/localidades/{{$visita->localidad_id}}"> <button class="btn btn-link pull-right" data-toggle="modal" data-target="#eModal{{$nx}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-info-circle" aria-hidden="true"></i></button></a>
                  </td>
                </tr>
                @include('departamentos.modal.delete')
                @include('departamentos.modal.edit')
                @endforeach

              </table>
            </div>
          </div>

          <div class="tab-pane fade " id="tab3default">
            <div class="table-responsive">
              <table class="table table-condensed table-hover" id="table" style="margin-bottom:0px">
                <thead>
                  <th>Nombre</th>
                  <th>Cargo</th>
                  <th>Celular</th>
                  <th>Email</th>
                  <th>Comentarios</th>
                  <th style="min-width: 91px;">
                    <div class="btn-group pull-right">
                      <button class="btn btn-link pull-right" data-toggle="modal" data-target="#btnModal" style="padding-top:0;padding-bottom:0"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                  </th>
                </thead>
                @php $nx=0;@endphp

                @php $nx++;@endphp

                <tr>
                  <td>Jose Veedorelli</td>
                  <td>Veedor</td>
                  <td>+54 9 341 6056865</td>
                  <td>joseveedor@gmail.com</td>
                  <td>Es el unico Veedor de la comuna</td>
                  <td>
                    <button class="btn btn-link pull-right" data-toggle="modal" data-target="#modal-delete-{{$visita->id}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-trash" aria-hidden="true"></i>
                      <button class="btn btn-link pull-right" data-toggle="modal" data-target="#modal-edit-{{$visita->id}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-pencil" aria-hidden="true"></i>
                  </td>
                </tr>



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

      <div class="panel panel-default" style="margin-bottom: 0;">
        <div class="panel-heading">Visitas por Mes<i class="fa fa-bar-chart pull-right" style="padding-top:4px"></i></div>
        <div class="panel-body">
          {!! $chartjs->render() !!}
        </div>
      </div>

    </div>
  </div>
</div>


@push ('scripts')
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-uk.js"></script>
<script>
  $(document).ready(function() {
    $('#table2').DataTable({
      "paging": false,
      "info": false,
      "searching": false,
      "columnDefs": [{
          "targets": [4],
          "orderable": false,
        },
        {
          type: 'date-uk',
          targets: 0
        }
      ],
      "order": [
        [0, "desc"]
      ]
    });
    var t = $('#table1').DataTable({
      "paging": false,
      "info": false,
      "searching": false,
      "columnDefs": [{
        "targets": [5, 0],
        "orderable": false,
      }],
      "order": [
        [2, "asc"],
        [3, "asc"],
        [4, "asc"]
      ]
    });
    t.on('order.dt search.dt', function() {
      t.column(0, {
        search: 'applied',
        order: 'applied'
      }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();
  });




  // This example requires the Places library. Include the libraries=places
  // parameter when you first load the API. For example:
  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

  var map;
  var service;
  var infowindow;
  var zonas = [];

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
        fullscreenControl: false
      }
    );


    departamento = document.getElementsByName("nombre");
    departamento = departamento[0];
    console.log(departamento);
    if (departamento.id == "Belgrano") {
      myFunction(belgrano, departamento.id.toLowerCase());
    }
    if (departamento.id == "Caseros") {
      myFunction(caseros, departamento.id.toLowerCase());
    }
    if (departamento.id == "San Lorenzo") {
      myFunction(san_lorenzo, departamento.id.toLowerCase());
    }
    if (departamento.id == "General Lopez") {
      myFunction(general_lopez, departamento.id.toLowerCase());
    }
    if (departamento.id == "Rosario") {
      myFunction(rosario, departamento.id.toLowerCase());
    }
    if (departamento.id == "Iriondo") {
      myFunction(iriondo, departamento.id.toLowerCase());
    }
    if (departamento.id == "Constitución") {
      myFunction(constitucion, departamento.id.toLowerCase());
    }

    setTimeout(function() {
        map.setZoom(9);
        map.set;
        // Add a marker clusterer to manage the markers.
        new MarkerClusterer(map, markers, {
          imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
        });
      },
      600);


    function myFunction(depto, string) {
      clearMarkers();
      clearDepartamentos();
      mark(string, 'presentacion');
      mark(string, 'entrevista');
      mark(string, 'informe');
      mark(string, 'restante');
      depto.setMap(map);
    }



    function mark(departamento, filtro) {
      url = 'https://bpas.herokuapp.com/api/localidades'
      $.ajax({
          url: url,
          type: 'GET',
          dataType: 'json',
          data: {
            departamento: departamento,
            filtro: filtro
          }
        })
        .done(function(data) {
          console.log('data:', data.length, filtro);
          data.forEach(function(valor, indice, array) {
            var res = {
              name: valor.nombreLocalidad,
              coord: {
                lat: parseFloat(valor.lat),
                lng: parseFloat(valor.lng)
              }
            };

            createMarker(res, filtro);
            console.log(res.coord, filtro)

          });

        })

    }

    function createMarker(place, filtro) {
      if (filtro == 'presentacion') {
        var marker = new google.maps.Marker({
          position: place.coord,
          icon: {
            url: "https://mt.google.com/vt/icon/name=icons/onion/SHARED-mymaps-container_4x.png,icons/onion/1502-shape_star_4x.png&highlight=00a65a,ff000000&scale=1.0"
          }
        });
      }
      if (filtro == 'entrevista') {
        var marker = new google.maps.Marker({
          position: place.coord,
          icon: {
            url: "https://mt.google.com/vt/icon/name=icons/onion/SHARED-mymaps-container_4x.png,icons/onion/1502-shape_star_4x.png&highlight=F9A825,ff000000&scale=1.0"
          }
        });
      }
      if (filtro == 'informe') {
        var marker = new google.maps.Marker({
          position: place.coord,
          icon: {
            url: "https://mt.google.com/vt/icon/name=icons/onion/SHARED-mymaps-container_4x.png,icons/onion/1502-shape_star_4x.png&highlight=00c0ef,ff000000&scale=1.0"
          }
        });
      }
      if (filtro == 'restante') {
        var marker = new google.maps.Marker({
          position: place.coord,
          icon: {
            url: "https://mt.google.com/vt/icon/name=icons/onion/SHARED-mymaps-container-bg_4x.png,icons/onion/SHARED-mymaps-container_4x.png,icons/onion/1590-hardware-wrench_4x.png&highlight=ff000000,BDBDBD,ff000000&scale=1.0"
          }
        });
      }

      google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(place.name + ' - ' + filtro.charAt(0).toUpperCase() + filtro.slice(1));
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap" sync defer></script>

@endpush



@endsection