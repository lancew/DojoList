<?php
/**
 * DojoList admin controller file
 *
 * This controller is for the main pages for the DojoList Application.
 *
 * PHP version 5
 *
 * LICENSE: please see the AGPL license file is data/agpl-3.0.txt
 *
 * @category  AdminController
 * @copyright 2009 Lance Wicks
 * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
 * @link      http://github.com/lancew/DojoList
 * @author    Lance Wicks <lw@judocoach.com>
 * @package   DojoList
 */


/**
 * Admin Index - Displays the admin index page page
 *
 * @return unknown
 */
function Admin_index()
{
	if (isset($_COOKIE["user"])) {
		return html('admin/index.html.php');
	} else {
		return html('admin/index_login.html.php');
	}
}


/**
 * Admin Login - Login page
 *
 * @return unknown
 */
function Admin_login()
{
	if ($_POST['password'] == option('password')) {
		setcookie("user", "Alex Porter", time()+3600);
		return html('admin/index.html.php');
	} else {
		return html('admin/index_login.html.php');
	}
}


/**
 * Admin Logout - logs Admin out
 *
 * @return unknown
 */
function Admin_logout()
{
	setcookie("user", "", time()-3600);
	return html('admin/index_login.html.php');
}


/**
 * Admin Create - Displays create new dojo page
 *
 * @return unknown
 */
function Admin_create()
{
	return html('admin/create.html.php');
}


/**
 * Admin Create Add - writes dojo to XML file, then displays page saying job done.
 *
 * @return unknown
 */
function Admin_Create_add()
{

	$resp = recaptcha_check_answer (option('recaptcha_private_key'),
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]);

	if ($resp->is_valid) {

		Create_dojo($_POST, $_FILES);
		$DojoName = $_POST["DojoName"];
		set('DojoName', $DojoName);
		admin_create_kml();
		return render('admin/create_add.html.php');

	} else {
		// set the error code so that we can display it
		halt('Failed to add new Dojo: '.$resp->error);

	}

}


/**
 * Admin Edit - Displays a page with a list of existing Dojo to edit
 *
 * @return unknown
 */
function Admin_edit()
{
	set('DojoList', Find_Dojo_all());
	return html('admin/edit.html.php');
}


/**
 * Admin Edit Form - Displays the edit form, showing Dojo with pre-existing data
 *
 * @return unknown
 */
function Admin_editform()
{
	$DojoName = params('dojo');
	$DojoName = str_replace('%20', ' ', $DojoName);
	$xml = Find_Dojo_all();
	$dojo_data = '';
	foreach ($xml->Dojo as $dojo) {
		if ($dojo->DojoName == $DojoName) {
			set('Dojo', $dojo);
			print($dojo);
		}
	}
	return html('admin/edit_form.html.php');
}


/**
 * Admin EditForm End - Writes changes from edit to XML file.
 *
 * @return unknown
 */
function Admin_Editform_end()
{
	$resp = recaptcha_check_answer (option('recaptcha_private_key'),
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]);
	if ($resp->is_valid) {

		$DojoName = params('dojo');
		$DojoName = str_replace('%20', ' ', $DojoName);

		$DojoOrigEmail ='';
		// Read in the XML data from file.
		$xml = Find_Dojo_all();
		$newxml = '<xml>
	<!-- The data created by DojoList by
	<a xmlns:cc="http://creativecommons.org/ns#"
	href="http://github.com/lancew/DojoList"
	property="cc:attributionName"
	rel="cc:attributionURL">
	Lance Wicks</a> is licensed under a
	<a rel="license"
	href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">
	Creative Commons Attribution-Noncommercial-Share Alike 2.0
	UK: England &amp; Wales License</a>. -->';

		foreach ($xml->Dojo as $dojo) {
			if ($dojo->DojoName == $DojoName) {
				foreach ($_POST as $field => $value) {
					$DojoOrigEmail = $dojo->ContactEmail;
					unset($dojo->$field);
					if ($field != 'recaptcha_challenge_field' && $field != 'recaptcha_response_field') {
						$clean_field = strip_tags(addslashes($field));
						$clean_value = strip_tags(addslashes($value));
						$dojo->addChild($clean_field, $clean_value);
					}
				}
				$newxml .= $dojo->asXML();
			} else {
				$newxml .= $dojo->asXML();
			}
		}
		$newxml .= '</xml>';
		$myFile = "data/dojo.xml";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $newxml);
		fclose($fh);

		$to      = $DojoOrigEmail;
		$subject =  _("A change has been made to ") .$dojo->DojoName;
		$message = _("Hello, a change has been made to the listing for the dojo ") . $dojo->DojoName . _(' which this email address was/is associated with. You can check the details by visiting ') . option('site_url').'/dojo/'. $dojo->DojoName ;
		$headers = 'From: noreply@dojolist.org' . "\r\n";
		$message = wordwrap($message, 70);

		mail($to, $subject, $message, $headers);

		set('DojoName', $DojoName);
		admin_create_kml();
		set('DojoName', $DojoName);
		flash('notice', 'Edited OK');
		return html('admin/edit_end.html.php');
	} else {
		// set the error code so that we can display it
		halt('Failed to edit Dojo: '.$resp->error);

	}
}


/**
 * Admin Delete - Displays list of Dojo so user can choose one to delete.
 *
 * @return unknown
 */
function Admin_delete()
{
	$DojoName = params('dojo');
	set('DojoName', $DojoName);
	return html('admin/delete_recaptcha.html.php');
}


/**
 * Admin Delete End - Once dojo selected to be deleted, write changes to XML
 *
 * @return unknown
 */
function Admin_Delete_end()
{
	if ($_POST["recaptcha_response_field"]) {
		$DojoName = params('dojo');
		Delete_dojo($Dojoname);
		set('DojoName', $DojoName);
		admin_create_kml();
		return html('admin/delete_end.html.php');
    } else {
		halt('no recaptcha provided');
	}
    
}


/**
 * Admin Create KML - Create the dojo.kml file
 *
 * @return unknown
 */
function Admin_Create_kml()
{
	$xml = Find_Dojo_all();

	$newKML = '<?xml version="1.0" encoding="UTF-8"?>
    <kml xmlns="http://www.opengis.net/kml/2.2">
    <!-- The data created by DojoList by
    <a xmlns:cc="http://creativecommons.org/ns#"
    href="http://github.com/lancew/DojoList"
    property="cc:attributionName"
    rel="cc:attributionURL">Lance Wicks</a>
    is licensed under a
    <a rel="license"
    href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">
    Creative Commons Attribution-Noncommercial-Share Alike 2.0
    UK: England &amp; Wales License</a>. -->
    <Document>
    <name>Dojo List</name>';

	foreach ($xml->Dojo as $dojo) {
		$newKML .= '<Placemark>';
		$newKML .= '<name>'.$dojo->DojoName.'</name>';
		$newKML .= '<description><![CDATA[';

		//$newKML .= '<h1>'.$dojo->DojoName.'</h1>';
		if ($dojo->DojoLogo) {$newKML .= '<img alt="'.$dojo->DojoName.'" src="'.$dojo->DojoLogo.'" width="250px"/>'; }
		$newKML .= '<a href="'.option('site_url').'/dojo/'.$dojo->DojoName.'">View Details</a>';

		$newKML .= ']]></description>';
		$newKML .= '<Point><coordinates>';
		$newKML .= $dojo->Longitude . ',' . $dojo->Latitude;
		$newKML .= '</coordinates></Point>';
		$newKML .= '</Placemark>';
	}
	$newKML .= '</Document></kml>';
	$myFile = "data/dojo.kml";
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, $newKML);
	fclose($fh);
	return html('admin/create_kml.html.php');
}


?>