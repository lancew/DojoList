<ul>
    <?php 
foreach ($DojoList as $dojo) { 
    ?>
    <li>
        <?php 
        echo h($dojo->DojoName)?> 
        <a href="<?php echo url_for('admin', 'edit', h($dojo->DojoName))?>">
            <?php echo _("[Edit]"); ?>
        </a>
    </li>
    <?php 
} 
    ?>
</ul>
