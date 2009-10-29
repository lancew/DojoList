<body onload="initialize()">
	
	    <div id="mapstraction" style="width: 100%;"></div>
   <!-- ========================================================================================================================= -->
    <!-- ! dev.dojolist Google Maps key = ABQIAAAA2Xy4GEmk_3kINx3LAgnNqhQXBDc1CkX49eEa50oiJq9JEnZWARSVOY8m3-zJmuoOv8hU-Z2ODM5hww   -->
    <!-- ========================================================================================================================= -->

	
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo option('GoogleKey') ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo option('base_uri') ?>js/mapstraction.js"></script>
    <style type="text/css">
      #mapstraction {
        height: 450px;
        width: 738px;
      }
    </style> 
	

	
	

    <script type="text/javascript">

      // initialise the map with your choice of API
      var mapstraction = new Mapstraction('mapstraction','openstreetmap');
      
      var myPoint = new LatLonPoint(51.090113,-1.165786);
      // display the map centered on a latitude and longitude (Google zoom levels)
      mapstraction.setCenterAndZoom(myPoint, 9);
      mapstraction.addControls({zoom: 'large'});
     
      
      // Add url to the URL of your online KML dojo.kml file here      
      mapstraction.addOverlay("http://<?php echo $_SERVER['HTTP_HOST'].option('base_uri') ?>/data/dojo.kml");
      
    </script> 
	<p><a href="<?php echo option('base_uri') ?>data/dojo.kml">KML</a> - <a href="html">HTML</a> - <a href="<?php echo option('app_path') ?>/data/dojo.kml">KML</a></p>
	
	