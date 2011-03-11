<h2><?php echo _("Sync"); ?></h2>

<p>Number of Dojo in far site that are not in the local database: <?php echo h($NewInFar); ?></p>
<ul>
    <?php
    foreach($Newlist as $dojo) {
        echo '<li>';
        echo $dojo;
        echo '</li>';
    
    }
    
    ?>


</ul>


<p>Number of Dojo in far site that are more up to date than the local database: <?php echo h($UpdatedInFar); ?></p>