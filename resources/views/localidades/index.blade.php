@extends ('layouts.admin')
@section ('titulo') 
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">        
  Listado Localidades      
  </div>
  <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
    @include('localidades.search')      
  </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 " style="margin-top:5px">
    <a href="pedidos/create"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
  </div>
  </div>

@endsection
@section ('contenido')   
<div class="row">
  <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
      <table class="table table-striped table-condensed table-hover" id="table">
        <thead style="background-color:#A9D0F5">         
          <th>Nº</th>
          <th>Nombre</th>
          <th>Departamento</th>
          <th>Municipio</th>
          <th>Presentacion</th>
          <th>Entrevista</th>          
          <th>Informe</th>                    
          <th>Opciones</th>
        </thead>
        @php $n=0;@endphp
        @foreach ($localidades as $visita)
        @php $n++;@endphp        
        <tr>
          <td>{{$visita->id}}
          <td>{{$visita->nombreLocalidad}}</td>
          <td>{{$visita->nombreDepartamento}}</td>
          <td>
              @if($visita->municipio==0)    
              <input type="checkbox" disabled class="checkbox disabled ">
              @else
              <input type="checkbox" checked disabled class="checkbox disabled">
              @endif   
         </td>
          <td>
          @if($visita->presentacion==0)    
              <input type="checkbox" disabled class="checkbox disabled ">
              @else
              <input type="checkbox" checked disabled class="checkbox disabled">
              @endif 
          </td>
          <td>
          @if($visita->entrevista==0)    
              <input type="checkbox" disabled class="checkbox disabled ">
              @else
              <input type="checkbox" checked disabled class="checkbox disabled">
              @endif 
          </td>
          <td>
          @if($visita->informe==0)    
              <input type="checkbox" disabled class="checkbox disabled ">
              @else
              <input type="checkbox" checked disabled class="checkbox disabled">
              @endif 
          </td>
                  
          <td>          
            <a href="" data-target="#modal-edit-{{$visita->id}}" data-toggle="modal"><button class="btn btn-info btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>             
            <a href="" data-target="#modal-delete-{{$visita->id}}" data-toggle="modal"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>
          </td>
        </tr>  
        @include('localidades.modal.delete')    
        @include('localidades.modal.edit')     
        @endforeach
        
      </table>
    </div>
    {{$localidades->appends(Request::only(['searchText']))->render()}}
  </div>
</div>
@push ('script')


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
