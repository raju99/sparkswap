<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <script src="//maps.google.com/maps?file=api&v=2.x&key=AIzaSyD00x4u7KenzJqQEBVkOGt58W0q1T9wFYw"
      type="text/javascript"></script>
   <script src="http://192.168.0.18/spark/js/gmaps.CircleOverlay.js" type="text/javascript"></script>

	 <script type="text/javascript"> 
	// Create a directions object and register a map and DIV to hold the 
    // resulting computed directions

    var map;
    var directionsPanel;
    var directions;

    function initialize() {
      map = new GMap2(document.getElementById("map_canvas"));
      map.setCenter(new GLatLng(42.351505,-71.094455), 3);
     // directionsPanel = document.getElementById("route");
      directions = new GDirections(map, directionsPanel);
      directions.load("from: 500 Memorial Drive, Cambridge, MA to: 4 Yawkey Way, Boston, MA 02215 (Fenway Park)");

	   directions.load("from: #871 phase 11 mohali, punjab, india to: #34 phase 1 mohali, punjab, india");
    }
    </script>
  </head>

  <body onload="initialize()">

    <div id="map_canvas" style="width: 70%; height: 480px; float:left; border: 1px solid black;"></div>
    <div id="route" style="width: 25%; height:480px; float:right; border; 1px solid black;"></div>
    <br/>
  </body>
</html>
