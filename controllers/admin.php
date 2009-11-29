<?php




/**
 *
 *
 * @return unknown
 */


function admin_index() {
	if(isset($_COOKIE["user"])) {
		return html('admin/index.html.php');
	} else {
		return html('admin/index_login.html.php');
	}	


}


function admin_login() {
		if($_POST['password'] == option('password')){
			setcookie("user", "Alex Porter", time()+3600);
			return html('admin/index.html.php');
		} else {
			return html('admin/index_login.html.php');
		}
	
}

function admin_logout() {
	
		setcookie("user", "", time()-3600);
		return html('admin/index_login.html.php');
	
}




/**
 *
 *
 * @return unknown
 */
function admin_create() {
	return html('admin/create.html.php');
}




/**
 *
 *
 * @return unknown
 */
function admin_create_add() {
	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		halt('Failed to open dojo.xml.');
	}
	//print $xml->Dojo->ClubName;

	$new1 = $xml->addChild("Dojo");
	foreach ($_POST as $key => $value) {
		//print "$key has a value of $value<br />";
		$new1->addChild(strip_tags(addslashes($key)), strip_tags(addslashes($value)));
	}

	$DojoName = $_POST["DojoName"];
	//echo '<pre>'.$xml->asXML().'</pre>';

	$myFile = "data/dojo.xml";
	$fh = fopen($myFile, 'w') or die("can't open file");


	fwrite($fh, $xml->asXML());

	fclose($fh);
	set('DojoName', $DojoName);
	admin_create_kml();
	return render('admin/create_add.html.php');


}


function admin_edit() {
	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}

	$dojo_list = '';
	foreach ($xml->Dojo as $dojo) {
		$dojo_list[] =$dojo->DojoName;
	}
	//print_r($dojo_list);
	set('DojoList', $dojo_list);


	return html('admin/edit.html.php');
}

function admin_editform() {
	$DojoName = params('dojo');
	print $Dojoname;
	$Dojoname = str_replace('%20', ' ', $Dojoname);
	print $Dojoname;
	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}

	$dojo_data = '';
	foreach ($xml->Dojo as $dojo) {
		if($dojo->DojoName == $DojoName) {
			set('Dojo', $dojo);
			//set('DojoName', $dojo->DojoName);
			print($dojo);
		}
	}
	

	return html('admin/edit_form.html.php');
}


function admin_editform_end() {
	$DojoName = params('dojo');
	//print_r($_POST["DojoName"]);
	
	
	
	
	// Read in the XML data from file.
	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}
	
	//
	//   Add code here to edit the XML data.
	//
	
	
	$newxml = '<xml>
	<!-- The data created by DojoList by <a xmlns:cc="http://creativecommons.org/ns#" href="http://github.com/lancew/DojoList" property="cc:attributionName" rel="cc:attributionURL">Lance Wicks</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">Creative Commons Attribution-Noncommercial-Share Alike 2.0 UK: England &amp; Wales License</a>. -->';

	foreach ($xml->Dojo as $dojo) {
		// echo $dojo->ClubName, '<br />';

		if ($dojo->DojoName == $DojoName) {

			
			//print_r($_POST);
			foreach($_POST AS $field => $value) {
				unset($dojo->$field);
				//$dojo->addChild($field, $value);
				$dojo->addChild(strip_tags(addslashes($field)), strip_tags(addslashes($value)));
				
			}
			
			$newxml .= $dojo->asXML();
			
		} else {

			$newxml .= $dojo->asXML();
		}

	}


	$newxml .= '</xml>';

	$myFile = "data/dojo.xml";
	$fh = fopen($myFile, 'w') or die("can't open file");


	fwrite($fh, $newxml);

	fclose($fh);

	//print_r($newxml);
	set('DojoName', $DojoName);
	admin_create_kml();


	set('DojoName',$DojoName);
	return html('admin/edit_end.html.php');

}




/**
 *
 *
 * @return unknown
 */
function admin_delete() {
	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}

	$dojo_list = '';
	foreach ($xml->Dojo as $dojo) {
		$dojo_list[] =$dojo->DojoName;
	}
	//print_r($dojo_list);
	set('DojoList', $dojo_list);


	return html('admin/delete.html.php');
}



/**
 *
 *
 * @return unknown
 */
function admin_delete_end() {
	$DojoName = params('dojo');


	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}



	$newxml = '<xml>
	<!-- The data created by DojoList by <a xmlns:cc="http://creativecommons.org/ns#" href="http://github.com/lancew/DojoList" property="cc:attributionName" rel="cc:attributionURL">Lance Wicks</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">Creative Commons Attribution-Noncommercial-Share Alike 2.0 UK: England &amp; Wales License</a>. -->
	';

	foreach ($xml->Dojo as $dojo) {
		// echo $dojo->ClubName, '<br />';

		if ($dojo->DojoName == $DojoName) {

			//echo $DojoName.' deleting...<br />';



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
	admin_create_kml();
	return html('admin/delete_end.html.php');


}



/**
 *
 *
 * @return unknown
 */
function admin_create_kml() {
	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}

	$newKML = '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<!-- The data created by DojoList by <a xmlns:cc="http://creativecommons.org/ns#" href="http://github.com/lancew/DojoList" property="cc:attributionName" rel="cc:attributionURL">Lance Wicks</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">Creative Commons Attribution-Noncommercial-Share Alike 2.0 UK: England &amp; Wales License</a>. -->
<Document>
<name>Dojo List</name>';

	foreach ($xml->Dojo as $dojo) {
		$newKML .= '<Placemark>';
		$newKML .= '<name>'.$dojo->DojoName.'</name>';
		$newKML .= '<description><![CDATA[';
		foreach ($dojo as $key => $value) {
			switch ($key) {
				case 'ClubWebsite':
    				$newKML .= "$key: <a href='http://$value'>$value</a> <br />\n";
    				break;
				case 'ContactEmail':
    				$newKML .= "$key: <a href='mailto:$value'>$value</a> <br />\n";
    				break;
				
				default:
					$newKML .= "$key: $value <br />\n";
			
			
				
			}
			
			
			
			
		}

		$newKML .= ']]></description>';
		$newKML .= '<Point><coordinates>';
		$newKML .= $dojo->Longitude . ',' . $dojo->Latitude;
		$newKML .= '</coordinates></Point>';
		$newKML .= '</Placemark>';

	}


	$newKML .= '</Document></kml>';
	//print"<pre> $newKML </pre>";

	$myFile = "data/dojo.kml";
	$fh = fopen($myFile, 'w') or die("can't open file");


	fwrite($fh, $newKML);

	fclose($fh);


	return html('admin/create_kml.html.php');
}


?>