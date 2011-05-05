<h1>
    <?php echo _("Dojo Management System"); ?>
</h1>

<p>
    <?php echo h($DojoName)?> 
    <?php echo _("Dojo Added"); ?>
</p>

<a href="<?php echo url_for('dojo', $DojoName)?>">
<?php echo _("CONTINUE"); ?>
</a>