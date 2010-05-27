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

?>
