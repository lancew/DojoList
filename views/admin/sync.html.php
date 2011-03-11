<h2><?php echo _("Sync"); ?></h2>

<p>Number of Dojo in far site that are not in the local database: <?php echo h($NewInFar); ?></p>
<p>Number of Dojo in far site that are more up to date than the local database: <?php echo h($UpdatedInFar); ?></p>

<h3><a href="<?php
                if($NewInFar){
                    echo url_for('admin', 'sync_new');
                } else {
                    echo url_for('admin', 'sync_updated');
                }
            ?>
            ">NEXT</a></h3>