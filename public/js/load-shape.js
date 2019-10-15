
      var shapeMap;     
      var shp;
	  var dbf;
      var infowindow; 
     

     
      function loadShape(shpfileName, path){       
        
        shpfile = path+'/' + shpfileName;        
        console.log('Shape´s file names:',shpfileName);
        console.log('Shape´s file path:',path);
        SHPParser.load(shpfile + '.shp', shpLoad, shpLoadError);
        DBFParser.load(shpfile + '.dbf', dbfLoad, dbfLoadError);
        
      }

      // Handles the callback from loading DBFParser by assigning the dbf to a global.
      function dbfLoad(db) {
        dbf = db;
        if (dbf && shp) {
          render();
        }
      }

      // Handles the callback from loading SHPParser by assigning the shp to a global.
      function shpLoad(sh) {
        shp = sh;
        if (dbf && shp) {
          render();
        }
      } 
	  

      // Adds overlays for all features in the shpfiles array
      function render() {
        var bounds = new google.maps.LatLngBounds();       
         
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
                  map: shapeMap,
                  zIndex: (0 + j)
                });
                overlay = marker;
                break;

              case 3:
                points = pathToArray(shape.content.points);
                var polyline = new google.maps.Polyline({
                  strokeWeight: 2,
                  path: points,
                  map: shapeMap,
                  zIndex: (0 + j)
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
                  map: shapeMap,
                  zIndex: (0 + j)
                });

                overlay = polygon;
             }

             var htmlContent = recordHtmlContent(dbf.records[j]);
				
             handle_clicks(overlay, htmlContent);

          }
        
		  
        shapeMap.fitBounds(bounds);
      }

      function handle_clicks(overlay, info) {
        google.maps.event.addListener(overlay, 'click', function(e) {
          if (typeof infowindow != 'undefined') {
            infowindow.close();
          }
		      
          infowindow = new google.maps.InfoWindow({
            content: info,
            position: e.latLng,
            map: shapeMap
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

        /********************
        * Create shp Parser *
        *********************/      

        SHP = {
            NULL: 0,
            POINT: 1,
            POLYLINE: 3,
            POLYGON: 5
        };
        
        SHP.getShapeName = function(id) {
            for (name in this) {
            if (id === this[name]) {
                return name;
            }
            }
        };
        
        SHPParser = function() {
        };
        
        SHPParser.load = function(src, callback, onerror) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', src);
            xhr.responseType = 'arraybuffer';
            xhr.onload = function() {
            console.log(xhr.response);
            var d = new SHPParser().parse(xhr.response,src);
            callback(d);
            };
            xhr.onerror = onerror;
            xhr.send(null);
        };
        
        SHPParser.prototype.parse = function(arrayBuffer,src) {
            var o = {};
            var dv = new DataView(arrayBuffer);
            var idx = 0;
            o.fileName = src;
            o.fileCode = dv.getInt32(idx, false);
            if (o.fileCode != 0x0000270a) {
            throw (new Error("Unknown file code: " + o.fileCode));
            }
            idx += 6*4;
            o.wordLength = dv.getInt32(idx, false);
            o.byteLength = o.wordLength * 2;
            idx += 4;
            o.version = dv.getInt32(idx, true);
            idx += 4;
            o.shapeType = dv.getInt32(idx, true);
            idx += 4;
            o.minX = dv.getFloat64(idx, true);
            o.minY = dv.getFloat64(idx+8, true);
            o.maxX = dv.getFloat64(idx+16, true);
            o.maxY = dv.getFloat64(idx+24, true);
            o.minZ = dv.getFloat64(idx+32, true);
            o.maxZ = dv.getFloat64(idx+40, true);
            o.minM = dv.getFloat64(idx+48, true);
            o.maxM = dv.getFloat64(idx+56, true);
            idx += 8*8;
            o.records = [];
            while (idx < o.byteLength) {
            var record = {};
            record.number = dv.getInt32(idx, false);
            idx += 4;
            record.length = dv.getInt32(idx, false);
            idx += 4;
            try {
                record.shape = this.parseShape(dv, idx, record.length);
            } catch(e) {
                console.log(e, record);
            }
            idx += record.length * 2;
            o.records.push(record);
            }
            return o;
        };
        
        SHPParser.prototype.parseShape = function(dv, idx, length) {
            var i=0, c=null;
            var shape = {};
            shape.type = dv.getInt32(idx, true);
            idx += 4;
            var byteLen = length * 2;
            switch (shape.type) {
            case SHP.NULL: // Null
                break;
        
            case SHP.POINT: // Point (x,y)
                shape.content = {
                x: dv.getFloat64(idx, true),
                y: dv.getFloat64(idx+8, true)
                };
                break;
            case SHP.POLYLINE: // Polyline (MBR, partCount, pointCount, parts, points)
            case SHP.POLYGON: // Polygon (MBR, partCount, pointCount, parts, points)
                c = shape.content = {
                minX: dv.getFloat64(idx, true),
                minY: dv.getFloat64(idx+8, true),
                maxX: dv.getFloat64(idx+16, true),
                maxY: dv.getFloat64(idx+24, true),
                parts: new Int32Array(dv.getInt32(idx+32, true)),
                points: new Float64Array(dv.getInt32(idx+36, true)*2)
                };
                idx += 40;
                for (i=0; i<c.parts.length; i++) {
                c.parts[i] = dv.getInt32(idx, true);
                idx += 4;
                }
                for (i=0; i<c.points.length; i++) {
                c.points[i] = dv.getFloat64(idx, true);
                idx += 8;
                }
                break;
        
            case 8: // MultiPoint (MBR, pointCount, points)
            case 11: // PointZ (X, Y, Z, M)
            case 13: // PolylineZ
            case 15: // PolygonZ
            case 18: // MultiPointZ
            case 21: // PointM (X, Y, M)
            case 23: // PolylineM
            case 25: // PolygonM
            case 28: // MultiPointM
            case 31: // MultiPatch
                throw new Error("Shape type not supported: "
                                + shape.type + ':' +
                                + SHP.getShapeName(shape.type));
            default:
                throw new Error("Unknown shape type at " + (idx-4) + ': ' + shape.type);
            }
            return shape;
        };

        /********************
         * Create dbf Parser*
         ********************/         
             

        // Creates global namespace.
        DBF = {};

        DBFParser = function() {};

        /**
         * Executes a binary XHR to load a .dbf file and then creates a callback to
         * handle the result.
         * @param {string} url URL to the .dbf file.
         * @param {function(Object)} callback the function to be called when finished.
         * @param {Function} onerror the function to be called in case of an error
         *                   loading the file.
         */
        DBFParser.load = function(url, callback, onerror) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.responseType = 'arraybuffer';
        xhr.onload = function() {
            var d = new DBFParser().parse(xhr.response,url);
            callback(d);
        };
        xhr.onerror = onerror;
        xhr.send(null);
        };

        /**
         * Parses through the .dbf file byte by byte
         * @param {arraybuffer} arrayBuffer the ArrayBuffer created by loading the file
         *                        in XHR.
         * @return {object} o An object representing the .dbf file.
         */
        DBFParser.prototype.parse = function(arrayBuffer,src) {
        var o = {};
        var dv = new DataView(arrayBuffer);
        var idx = 0;
        o.fileName = src;
        o.version = dv.getInt8(idx, false);

        idx += 1;
        o.year = dv.getUint8(idx) + 1900;
        idx += 1;
        o.month = dv.getUint8(idx);
        idx += 1;
        o.day = dv.getUint8(idx);
        idx += 1;

        o.numberOfRecords = dv.getInt32(idx, true);
        idx += 4;
        o.bytesInHeader = dv.getInt16(idx, true);
        idx += 2;
        o.bytesInRecord = dv.getInt16(idx, true);
        idx += 2;
        //reserved bytes
        idx += 2;
        o.incompleteTransation = dv.getUint8(idx);
        idx += 1;
        o.encryptionFlag = dv.getUint8(idx);
        idx += 1;
        // skip free record thread for LAN only
        idx += 4;
        // reserved for multi-user dBASE in dBASE III+
        idx += 8;
        o.mdxFlag = dv.getUint8(idx);
        idx += 1;
        o.languageDriverId = dv.getUint8(idx);
        idx += 1;
        // reserved bytes
        idx += 2;

        o.fields = [];
        while (true) {
            var field = {};
            var nameArray = [];
            for (var i = 0; i < 10; i++) {
            var letter = dv.getUint8(idx);
            if (letter != 0) nameArray.push(String.fromCharCode(letter));
            idx += 1;
            }
            field.name = nameArray.join('');
            idx += 1;
            field.type = String.fromCharCode(dv.getUint8(idx));
            idx += 1;
            // Skip field data address
            idx += 4;
            field.fieldLength = dv.getUint8(idx);
            idx += 1;
            //field.decimalCount = dv.getUint8(idx);
            idx += 1;
            // Skip reserved bytes multi-user dBASE.
            idx += 2;
            field.workAreaId = dv.getUint8(idx);
            idx += 1;
            // Skip reserved bytes multi-user dBASE.
            idx += 2;
            field.setFieldFlag = dv.getUint8(idx);
            idx += 1;
            // Skip reserved bytes.
            idx += 7;
            field.indexFieldFlag = dv.getUint8(idx);
            idx += 1;
            o.fields.push(field);
            var test = dv.getUint8(idx);
            // Checks for end of field descriptor array. Valid .dbf files will have this
            // flag.
            if (dv.getUint8(idx) == 0x0D) break;
        }

        idx += 1;
        o.records = [];

        for (var i = 0; i < o.numberOfRecords; i++) {
            var record = {};
            // Skip record deleted flag.
            //record["recordDeleted"] = String.fromCharCode(dv.getUint8(idx));
            idx += 1;
            for (var j = 0; j < o.fields.length; j++) {
            var charString = [];
            for (var h = 0; h < o.fields[j].fieldLength; h++) {
                charString.push(String.fromCharCode(dv.getUint8(idx)));
                idx += 1;
            }
            record[o.fields[j].name] = charString.join('').trim();

            }
            o.records.push(record);
        }

        return o;
        };


    