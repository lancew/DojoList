<?php

/**
  * DojoList main controller file
  *
  * This controller is for the main pages for the DojoList Application.
  *
  * PHP version 5
  *
  * LICENSE: please see the AGPL license file is data/agpl-3.0.txt
  *
  * @category  MainController
  * @package   DojoList
  * @author    Lance Wicks <lw@judocoach.com>
  * @copyright 2009 Lance Wicks
  * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
  * @link      http://github.com/lancew/DojoList
 */


/**
 * Main_Page - Displays main page
 *
 * @return unknown
 */
function Main_page() 
{
    return html('main.html.php');
}

/**
 * Html_list - Displays all the Dojo in a HTML page
 *
 * @return dojolist html page
 */
function Html_list() 
{
    //set('DojoList', Find_Dojo_all());
    set('DojoList', Sorted_dojo());
    return html('main.html_list.html.php');
}


/**
 * view - Displays a single Dojo in a HTML page
 *
 * @return dojo html page
 */
function view()
{
    $target = params('dojo');
    $target = str_replace('%20', ' ', $target);
    set('Dojo', Find_dojo($target));
    return html('view.html.php');
}




?>