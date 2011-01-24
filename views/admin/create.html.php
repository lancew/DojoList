<script>
  $(document).ready(function(){
    $("#dojoform").validate();
  });
  </script>

<script type="text/javascript">
    window.onload=dofo;
        function dofo() {
            document.dojoform.DojoName.focus();

        }
</script>

<h1>
    <?php echo _("Dojo Management System"); ?>
</h1>

<form 
    method="post" 
    action="" 
    name="dojoform" 
    enctype="multipart/form-data" 
    id="dojoform"
>
<table>
    <tr>
        <td>
            <?php echo _("* Club/Dojo Name:"); ?>
        </td>
        <td>
            <input 
                type="text" 
                name="DojoName" 
                class="required"
            >
        </td>
    </tr>
    <tr>
        <td>
            <?php echo _("NGB Membership ID:"); ?>
        </td>
        <td>
            <input 
                type="text" 
                name="MembershipID"
            >
        </td>
    </tr>
    <tr>
        <td>
            <?php echo _("Head Coach Name:"); ?>
        </td>
        <td>
            <input 
                type="text" 
                name="CoachName"
            >
        </td>
    </tr>
    
    <tr>
        <td>
            <input 
                type="hidden" 
                name="MAX_FILE_SIZE" 
                value="20000" 
            />
            Upload Photo of Head Coach: 
            <input 
                type="file" 
                name="CoachPhoto"
            >
        </td>

    </tr>
     

    <tr>
        <td>
            <?php echo _("* Dojo Address:"); ?>
        </td>
        <td>
            <input 
                type="text" 
                name="DojoAddress" 
                id="DojoAddress" 
                onBlur="moveMarker(this.form.DojoAddress.value);" 
                class="required"
            >
        </td>
    </tr>
    <tr>
        <td>
            <?php echo _("Training Sessions:"); ?>
        </td>
        <td>
            <input 
                type="hidden" 
                id="id" 
                value="1"
            >
            <div id="divTxt"></div>
            <p>
                <a href="#" onClick="addFormField(); return false;">
                <?php echo _("Add"); ?>
                </a>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo _("Contact Name:"); ?>
        </td>
        <td>
            <input 
                type="text" 
                name="ContactName"
            >
        </td>
    </tr>
    <tr>
        <td>
            <?php echo _("Contact Phone Number:"); ?>
        </td>
        <td>
            <input 
                type="text" 
                name="ContactPhone"
            >
        </td>
    </tr>
    <tr>
        <td>
            <?php echo _("Contact Email:"); ?>
        </td>
        <td>
            <input 
                type="text" 
                name="ContactEmail" 
                class="email"
            >
        </td>
    </tr>
    <tr>
        <td>
            <?php echo _("Club website:"); ?>
        </td>
        <td>
            http://<input 
                        type="text" 
                        name="ClubWebsite"
                    >
        </td>
    </tr>
    <tr>
        <td>
            <input 
                type="hidden" 
                name="MAX_FILE_SIZE" 
                value="20000" 
            />
            Upload Dojo Logo: 
            <input 
                type="file" 
                name="DojoLogo"
            >
        </td>
    </tr>
    <tr>
        <td>
            <?php echo _("Coordinates:"); ?>
        </td>
        <td>
            <?php echo _("Latitude:"); ?> 
            <input 
                type="text" 
                id='lat' 
                name="Latitude"
            >
            <br />
            <?php echo _("Longitude:"); ?> 
            <input 
                type="text" 
                id='long' 
                name="Longitude"
            >
        </td>
    </tr>
    <tr>
        <td>
        </td>
        <td>
            <div 
                id="map" 
                style="width: 250px;
                       height: 250px; 
                       float: right;
                       ">
            </div>
        </td>
    </tr>
    <input 
        type="hidden" 
        name="GUID" 
        value="<?php echo guid(); ?>" 
    />
    <tr>
        <td>
        </td>
        <td>
            <?php echo recaptcha_get_html(option('recaptcha_public_key')); ?>
            <input 
                type="submit" 
                value="submit"
            >
            <br />
        </td>
    </tr>
</table>
</form>

<script 
    src="http://maps.google.com/maps?file=api&v=2&key=
    <?php echo option('GoogleKey') ?>" 
    type="text/javascript">
</script>


<script type="text/javascript">
<!--
if (GBrowserIsCompatible())
{
	// create map and add controls
	var map = new GMap2(document.getElementById("map"));
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());

	// set centre point of map
	var centrePoint = new GLatLng('53.34870686020199', '-6.267356872558594');
	map.setCenter(centrePoint, 14);

	// add a draggable marker
	var marker = new GMarker(centrePoint, {draggable: true});
	map.addOverlay(marker);

	// add a drag listener to the map
	GEvent.addListener(marker, "dragend", function() {
		var point = marker.getPoint();
		map.panTo(point);
		document.getElementById("lat").value = point.lat();
		document.getElementById("long").value = point.lng();
    });
}
//-->
</script>
