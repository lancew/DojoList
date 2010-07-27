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
 * @param mixed $xml
 * @param string $file. (default: 'data/dojo.xml')
 * @return void
 */
function Save_Xml_data($xml, $file = 'data/dojo.xml')
{
	$fh = fopen($file, 'w') or die("can't open file");
	fwrite($fh, $xml);
	fclose($fh);
    return $file;
}


/**
 * get_string_between function.
 * 
 * @access public
 * @param mixed $string
 * @param mixed $start
 * @param mixed $end
 * @return void
 */
function get_string_between($string, $start, $end)
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
function guid(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
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
 * @param mixed $data
 * @param mixed $type
 * @return INT 0 or 1
 */
function validate_field($data, $type)
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
    
    switch($type) {
        case "DojoName":
            if(ereg('[^A-Za-z ]',$data)) {return 1;}
            break;
        case "MembershipID":
            if(ereg('[^0-9]',$data)) {return 1;}
            break;
        case "CoachName":
            if(ereg('[^A-Za-z ]',$data)) {return 1;}
            break;
        case "DojoAddress":
            if(ereg('[^A-Za-z0-9 ]',$data)) {return 1;}
            break;
        case "ContactName":
            if(ereg('[^A-Za-z ]',$data)) {return 1;}
            break;
        case "ContactPhone":
            if(ereg('[^0-9()]',$data)) {return 1;}
            break;    
        
        default:
            return 0;
    
    
    }


}

/**
 * Validate_create function.
 * 
 * This function is used to check all fields in the create form. returns the number of errors, hopefully it shold be 0
 *
 * @access public
 * @param mixed $_POST. (default: null)
 * @return void
 */
function Validate_form($_POST = null)
{
   // echo '<pre>';
   // print_r($_POST);
   // echo '</pre>';
    //set error_count to 0, should stay 0 if all forms validate
    $error_count = 0;
    foreach($_POST as $field => $value)
    {
        
        if($field==="DojoName"){
            if(!$value){
                $error_count++; 
                //echo $error_count;
                
                }
            }
        if($value){
                $result = validate_field($value,$field);
              //  echo  $field.": ".$result;
                $error_count = $error_count + $result;
              //  echo "COUNT: $error_count<br>";
                }
                
        
    }
    // check the error count and return 1 if no errors 0 if any errors
    if($error_count < 1){
        return 1;
        } else {
        return 0;
        }
}


?>
