@extends ('layouts.admin')


@section ('titulo') 
<div class="row">
  <div class="col-lg-9 col-md-8 col-sm-6 col-xs-6" id="nombre">        
  Localidades
  </div>
  <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
    @include('setting.localidades.search')      
  </div>
  
  </div>

@endsection

@section ('contenido')   
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
      <table class="table table-condensed table-hover" id="table" style="margin-bottom:0px">
        <thead style="background-color:#A9D0F5">
          <th>nº</th> 
          <th>id</th>       
          <th>Localidad</th>
          <th>Departamento</th>
          <th>Longitud</th>
          <th>Latitud</th>         
          <th>Detalle</th>
        </thead>
        @php $nx=0;@endphp                
        @foreach ($localidades as $localidad)
        @php $nx++;@endphp
        
        <tr>
          <td>{{$nx}}</td>
          <td>{{$localidad->id}}</td>
          <td>{{$localidad->nombreLocalidad}}</td>  
          <td>{{$localidad->nombreDepartamento}}</td>          
          <td>{{$localidad->lng}}</td>
          <td>{{$localidad->lat}}</td>          
          </td>         
          <td style="text-align: center;">            
           <a href="localidades/{{$localidad->id}}/edit"> <button class="btn btn-link pull-right" data-toggle="modal" data-target="#eModal{{$nx}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-info-circle" aria-hidden="true"></i> </button>   </a>        
          </td>
        </tr>
        
        @endforeach
        
      </table>
    </div>
  </div>
</div>
  
@push ('script')

 <script>

$(document).ready(function() {
  $('#table').DataTable( {
    "paging":   false,
     "info":   false,
    "searching": false,
    "order": [[ 0, "asc" ]],
    "columnDefs": [ 
            
            {
                "targets": [ 6 ],
                "orderable": false,
            }    
        ]
    } );
} );



</script> 
@endpush  

@endsection
