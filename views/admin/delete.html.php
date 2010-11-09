<ul>
<?php 
foreach ($DojoList as $dojo) {
    ?>

        <li>
            <?php echo $dojo[0]; ?> 
            <a href="<?php echo url_for('admin', 'delete', $dojo[0])?>">
            <?php echo _("[Delete]"); ?>
            </a>
        </li>
    <?php 
} 
?>
</ul>
