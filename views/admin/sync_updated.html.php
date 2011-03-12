<h2><?php echo _("Sync"); ?></h2>

<h2>Dojo in far updated:</h2>
<ul>
<?php
    foreach($Newlist as $dojo) {
        echo '<li>';
        echo $dojo;
        echo '</li>';
        
    }


?>
</ul>

<h3><a href="<?php echo url_for('/'); ?>">FINISH</a></h3>