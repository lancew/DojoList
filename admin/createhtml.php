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
<title>Create New HTML File</title> 
</head> 
<body> 
<h1>Create New HTML Club List File</h1>
<p><a href="index.php">[Return to main]</a></p>

<?php
$newKML = '<html>
<body>
<h1>Judo Clubs in Hampshire.</h1>
<ul>';




foreach ($xml->Dojo as $dojo) {
	$newKML .= '<li>';
	$newKML .= '<h2>'.$dojo->ClubName.'</h2>';
	$newKML .= '<ul>';
		$newKML .= '<li>Address: '.$dojo->DojoAddress.'</li>';
		$newKML .= '<li>Training Sessions: '.$dojo->TrainingSessions.'</li>';
		$newKML .= '<li>Contact Name: '.$dojo->ContactName.'</li>';
		$newKML .= '<li>Contact Telephone Number: '.$dojo->ContactPhone.'</li>';
		$newKML .= '<li>Contact Email: <a href="mailto:'.$dojo->ContactEmail.'">'.$dojo->ContactEmail.'</a></li>';
	$newKML .= '</ul>';	
	//$newKML .= '<Point><coordinates>';
	//	$newKML .= $dojo->coordinates;
	//$newKML .= '</coordinates></Point>';
	$newKML .= '</li>';	
	
}

	
$newKML .= '</ul></body></html>';






//print $newKML;








$myFile = "clubs.html";
$fh = fopen($myFile, 'w') or die("can't open file");


fwrite($fh, $newKML);

fclose($fh);
 print '<h3>KML Created: <a href="clubs.html">clubs.html</a></h3>'
	

?>
<?php include('footer.php'); ?>
</body>
</html>