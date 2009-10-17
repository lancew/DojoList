<body>
<h1>DOJO LIST</h1>

<ul>
<?php foreach ($DojoList as $dojo) { ?>
  <li><?php echo $dojo->ClubName; ?></li>
    <ul>
    <li>&nbsp;<?php echo $dojo->DojoAddress; ?></li>
    </ul>
 
  
<?php } ?>
</ul>