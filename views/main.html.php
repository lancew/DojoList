
<body onload="initialize()">
    <div id="mapstraction" style="width: 100%;"></div>
    <script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo option('GoogleKey') ?>" type="text/javascript">
    </script>
    <script type="text/javascript" src="<?php echo option('js_dir') ?>/mapstraction.js">
    </script>
    <form action="javascript:document.search.s.focus();return false;" onSubmit="showAddress(this.form.s.value)">
    <input type="text" name="s" id="search-postcode" size="45" value="<?php echo _("Enter your address or Postcode to find a local club"); ?>" onBlur="showAddress(this.form.s.value)" onFocus="this.form.s.value = '';" />
     
    </form>
    <style type="text/css">
        #mapstraction {
            height: 450px;
            width: 738px;
        }
    </style> 
	
    <script type="text/javascript">
      // initialise the map with your choice of API
        var mapstraction = new Mapstraction('mapstraction','google');
      
        var myPoint = new LatLonPoint(51.090113,-1.165786);
        // display the map centered on a latitude and longitude (Google zoom levels)
        mapstraction.setCenterAndZoom(myPoint, 2);
        mapstraction.addControls({zoom: 'large'});
     
        // Add url to the URL of your online KML dojo.kml file here  
        // Note: The php that adds ?v= and a random number stops google caching the kml file, so updates appear right away.    
        mapstraction.addOverlay("http://<?php echo $_SERVER['HTTP_HOST'] ?>/data/dojo.kml<?php echo "?v=".rand(1,1000); ?>");
      
    </script> 
	<p><a href="<?php echo option('data_dir') ?>/dojo.kml">KML</a> - <a href="html">HTML</a> - 
	<a href="<?php echo option('data_dir') ?>/dojo.xml" rel="nofollow">XML</a>
	 -> <?php echo Count_dojo(); ?> <?php echo _("Dojo listed on this site and in these files."); ?>
	</p>
	
<script type="text/javascript">
  	function showAddress(address) {
      var geocoder = null;
      geocoder = new GClientGeocoder();
      
      if (geocoder) {
      
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
              //alert(address + " not found");
            } else {
            
                
            	sPoint = point.toString();
            	sPoint = sPoint.replace(/\(/i, "");
            	sPoint = sPoint.replace(/\)/i, "");
            	sPoint = sPoint.replace(/ /i, "");
            	
            	coords = sPoint.split(',');
				
			  	var home = new mxn.LatLonPoint(coords[0],coords[1]);
              	mapstraction.addMarker( new mxn.Marker(home));	
              	mapstraction.setCenterAndZoom(home, 12);
              	
              	              
            }
          }
        );
      }
    } 
     
 </script>