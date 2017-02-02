<?php
/**
 * DojoList api controller file
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

//require_once 'lib/dojo.model.php';


/**
 * api_read function.
 * 
 * @access public
 * @return $target
 */
function Api_read()
{
    $target = params('dojo');
    $target = str_replace('%20', ' ', $target);
    return json(Find_dojo($target));
}



?>