<script type="text/javascript">
window.onload=dofo;
function dofo() {
document.login.password.focus();
}

</script>

<form method="post" action="<?=url_for('admin','login')?>" name="login">

PASSWORD: <input type="password" name="password">

<input type="submit" value="submit"><br />
</form>


