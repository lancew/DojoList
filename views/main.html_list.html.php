<body>
<h1>DOJO LIST</h1>
<h2><?php echo _("Number of Dojo:"); echo Count_dojo(); ?></h2>

<?php foreach ($DojoList as $dojo) {

	
	
	
        echo "<h2>&nbsp;<a href='".url_for('dojo')."/$dojo'>$dojo</a></h2>";
} ?>