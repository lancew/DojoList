<?php
// The file test.xml contains an XML document with a root element
// and at least an element /[root]/title.

if (file_exists('dojo.xml')) {
	$xml = simplexml_load_file('dojo.xml');
} else {
	exit('Failed to open dojo.xml.');
}
?>

<html> 
<head> 
<title>Delete Dojo</title> 
</head> 
<body> 
<h1>Delete Dojo</h1>
<p><a href="index.php">[Return to main]</a></p>

<?php 
if (!isset($_POST['submit'])) { 

print '<h2>Existing Dojos</h2>';
foreach ($xml->Dojo as $dojo) {
	?> 
	<form method="post" action="">
	<input type="hidden" name="DojoName" value="<?php echo $dojo->ClubName ?>">
	<input type="submit" value="Delete <?php echo $dojo->ClubName ?>" name="submit">
	</form>
	<?php
}

?>


<?php


} else {
$DojoName = $_POST["DojoName"];
print '<h2>Deleting dojo: "'.$DojoName.'"</h2>';


$newxml = '<xml>';

foreach ($xml->Dojo as $dojo) {
  // echo $dojo->ClubName, '<br />';

	if ($dojo->ClubName == $DojoName)

	{

		echo $DojoName.' deleting...<br />';
		
		

	} else {
	//print '.';
	$newxml .= $dojo->asXML();
	}

} 


$newxml .= '</xml>';
//print '<p /><pre>';
//print $newxml;
//print '</pre>';
$myFile = "dojo.xml";
$fh = fopen($myFile, 'w') or die("can't open file");


fwrite($fh, $newxml);

fclose($fh);

print '<h4>Dojo Deleted</h4>';
print '<a href="delete.php">Return</a>'; 
 
}






?>
<?php include('footer.php'); ?>
</body>
</html>