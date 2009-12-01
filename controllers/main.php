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
  * @author    Lance WIcks <lw@judocoach.com>
  * @copyright 2009 Lance Wicks
  * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
  * @link      http://github.com/lancew/DojoList
 */


function main_page() {
	return html('main.html.php');
}


/**
 *
 *
 * @return unknown
 */
function html_list() {
	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
		//print_r($xml);
	} else {
		exit('Failed to open dojo.xml.');
	}

	set('DojoList', $xml);


	return html('main.html_list.html.php');
}



?>