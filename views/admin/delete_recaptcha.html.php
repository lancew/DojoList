<h1>
    <?php echo _("Dojo Management System"); ?>
</h1>

<p>
    <?php echo h($DojoName)?>: 
    <?php echo _("Complete the box below to delete this dojo."); ?>
</p>

<form 
    method="post" 
    action="" 
    name="delete_recaptcha"
>
<input 
    id="DojoName" 
    type="hidden" 
    name="DojoName" 
    value="<?php echo h($DojoName)?>"
>
<?php 
    echo recaptcha_get_html(option('recaptcha_public_key')); 
?>
<input 
    type="submit" 
    value="submit"
>
<br />
</form>