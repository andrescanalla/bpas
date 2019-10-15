<!doctype html>
<html>
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-147630851-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-147630851-1');
    </script>

    <meta charset="utf-8">
    <title>Demo Shapefile in Google Maps </title>
    
  </head>
  <body>
  <script src="{{asset('js/load-shape.js')}}"></script>    
    <script type="text/javascript">
    // Creates the map, loads in the SHP and DBF files.
      function initMap() {
        shapeMap = new google.maps.Map(document.getElementById('shapeMap'), {
          zoom: 4,
          mapTypeId: 'satellite',                   
          mapTypeControl: true
        })
        /**
         * Load a shape´s file on shapeMap.
         * @param {string} 'SHAPE_FILES_NAME', is the name of the shape´s file with out extensions.
         * @param {string} 'PATH' is the path where the shape´s file are located.     
         **/        
        loadShape('parcelas1','http://127.0.0.1:8000/img');
      }
    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>
    <div id="shapeMap" style="height: 800px"></div>
    
  </body>
</html>