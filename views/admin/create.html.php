<script type="text/javascript">


function addFormField() {
	var id = document.getElementById("id").value;
	$("#divTxt").append("<p id='row" + id + "'><label for='txt" + id + "'>Training Session " + id + ":&nbsp;&nbsp;<input type='text' size='20' name='TrainingSession" + id + "Day' id='txt" + id + "' value='eg:Monday'>&nbsp;&nbsp<input type='text' size='8' name='TrainingSession" + id + "Time' id='txt" + id + "' value='eg:8:30pm'>&nbsp;&nbsp;<input type='text' size='20' name='TrainingSession" + id + "Age' id='txt" + id + "' value='eg:Juniors'><a href='#' onClick='removeFormField(\"#row" + id + "\"); return false;'>Remove</a><p>");
	id = (id - 1) + 2;
	document.getElementById("id").value = id;
}

function removeFormField(id) {
	$(id).remove();
}
</script>
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo option('GoogleKey') ?>" type="text/javascript"></script>
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
            	
            		

			  document.getElementById('long').value = coords[1];
			  
              document.getElementById('lat').value = coords[0];
              
            }
          }
        );
      }
    } 
     
 </script>


<h1>Dojo Management System</h1>

<form method="post" action="">

Club/Dojo Name: <input type="text" name="DojoName"><br />
NGB Membership ID: <input type="text" name="MembershipID"><br />
Head Coach Name: <input type="text" name="CoachName"><br />
Dojo Address: <input type="text" name="DojoAddress" onBlur="showAddress(this.form.DojoAddress.value)"><br />
Training Sessions: <br />

<input type="hidden" id="id" value="1">
<div id="divTxt"></div>
<p><a href="#" onClick="addFormField(); return false;">Add</a></p>


Contact Name: <input type="text" name="ContactName"><br />
Contact Phone Number: <input type="text" name="ContactPhone"><br />
Contact Email: <input type="text" name="ContactEmail"><br />
Club website: Http://<input type="text" name="ClubWebsite"><br />
Coordinates:<br />
Latitude: <input type="text" id='lat' name="Latitude"><br />
Longitude: <input type="text" id='long' name="Longitude"><p />
<input type="submit" value="submit"><br />
</form>


