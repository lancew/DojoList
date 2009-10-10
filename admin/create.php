<?php
// The file test.xml contains an XML document with a root element
// and at least an element /[root]/title.

if (file_exists('dojo.xml')) {
	$xml = simplexml_load_file('dojo.xml');
} else {
	exit('Failed to open dojo.xml.');
}
//print $xml->Dojo->ClubName;
?>

<html> 
<head> 
<title>Create New Dojo</title> 
</head> 
<body> 
<h1>Create New Dojo</h1>
<p><a href="index.php">[Return to main]</a></p>
<?php 
if (!isset($_POST['submit'])) { 
?>

<form method="post" action="">

Club/Dojo Name: <input type="text" name="DojoName"><br />
Dojo Address: <input type="text" name="DojoAddress"><br />
Training Sessions: <input type="text" name="TrainingSessions"><br />
Contact Name: <input type="text" name="ContactName"><br />
Contact Phone Number: <input type="text" name="ContactPhone"><br />
Contact Email: <input type="text" name="ContactEmail"><br />
Coordinates:<br />
Latitude: <input type="text" name="Latitude"><br />
Longitude: <input type="text" name="Longitude"><p />
<input type="submit" value="submit" name="submit"><br />
</form><br />
<?php
print '<h2>Existing Dojos</h2>';
foreach ($xml->Dojo as $dojo) {
	echo $dojo->ClubName, '<br />';
}


} else {

$DojoName = $_POST["DojoName"];
$DojoAddress = $_POST["DojoAddress"];
$TrainingSessions = $_POST["TrainingSessions"];
$ContactName = $_POST["ContactName"];
$ContactPhone = $_POST["ContactPhone"];
$ContactEmail = $_POST["ContactEmail"];
$Latitude = $_POST["Latitude"];
$Longitude = $_POST["Longitude"];


$new1 = $xml->addChild("Dojo");
$new1->addChild('ClubName', $DojoName);
$new1->addChild('DojoAddress', $DojoAddress);
$new1->addChild('TrainingSessions', $TrainingSessions);
$new1->addChild('ContactName', $ContactName);
$new1->addChild('ContactPhone', $ContactPhone);
$new1->addChild('ContactEmail', $ContactEmail);
$new1->addChild('coordinates', "$Longitude,$Latitude");
//kml format is long,lat,0


//echo '<pre>'.$xml->asXML().'</pre>';

$myFile = "dojo.xml";
$fh = fopen($myFile, 'w') or die("can't open file");


fwrite($fh, $xml->asXML());

fclose($fh);
 print '<h3>Dojo Added</h3>';

}






?>
<?php include('footer.php'); ?>
</body>
</html>