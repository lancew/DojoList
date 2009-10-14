<ul>
<?php foreach ($DojoList as $dojo) { ?>
  <li>
    <?php echo $dojo[0]; ?> <a href="/admin/delete/<?php echo $dojo[0]; ?>">[Delete]</a>
    
 
  </li>
<?php } ?>
</ul>