<script type="text/javascript">
window.onload=dofo;
function dofo() {
document.login.password.focus();
}

</script>

<form method="post" action="<?php echo url_for('admin', 'login')?>" name="login">

<?php echo _("PASSWORD:"); ?> <input type="password" name="password">

<input type="submit" value="submit"><br />
</form>
