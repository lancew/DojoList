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


function positive()
{
return 1;
}

function negative()
{
return 0;
}

/**
 * Return a list of all Dojo
 *
 * @return $xml list
 */
function Find_Dojo_all()
{
    if (file_exists('data/dojo.xml')) {
            $xml = simplexml_load_file('data/dojo.xml');
    } else {
            halt('Failed to open dojo.xml.');
    }

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
    
    if (file_exists('data/dojo.xml')) {
            $xml = simplexml_load_file('data/dojo.xml');
    } else {
            halt('Failed to open dojo.xml.');
    }


    foreach ($xml->Dojo as $dojo) 
    {
        if ($dojo->DojoName == $target) 
        {
            $return_value = $dojo;
        }
    }
                





    return $return_value;
}



?>



