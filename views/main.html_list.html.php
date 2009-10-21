<body>
<h1>DOJO LIST</h1>
<hr>
<hr>
<ul>
<?php foreach ($DojoList as $dojo) { 

		 foreach ($dojo as $key => $value)
		{
			print "<li>&nbsp; $key: $value</li>";
		} 
  ?><hr><?php
 } ?>
</ul>


