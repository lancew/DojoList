<body>
<h1>DOJO LIST</h1>
<hr>
<hr>

<?php foreach ($DojoList as $dojo) {

	foreach ($dojo as $key => $value) {


		if ($key =='ContactEmail') {
			print "<li>&nbsp; $key: <a href='mailto:$value'>$value</a></li>";
			continue;

		}


		if ($key =='ClubWebsite') {
			print "<li>&nbsp; $key: <a href='http://$value'>$value</a></li>";
			continue;
		}

		print "<li>&nbsp; $key: $value</li>";

	}
	print '<p>&nbsp;</p>';
} ?>