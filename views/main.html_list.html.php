<body>
<h1>DOJO LIST</h1>
<hr>
<hr>

<?php foreach ($DojoList as $dojo) {

	
	
	foreach ($dojo as $key => $value) {
		// The following line skips fields if they are blank.
		if (!$value){continue;}

		// Display the email address as HTML link.
		if ($key =='DojoName') {
			print "<li>&nbsp;<a href='".url_for('view')."/$value'>$value</a></li>";
			continue;
		}
		
		// Display the email address as HTML link.
		if ($key =='ContactEmail') {
			print "<li>&nbsp; $key: <a href='mailto:$value'>$value</a></li>";
			continue;

		}

		// Display the email address as HTML link.
		if ($key =='ClubWebsite') {
			print "<li>&nbsp; $key: <a href='http://$value'>$value</a></li>";
			continue;
		}

		// Default: Display the key and Value for the fields
		print "<li>&nbsp; $key: $value</li>";
		

	}
	print '<p>&nbsp;</p>';
} ?>