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
<title>Create New KML File</title> 
</head> 
<body> 
<h1>Create New KML File</h1>
<p><a href="index.php">[Return to main]</a></p>

<?php
$newKML = '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<Document>
<name>Dojo List</name>';

foreach ($xml->Dojo as $dojo) {
	$newKML .= '<Placemark>';
	$newKML .= '<name>'.$dojo->ClubName.'</name>';
	$newKML .= '<description>';
		$newKML .= $dojo->DojoAddress;
		$newKML .= $dojo->TrainingSessions;
		$newKML .= $dojo->ContactName;
		$newKML .= $dojo->ContactPhone;
		$newKML .= $dojo->ContactEmail;
	$newKML .= '</description>';	
	$newKML .= '<Point><coordinates>';
		$newKML .= $dojo->coordinates;
	$newKML .= '</coordinates></Point>';
	$newKML .= '</Placemark>';	
	
}

	
$newKML .= '</Document></kml>';
//print $newKML;

$myFile = "../dojo.kml";
$fh = fopen($myFile, 'w') or die("can't open file");


fwrite($fh, $newKML);

fclose($fh);
 print '<h3>KML Created: <a href="../dojo.kml">dojo.kml</a></h3>'
	

?>
<?php include('footer.php'); ?>
</body>
</html>