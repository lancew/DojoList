<?php


function admin_index() {
	return html('admin/index.html.php');
}



function admin_create() {
	return html('admin/create.html.php');
}



function admin_create_add() {

	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		halt('Failed to open dojo.xml.');
	}
	//print $xml->Dojo->ClubName;

	$DojoName = $_POST["DojoName"];
	$DojoAddress = $_POST["DojoAddress"];
	$TrainingSessions = $_POST["TrainingSessions"];
	$ContactName = $_POST["ContactName"];
	$ContactPhone = $_POST["ContactPhone"];
	$ContactEmail = $_POST["ContactEmail"];
	$Latitude = $_POST["Latitude"];
	$Longitude = $_POST["Longitude"];

	#print $DojoName;

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

	//$myFile = "dojo.xml";
	//$fh = fopen($myFile, 'w') or die("can't open file");


	//fwrite($fh, $xml->asXML());

	//fclose($fh);
	return html('admin/create_add.html.php');

}