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
	<style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0px; padding: 0px }
	  #map { height: 100% }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script src="{{asset('js/dbf.js')}}"></script>
    <script src="{{asset('js/shp.js')}}"></script>
    <script type="text/javascript">
      var map;
      var shpfiles = [];
      var arrDbf = [];
      var arrShp = [];
      var infowindow;

      // Creates the map, loads in the SHP and DBF files.
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          mapTypeId: 'satellite',                   
          mapTypeControl: true
        });
		
        shpfiles = new Array('parcelas1');

        for (var i=0; i < shpfiles.length; i++) {
          shpfile = shpfiles[i];
          SHPParser.load(shpfile + '.shp', shpLoad, shpLoadError);
          DBFParser.load(shpfile + '.dbf', dbfLoad, dbfLoadError);
        }
      }

      // Handles the callback from loading DBFParser by assigning the dbf to a global.
      function dbfLoad(db) {
        arrDbf.push(db);
        if (arrDbf.length == shpfiles.length && arrShp.length == shpfiles.length) {
          reorder()
		  render();
        }
      }

      // Handles the callback from loading SHPParser by assigning the shp to a global.
      function shpLoad(sh) {
        arrShp.push(sh);
        if (arrDbf.length == shpfiles.length && arrShp.length == shpfiles.length) {
          reorder();
		  render();
        }
      }
	  
	  // Files could be read in out of original sequence; this puts them back in sequence
	  function reorder() {
	    var fixedShp = [];
		var fixedDbf = [];
	
    	for (var i = 0; i < shpfiles.length; i++) {
		  name = shpfiles[i];
		  
		  for (var j = 0; j < arrShp.length; j++) {
			shp = arrShp[j];
			if (shp.fileName == (name + '.shp')) {
				fixedShp[i] = shp;
				break;
			}
		  }
		  
		  for (var j = 0; j < arrDbf.length; j++) {
			dbf = arrDbf[j];
			if (dbf.fileName == (name + '.dbf')) {
				fixedDbf[i] = dbf;
				break;
			}
		  }
		}
		
		arrShp = fixedShp;
		arrDbf = fixedDbf;
	  }

      // Adds overlays for all features in the shpfiles array
      function render() {
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0; i < arrShp.length; i++) {
          var shp = arrShp[i];
          var dbf = arrDbf[i];
          var points;
          var type;
          var ne = new google.maps.LatLng(shp.maxY, shp.maxX);
          var sw = new google.maps.LatLng(shp.minY, shp.minX);
          bounds.union(new google.maps.LatLngBounds(sw, ne));

          for (var j = 0; j < shp.records.length; j++) {
            var shape = shp.records[j].shape;
            var overlay;
            switch (shape.type) {
              case 1:
                var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(shape.content.y,shape.content.x),
                  map: map,
                  zIndex: (i * 100 + j)
                });
                overlay = marker;
                break;

              case 3:
                points = pathToArray(shape.content.points);
                var polyline = new google.maps.Polyline({
                  strokeWeight: 2,
                  path: points,
                  map: map,
                  zIndex: (i * 100 + j)
                });

                overlay = polyline;
                break;

              case 5:
                // split into rings
				var polygonPoints = [];
                var parts = shape.content.parts;
                if (parts.length === 1) {
                  polygonPoints.push(pathToArray(shape.content.points));
                } else {
                  var k;
                  for (k = 0; k < parts.length - 1; k++) {
                    polygonPoints.push(pathToArray(shape.content.points.subarray(2 * parts[k], 2 * parts[k + 1])));
                    if (2 * parts[k + 1] > shape.content.points.length) {
                      throw new Error('part index beyond points array end');
                    }
                  }
                }
					
                // create a polygon.
                var polygon = new google.maps.Polygon({
                  strokeWeight: .3,
                  fillOpacity: .2,
                  paths: polygonPoints,
                  map: map,
                  zIndex: (i * 100 + j)
                });

                overlay = polygon;
             }

             var htmlContent = recordHtmlContent(dbf.records[j]);
				
             handle_clicks(overlay, htmlContent);

          }
        }
		  
        map.fitBounds(bounds);
      }

      function handle_clicks(overlay, info) {
        google.maps.event.addListener(overlay, 'click', function(e) {
          if (typeof infowindow != 'undefined') {
            infowindow.close();
          }
		      
          infowindow = new google.maps.InfoWindow({
            content: info,
            position: e.latLng,
            map: map
          });
		      
          
        });
      }
		
		
      /* Create a nice presentation for the attribute data.
       * @param {object} record An object representing the individual record.
       */
      function recordHtmlContent(record) {
        var content = '';
        for (var key in record) {
          content += '<b>' + key + '</b>: ' + record[key] + '<br>';
        }
        return content;
      }

      /* Create an Array out of a set of points ordered longitude/latitude
       * @param {array} path an array of points.
       */
      function pathToArray(path) {
		var polygonPoints = [];
		for (var i = 0; i < path.length; i += 2) {
          polygonPoints.push(new google.maps.LatLng(path[i + 1], path[i]));
        }
        return polygonPoints;
      }
	  
      // error handler for shploader.
      function shpLoadError() {
        window.console.log('shp file failed to load');
      }

      // error handler for dbfloader.
      function dbfLoadError() {
        console.log('dbf file failed to load');
      }
    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>
  </body>
</html>