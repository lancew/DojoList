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
	$return_value = null;
	$xml = Load_Xml_data();

	foreach ($xml->Dojo as $dojo) {
		if ($dojo->DojoName == $target) {
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



	foreach ($dojo as $key => $value) {
		if ($key != 'recaptcha_challenge_field' 
		    && $key != 'recaptcha_response_field' 
		    && $key !='MAX_FILE_SIZE'
        ) {
			$clean_key = strip_tags(addslashes($key));
			$clean_val = strip_tags(addslashes($value));
			$new1->addChild($clean_key, $clean_val);

		}
	}

	Save_Xml_data($xml->asXML());
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
    Ulrich Wisser under a Creative Commons NC-SA License. -->';

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
	return "$Dojoname Dojo Deleted";

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

?>
