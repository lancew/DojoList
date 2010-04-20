<body>
<h1>DOJO LIST</h1>


<?php foreach ($DojoList as $dojo) {

	
	
	
        echo "<h2>&nbsp;<a href='".url_for('dojo')."/$dojo'>$dojo</a></h2>";
} ?>