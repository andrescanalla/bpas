<div class="row">
  <div class="panel with-nav-tabs panel-default" style="padding:0; margin-bottom:0">
    <div class="panel-heading" style="min-height:42px">
      <div class="pull-left">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1default" data-toggle="tab">Visitas</a></li>
            <li><a href="#tab2default" data-toggle="tab" id="tab-pedido">To Do</a></li>
             <li><a href="#tab3default" data-toggle="tab" id="tab-pedido">Agenda</a></li>
        </ul>
      </div>   
    </div>  
      <!-- Modal new to do-->                     
      {{--@include ('dashboard.modal.createtodo')--}}
               
       <!-- Modal new Pedido-->
      {{--@include ('dashboard.modal.createpedido')  --}}

       <!-- Modal new Pedido-->
      {{--@include ('dashboard.modal.createagenda') --}}
                               
    <div class="panel-body" style="padding-top:0; min-height:620px">
        <div class="tab-content"> 
          <div class="tab-pane fade in active" id="tab1default">          
            <div class="table-responsive">
              <table class="table table-condensed table-hover" id="ex" style="margin-bottom:0px">
                <thead>
                <th>Fecha</th>
                <th>Detalle</th>
                <th><div class="btn-group pull-right">
                      <button class="btn btn-link pull-right" data-toggle="modal" data-target="#btnModal" style="padding-top:0;padding-bottom:0"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                </th>
                </thead>
                @php $nx=0;@endphp
                @foreach ($todo as $to)
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
                  <td> {{$to->nombreImplementador}} - {{$to->nombreLocalidad}} - {{$to->nombreTipoVisita}} </td>                  
                  <td><button class="btn btn-link pull-right" data-toggle="modal" data-target="#eModal{{$nx}}" style="padding-top:0;padding-bottom:0"><i class="fa fa-trash" aria-hidden="true"></i></td>
                </tr>
               
                @endforeach
                
              </table>
            </div>      
          </div>
          </div>
          </div>     
         
    </div>
</div>
 