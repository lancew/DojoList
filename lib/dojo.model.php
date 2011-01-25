<?php
/**
 * DojoList Dojo Model file
 *
 * This file is the model for Dojo in the DojoList Application.
 *
 * PHP version 5
 *
 * LICENSE: please see the AGPL license file is data/agpl-3.0.txt
 *
 * @category  DojoModel
 * @package   DojoList
 * @author    Lance Wicks <lw@judocoach.com>
 * @copyright 2009 Lance Wicks
 * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
 * @link      http://github.com/lancew/DojoList
 */

require_once 'lib/data.model.php';
require_once 'lib/rss.php';


/**
 * Return a list of all Dojo
 *
 * @return $xml list
 */
function Find_Dojo_all()
{
	$xml = Load_Xml_data();
	return $xml;
}


/**
 * Return a single Dojo
 *
 * @param string $target Name of the dojo we are searching for.
 *
 * @return $xml single dojo
 *
 */
function Find_dojo($target=null)
{
	$target = clean_name($target);
	$return_value = null;
	$xml = Load_Xml_data();

	foreach ($xml->Dojo as $dojo) {
		if (strtolower($dojo->DojoName) == strtolower($target)) {
			$return_value = $dojo;
		}
	}
	return $return_value;
}


/**
 * Creates a new Dojo
 *
 * @param array $dojo Details of the Dojo.
 * @param array $file Uploaded logo.
 *
 * @return $xml single dojo
 *
 */
function Create_dojo($dojo, $file = null)
{

	$xml = Load_Xml_data();
	$new1 = $xml->addChild("Dojo");
	//print_r($dojo);
	//print_r($file);

    $dojo_name = '';
    $source_url = '';
    
    
	if ($file["DojoLogo"]["name"]) {
        if ((($file["DojoLogo"]["type"] == "image/gif")
            || ($file["DojoLogo"]["type"] == "image/jpeg")
            || ($file["DojoLogo"]["type"] == "image/pjpeg")
            || ($file["DojoLogo"]["type"] == "image/png"))
			&& ($file["DojoLogo"]["size"] < 20000)
		) {
			if ($file["DojoLogo"]["error"] > 0) {
				halt("Error: " . $file["DojoLogo"]["error"] . "<br />");
			} else {
				$new_child = 'data:'.$file["DojoLogo"]["type"].';base64,';
				$file = file_get_contents($file['DojoLogo']['tmp_name']);
				$new_child .= base64_encode($file);
				$new1->addChild('DojoLogo', $new_child);
			}
		} else {
			return 0;
		}
	}
	
	
	
	// Code for adding the coach photo
	// ------------------------------------------
	
	if ($file["CoachPhoto"]["name"]) {
        if ((($file["CoachPhoto"]["type"] == "image/gif")
            || ($file["CoachPhoto"]["type"] == "image/jpeg")
            || ($file["CoachPhoto"]["type"] == "image/pjpeg")
            || ($file["CoachPhoto"]["type"] == "image/png"))
			&& ($file["CoachPhoto"]["size"] < 20000)
		) {
			if ($file["CoachPhoto"]["error"] > 0) {
				halt("Error: " . $file["CoachPhoto"]["error"] . "<br />");
			} else {
				$new_child = 'data:'.$file["CoachPhoto"]["type"].';base64,';
				$file = file_get_contents($file['CoachPhoto']['tmp_name']);
				$new_child .= base64_encode($file);
				$new1->addChild('CoachPhoto', $new_child);
			}
		} else {
			return 0;
		}
	}

    
    // *** end of code adding coach photo.
    // ------------------------------------------------

    
    $flag_url_present = '0';
    foreach ($dojo as $key => $value) {
        if ($key === 'URL') {
            $flag_url_present = '1';
        }
	}
    

    // Go through all the data passed to us and add the items to the XML
	foreach ($dojo as $key => $value) {
		
		if ($key != 'recaptcha_challenge_field' 
		    && $key != 'recaptcha_response_field' 
		    && $key !='MAX_FILE_SIZE'
        ) {
			// If we are up to the DojoName entry, 
			// create the appropriate URL and add it to the XML.
			if ($key === 'DojoName' and $flag_url_present != '1') {
			     $source_url = 'http://'.$_SERVER['SERVER_NAME'].'/dojo/'.$value;
                 $new1->addChild('URL', $source_url);
                 $value = clean_name($value);
			
			}
			
			$clean_key = strip_tags(addslashes($key));
			$clean_val = strip_tags(addslashes($value));
			$new1->addChild($clean_key, $clean_val);

		}
	}

    // Add field for update date and time
    date_default_timezone_set("UTC");
    $time = date("l, F d, Y h:i", time()); 
    $new1->addChild('Updated', $time);
    
	Save_Xml_data($xml->asXML());
	$description = $dojo['DojoName']
	               .' Dojo was created. <a href="'
	               .$source_url.'/dojo/'
	               .$dojo['DojoName']
	               .'">'
	               .$dojo['DojoName']
	               .'</a>';
	//print_r($dojo);
	//echo $description;
	$rss_array = array('description' => $description);
	Add_rss_item($rss_array);

	return 'Dojo Created';

}

/**
 * Deletes a new Dojo
 *
 * @param string $Dojoname Name of the dojo.
 *
 * @return string $xml single dojo
 *
 */
function Delete_dojo($Dojoname)
{
	$xml = Load_Xml_data();
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
    Ulrich Wisser under a Creative Commons NC-SA License.
    DojoList software version'.option('version').' -->';

	foreach ($xml->Dojo as $dojo) {
		if ($dojo->DojoName == $Dojoname) {
			// do nothing if it is the dojo we are looking for

		} else {
			// for every other dojo create a new dojo in the newxml file
			$newxml .= $dojo->asXML();

		}
	}
	$newxml .= '</xml>';
	Save_Xml_data($newxml, 'data/dojo.xml');
	
	$description = "$Dojoname Dojo was deleted";
	$rss_array = array('description' => $description);
	Add_rss_item($rss_array);
	return $description;

}


/**
 * Update a new Dojo
 *
 * @param array $Dojo Name of the dojo to be deleted.
 *
 * @return string $xml single dojo
 *
 */
function Update_dojo($Dojo)
{


}

/**
 * Count the number of Dojo in the DB.
 *
 * @return int $dojo_count
 *
 */
function Count_dojo()
{
	$xml = Load_Xml_data();
	$dojo_count = 0;
	foreach ($xml->Dojo as $dojo) {
		$dojo_count++;
	}

	return $dojo_count;

}

/**
 * Return a sorted list of clubs as an array.
 *
 * @return array $dojolist an array of dojo sorted alpha a-z
 *
 */
function Sorted_dojo()
{
	$xml = Find_Dojo_all();
	$dojolist = array();
	foreach ($xml->Dojo as $dojo) {
		$dojolist[] = (string)$dojo->DojoName;

	}
	sort($dojolist);
	return $dojolist;

}


function Clean_name($name)
{
    
	$name = str_replace('&', ' and ', $name);
	$name = str_replace("'", '', $name);
	$name = str_replace("\\", '', $name);
	$name = str_replace("\"", '', $name);
	$name = str_replace("/", ' ', $name);
	$name = str_replace("(", '', $name);
	$name = str_replace(")", '', $name);
	$name = iconv("UTF-8", "UTF-8//IGNORE", $name);

    return $name;
}



function geoAddress($address = null)
{
    //Three parts to the querystring: q is address, output is the format (
    $lat = null;
    $lng = null;
    $key = option('GoogleKey');
    $address2 = urlencode($address);
    $mapurl = "http://maps.google.com/maps/geo?q="
                .$address2
                ."&amp;output=json&amp;key="
                .$key;
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

    $aLatLng[0]=$lat;
    $aLatLng[1]=$lng;
    return $aLatLng;    
}


function Websites()
{
	$xml = Find_Dojo_all();
	$websites = array();
	foreach ($xml->Dojo as $dojo) {
	       //echo $dojo->ClubWebsite;
	       if($dojo->ClubWebsite > '') {
                $websites[] = (string)$dojo->ClubWebsite;
		   }
	}
	sort($websites);
	return $websites;

}


?>
