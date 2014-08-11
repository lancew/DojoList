<h1>
    <?php echo _("Dojo Management System"); ?>
</h1>

<h2>Validation Error</h2>

<ul>
<?php
    foreach($Errors as $error) {
        echo "<li>$error</li>";
    
    }

?>
</ul>