<ul>
<?php foreach ($DojoList as $dojo) { ?>
  <li>
    <?=h($dojo->DojoName)?> <a href="<?=url_for('admin','edit',h($dojo->DojoName))?>">[Edit]</a>
  </li>
<?php } ?>
</ul>


