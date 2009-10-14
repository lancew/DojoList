<body onload="initialize()">
	<h1>Dojo List</h1>
	    <div id="mapstraction" style="width: 100%;"></div>
    <script type="text/javascript">

      // initialise the map with your choice of API
      var mapstraction = new Mapstraction('mapstraction','openstreetmap');
      
      var myPoint = new LatLonPoint(51.090113,-1.165786);
      // display the map centered on a latitude and longitude (Google zoom levels)
      mapstraction.setCenterAndZoom(myPoint, 9);
      mapstraction.addControls({zoom: 'large'});
     
      
      // Add url to the URL of your online KML dojo.kml file here      
      mapstraction.addOverlay("http://hampshirejudo.org.uk/map/hantsjudo.kml");
      
    </script> 
