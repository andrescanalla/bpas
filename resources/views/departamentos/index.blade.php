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
    <div class="table-responsive">
      <table class="table table-condensed table-hover" id="table" style="margin-bottom:0px">
        <thead style="background-color:#A9D0F5">
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
        
        <tr>
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
  <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
  </div>
</div>
  


@endsection
