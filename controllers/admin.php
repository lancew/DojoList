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
  * @package   DojoList
  * @author    Lance Wicks <lw@judocoach.com>
  * @copyright 2009 Lance Wicks
  * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
  * @link      http://github.com/lancew/DojoList
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
    if (file_exists('data/dojo.xml')) {
            $xml = simplexml_load_file('data/dojo.xml');
    } else {
            halt('Failed to open dojo.xml.');
    }
    
    $resp = recaptcha_check_answer (option('recaptcha_private_key'),
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
        				$new1 = $xml->addChild("Dojo");
    					foreach ($_POST as $key => $value) {
        					if($key != 'recaptcha_challenge_field' && $key != 'recaptcha_response_field') {
        						$clean_key = strip_tags(addslashes($key));
        						$clean_val = strip_tags(addslashes($value));
        						$new1->addChild($clean_key, $clean_val);
        						}
    					}
    					$DojoName = $_POST["DojoName"];
    					$myFile = "data/dojo.xml";
    					$fh = fopen($myFile, 'w') or die("can't open file");
    					fwrite($fh, $xml->asXML());
    					fclose($fh);
    					set('DojoName', $DojoName);
    					admin_create_kml();
    					return render('admin/create_add.html.php');
                
        } else {
                # set the error code so that we can display it
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
            foreach ($_POST AS $field => $value) {
                unset($dojo->$field);
                if($field != 'recaptcha_challenge_field' && $field != 'recaptcha_response_field') {
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
    set('DojoName', $DojoName);
    admin_create_kml();
    set('DojoName', $DojoName);
    flash('notice', 'Edited OK');
    return html('admin/edit_end.html.php');
     } else {
                # set the error code so that we can display it
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
    $xml = Find_Dojo_all();
    $newxml = '<xml>
	<!-- The data created by DojoList by 
	<a xmlns:cc="http://creativecommons.org/ns#" 
	href="http://github.com/lancew/DojoList" 
	property="cc:attributionName" 
	rel="cc:attributionURL">Lance Wicks</a>
	 is licensed under a <a rel="license" 
	 href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">
	 Creative Commons Attribution-Noncommercial-Share Alike 2.0 
	 UK: England &amp; Wales License</a>. -->';

    foreach ($xml->Dojo as $dojo) {
        if ($dojo->DojoName == $DojoName) {
        
        } else {
            $newxml .= $dojo->asXML();
        }
    }
    $newxml .= '</xml>';
    $myFile = "data/dojo.xml";
    $fh = fopen($myFile, 'w') or die("can't open file");
    fwrite($fh, $newxml);
    fclose($fh);
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
        foreach ($dojo as $key => $value) {
            if ($value) {
                switch ($key) {
                case 'ClubWebsite':
                    $newKML .= "$key: <a href='http://$value'>$value</a> <br />\n";
                    break;
                case 'ContactEmail':
                    $newKML .= "$key: <a href='mailto:$value'>$value</a> <br />\n";
                    break;
                default:
                    $newKML .= "$key: $value <br />\n";
                }
            }
        }
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