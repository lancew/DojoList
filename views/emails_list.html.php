<body>
<h1>DOJO LIST</h1>
<h2>Emails</h2>


<?php
 $DojoList = array_unique($DojoList);
 echo '<h2>'.count($DojoList).' emails in the data.</h2>';

 foreach ($DojoList as $dojo) {

	
	
	
        echo "$dojo,".'<br />';
} ?>
