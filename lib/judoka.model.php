<?php
/**
 * DojoList Judoka Model file
 *
 * This file is the model for Judoka in the DojoList Application.
 *
 * PHP version 5
 *
 * LICENSE: please see the AGPL license file is data/agpl-3.0.txt
 *
 * @category  JudokaModel
 * @package   DojoList
 * @author    Lance Wicks <lw@judocoach.com>
 * @copyright 2013 Lance Wicks
 * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
 * @link      http://github.com/lancew/DojoList
 */

require_once 'lib/data.model.php';
require_once 'lib/rss.php';


/**
 * Return a single judoka
 *
 * @param string $target Displayname of the judoka we are searching for.
 *
 * @return $xml single judoka
 */
function Find_judoka($target=null)
{
    $target = clean_name($target);
    $return_value = null;
    $xml = Load_Xml_data('data/judoka.xml');

    foreach ($xml->Judoka as $Judoka) {
        if (strtolower($Judoka->DisplayName) == strtolower($target)) {

            $return_value = $Judoka;
        }
    }
    return $return_value;
}

/**
 * Return a array of Judoka associate with a Dojo
 */
function Find_judoka_by_dojo($target=null)
{
    $return_value = null;
    $xml = Load_Xml_data('data/judoka.xml');

    foreach ($xml->Judoka as $Judoka) {
        if (strtolower($Judoka->Dojo) == strtolower($target)) {
            
            $return_value[] = $Judoka;
        }
    }
    return $return_value;
}




?>
