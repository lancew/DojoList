<?php
/**
 * DojoList Data Model file
 *
 * This model abstracts data access away from the dojo model.
 *
 * PHP version 5
 *
 * LICENSE: please see the AGPL license file is data/agpl-3.0.txt
 *
 * @category  DataModel
 * @package   DojoList
 * @author    Lance Wicks <lw@judocoach.com>
 * @copyright 2010 Lance Wicks
 * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
 * @link      http://github.com/lancew/DojoList
 */

/**
 * Load_Xml_data function.
 * 
 * @access public
 * @param string $file. (default: 'data/dojo.xml')
 * 
 * @return void
 */
function Load_Xml_data($file = 'data/dojo.xml')
{

	if (file_exists($file)) {
		$xml = simplexml_load_file($file);
	} else {
		return 'Failed to load XML';
	}
	return $xml;
}


/**
 * Save_Xml_data function.
 *
 * @access public
 * @param mixed   $xml
 * @param string  $file. (default: 'data/dojo.xml')
 *
 * @return void
 */
function Save_Xml_data($xml, $file = 'data/dojo.xml')
{
	Backup_data();
	$fh = fopen($file, 'w') or die("can't open file");
	fwrite($fh, $xml);
	fclose($fh);
	return $file;
}


/**
 * get_string_between function.
 *
 * @access public
 * @param mixed   $string
 * @param mixed   $start
 * @param mixed   $end
 * @return void
 */
function Get_string_between($string, $start, $end)
{
	$string = " ".$string;
	$ini = strpos($string, $start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}

/**
 * guid function.
 *
 * @access public
 * @return guid
 */
function guid()
{
	if (function_exists('com_create_guid')) {
		return com_create_guid();
	} else {
		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);// "-"
		$uuid = chr(123)// "{"
		.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid, 12, 4).$hyphen
			.substr($charid, 16, 4).$hyphen
			.substr($charid, 20, 12)
			.chr(125);// "}"
		return $uuid;
	}
}

/**
 * validate_field function.
 *
 * This function checks individual fields and returns the number of errors found, preferably 0.
 *
 * @access public
 * @param mixed   $data
 * @param mixed   $type
 * @return INT 0 or 1
 */
function Validate_field($data, $type)
{
	// This function checks fields and returns the number of errors found.
	// Check if the parameters have been sent.
	//if(!$data or !$type) { return 1;}
	/*
    [DojoName] => Lancew"
    [MembershipID] =>
    [CoachName] =>
    [DojoAddress] =>
    [ContactName] =>
    [ContactPhone] =>
    [ContactEmail] =>
    [ClubWebsite] =>
    [MAX_FILE_SIZE] => 20000
    [Latitude] =>
    [Longitude] =>
    [GUID] => {F6E3B62D-EE41-7213-D7DF-EFFFB9139F16}
    */

	//echo $type.':'.$data.'<br>';
	switch ($type) {
	case "DojoName":
		if (preg_match('[^A-Za-z -]', $data)) {   
            return 'Dojo Name: Must be alphanumeric only';
        }
		return null;
	case "MembershipID":
		if (preg_match('[^0-9]', $data)) {
            return 'Membership ID: Must be numbers only';
        }
		break;
	case "CoachName":
		if (preg_match('[^A-Za-z ]', $data)) {
            return 'Coach Name: Must be letters a-z or A-Z only';
        }
		return null;
	case "DojoAddress":
		if (preg_match('[^A-Za-z0-9,. ]', $data)) {
            return 'Dojo Address: Must be alphanumeric or a comma, or fullstop only';
        }
		return null;
	case "ContactName":
		if (preg_match('[^A-Za-z ]', $data)) {
            return 'Contact Name: Must be letters a-z or A-Z only';
        }
		return null;
	case "ContactPhone":
		if (preg_match('[^0-9() ]', $data)) {
            return 'Contact telephone number: Must be numbers 0-9 only';
        }
		return null;
		


	default:
		return null;


	}


}

/**
 * Validate_create function.
 *
 * This function is used to check all fields in the create form.
 * returns the number of errors, hopefully it should be 0
 *
 * @access public
 * @param mixed   $_POST. (default: null)
 * @return void
 */
function Validate_form($post = null)
{
	// echo '<pre>';
	// print_r($_POST);
	// echo '</pre>';
	
	//create the error array
	$aErrors = null;
	
	
	// Cycle through all variables. If no dojoname then fail
	// else use the validate_field function
	foreach ($post as $field => $value) {

		if ($field==="DojoName") {
			if (!$value) {
				$aErrors[] = 'Dojo name not present';
				

			}
		}
		if ($value) {
			$result = Validate_field($value, $field);
			//  echo  $field.": ".$result;
			$aErrors[] = $result;
			//  echo "COUNT: $error_count<br>";
		}


	}
	// return an array of validation errors
	//print_r($aErrors);
	$ret = null;
	foreach($aErrors as $error){
	   if($error){
	       $ret = 1;
	   }
	}
	if($ret != null){
	   return $aErrors;
	} else {
	   return null;
	}
	
}

function Backup_data()
{
    // Backup the XML file in case we mess things up.
    // Five versions.
    
    for ($i = 4; $i >= 1; $i--) 
    {
        //echo $i;
        $filename = 'data/dojo_'.$i.'.xml';
        $newfile = 'data/dojo_'.($i+1).'.xml';
        if (file_exists($filename))
        //echo $filename;
        {
            //echo '.';
            copy($filename, $newfile);
        }

    }
    copy('data/dojo.xml', 'data/dojo_1.xml');
}

?>
