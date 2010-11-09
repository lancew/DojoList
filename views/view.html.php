<body>

<?php

foreach ($Dojo as $key => $value) {
	// The following line skips fields if they are blank.
	if (!$value) {
	    continue;
    }

	// Skip display of the GUID
	if ($key =='GUID' or $key =='URL') {
		continue;

	}

	// Display the email address as HTML link.
	if ($key =='DojoName') {
		print "<h1>$value</h1>";
		continue;

	}

	if ($key =='ContactEmail') {
		print "<li>&nbsp; $key: <a href='mailto:$value'>$value</a></li>";
		continue;

	}

	// Display the email address as HTML link.
	if ($key =='ClubWebsite') {
		print "<li>&nbsp; $key: <a href='http://$value'>$value</a></li>";
		continue;
	}

	if ($key =='DojoLogo') {

		echo '<img alt="'.$Dojo->DojoName.'"
  src="'.$Dojo->DojoLogo.'" />';

		continue;
	}

	// Default: Display the key and Value for the fields
	print "<li>&nbsp; $key: $value</li>";


}
print '<p>&nbsp;</p>';
?>

  <body onload="initialize()">
    <div id="mapstraction"></div>
    <script src="http://maps.google.com/maps?file=api&v=2&key=
    <?php echo option('GoogleKey') ?>
    " type="text/javascript">
    </script>
    <script type="text/javascript" src="/
    <?php echo option('js_dir') ?>
    /mapstraction.js">
    </script>
    <style type="text/css">
        #mapstraction {
            height: 250px;
            width: 250px;
        }
    </style>

    <script type="text/javascript">
      // initialise the map with your choice of API
        var mapstraction = new Mapstraction('mapstraction','openstreetmap');

        var myPoint = new LatLonPoint(<?php echo $Dojo->Latitude
                                        .','
                                        .$Dojo->Longitude; ?>);
        // display the map centered on a latitude and longitude (Google zoom levels)
        mapstraction.setCenterAndZoom(myPoint, 9);
        mapstraction.addControls({zoom: 'small'});

        	     mapstraction.setCenterAndZoom(myPoint, 12);

        // create a marker positioned at a lat/lon
        var marker = new Marker(myPoint);

        // display marker
	    mapstraction.addMarker(marker);



    </script>

    <p />&nbsp;<p />
    <a href="<?php echo url_for('dojo', $Dojo->DojoName, 'edit'); ?>">
    <?php echo _("[EDIT DOJO]"); ?></a>
    - <a href="<?php echo url_for('dojo', $Dojo->DojoName, 'delete'); ?>">
    <?php echo _("[DELETE DOJO]"); ?>
    </a>
