
<h1>Dojo Management System</h1>

<form method="post" action="">
<table>
<div id="mapstraction" style="float:right;"></div>
<tr><td>Club/Dojo Name:</td><td><input type="text" name="DojoName"></td></tr>
<tr><td>NGB Membership ID:</td><td><input type="text" name="MembershipID"></td></tr>
<tr><td>Head Coach Name:</td><td><input type="text" name="CoachName"></td></tr>
<tr><td>Dojo Address:</td><td><input type="text" name="DojoAddress" onBlur="showAddress(this.form.DojoAddress.value)"></td></tr>
<tr><td>Training Sessions:</td><td>

<input type="hidden" id="id" value="1">
<div id="divTxt"></div>
<p><a href="#" onClick="addFormField(); return false;">Add</a>
</td></tr>


<tr><td>Contact Name:</td><td><input type="text" name="ContactName"></td></tr>
<tr><td>Contact Phone Number:</td><td><input type="text" name="ContactPhone"></td></tr>
<tr><td>Contact Email:</td><td><input type="text" name="ContactEmail"></td></tr>
<tr><td>Club website:</td><td>Http://<input type="text" name="ClubWebsite"></td></tr>
<tr><td>Coordinates:</td><td>
Latitude: <input type="text" id='lat' name="Latitude"><br />
Longitude: <input type="text" id='long' name="Longitude">
</td></tr>
</table>

<input type="submit" value="submit"><br />
</form>








<script type="text/javascript">
// This block is used to add the training session fields. It uses jQuery.
function addFormField() {
	var id = document.getElementById("id").value;
	$("#divTxt").append("<p id='row" + id + "'><label for='txt" + id + "'>Training Session " + id + ":<br /><input type='text' size='20' name='TrainingSession" + id + "Day' id='txt" + id + "' value='eg:Monday'><br /><input type='text' size='8' name='TrainingSession" + id + "Time' id='txt" + id + "' value='eg:8:30pm'><br /><input type='text' size='20' name='TrainingSession" + id + "Age' id='txt" + id + "' value='eg:Juniors'><a href='#' onClick='removeFormField(\"#row" + id + "\"); return false;'>Remove</a><p>");
	id = (id - 1) + 2;
	document.getElementById("id").value = id;
}

function removeFormField(id) {
	$(id).remove();
}
</script>


<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo option('GoogleKey') ?>" type="text/javascript"></script>



  	
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo option('GoogleKey') ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo option('base_uri') ?>js/mapstraction.js"></script>
    <style type="text/css">
      #mapstraction {
        height: 250px;
        width: 250px;
      }
    </style> 
	

	
	

    <script type="text/javascript">

      // initialise the map with your choice of API
      var mapstraction = new Mapstraction('mapstraction','openstreetmap');
      
      var myPoint = new LatLonPoint(51.090113,-1.165786);
      // display the map centered on a latitude and longitude (Google zoom levels)
      mapstraction.setCenterAndZoom(myPoint, 8);
      
     
      
      // Add url to the URL of your online KML dojo.kml file here      
      mapstraction.addOverlay("http://<?php echo $_SERVER['HTTP_HOST'].option('base_uri') ?>/data/dojo.kml");
      
    </script> 
    
    
    <script type="text/javascript">
  // This function is called when you tab away from the address field, it geocodes the address and comes up with the lat and long
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
            	
            		

			  	document.getElementById('long').value = coords[1];
			  
              	document.getElementById('lat').value = coords[0];
              	
        

              
            }
          }
        );
      }
    } 
     
 </script>

