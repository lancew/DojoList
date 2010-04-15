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

require_once('lib/data.model.php');


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
 * @return $xml single dojo
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



function Create_dojo ()
{
			
        $xml = Load_Xml_data();
		$new1 = $xml->addChild("Dojo");

		if ($_FILES["DojoLogo"]["name"]) {
			if ((($_FILES["DojoLogo"]["type"] == "image/gif")
					|| ($_FILES["DojoLogo"]["type"] == "image/jpeg")
					|| ($_FILES["DojoLogo"]["type"] == "image/pjpeg")
					|| ($_FILES["DojoLogo"]["type"] == "image/png"))
				&& ($_FILES["DojoLogo"]["size"] < 20000)) {
				if ($_FILES["DojoLogo"]["error"] > 0) {
					halt("Error: " . $_FILES["DojoLogo"]["error"] . "<br />");
                } else {
				    $new1->addChild('DojoLogo', 'data:'.$_FILES["DojoLogo"]["type"].';base64,'.base64_encode(file_get_contents($_FILES['DojoLogo']['tmp_name'])));
				}
			} else {
				return 0;
			}
		}

		foreach ($_POST as $key => $value) {
			if ($key != 'recaptcha_challenge_field' && $key != 'recaptcha_response_field' && $key !='MAX_FILE_SIZE') {
				$clean_key = strip_tags(addslashes($key));
				$clean_val = strip_tags(addslashes($value));

				$new1->addChild($clean_key, $clean_val);
			}
		}
		
		$myFile = "data/dojo.xml";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $xml->asXML());
		fclose($fh);
		return 'Dojo Created';
		
		



}

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
	 UK: England &amp; Wales License</a>. -->';

		foreach ($xml->Dojo as $dojo) {
			if ($dojo->DojoName == $Dojoname) {
                // do nothing if it is the dojo we are looking for
                
			} else {
				// for every other dojo create a new dojo in the newxml file
				$newxml .= $dojo->asXML();
				
			}
		}
		$newxml .= '</xml>';
		Save_Xml_data($newxml,'data/dojo.xml');
        return "$Dojoname Dojo Deleted";

}

function Update_dojo()
{

}



?>
