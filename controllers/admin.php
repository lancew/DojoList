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
	
	$new1 = $xml->addChild("Dojo");
	foreach ($_POST as $key => $value)
		{
			//print "$key has a value of $value<br />";
			$new1->addChild($key, $value);
	}

	$DojoName = $_POST["DojoName"];
	//$CoachName = $_POST["CoachName"];
	//$MembershipID = $_POST["MembershipID"];
	//$DojoAddress = $_POST["DojoAddress"];
	//$TrainingSessions = $_POST["TrainingSessions"];
	//$ContactName = $_POST["ContactName"];
	//$ContactPhone = $_POST["ContactPhone"];
	//$ContactEmail = $_POST["ContactEmail"];
	//$Latitude = $_POST["Latitude"];
	//$Longitude = $_POST["Longitude"];

	#print $DojoName;

	//$new1 = $xml->addChild("Dojo");
	//$new1->addChild('ClubName', $DojoName);
	//$new1->addChild('CoachName', $CoachName);
	//$new1->addChild('MembershipID', $MembershipID);
	//$new1->addChild('DojoAddress', $DojoAddress);
	//$new1->addChild('TrainingSessions', $TrainingSessions);
	//$new1->addChild('ContactName', $ContactName);
	//$new1->addChild('ContactPhone', $ContactPhone);
	//$new1->addChild('ContactEmail', $ContactEmail);
	//$new1->addChild('coordinates', "$Longitude,$Latitude");
	#kml format is long,lat,0


	//echo '<pre>'.$xml->asXML().'</pre>';

	$myFile = "data/dojo.xml";
	$fh = fopen($myFile, 'w') or die("can't open file");


	fwrite($fh, $xml->asXML());

	fclose($fh);
	set('DojoName', $DojoName);
	return render('admin/create_add.html.php');
	#return html('admin/create_add.html.php');

}

function admin_delete() {
	if (file_exists('data/dojo.xml')) {
	$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}

	$dojo_list = '';
	foreach ($xml->Dojo as $dojo) {
		 $dojo_list[] =$dojo->ClubName;
	}
	#print_r($dojo_list);
	set('DojoList', $dojo_list);

	
	return html('admin/delete.html.php');
}

function admin_delete_end() {
	$DojoName = params('dojo');
	

	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}



	$newxml = '<xml>';

	foreach ($xml->Dojo as $dojo) {
  		// echo $dojo->ClubName, '<br />';

		if ($dojo->ClubName == $DojoName)

		{

			#echo $DojoName.' deleting...<br />';
		
		

		} else {
		
			$newxml .= $dojo->asXML();
		}

	} 


	$newxml .= '</xml>';

	$myFile = "data/dojo.xml";
	$fh = fopen($myFile, 'w') or die("can't open file");


	fwrite($fh, $newxml);

	fclose($fh);


	set('DojoName', $DojoName);
	return html('admin/delete_end.html.php');


}

function admin_create_kml() {
	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}
	
	$newKML = '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<Document>
<name>Dojo List</name>';

foreach ($xml->Dojo as $dojo) {
	$newKML .= '<Placemark>';
	$newKML .= '<name>'.$dojo->ClubName.'</name>';
	$newKML .= '<description>';
		$newKML .= $dojo->CoachName;
		$newKML .= $dojo->MembershipID;
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

$myFile = "data/dojo.kml";
$fh = fopen($myFile, 'w') or die("can't open file");


fwrite($fh, $newKML);

fclose($fh);


		return html('admin/create_kml.html.php');
}

