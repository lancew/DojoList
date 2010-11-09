<script>
  $(document).ready(function(){
    $("#dojoform").validate();
  });
</script>

<script type="text/javascript">
	window.onload=dofo;
	function dofo() {
		document.dojoform.MembershipID.focus();
		
	}

</script>

<h1><?php echo _("Dojo Management System"); ?></h1>

<form method="post" action="" name="dojoform" enctype="multipart/form-data" id="dojoform">
<table>
<div id="map" style="width: 250px; height: 250px; float: right;">
<tr><td><?php echo  _("Dojo Logo:"); ?></td><td> <?php if ($Dojo->DojoLogo) { echo '<img alt="'.$Dojo->DojoName.'" src="'.$Dojo->DojoLogo.'" />'; ?> 
	<br /><br />Delete Logo <input type=checkbox name="delete_logo" value="delete_logo"/> <?php } ?>   
	<br /><input type="hidden" name="MAX_FILE_SIZE" value="20000" /><input type="file" name="DojoLogo" />
	
	</td></tr>



</td></tr>
<tr><td><?php echo _("Club/Dojo Name:"); ?></td><td><input type="text" name="DojoName" value="<?=h($Dojo->DojoName)?>" class="required"></td></tr>
<tr><td><?php echo _("NGB Membership ID:"); ?></td><td><input type="text" name="MembershipID" value="<?=h($Dojo->MembershipID)?>"></td></tr>
<tr><td><?php echo _("Head Coach Name:"); ?></td><td><input type="text" name="CoachName" value="<?=h($Dojo->CoachName)?>"></td></tr>
<tr><td><?php echo _("Dojo Address:"); ?></td><td><input type="text" name="DojoAddress" class="required" id="DojoAddress" onBlur="moveMarker(this.form.DojoAddress.value)" value="<?=h($Dojo->DojoAddress)?>" class="required"></td></tr>
<tr><td><?php echo _("Training Sessions:"); ?></td><td></td></tr>

<?php

foreach ($Dojo AS $field => $value) {
	if (preg_match('/^TrainingSession/', $field)) {
		echo '<tr><td></td><td><input type="text" name="'.$field.'" value="'.$value.'"></td></tr>';
        }
  
}

?>
<tr><td></td><td>&nbsp;</td></tr>
<tr><td></td>
<td>
<input type="hidden" id="id" value="1">
<div id="divTxt"></div>
<p><a href="#" onClick="addFormField(); return false;"><?php echo _("Add"); ?></a>
</td></tr>


<tr><td><?php echo _("Contact Name:"); ?></td><td><input type="text" name="ContactName" value="<?=h($Dojo->ContactName)?>"></td></tr>
<tr><td><?php echo _("Contact Phone Number:"); ?></td><td><input type="text" name="ContactPhone" value="<?=h($Dojo->ContactPhone)?>"></td></tr>
<tr><td><?php echo _("Contact Email:"); ?></td><td><input type="text" name="ContactEmail" class="email" value="<?=h($Dojo->ContactEmail)?>"></td></tr>
<tr><td><?php echo _("Club website:"); ?></td><td>Http://<input type="text" name="ClubWebsite" value="<?=h($Dojo->ClubWebsite)?>"></td></tr>
<tr><td><?php echo _("Coordinates:"); ?></td><td>
<?php echo _("Latitude:"); ?> <input type="text" id='lat' name="Latitude" value="<?=h($Dojo->Latitude)?>"><br />
<?php echo _("Longitude:"); ?> <input type="text" id='long' name="Longitude" value="<?=h($Dojo->Longitude)?>">
</td></tr>
<tr><td><em><?php echo _("Please note: Notifications of changes will be send to administrators."); ?></em></td></tr>
</table>

<input type="hidden" name="GUID" value="<?=h($Dojo->GUID)?>" />

<?php echo recaptcha_get_html(option('recaptcha_public_key')); ?>
<input type="submit" value="submit"><br />
</form>



<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo option('GoogleKey') ?>" type="text/javascript"></script>


<script type="text/javascript">	
<!--
if (GBrowserIsCompatible()) 
{
	// create map and add controls
	var map = new GMap2(document.getElementById("map"));
	map.addControl(new GLargeMapControl());        
	map.addControl(new GMapTypeControl());
	
	// set centre point of map
	var centrePoint = new GLatLng(document.getElementById('lat').value, document.getElementById('long').value);
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
