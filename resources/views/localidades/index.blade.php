@extends ('layouts.admin')


@section ('titulo') 
<div class="row">
  <div class="col-lg-9 col-md-8 col-sm-6 col-xs-6" id="nombre">        
  Localidades
  </div>
  <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
    @include('localidades.search')      
  </div>
  
  </div>

@endsection

@section ('contenido')   
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
      <table class="table table-condensed table-hover" id="table" style="margin-bottom:0px">
        <thead style="background-color:#A9D0F5">
          <th>id</th>        
          <th>Localidad</th>
          <th>Departamento</th>
          <th>Implementador</th>
          <th style="text-align: center;">Presentacion</th>
          <th>Entrevista</th>
          <th>Informe</th>
          <th>Ord</th>
          <th>Veedor</th>
          <th>Problema</th>
          <th>S/Apl</th>
          <th>Apl/Cont</th>
          <th>Detalle</th>
        </thead>
        @php $nx=0;@endphp                
        @foreach ($localidades as $localidad)
        @php $nx++;@endphp
        
        <tr>
          <td>{{$localidad->id}}</td>
          <td>{{$localidad->nombreLocalidad}}</td>          
          <td>{{$localidad->nombreDepartamento}}</td>
          <td>{{$localidad->nombreImplementador}}</td>
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
          @if($localidad->ordenanza==1)
          <span style=" color: Green;">
          <i class="fa fa-check" aria-hidden="true"></i>
          <input type="hidden" val="1">
          </span>
          @elseif(is_null($localidad->ordenanza))
         
          @else
          <span style=" color: Tomato;">
          <i class="fa fa-times" aria-hidden="true"></i>
          <input type="hidden" val="0">
          </span>

          @endif</td>    
          <td style="text-align: center;">
          @if($localidad->veedor==1)
          <span style=" color: Green;">
          <i class="fa fa-check" aria-hidden="true"></i>
          <input type="hidden" val="1">
          </span>
          @elseif(is_null($localidad->veedor))
         
          @else
          <span style=" color: Tomato;">
          <i class="fa fa-times" aria-hidden="true"></i>
          <input type="hidden" val="0">
          </span>

          @endif</td> 
          <td style="text-align: center;">
          @if($localidad->problema==1)
          <span style=" color: Tomato;">
          <i class="fa fa-check" aria-hidden="true"></i>
          <input type="hidden" val="1">
          </span>
          @elseif(is_null($localidad->problema))
         
          @else
          <span style=" color: Green;">
          <i class="fa fa-times" aria-hidden="true"></i>
          <input type="hidden" val="0">
          </span>

          @endif</td>     
          <td style="text-align: center;">
          @if(is_null($localidad->sin_aplicacion))
          @else
          {{$localidad->sin_aplicacion}} metros
          @endif
          </td>  
          <td style="text-align: center;">
          @if(is_null($localidad->aplicacion_controlada))
          @else
          {{$localidad->aplicacion_controlada}} metros
          @endif
          </td>         
          <td style="text-align: center;">            
           <a href="localidades/{{$localidad->id}}"> <button class="btn btn-link pull-right" data-toggle="modal" data-target="#eModal{{$nx}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-info-circle" aria-hidden="true"></i> </button>   </a>        
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
                "targets": [ 12 ],
                "orderable": false,
            }    
        ]
    } );
} );



</script> 
@endpush  

@endsection
