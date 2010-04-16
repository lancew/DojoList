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
 * Load dojo list as XML
 *
 * @return $xml list
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

function Save_Xml_data($xml,$file = 'data/data.xml')
{
    $fh = fopen($file, 'w') or die("can't open file");
    fwrite($fh, $xml);
    fclose($fh);
    
    return $file;
}

function get_string_between($string, $start, $end){ 
    $string = " ".$string; 
    $ini = strpos($string,$start); 
    if ($ini == 0) return ""; 
    $ini += strlen($start); 
    $len = strpos($string,$end,$ini) - $ini; 
    return substr($string,$ini,$len); 
} 
 


?>
