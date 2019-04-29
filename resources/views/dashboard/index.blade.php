@extends ('layouts.admin')
@push ('script')
<link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">
<script src="{{asset('js/Chart.bundle.min.js')}}"></script>

@endpush
@section ('titulo')  
<div class="col-lg-9 col-md-4 col-sm-4 col-xs-12">
Dashboard
</div>  

<div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:5px">        
    @include('dashboard.search')      
</div>
 
 
@endsection
@section ('contenido')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
  @include ('dashboard.todo')
</div>    
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  <div class="row">
    <div class="panel panel-default" style="margin-left:15px;margin-bottom:0px">
      <div class="panel-heading">Visitas Localidades<i class="fa fa-bar-chart pull-right" style="padding-top:4px"></i></div>
      <div class="panel-body"> 
       {!! $chartjs1->render() !!} 
        <div class="text-color"><hr>
        </div>
        {!! $chartjs2->render() !!}  
      </div>
      </div>
  </div>  
</div>
<div class="col-lg-5 col-md-4 col-sm-4 col-xs-12" style="padding-right:0">   
    <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12" style="" id="trash"> 
     @include ('dashboard.departamentos') 
    </div>  
    <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
      <div class="row">
        <div class="panel panel-default" style="min-height:465px;margin-bottom:0;max-height:490px">          
          <div class="panel-body" id='calendar'>        
          </div>
        </div>
      </div>
    </div>
</div>


@push ('scripts')
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/fullcalendar.min.js')}}"></script>
<script src="{{asset('js/gcal.min.js')}}"></script>
<script src="{{asset('js/es.js')}}"></script>


<script>
$(document).ready(function() {
  
  $.ajax({
              url: 'https://graph.facebook.com/1470907659896279?access_token=EAAUJuPkcQtkBAAaM9R5q2YZAmSFXeJDh5NMZBskyZBdXiahvOmj54j6ryDWybVJlBUb75avyM4aJ4x2vUiCtZAF4vAOV9OclIK6ZACPOKTbcUMNMdkGrc7s8av8g6VoHCebU3ArjUlYtyfZCZBEm3eRjZBDcUpKvfd86qh7nj0N3UgZDZD&fields=fan_count,unread_message_count',
              type: 'GET',
              dataType: 'json',
              success: function(data){               
                  $('#likes').html(data.fan_count);
                  $('#mensajes').html(data.unread_message_count);
                  }
  });
  setInterval(function() {
            $.ajax({
              url: 'https://graph.facebook.com/1470907659896279?access_token=EAAUJuPkcQtkBAAaM9R5q2YZAmSFXeJDh5NMZBskyZBdXiahvOmj54j6ryDWybVJlBUb75avyM4aJ4x2vUiCtZAF4vAOV9OclIK6ZACPOKTbcUMNMdkGrc7s8av8g6VoHCebU3ArjUlYtyfZCZBEm3eRjZBDcUpKvfd86qh7nj0N3UgZDZD&fields=fan_count,unread_message_count',
              type: 'GET',
              dataType: 'json',
              success: function(data){      
                  $('#likes').html(data.fan_count);
                  $('#mensajes').html(data.unread_message_count);
              }
            })
  }, 5000); 
          
  $('.createpedido').click(function(e){      
    var form = $(this).parents('form:first');
    var method = 'Aa';
    console.log(method);        
    e.preventDefault();
    var _token = form.find('input[name=_token]').val();
    var todo = form.find('select[name=todo]').val();
    var usuario = form.find('input[name=usuario]').val();        
    var comentarios = form.find('textarea[name=comentarios]').val();
    var tipo = form.find('input[name=tipo]').val();
    console.log(comentarios);
    var url = form.attr('action');
    console.log(url);
    var target = form.find('.success');
          $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {todo:todo, usuario:usuario, comentarios:comentarios, _token:_token,tipo:tipo}
            })
          .done(function(data) {
            if (todo==3) {
            var clase="danger";
            }
            else if (todo==3) {
              var clase="danger";
            }
            var clase="";
            $('#tabla-pedido').append("<tr class='"+clase+"' data-id='"+data.iddash+"'><td><span data-toggle='modal' data-target='#mpModal'>"+usuario+"</span></td><td><span data-toggle='modal' data-target='#mpModal'>"+comentarios+"</span></td><td><a href='#'class='btn btn-link pull-right boton-delete2' style='padding-top:0;padding-bottom:0' data-comment='"+comentarios+"' data-usuario='"+usuario+"'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>");
          })

          .fail(function(data) {
            var errors = data.responseJSON;
            var errorsHtml = " ";
            $.each( errors, function( key, value ) {
                errorsHtml += "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><p>"+ value[0] + "</p></div>"; //showing only the first error.
            });
            target.html(errorsHtml);
            $('.submitbutton').html("<i class='fa fa-flash'></i>&nbspResend").attr('disabled', false);
            })
          .always(function() {
            console.log("complete");
          });
          form[0].reset();                
  });

  $('.createagenda').click(function(e){      
        var form = $(this).parents('form:first');
        var method = 'Aa';
        console.log(method);        
        e.preventDefault();
        var _token = form.find('input[name=_token]').val();
        var todo = form.find('select[name=todo]').val();
        var usuario = form.find('input[name=usuario]').val();
        var tel = form.find('input[name=tel]').val();
        var comentarios = form.find('textarea[name=comentarios]').val();
        var tipo = form.find('input[name=tipo]').val();
        console.log(comentarios);
        var url = form.attr('action');
        console.log(url);
        var target = form.find('.success');
          $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {todo:todo, tel:tel, usuario:usuario, comentarios:comentarios, _token:_token,tipo:tipo}})
              .done(function(data) {
                if (todo==3) {
                var clase="danger";
                }
                else if (todo==3) {
                  var clase="danger";
                }
                var clase="";
               $('#tabla-agenda').append("<tr class='"+clase+"' data-id='"+data.iddash+"'><td><span data-toggle='modal' data-target='#mpModal'>"+usuario+"</span></td><td><span data-toggle='modal' data-target='#mpModal'>"+tel+"</span></td><td><span data-toggle='modal' data-target='#mpModal'>"+comentarios+"</span></td><td><a href='#'class='btn btn-link pull-right boton-delete2' style='padding-top:0;padding-bottom:0' data-comment='"+comentarios+"' data-usuario='"+usuario+"'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>");
              })
              .fail(function(data) {
                var errors = data.responseJSON;
                var errorsHtml = " ";
                $.each( errors, function( key, value ) {
                    errorsHtml += "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><p>"+ value[0] + "</p></div>"; //showing only the first error.
                });
                target.html(errorsHtml);
                $('.submitbutton').html("<i class='fa fa-flash'></i>&nbspResend").attr('disabled', false);
                })
              .always(function() {
                console.log("complete");
              });
              form[0].reset();                
        });
    $('.boton-delete').click(function(e){
          console.log('inicio Eliminar');
          e.preventDefault();
          var row = $(this).parents('tr');
          var iddash = row.data('id');
          console.log('id trash:'+iddash);
          var modal =$('#epModal');
          var usuario =$(this).data('usuario');
          modal.find('input[name=usuario]').val(usuario);
          modal.find('textarea[name=comentarios]').val($(this).data('comment'));
          modal.find('input[name=id]').val(iddash);
          console.log('usuario:'+usuario);
          $('#epModal').modal('show');
       });

       $('.boton-deletes').click(function(e){
          console.log('inicio Eliminar');
          e.preventDefault();
          var row = $(this).parents('tr');
          var iddash = row.data('id');
          console.log('id trash:'+iddash);
          var modal =$('#eaModal');
          var usuario =$(this).data('usuario');         
          modal.find('input[name=usuario]').val(usuario);
          modal.find('input[name=tel]').val($(this).data('tel'));
          modal.find('textarea[name=comentarios]').val($(this).data('comment'));
          modal.find('input[name=id]').val(iddash);
          console.log('usuario:'+usuario);
          $('#eaModal').modal('show');


      });
     $('#btn-delete').click(function(){
            var form = $(this).parents('.modal-content');                 
            var _token = form.find('input[name=_token]').val();
            console.log(_token);  
            var tipo = form.find('input[name=tipo]').val();
            var iddash = form.find('input[name=id]').val();               
            var url = 'http://tienda.ar/dashboard/update2';
            console.log(url);
            console.log('id antes ajax:'+iddash);            
                        
            // jQuery.noConflict();

              $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {_token:_token,tipo:tipo,iddash:iddash}
              })
              .done(function(data) {
                console.log('id despues ajax:'+data.iddash);
                
                $('#p'+iddash).remove(); 

                 console.log('Fin Eliminar'); 
                $('#epModal').modal('hide'); 
              })
          });
     $('#btn-deletes').click(function(){
            var form = $(this).parents('.modal-content');                 
            var _token = form.find('input[name=_token]').val();
            console.log(_token);  
            var tipo = form.find('input[name=tipo]').val();
            var iddash = form.find('input[name=id]').val();               
            var url = 'http://tienda.ar/dashboard/update2';
            console.log(url);
            console.log('id antes ajax:'+iddash);            
                        
            // jQuery.noConflict();

              $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {_token:_token,tipo:tipo,iddash:iddash}
              })
              .done(function(data) {
                console.log('id despues ajax:'+data.iddash);
                
                $('#p'+iddash).remove(); 

                 console.log('Fin Eliminar'); 
                $('#eaModal').modal('hide'); 
              })
          });

 

      var currentMousePos = {
          x: -1,
          y: -1
      };

      
       
      jQuery(document).on("mousemove", function (event) {
         currentMousePos.x = event.pageX;
         currentMousePos.y = event.pageY;
      });
    // page is now ready, initialize the calendar...
    
    $('#calendar').fullCalendar({
        // put your options and callbacks here
        customButtons: {
            myCustomButton: {
                text: 'C',
                click: function(event) {
                    var title = 'Nuevo Evento';
                    $.ajax({
                      url: 'http://tienda.ar/dashboard/calc',
                      data: 'type=new&title='+title,
                      type: 'GET',
                      dataType: 'json',
                      success: function(response){
                        event.id = response.eventid;
                        $('#calendar').fullCalendar('refetchEventSources',{url: 'dashboard/calc'});
                      },
                      error: function(e){
                        console.log(e.responseText);

                      }
                    });
                    
                }
            },
            retira: {
                text: 'R',
                click: function(event) {
                    var title = 'R - Nuevo';
                    $.ajax({
                      url: 'http://tienda.ar/dashboard/calr',
                      data: 'type=new&title='+title,
                      type: 'GET',
                      dataType: 'json',
                      success: function(response){
                        
                        $('#calendar').fullCalendar('refetchEventSources',{ url: 'dashboard/calr'});
                      },
                      error: function(e){
                        console.log(e.responseText);

                      }
                    });
                    
                }
            },
            entrega: {
                text: 'E',
                click: function(event) {
                    var title = 'E - Nueva';
                    $.ajax({
                      url: 'http://tienda.ar/dashboard/cale',
                      data: 'type=new&title='+title,
                      type: 'GET',
                      dataType: 'json',
                      success: function(response){                        
                        $('#calendar').fullCalendar('refetchEventSources',{ url: 'dashboard/cale'});
                      },
                      error: function(e){
                        console.log(e.responseText);

                      }
                    });
                    
                }
            }  
        },
        height: "parent",
        googleCalendarApiKey:'AIzaSyDIqw1eIQ6AxMukLC2PNp8tVKL8XmRdiPQ',
        header: {
           left: ' prev,next, today',
           center: 'title',
           right: 'month,agendaWeek,agendaDay'
         },
        views: {
                week: { // name of view
                    titleFormat: 'YYYY',
                    
                    // other view-specific options here
                },
                month: { // name of view
                    titleFormat: 'MMM YYYY',
                    
                    // other view-specific options here
                },
                 day: { // name of view
                    titleFormat: 'DD MMM',
                    
                    // other view-specific options here
                }
               
        },
        droppable: true,
        displayEventTime: false,
        eventLimit:2,
        businessHours:{dow:[0,1,2,3,4,5,6],start:'08:30',end:'22:00'},
        fixedWeekCount: false,        
        eventSources: [
           {
            googleCalendarId: 'a-w-a.com.ar_mcfdvpi4cj4733b5ka5bh3eiss@group.calendar.google.com',
            className: 'nice-event',        
            editable: true,
            color: '#d9edf7',
            textColor: '#31708f',
            startEditable: true,
            endEditable: true,
            durationEditable: true,
            },
            {
            googleCalendarId: 'pasquinelli@a-w-a.com.ar', 
            className: 'nice-event', 
            color: '#fcf8e3',
            textColor:'black',
            editable: true,
            startEditable: true,
            endEditable: true,
            durationEditable: true,            
            }
            
            
            
        ],


    eventResize: function(event, delta, revertFunc) {
        if(event.source.color==undefined){
        console.log(event.source.color);
        var title = event.title;
        var end = event.end.format();
        var start = event.start.format();
            $.ajax({
              url: 'http://tienda.ar/cal',
              data: 'type=resetdate&start='+start+'&end='+end+'&eventid='+event.id,
              type: 'GET',
              dataType: 'json',
              success: function(response){ // What to do if we succeed
              console.log(response); 
              },
              error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
              console.log(JSON.stringify(jqXHR));
              console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
              }
            });
          }
           if(event.source.color=='green'||event.source.color=='blue'){
        console.log(event.source.color);
        var title = event.title;
        var end = event.end.format();
        var start = event.start.format();
            $.ajax({
              url: 'http://tienda.ar/dashboard/cale',
              data: 'type=resetdate&start='+start+'&end='+end+'&eventid='+event.id,
              type: 'GET',
              dataType: 'json',
              success: function(response){ // What to do if we succeed
              console.log(response); 
              },
              error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
              console.log(JSON.stringify(jqXHR));
              console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
              }
            });
          }
           if(event.source.color=='orange'){
        console.log(event.source.color);
        var title = event.title;
        var end = event.end.format();
        var start = event.start.format();
            $.ajax({
              url: 'http://tienda.ar/dashboard/calr',
              data: 'type=resetdate&start='+start+'&end='+end+'&eventid='+event.id,
              type: 'GET',
              dataType: 'json',
              success: function(response){ // What to do if we succeed
              console.log(response); 
              },
              error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
              console.log(JSON.stringify(jqXHR));
              console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
              }
            });
          }
    },

    eventDrop: function(event, delta, revertFunc) {
     var title = event.title;
     var start = event.start.format();
     var end = (event.end == null) ? start : event.end.format();
        if(event.source.color==undefined){
            $.ajax({
              url: 'http://tienda.ar/cal',
              data: 'type=resetdate&start='+start+'&end='+end+'&eventid='+event.id,
              type: 'GET',
              dataType: 'json',
                success: function(response){ // What to do if we succeed
                  console.log(response); 
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
           });
        }
        if(event.source.color=='green'|| event.source.color=='blue'){
            $.ajax({
              url: 'http://tienda.ar/dashboard/cale',
              data: 'type=resetdate&start='+start+'&end='+end+'&eventid='+event.id,
              type: 'GET',
              dataType: 'json',
                success: function(response){ // What to do if we succeed
                  console.log(response); 
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
           });
        }
        if(event.source.color=='orange'){
            $.ajax({
              url: 'http://tienda.ar/dashboard/cale',
              data: 'type=resetdate&start='+start+'&end='+end+'&eventid='+event.id,
              type: 'GET',
              dataType: 'json',
                success: function(response){ // What to do if we succeed
                  console.log(response); 
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
           });
        }
      },

   eventClick: function(event, jsEvent, view) {
     var title = prompt('Titulo del  Evento:', event.title, { buttons: { Ok: true, Cancel: false} });
     if (title){
     event.title = title;
     $('#calendar').fullCalendar('updateEvent',event);
         if(event.source.color==undefined){
           $.ajax({
             url: 'http://tienda.ar/cal',
             data: 'type=changetitle&title='+title+'&eventid='+event.id,
             type: 'GET',
             dataType: 'json',
             success: function(response){
               console.log(response); 
             },
             error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
              }
             });
             if (event.url) {
                      event.url=null;
                      window.stop(event.url);
                      return false;
                  }
          }
          if(event.source.color=='green' ||event.source.color=='blue'){
               $.ajax({
                 url: 'http://tienda.ar/dashboard/cale',
                 data: 'type=changetitle&title='+title+'&eventid='+event.id,
                 type: 'GET',
                 dataType: 'json',
                 success: function(response){
                   console.log(response); 
                 },
                 error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                  }
                 });
          }
          if(event.source.color=='orange'){
               $.ajax({
                 url: 'http://tienda.ar/dashboard/cale',
                 data: 'type=changetitle&title='+title+'&eventid='+event.id,
                 type: 'GET',
                 dataType: 'json',
                 success: function(response){
                   console.log(response); 
                 },
                 error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                  }
                 });
          }                    
      }
    },

    eventDragStop: function (event, jsEvent, ui, view) {
          if (isElemOverDiv()) {
             if(event.source.color==undefined){
                    $.ajax({
                        url: 'http://tienda.ar/cal',
                        data: 'type=remove&eventid='+event.id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response){
                          console.log(response);
                          if(response.status == 'success'){
                             $('#calendar').fullCalendar('refetchEventSources',{googleCalendarId: 'tevhjs8d5nfk9l79iqme6ervek@group.calendar.google.com'});
                              
                              }
                        },
                        error: function(e){ 
                          alert('Error processing your request: '+e.responseText);
                        }
                      });
             }
             else {
                $.ajax({
                        url: 'http://tienda.ar/dashboard/cale',
                        data: 'type=remove&eventid='+event.id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response){
                          console.log(response);
                          if(response.status == 'success'){
                             $('#calendar').fullCalendar('refetchEventSources',{url: 'dashboard/cale'});
                              $('#calendar').fullCalendar('refetchEventSources',{url: 'dashboard/calr'});
                               $('#calendar').fullCalendar('refetchEventSources',{url: 'dashboard/calc'});
                              
                              }
                        },
                        error: function(e){ 
                          alert('Error processing your request: '+e.responseText);
                        }
                      });

             }
        }
      }

  });
  function isElemOverDiv() {
        var trashEl = jQuery('#trash');

        var ofs = trashEl.offset();

        var x1 = ofs.left;
        var x2 = ofs.left + trashEl.outerWidth(true);
        var y1 = ofs.top;
        var y2 = ofs.top + trashEl.outerHeight(true);

        if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
            currentMousePos.y >= y1 && currentMousePos.y <= y2) {
            return true;
        }
        return false;
    }
  });
</script>
@endpush

@endsection