// Javascript functions used on the DojoList.org
// by Lance Wicks. Last updated: 7 July 2010.
	
  	function moveMarker(address) {
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
            	sPoint = sPoint.replace('/\(/i', "");
            	sPoint = sPoint.replace('/\)/i', "");
            	sPoint = sPoint.replace('/ /i', "");

            	coords = sPoint.split(',');

			  	document.getElementById('long').value = coords[1];
			  	document.getElementById('lat').value = coords[0];
			  	
			  				  	
                });


              

            }
          }
        );
      }
    }



// This block is used to add the training session fields. It uses jQuery.
function addFormField() {
	var id = document.getElementById("id").value;
	$("#divTxt").append("<p id='row" + id + "'><label for='txt" + id + "'>Training Session " + id + ":<br /><input type='text' size='20' name='TrainingSession" + id + "Day' id='txt" + id + "' value='eg:Monday'><br /><input type='text' size='8' name='TrainingSession" + id + "Time' id='txt" + id + "' value='eg:8:30pm'><br /><input type='text' size='20' name='TrainingSession" + id + "Age' id='txt" + id + "' value='eg:Juniors'><a href='#' onClick='removeFormField(\"#row" + id + "\"); return false;'>Remove</a><p>");
	id = (id - 1) + 2;
	document.getElementById("id").value = id;
}

// This script removes the training session field.
function removeFormField(id) {
	$(id).remove();
}


