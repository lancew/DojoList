<h2><?php echo _("Sync"); ?></h2>

<h2>Dojo in far to be imported:</h2>
<ul>
<?php
    foreach($Newlist as $dojo) {
        echo '<li>';
        echo $dojo;
        echo '</li>';
        
    }


?>
</ul>

<h3><a href="<?php echo url_for('admin', 'sync_updated'); ?>">NEXT</a></h3>