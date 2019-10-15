@extends ('layouts.demo')
    @push ('script')
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-147630851-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-147630851-1');
      </script>
      <script src="{{asset('js/load-shape.js')}}"></script>    
        <script type="text/javascript">
        // Creates the map, loads in the SHP and DBF files.
          function initMap() {
            shapeMap = new google.maps.Map(document.getElementById('shapeMap'), {
              zoom: 4,
              mapTypeId: 'satellite',                   
              mapTypeControl: true
            });        
            loadShape('parcelas1','/img/');
          }
          
        </script>
    @endpush
    @section ('titulo') 
      <div class="row">
          <div class="col-lg-9 col-md-8 col-sm-10 col-xs-10">        
          Load ShapeFile in Google Maps
          </div>                
      </div>

    @endsection
    
    @section ('contenido')  
      <div id="shapeMap" style="height: 85vh"></div>
      
      @push ('scripts')
        <script async defer
          src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
        </script>
      @endpush
    @endsection

  