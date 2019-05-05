@extends ('layouts.admin')
@section ('titulo') 
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">        
  Visitas      
  </div>
  <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
    @include('visitas.search')      
  </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 " style="margin-top:5px">
    <a href="pedidos/create"><button class="btn btn-default btn-sm pull-right"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
  </div>
  </div>

@endsection
@section ('contenido')   
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div >
      <table class="table table-borderless" id="table">
        <thead  style="background-color:#f5f5f5">         
          <th>Nº</th>
          <th>Fecha</th>
          <th>Localidad</th>
          <th>Tipo de Visita</th>          
          <th>Departamento</th>
          <th>Implementador</th>                    
          <th>Comentarios</th>                    
          <th>Opciones</th>
        </thead>
        @php $n=0;@endphp
        @foreach ($visitas as $visita)
        @php $n++;@endphp        
        <tr>
          <td>{{$visita->id}}
          <td>{{$visita->fecha->format('d/m/Y')}}</td>
          <td>{{$visita->nombreLocalidad}}</td>
          <td>{{$visita->nombreTipoVisita}}</td>          
          <td>{{$visita->nombreDepartamento}}</td>
          <td>{{$visita->nombreImplementador}}</td>          
          <td>{{$visita->comentarios}}</td>         
          <td style="min-width: 85px;">          
            <a href="" data-target="#modal-edit-{{$visita->id}}" data-toggle="modal"><button class="btn btn-info btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>             
            <a href="" data-target="#modal-delete-{{$visita->id}}" data-toggle="modal"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>
          </td>
        </tr>  
        @include('visitas.modal.delete')    
        @include('visitas.modal.edit')     
        @endforeach
        
      </table>
    </div>
    {{$visitas->appends(Request::only(['searchText']))->render()}}
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
                "targets": [ 7 ],
                "orderable": false,
            }    
        ]
    } );
} );



</script> 
@endpush  

@endsection
