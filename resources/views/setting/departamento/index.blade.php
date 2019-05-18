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
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
      <table class="table table-condensed table-hover" id="table" style="margin-bottom:0px">
        <thead style="background-color:#A9D0F5">
          <th>nº</th> 
          <th>id</th>        
          <th>Departamento</th>
          <th>Cant Localidades</th>
          <th>Implementador</th>         
          <th>Detalle</th>
        </thead>
        @php $nx=0;@endphp                
        @foreach ($departamentos as $departamento)
        @php $nx++;@endphp
        
        <tr>
          <td>{{$nx}}</td>
          <td>{{$departamento->id}}</td>
          <td>{{$departamento->nombre}}</td>  
          <td>{{$departamento->cantidad_localidades}}</td>          
          <td>{{$departamento->implementador}}</td>               
          </td>         
          <td style="text-align: center;">            
          <a href="" data-target="#modal-edit-{{$departamento->id}}" data-toggle="modal"><button class="btn btn-info btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>        
          </td>
        </tr>
        @include('setting.departamento.modal.edit')   
        
        @endforeach
        
      </table>
    </div>
  </div>
</div>
  


@endsection
