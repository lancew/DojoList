<?php
/**
 * DojoList admin controller file
 *
 * This controller is for the main pages for the DojoList Application.
 *
 * PHP version 5
 *
 * LICENSE: please see the AGPL license file is data/agpl-3.0.txt
 *
 * @category  AdminController
 * @package   DojoList
 * @author    Lance Wicks <lw@judocoach.com>
 * @copyright 2009 Lance Wicks
 * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
 * @link      http://github.com/lancew/DojoList
 */

require_once 'lib/rss.php';
require_once 'lib/dojo.model.php';

/**
 * Admin Index - Displays the admin index page page
 *
 * @return unknown
 */
function Admin_index()
{
	if (isset($_COOKIE["user"])) {
		return html('admin/index.html.php');
	} else {
		return html('admin/index_login.html.php');
	}
}


/**
 * Admin Login - Login page
 *
 * @return unknown
 */
function Admin_login()
{
	if ($_POST['password'] == option('password')) {
		setcookie("user", "Alex Porter", time()+3600);
		return html('admin/index.html.php');
	} else {
		return html('admin/index_login.html.php');
	}
}


/**
 * Admin Logout - logs Admin out
 *
 * @return unknown
 */
function Admin_logout()
{
	setcookie("user", "", time()-3600);
	return html('admin/index_login.html.php');
}


/**
 * Admin Create - Displays create new dojo page
 *
 * @return unknown
 */
function Admin_create()
{
	return html('admin/create.html.php');
}


/**
 * Admin Create Add - writes dojo to XML file, then displays page saying job done.
 *
 * @return unknown
 */
function Admin_Create_add()
{


	if (!Validate_form($_POST)) {
		$resp = recaptcha_check_answer(
            option('recaptcha_private_key'),
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]
        );

		if ($resp->is_valid) {

			Create_dojo($_POST, $_FILES);
			$DojoName = clean_name($_POST["DojoName"]);
			set('DojoName', $DojoName);
			admin_create_kml();
			return render('admin/create_add.html.php');

		} else {
			// set the error code so that we can display it
			halt('Failed to add new Dojo: '.$resp->error);

		}
	} else {
		set('Errors', Validate_form($_POST));
		return render('admin/validation_error.html.php');
	}

}


/**
 * Admin Edit - Displays a page with a list of existing Dojo to edit
 *
 * @return unknown
 */
function Admin_edit()
{
	set('DojoList', Find_Dojo_all());
	return html('admin/edit.html.php');
}


/**
 * Admin Edit Form - Displays the edit form, showing Dojo with pre-existing data
 *
 * @return unknown
 */
function Admin_editform()
{
	$DojoName = params('dojo');
	$DojoName = str_replace('%20', ' ', $DojoName);
	$xml = Find_Dojo_all();
	$dojo_data = '';
	foreach ($xml->Dojo as $dojo) {
		if ($dojo->DojoName == $DojoName) {
			set('Dojo', $dojo);
			print($dojo);
		}
	}
	return html('admin/edit_form.html.php');
}


/**
 * Admin EditForm End - Writes changes from edit to XML file.
 *
 * @return unknown
 */
function Admin_Editform_end()
{
	if (!Validate_form($_POST)) {
		$resp = recaptcha_check_answer(
		    option('recaptcha_private_key'),
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]
        );
		if ($resp->is_valid) {

			$DojoName = params('dojo');
			$DojoName = str_replace('%20', ' ', $DojoName);

			$DojoOrigEmail ='';
			// Read in the XML data from file.
			$xml = Find_Dojo_all();
			$newxml = '<xml>
	<!-- The data created by DojoList by
	<a xmlns:cc="http://creativecommons.org/ns#"
	href="http://github.com/lancew/DojoList"
	property="cc:attributionName"
	rel="cc:attributionURL">Lance Wicks</a>
	 is licensed under a <a rel="license"
	 href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">
	 Creative Commons Attribution-Noncommercial-Share Alike 2.0
	 UK: England &amp; Wales License</a>.
	 Some data imported from www.judoworldmap.com by
	 Ulrich Wisser under a Creative Commons NC-SA License. -->';

			foreach ($xml->Dojo as $dojo) {
				if ($dojo->DojoName == $DojoName) {
					foreach ($_POST as $field => $value) {
						$DojoOrigEmail = $dojo->ContactEmail;
						unset($dojo->$field);
						if ($field != 'recaptcha_challenge_field' 
						    && $field != 'recaptcha_response_field' 
						    && $field != 'MAX_FILE_SIZE' 
						    && $field != 'delete_logo'
						) {
							$clean_field = strip_tags(addslashes($field));
							$clean_value = strip_tags(addslashes($value));
							$dojo->addChild($clean_field, $clean_value);
						}
						if ($field === 'delete_logo') {
							unset($dojo->DojoLogo);
						}
					}

                    // start of if ($_FILES... section, 
                    // encodes and adds an upload logo file

					if ($_FILES["DojoLogo"]["name"]) {
						unset($dojo->DojoLogo);
						if ((($_FILES["DojoLogo"]["type"] == "image/gif")
				            || ($_FILES["DojoLogo"]["type"] == "image/jpeg")
				            || ($_FILES["DojoLogo"]["type"] == "image/pjpeg")
				            || ($_FILES["DojoLogo"]["type"] == "image/png"))
				            && ($_FILES["DojoLogo"]["size"] < 20000)
				        ) {
							if ($_FILES["DojoLogo"]["error"] > 0) {
								halt(
								    "Error: " . 
								    $_FILES["DojoLogo"]["error"] . 
								    "<br />"
								);
							} else {

								$dojo->addChild(
								    'DojoLogo', 
								    'data:'.
								    $_FILES["DojoLogo"]["type"].
								    ';base64,'.
								    base64_encode(
								        file_get_contents(
								            $_FILES['DojoLogo']['tmp_name']
								        )
								    )
								);

							}
						}
					}

					// end of if ($_FILES... section.
					
					// Coach Photo section.
					if ($_FILES["CoachPhoto"]["name"]) {
						unset($dojo->CoachPhoto);
						if ((($_FILES["CoachPhoto"]["type"] == "image/gif")
				            || ($_FILES["CoachPhoto"]["type"] == "image/jpeg")
				            || ($_FILES["CoachPhoto"]["type"] == "image/pjpeg")
				            || ($_FILES["CoachPhoto"]["type"] == "image/png"))
							&& ($_FILES["CoachPhoto"]["size"] < 20000)
				        ) {
							if ($_FILES["CoachPhoto"]["error"] > 0) {
								halt(
								    "Error: " .
								    $_FILES["CoachPhoto"]["error"].
								    "<br />"
								);
							} else {

								$dojo->addChild(
								    'CoachPhoto', 
								    'data:'.
								    $_FILES["CoachPhoto"]["type"].
								    ';base64,'.
								    base64_encode(
								        file_get_contents(
								            $_FILES['CoachPhoto']['tmp_name']
								        )
								    )
								);

							}
						}
					}

					// Coach Photo section
					

					// update the Updated field
					date_default_timezone_set("UTC");
					$time = date("l, F d, Y h:i", time());
					$dojo->Updated = $time;


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

			$to      = $DojoOrigEmail;
			$subject =  _("A change has been made to ") .$DojoName;
			$html_dojoname = str_ireplace(' ', '%20', $DojoName);
			
			$message 
                = _("Hello, a change has been made to the listing for the dojo ").
            $DojoName.
            _(' which this email address was/is associated with. You can check the details by visiting '). 
            option('site_url').
            '/dojo/'.
            $html_dojoname;
			
			$headers = 'From: noreply@dojolist.org' . "\r\n";
			$message = wordwrap($message, 70);

			mail($to, $subject, $message, $headers);

			set('DojoName', $DojoName);
			admin_create_kml();
			set('DojoName', $DojoName);

			$source_url = 'http://'.$_SERVER['SERVER_NAME'].'/dojo/'.$DojoName;
			$description 
                = $DojoName.
                ' Dojo was updated. <a href="'.
                $source_url.
                '">'.
                $DojoName.
                '</a>';
			$rss_array = array('description' => $description);
			Add_rss_item($rss_array);

			return html('admin/edit_end.html.php');
		} else {
			// set the error code so that we can display it
			halt('Failed to edit Dojo: '.$resp->error);

		}
	} else {
		set('Errors', Validate_form($_POST));
		return render('admin/validation_error.html.php');
	}
}


/**
 * Admin Delete - Displays list of Dojo so user can choose one to delete.
 *
 * @return unknown
 */
function Admin_delete()
{
	$DojoName = params('dojo');
	set('DojoName', $DojoName);
	return html('admin/delete_recaptcha.html.php');
}


/**
 * Admin Delete End - Once dojo selected to be deleted, write changes to XML
 *
 * @return unknown
 */
function Admin_Delete_end()
{
	if ($_POST["recaptcha_response_field"]) {
		$DojoName = params('dojo');
		Delete_dojo($DojoName);
		set('DojoName', $DojoName);
		admin_create_kml();
		return html('admin/delete_end.html.php');
	} else {
		halt('no recaptcha provided');
	}

}


/**
 * Admin Create KML - Create the dojo.kml file
 *
 * @return unknown
 */
function Admin_Create_kml()
{
	$xml = Find_Dojo_all();

	$newKML = '<?xml version="1.0" encoding="UTF-8"?>
    <kml xmlns="http://www.opengis.net/kml/2.2">
	<!-- The data created by DojoList by
	<a xmlns:cc="http://creativecommons.org/ns#"
	href="http://github.com/lancew/DojoList"
	property="cc:attributionName"
	rel="cc:attributionURL">Lance Wicks</a>
	 is licensed under a <a rel="license"
	 href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">
	 Creative Commons Attribution-Noncommercial-Share Alike 2.0
	 UK: England &amp; Wales License</a>.
	 Some data imported from www.judoworldmap.com by
	 Ulrich Wisser under a Creative Commons NC-SA License. -->
    <Document>
    <name>Dojo List</name>';

	foreach ($xml->Dojo as $dojo) {
		$newKML .= '<Placemark>';
		$newKML .= '<name>'.$dojo->DojoName.'</name>';
		$newKML .= '<description><![CDATA[';

		$newKML 
            .= '<a href="'.
            option('site_url').
            '/dojo/'.
            $dojo->DojoName.
            '">View Details</a>';

		$newKML .= ']]></description>';
		$newKML .= '<Point><coordinates>';
		$newKML .= $dojo->Longitude . ',' . $dojo->Latitude;
		$newKML .= '</coordinates></Point>';
		$newKML .= '</Placemark>';
	}
	$newKML .= '</Document></kml>';
	$myFile = "data/dojo.kml";
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, $newKML);
	fclose($fh);
	return html('admin/create_kml.html.php');
}


/**
 * Admin_importjwm function.
 * 
 * @access public
 * @return void
 */
function Admin_importjwm()
{


	$ch = curl_init("http://judoworldmap.com/");
	$fp = fopen("data/jwm.txt", "w");

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);


	$raw_data = file_get_contents('data/jwm.txt');
	if (strpos($raw_data, 'This work is licensed under Creative Commons NC-SA')) {

		$data = get_string_between($raw_data, 'var icon17', 'new GIcon();');
		$data_array = explode('var icon', $data);
		echo '<?xml version="1.0" encoding="UTF-8" ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
		echo '<table border=1>';
		$loop=1;
		foreach ($data_array as $value) {
			//echo ".$value<br />";
			echo '<tr>';
			echo "<td>$loop</td>";
			$coords = get_string_between($value, 'GLatLng(', ')');
			$LatLng = explode(',', $coords);
			$url = get_string_between($value, 'http://', '\\"');
			$name = strip_tags(stripslashes(get_string_between($value, '<b>', '</b>')));
			$name = clean_name($name);



			$Lat = $LatLng[0];
			$Lng = $LatLng[1];


			echo "<td>$name</td><td width =50>$url</td><td>$Lat</td><td>$Lng</td>";


			$dojo = Find_dojo($name);

			if (!$dojo && $name) {
				echo "<td>NEW</td>";

				$dojo_array = array('DojoName' => $name, 'ClubWebsite' => $url, 'Latitude' => $Lat, 'Longitude' => $Lng, 'URL' => 'http://judoworldmap.com/' );
				//print_r($dojo_array);
				Create_dojo($dojo_array);
			} else {
				echo "<td>&nbsp;</td>";
			}

			echo "</tr>";
			$loop++;

		}
		echo '</table>';
		unlink('data/jwm.txt');
		admin_create_kml();

	} else {
		halt('CC License no longer on JWM site');
	}

}


/**
 * Admin_importBJA function.
 * 
 * @access public
 * @return void
 */
function Admin_importBJA()
{

	set_time_limit(0);
	$bja_url = 'http://www.britishjudo.org.uk/thesport/findclubresults.php';
	$select_field_name = 'hidRegion';
	$aAreas = array('ARMY', 'BJA IN SCHOOLS', 'BRISTOL CITY', 'BUCKS, BERKS AND OXON', 'CAMBRIDGESHIRE/PETERBOROU', 'DEVON AND CORNWALL', 'DORSET AND GLOS.', 'EAST MIDLANDS', 'EASTERN', 'ENJOY JUDO', 'ESSEX', 'GUERNSEY', 'HAMPSHIRE', 'HERTS AND BEDS', 'JERSEY', 'KENT', 'LANCASHIRE', 'LONDON', 'MIDDLESEX', 'MISCELLANEOUS', 'NORTHERN', 'NORTHERN IRELAND', 'NORTHWEST', 'SCOTLAND', 'SOMERSET AND WILTSHIRE', 'SURREY', 'SUSSEX', 'WALES', 'WEST MIDLANDS', 'WESTERN', 'YORKSHIRE AND HUMBERSIDE');

	foreach ($aAreas as $area) {

		echo $area.'<br>';
		$field = 'hidRegion=';

		$ch = curl_init($bja_url);
		$fp = fopen("data/bja.txt", "w");

		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $field.$area);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);

		$raw_data = file_get_contents('data/bja.txt');
		$data = get_string_between($raw_data, '<!-- InstanceBeginEditable name="PageContent" -->', '<!-- InstanceEndEditable --></td>');
		$data_array = explode('<table ', $data);
		$dojo_count = count($data_array);

		for ($i = 2; $i <= $dojo_count; $i++) {
			$d = $data_array[$i];

			//grab the data from the tables
			$name = strip_tags(stripslashes(get_string_between($d, 'colspan="3"><strong>', '</strong>')));
			$club_url = get_string_between($d, '><a href="http://', '">http:');
			$address = trim(get_string_between($d, 'Location:</strong></td>', '</td>'));
			$phone = trim(get_string_between($d, 'Phone:</strong></td>', '</td>'));
			$contact = trim(get_string_between($d, 'Contact name:</strong></td>', '</td>'));
			$email = get_string_between($d, '<a href="mailto:', '">');

			// clean up the name
			$name = clean_name($name);

			//Set up our variables
			$longitude = "";
			$latitude = "";
			$precision = "";

			//Three parts to the querystring: q is address, output is the format (
			$key = option('GoogleKey');
			$address2 = urlencode($address);
			$url = "http://maps.google.com/maps/geo?q=".$address2."&amp;output=json&amp;key=".$key;
			$ch2 = curl_init();
			curl_setopt($ch2, CURLOPT_URL, $url);
			curl_setopt($ch2, CURLOPT_HEADER, 0);
			curl_setopt($ch2, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
			curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($ch2);
			curl_close($ch2);
			$point = get_string_between($data, 'coordinates": [', ']');
			$latlong = explode(',', $point);
			$lat = trim($latlong[1]);
			$lng = trim($latlong[0]);
			$dojo = Find_dojo($name);

			if (!$dojo && $name) {
				echo "NEW:";
				$dojo_array = array('DojoName' => $name, 'ClubWebsite' => $club_url, 'DojoAddress' => $address, 'URL' => 'http://www.britishjudo.org.uk/thesport/findclubresults.php', 'ContactPhone' => $phone, 'ContactName' => $contact, 'ContactEmail' => $email, 'Latitude' => $lat, 'Longitude' => $lng, 'GUID' => guid() );
				//print_r($dojo_array);
				Create_dojo($dojo_array);
				echo '<br>';
			} else {
				echo ".";
			}
		}
	}


	admin_create_kml();
	unlink('data/bja.txt');

}


/**
 * Admin_importUSJA function.
 * 
 * @access public
 * @return void
 */
function Admin_importUSJA()
{
	set_time_limit(0);


	for ( $id = 6501; $id <= 7000; $id++) {
		//sleep (1);
		$usja_url = 'http://usjamanagement.com/public/charteredClubs/clubDetail.asp?clubID='.$id;
		$club_url = str_ireplace('http://', '', $usja_url);
		$html = file_get_contents($usja_url);
		$data = explode('</td>', $html);



		$name = htmlspecialchars_decode($data[0]);
		$name = clean_name(strip_tags($name));
		$name = str_ireplace(' and nbsp;', '', $name);
		$name = str_ireplace('\n', '', $name);
		$name = str_ireplace('\t', '', $name);
		$name = str_ireplace('  ', ' ', $name);
		$name = trim($name);

		$address = strip_tags($data[1].' '.$data[2]);
		$address = str_ireplace('\n', '', $address);
		$address = str_ireplace('\t', '', $address);

		$address = htmlspecialchars_decode($address);
		$address = str_ireplace('&nbsp;', ' ', $address);
		$address = str_replace(array("\n", "\r", "\t", "  ", "\o", "\xOB"), '', $address);
		$address = trim($address);
		//echo '<pre>';
		//var_dump($address);
		//echo '</pre>';


		$short_addy = strip_tags(trim($data[2]));

		$phone = strip_tags($data[3]);

		$email = get_string_between($data[6], "<a href='mailto:", "'><font");


		//Three parts to the querystring: q is address, output is the format (
		$key = option('GoogleKey');
		$address2 = urlencode($address);
		$url = "http://maps.google.com/maps/geo?q=".$address2."&amp;output=json&amp;key=".$key;
		$ch2 = curl_init();
		curl_setopt($ch2, CURLOPT_URL, $url);
		curl_setopt($ch2, CURLOPT_HEADER, 0);
		curl_setopt($ch2, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
		curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch2);
		//echo $data;
		curl_close($ch2);
		$status = get_string_between($data, '"code": ', ',');
		if ($status === '200') {
			$point = get_string_between($data, 'coordinates": [', ']');
			$latlong = explode(',', $point);
			$lat = trim($latlong[1]);
			$lng = trim($latlong[0]);


			$dojo = Find_dojo($name);

			if (!$dojo) {
				echo " $name ";
				$dojo_array = array('DojoName' => $name, 'DojoAddress' => $address, 'ClubWebsite' => $club_url, 'URL' => $usja_url, 'ContactEmail' => $email, 'Latitude' => $lat, 'Longitude' => $lng, 'GUID' => guid() );
				//print_r($dojo_array);
				Create_dojo($dojo_array);
				echo '<br>';

			} else {
				echo ".";

			}
		} else {
			echo 'x';
        }


	}

}


/**
 * Admin_importUSAJUDO function.
 * 
 * @access public
 * @return void
 */
function Admin_importUSAJUDO()
{
	// http://www.usjudo.org/documents/websiteclubs.pdf
	echo 'Importing USJA Judo club list...';
	$data = file_get_contents('USAJUDOClubs.txt');

	$data = explode("\n", $data);

	$count = count($data);
	echo $count.'<br />';

	$count = 1;
	$temp_name = null;
	$temp_address = null;
	foreach ($data as $item) {


		if ($count === 1) {
			$temp_name = $item;

		}
		if ($count === 2) {
			$temp_address = $item;

			$phone = null;
			$email = null;
			$address = null;
			$contact = get_string_between($item, 'Contact: ', ' Phone:');
			$regex = '/\(?\d{3}\)?[-\s.]?\d{3}[-\s.]\d{4}/x';
			if (preg_match($regex, $item, $regs)) {
				$phone = $regs[0];
			}



			$regex = '/[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/';
			if (preg_match($regex, $item, $regs)) {
				$email = trim($regs[0]);
			}

			$regex = '/^.*Contact/';
			if (preg_match($regex, $item, $regs)) {
				$address = trim($regs[0]);
				$address = str_ireplace(' Contact', '', $address);
			}

			$name = clean_name(strip_tags($temp_name));
			/*
            echo $name;
            echo ':';
            echo $contact;
            echo ':';
            if($phone){echo $phone;}
            echo ':';
            if($email){echo $email;}
            echo ':';
            if($address){echo $address;}
            echo '<br />';
            */


			// Now we have all the data, 
			// lets check if the dojo exists and add it if it does not.

			//Three parts to the querystring: q is address, 
			// output is the format (
			$key = option('GoogleKey');
			$address2 = urlencode($address);
			$url = "http://maps.google.com/maps/geo?q=".$address2."&amp;output=json&amp;key=".$key;
			$ch2 = curl_init();
			curl_setopt($ch2, CURLOPT_URL, $url);
			curl_setopt($ch2, CURLOPT_HEADER, 0);
			curl_setopt($ch2, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
			curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($ch2);
			//echo $data;
			curl_close($ch2);
			$status = get_string_between($data, '"code": ', ',');
			if ($status === '200') {
				$point = get_string_between($data, 'coordinates": [', ']');
				$latlong = explode(',', $point);
				$lat = trim($latlong[1]);
				$lng = trim($latlong[0]);


				$dojo = Find_dojo($name);

				if (!$dojo) {
					echo " $name ";
					$dojo_array = array('DojoName' => $name, 'DojoAddress' => $address, 'URL' => 'http://www.usjudo.org/documents/websiteclubs.pdf', 'ContactEmail' => $email, 'Latitude' => $lat, 'Longitude' => $lng, 'GUID' => guid() );
					//print_r($dojo_array);
					Create_dojo($dojo_array);
					echo '<br>';

				} else {
					echo ".";

				}
			} else {
				echo 'x';
            }







			$count = 0;
		}
		$count++;

	}
}

/**
 * Admin_import_NZJF function.
 * 
 * @access public
 * @return void
 */
function Admin_Import_nzjf()
{
    // http://judonz.org/front/index.php?option=com_content&view=article&id=18
    // id ranges from 16 through to 23.
    // Start of clubs: <div>ONLY THE CLUBS LISTED BELOW ARE CURRENTLY AFFILIATED TO JUDO NEW ZEALAND</div>
    // End of clubs: <!--EOF content section -->
    echo '<h1>Import NZJF</h1>';

    for ( $id = 16; $id <= 23; $id++) {
        $url = 'http://judonz.org/front/index.php?option=com_content&view=article&id='.$id;
	    $html = file_get_contents($url);
	    $data 
	        = get_string_between(
	            $html,
	            '<div>ONLY THE CLUBS LISTED BELOW ARE CURRENTLY AFFILIATED TO JUDO NEW ZEALAND</div>',
	            '<!--EOF content section -->'
	        );
	
	
	    // Having got data for the area, explode out each club then loop through them.
	    $aClub = explode('<div style="width:100%;background-color:#999;">', $data);
	    array_shift($aClub);
	    foreach ($aClub as $club) {
	        $name 
                = clean_name(
                    get_string_between(
	                    $club,
	                    '<div style="float:left;margin-left:5px;"><strong>',
	                    '</strong></div>'
                    )
                );
	   
	        $dojo = Find_dojo($name);
	        if (!$dojo) {
	   
	   
	            $address 
	                = trim(
	                    strip_tags(
	                        get_string_between(
	                            $club, 
	                            '<div style="float:left;width:37px;">dojo:</div>',
	                            '</div>'
                            )
                        )
                    );
	   
                $address .= ', New Zealand';
	       
                //Three parts to the querystring: q is address, output is the format (
                $key = option('GoogleKey');
                $address2 = urlencode($address);
                $mapurl = "http://maps.google.com/maps/geo?q=".$address2."&amp;output=json&amp;key=".$key;
                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $mapurl);
                curl_setopt($ch2, CURLOPT_HEADER, 0);
                curl_setopt($ch2, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
                curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
                $data = curl_exec($ch2);
                //echo $data;
                curl_close($ch2);
                $status = get_string_between($data, '"code": ', ',');
                if ($status === '200') {
				    $point = get_string_between($data, 'coordinates": [', ']');
				    $latlong = explode(',', $point);
				    $lat = trim($latlong[1]);
				    $lng = trim($latlong[0]);
	            }

	            $dojo_array = array(
                'DojoName' => $name, 
                'DojoAddress' => $address, 
                'URL' => $url,  
                'Latitude' => $lat, 
                'Longitude' => $lng, 
                'GUID' => guid() 
                );
			
                Create_dojo($dojo_array);
			
            } else {
                echo "* $name exists in database<br>";
            }
        }
    }
}


/**
 * Admin_importNSW function.
 * 
 * @access public
 * @return void
 */
function Admin_importNSW()
{
    echo '<h1>Import Judo NSW Dojo</h1>';
    // http://www.judonsw.com.au./index.php?option=com_content&view=article&id=49&Itemid=57
    $url = 'http://www.judonsw.com.au./index.php?option=com_content&view=article&id=49&Itemid=57';
    $data = file_get_contents($url);
    //print_r($data);
    $data = iconv("UTF-8", "ISO-8859-1//IGNORE", $data);
    //print_r($data);
    
    $data = get_string_between(
        $data, 
        'Judo Federation Of Australia (NSW) Member Clubs',
        '<td class="modifydate">'
    );
        //print_r($data);
        $aData = explode('<tr>', $data);
        array_shift($aData);
        array_shift($aData);
        //print_r($aData);
        foreach ($aData as $dojo)
        {
            
            //print_r($dojo);
            $dojo = str_ireplace('&#xD;', '', $dojo);
            $details = explode('<br />', $dojo);    
            // print_r($details);   
            $name = clean_name(trim(strip_tags($details[0])));
            $name = str_ireplace('&#xD;', '', $name);
            
           
            if(!find_dojo($name))
            {
                $address = $details[1].', NSW, Australia';
                $address = str_ireplace('&#xD;','',$address);
            
                $latlng = geoAddress($address);
            
                $email = get_string_between($dojo, '"mailto:', '"');
                $website = get_string_between($dojo, '<a href="http://','"');
                $website = rtrim($website, "/");
            
                /*
                echo '<br />';
                echo $name;
                echo '<br />';
                echo $latlng[0];
                echo '<br />';
                echo $latlng[1];
                echo '<br />';
                echo $email;
                echo '<br />';
                echo $website;
                echo '<hr>'; 
                */ 

                if($latlng[0] && $latlng[1])
                {
                    $dojo_array = array(
                    'DojoName' => $name, 
                    'DojoAddress' => $address, 
                    'URL' => $url, 
                    'Latitude' => $latlng[0], 
                    'Longitude' => $latlng[1], 
                    'ClubWebsite' => $website,
                    'GUID' => guid() 
                    );
                
				    //print_r($dojo_array);
				    Create_dojo($dojo_array);
				    echo "$name created<br>";
				}


            
            } else {
                echo "$name exists already<br>";            
            }
           
          }


}


function Admin_import_JudoSA(){
    // http://www.judosa.com.au/html/clubloc.cfm
    // Australian South Australia website
    
    echo '<h1>Import Judo SA Dojo</h1>';
    
    $url = 'http://www.judosa.com.au/html/clubloc.cfm';
	$data = file_get_contents($url);
	$data = get_string_between($data, 'Download in Word Format:', '</BODY>');
	$data = explode('<I><B>', $data);
	// Shift the junk off the top of the array first.
	array_shift($data);
	foreach($data as $dojo){
	   $fields = explode('<FONT CLASS="field">', $dojo);
	   
	   $name = trim(clean_name(strip_tags($fields[0])));
	   
	   $dojo = Find_dojo($name);
	   
	   if(!$dojo) {
   
	   $address = trim($fields[1]).' Australia';
	   $address = str_ireplace('Location:', '', $address);
	   $address = str_ireplace("/r", ",", $address);
	   $address = str_ireplace("/n", ",", $address);
	   $address = str_ireplace('<br>', ',', $address);	
	   $address = strip_tags($address);   
	   $address = ltrim($address, ',');
	   
	   $email_address = get_string_between($dojo, 'mailto:', '"');
	   $web_address = get_string_between($dojo, 'http://', '"');
	   $web_address = rtrim($web_address, '/');
	   
	   $aLatLng = geoAddress($address);
	   if($aLatLng){	   
	   	   echo " $name ";
               $dojo_array = array(
                    'DojoName' => $name, 
                    'DojoAddress' => $address, 
                    'URL' => $url, 
                    'Latitude' => $aLatLng[0], 
                    'Longitude' => $aLatLng[1], 
                    'GUID' => guid() 
                    );
				//print_r($dojo_array);
				Create_dojo($dojo_array);
				echo '<br>';
				}
        } else {
            echo ".";
        }
	   }
	
}


function Admin_importJudoBC()
{
	// http://174.120.241.98/~judobc/locator/store_info.php?store=1
	set_time_limit(0);

	for ( $id = 1; $id <= 50; $id++) {
		$url = 'http://174.120.241.98/~judobc/locator/store_info.php?store='.$id;
		$data = file_get_contents($url);
		$name = get_string_between($data, '<div class="txtsubheader">', '</div>');
		$address = get_string_between($data, '<strong>To:</strong> ', '<p>');
		$address = trim($address);
		$website = get_string_between($data, "<a class='smalltxt altaltlink' href=", "' target=");
		$website = str_ireplace("'http://", '', $website);
		$website = rtrim($website, "/");



		/*
        echo $name;
        echo ':';
        echo $address;
        echo ':';
        echo $website;
        echo '<br />';
        */

		//Three parts to the querystring: q is address, output is the format (
		$key = option('GoogleKey');
		$address2 = urlencode($address);
		$url = "http://maps.google.com/maps/geo?q=".$address2."&amp;output=json&amp;key=".$key;
		$ch2 = curl_init();
		curl_setopt($ch2, CURLOPT_URL, $url);
		curl_setopt($ch2, CURLOPT_HEADER, 0);
		curl_setopt($ch2, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
		curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch2);
		//echo $data;
		curl_close($ch2);
		$status = get_string_between($data, '"code": ', ',');
		if ($status === '200') {
			$point = get_string_between($data, 'coordinates": [', ']');
			$latlong = explode(',', $point);
			$lat = trim($latlong[1]);
			$lng = trim($latlong[0]);


			$dojo = Find_dojo($name);

			if (!$dojo) {
				echo " $name ";
				$dojo_array = array('DojoName' => $name, 'DojoAddress' => $address, 'URL' => $url, 'Latitude' => $lat, 'Longitude' => $lng, 'GUID' => guid() );
				//print_r($dojo_array);
				Create_dojo($dojo_array);
				echo '<br>';

			} else {
				echo ".";

			}
		} else
			echo 'x';


	}

}


function Admin_import_judo_alberta()
{
	$url = 'http://www.judoalberta.com/clubdirectory.shtml';
	$data = file_get_contents($url);
	$data = get_string_between($data, '<h1>Club Directory</h1>', '<div id="footerbg">');
	$data = explode('<!--START CLUB-->', $data);
	array_shift($data);
	echo "Importing ".count($data)." Judo Alberta clubs...<br>";

	foreach ($data as $dojo) {
		$name = get_string_between($dojo, '<h2>', '</h2>');
		$address = get_string_between($dojo, 'Club Address:</strong> ', '<br />');
		$contact = get_string_between($dojo, 'Sensei:</strong> ', '<br />');

		$email = get_string_between($dojo, 'href="mailto:', '">');

		$website = get_string_between($dojo, 'href="http://', '/"');

		/*
        echo $name;
        echo ':';
        echo $address;
        echo ':';
        echo $contact;
        echo ':';
        echo $email;
        echo ':';
        echo $website;
        echo ':';

        echo'<br>';
        */

		//Three parts to the querystring: q is address, output is the format (
		$key = option('GoogleKey');
		$address2 = urlencode($address);
		$url = "http://maps.google.com/maps/geo?q=".$address2."&amp;output=json&amp;key=".$key;
		$ch2 = curl_init();
		curl_setopt($ch2, CURLOPT_URL, $url);
		curl_setopt($ch2, CURLOPT_HEADER, 0);
		curl_setopt($ch2, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
		curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch2);
		//echo $data;
		curl_close($ch2);
		$status = get_string_between($data, '"code": ', ',');
		if ($status === '200') {
			$point = get_string_between($data, 'coordinates": [', ']');
			$latlong = explode(',', $point);
			$lat = trim($latlong[1]);
			$lng = trim($latlong[0]);


			$dojo = Find_dojo($name);

			if (!$dojo) {
				echo " $name ";
				$dojo_array = array('DojoName' => $name, 'DojoAddress' => $address, 'ClubWebsite' => $website, 'ContactEmail' => $email, 'URL' => 'http://judonz.org', 'Latitude' => $lat, 'Longitude' => $lng, 'GUID' => guid() );
				//print_r($dojo_array);
				Create_dojo($dojo_array);
				echo '<br>';

			} else {
				echo ".";

			}
		} else
			echo 'x';



	}



}


function sync()
{
 
 $NewInFar = DojoNotInLocal(option('sync_site'));
 $Newlist[]='No new in far site data';
 $UpdatedInFar = NewerFarDojo(option('sync_site'));
 set('NewInFar', $NewInFar);
 set('UpdatedInFar', $UpdatedInFar);
 
 return html('admin/sync.html.php');

}

function sync_new()
{
    $Newlist = ListDojoNotInLocal(option('sync_site'));
    set('Newlist', $Newlist); 
    return html('admin/sync_new.html.php');

}


function sync_updated()
{
    $Newlist = ListNewerFarDojo(option('sync_site'));
    set('Newlist', $Newlist); 
    return html('admin/sync_updated.html.php');

}


?>