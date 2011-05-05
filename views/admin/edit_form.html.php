<!-- The following Javascript enables jQuery validation -->
<script>
  $(document).ready(function(){
    $("#dojoform").validate();
  });
</script>

<!-- The following Javascript forces the focus into the first field of the form. -->
<script type="text/javascript">
	window.onload=dofo;
	function dofo() {
		document.dojoform.MembershipID.focus();

	}

</script>

<!-- The following Javascript disables the enter key on a page with a form -->
<script type="text/javascript"> 

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 

</script>


<h1><?php echo _("Dojo Management System"); ?></h1>

<form
    method="post"
    action=""
    name="dojoform"
    enctype="multipart/form-data"
    id="dojoform"
>
<table>
<div id="map" style="width: 250px; height: 250px; float: right;">
<tr>
    <td>
        <?php echo  _("Dojo Logo:"); ?></td>
        <td>
        <?php if ($Dojo->DojoLogo) {
	echo '<img alt="'.$Dojo->DojoName.'" src="'.$Dojo->DojoLogo.'" />'; ?>
            <br />
            <br />Delete Logo
            <input
                type=checkbox
                name="delete_logo"
                value="delete_logo"
            />
        <?php 
} 
        ?>

        <br />
        <input
            type="hidden"
            name="MAX_FILE_SIZE"
            value="20000"
        />
        <input
            type="file"
            name="DojoLogo"
        />

	   </td>
    </tr>
</td>
</tr>

<tr>
    <td>
        <?php echo _("Club/Dojo Name:"); ?>
    </td>
    <td>
        <input 
            type="text" 
            name="DojoName" 
            value="<?php echo h($Dojo->DojoName)?>" 
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
            value="<?php echo h($Dojo->MembershipID)?>"
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
            value="<?php echo h($Dojo->CoachName)?>"
        >
    </td>
</tr>


<tr>
    <td>
        <?php echo  _("Head Coach Photo:"); ?></td>
        <td>
        <?php if ($Dojo->CoachPhoto) {
	echo '<img alt="'.$Dojo->CoachPhoto.'" src="'.$Dojo->CoachPhoto.'" />'; ?>
            <br />
            <br />Delete Photo
            <input
                type=checkbox
                name="delete_photo"
                value="delete_photo"
            />
        <?php 
} 
        ?>

        <br />
        <input
            type="hidden"
            name="MAX_FILE_SIZE"
            value="20000"
        />
        <input
            type="file"
            name="CoachPhoto"
        />

	   </td>
    </tr>
</td>
</tr>



<tr>
    <td>
        <?php echo _("Dojo Address:"); ?>
    </td>
    <td>
        <input 
            type="text" 
            name="DojoAddress" 
            class="required" 
            id="DojoAddress" 
            onBlur="moveMarker(this.form.DojoAddress.value)" 
            value="<?php echo h($Dojo->DojoAddress)?>" 
            class="required"
        >
    </td>
</tr>

<tr>
    <td>
        <?php echo _("Training Sessions:"); ?>
    </td>
    <td>
    </td>
</tr>

<?php
foreach ($Dojo as $field => $value) {
	if (preg_match('/^TrainingSession/', $field)) {
		echo '<tr>
		          <td>
		          </td>
		          <td>
		              <input 
		                  type="text" 
		                  name="'.$field.'" 
		                  value="'.$value.'"
		              >
		          </td>
		      </tr>';
	}

}
?>

<tr>
    <td>
    </td>
    <td>
        &nbsp;
    </td>
</tr>

<tr>
    <td>
    </td>
    <td>
        <input 
            type="hidden" 
            id="id" 
            value="1"
        >
        <div id="divTxt"></div>
        <p>
            <a 
                href="#" 
                onClick="addFormField(); 
                return false;">
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
            value="<?php echo h($Dojo->ContactName)?>"
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
            value="<?php echo h($Dojo->ContactPhone)?>"
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
            value="<?php echo h($Dojo->ContactEmail)?>"
        >
    </td>
</tr>

<tr>
    <td>
        <?php echo _("Club website:"); ?>
    </td>
    <td>
        Http://<input 
                    type="text" 
                    name="ClubWebsite" 
                    value="<?php echo h($Dojo->ClubWebsite)?>"
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
            value="<?php echo h($Dojo->Latitude)?>"
        >
        <br />
        <?php echo _("Longitude:"); ?> 
        <input 
            type="text" 
            id='long' 
            name="Longitude" 
            value="<?php echo h($Dojo->Longitude)?>"
        >
    </td>
</tr>

<tr>
    <td>
        <p>Notes:</p>
    </td>
    <td>
        <textarea
            rows="10" 
            cols="30"
            id='Notes'
            name='Notes'
            
        ><?php echo h($Dojo->Notes)?></textarea>
            
    </td>
</tr>

<tr>
    <td>
        <em>
            <?php 
            echo _(
                "Please note: 
                Notifications of changes will be send to administrators."
            );
            ?>
        </em>
    </td>
</tr>
</table>

<input 
    type="hidden" 
    name="GUID" 
    value="<?php echo h($Dojo->GUID)?>" 
/>

<?php echo recaptcha_get_html(option('recaptcha_public_key')); ?>
<input 
    type="submit" 
    value="submit"
>
<br />
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
	var centrePoint = new GLatLng(
	                       document.getElementById('lat').value, 
	                       document.getElementById('long').value
	                       );
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
