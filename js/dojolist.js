/*
// Javascript functions used on the DojoList.org
// by Lance Wicks. Last updated: 7 July 2010.
// showAddress is from 0.6.0 and geolocates off the address and places a marker on the map
// location: create dojo page
// *** This is using maprstraction and needs correcting to work with 0.7.0 testing version
// moveMarker updates the lat and long fields when the marker is dragged
// location: create dojo page
*/

function moveMarker(address) {
      var geocoder = null;
      geocoder = new GClientGeocoder();

      if (geocoder) {

        geocoder.getLatLng(
          address,
          function(point) {
            if (point) {
                sPoint = point.toString();
                sPoint = sPoint.replace('/\(/i', "");
                sPoint = sPoint.replace('/\)/i', "");
                sPoint = sPoint.replace('/ /i', "");

                sPoint = sPoint.replace("(", "");
                sPoint = sPoint.replace(")", "");
                coords = sPoint.split(',');

                document.getElementById('long').value = coords[1];
                document.getElementById('lat').value = coords[0];

                var centrePoint = new GLatLng(coords[0], coords[1]);
                marker.setPoint(centrePoint);
                map.setCenter(centrePoint, 14);

                }

            }

        );

      }
}



// This block is used to add the training session fields. It uses jQuery.
// location: create dojo, edit dojo
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

function ORIGshowAddress(address) {
      var geocoder = null;
      geocoder = new GClientGeocoder();

      if (geocoder) {

        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
              alert(address + " not found");
            } else {

                alert(address + " found");
                sPoint = point.toString();
                sPoint = sPoint.replace(/\(/i, "");
                sPoint = sPoint.replace(/\)/i, "");
                sPoint = sPoint.replace(/ /i, "");

                coords = sPoint.split(',');

                document.getElementById('long').value = coords[1];
                document.getElementById('lat').value = coords[0];

                //mapstraction.addMarker( new mxn.Marker( new mxn.LatLonPoint(coords[0],coords[1])));
                var my_marker = new mxn.Marker( new mxn.LatLonPoint(coords[0],coords[1]));


                mapstraction.addMarkerWithData(my_marker,{

                draggable : true,
                hover : true

                });


                mapstraction.autoCenterAndZoom();




            }
          }
        );
      }
    }

