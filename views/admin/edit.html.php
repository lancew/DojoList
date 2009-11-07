<ul>
<?php foreach ($DojoList as $dojo) { ?>
  <li>
    <?php echo $dojo[0]; ?> <a href="<?=url_for('admin','edit',$dojo[0])?>">[Edit]</a>
  </li>
<?php } ?>
</ul>


