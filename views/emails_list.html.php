<body>
<h1>DOJO LIST</h1>
<h2>Emails</h2>


<?php
 $DojoList = array_unique($DojoList);
 echo count($DojoList).'<br />';

 foreach ($DojoList as $dojo) {

	
	
	
        echo "$dojo,".'<br />';
} ?>
