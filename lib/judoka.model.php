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


class Judoka {

	public $display_name;
	public $email;
	public $family_name;
	public $given_name;
	public $uuid;

	public function __construct()
	{
		$this->uuid = guid();
	}


	private function guid()
	{
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


?>
