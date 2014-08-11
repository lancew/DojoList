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

require_once 'lib/rss.php';
require_once 'lib/dojo.model.php';

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
        Delete_dojo($DojoName);
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
	 is licensed under a <a rel="license"
	 href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">
	 Creative Commons Attribution-Noncommercial-Share Alike 2.0
	 UK: England &amp; Wales License</a>.
	 Some data imported from www.judoworldmap.com by
	 Ulrich Wisser under a Creative Commons NC-SA License. -->
    <Document>
    <name>Dojo List</name>';

    foreach ($xml->Dojo as $dojo) {
        $newKML .= '<Placemark>';
        $newKML .= '<name>'.$dojo->DojoName.'</name>';
        $newKML .= '<description><![CDATA[';

        $newKML
            .= '<a href="'.
            option('site_url').
            '/dojo/'.
            $dojo->DojoName.
            '">View Details</a>';

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


/**
 * Admin_importjwm function.
 *
 * @access public
 * @return void
 */
function Admin_importjwm()
{

    set_time_limit();
    $ch = curl_init("http://judoworldmap.com/");
    $fp = fopen("data/jwm.txt", "w");

    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);


    $raw_data = file_get_contents('data/jwm.txt');
    if (strpos($raw_data, 'This work is licensed under Creative Commons NC-SA')) {

        $data = get_string_between($raw_data, 'var icon17', 'new GIcon();');
        $data_array = explode('var icon', $data);
        echo '<?xml version="1.0" encoding="UTF-8" ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
        echo '<table border=1>';
        $loop=1;
        foreach ($data_array as $value) {
            //echo ".$value<br />";
            echo '<tr>';
            echo "<td>$loop</td>";
            $coords = get_string_between($value, 'GLatLng(', ')');
            $LatLng = explode(',', $coords);
            $url = get_string_between($value, 'http://', '\\"');
            $name = strip_tags(stripslashes(get_string_between($value, '<b>', '</b>')));
            $name = clean_name($name);



            $Lat = $LatLng[0];
            $Lng = $LatLng[1];


            echo "<td>$name</td><td width =50>$url</td><td>$Lat</td><td>$Lng</td>";


            $dojo = Find_dojo($name);

            if (!$dojo && $name) {
                echo "<td>NEW</td>";

                $dojo_array = array('DojoName' => $name, 'ClubWebsite' => $url, 'Latitude' => $Lat, 'Longitude' => $Lng, 'URL' => 'http://judoworldmap.com/' );
                //print_r($dojo_array);
                Create_dojo($dojo_array);
            } else {
                echo "<td>&nbsp;</td>";
            }

            echo "</tr>";
            $loop++;

        }
        echo '</table>';
        unlink('data/jwm.txt');
        admin_create_kml();

    } else {
        halt('CC License no longer on JWM site');
    }

}



/**
 * sync function.
 *
 * @access public
 * @return void
 */
function sync()
{
    $NewInFar = DojoNotInLocal(option('sync_site'));
    $Newlist[]='No new in far site data';
    $UpdatedInFar = NewerFarDojo(option('sync_site'));
    set('NewInFar', $NewInFar);
    set('UpdatedInFar', $UpdatedInFar);

    return html('admin/sync.html.php');

}

/**
 * sync_new function.
 *
 * @access public
 * @return void
 */
function Sync_new()
{
    $Newlist = ListDojoNotInLocal(option('sync_site'));
    set('Newlist', $Newlist);
    return html('admin/sync_new.html.php');

}


/**
 * sync_updated function.
 *
 * @access public
 * @return void
 */
function Sync_updated()
{
    $Newlist = ListNewerFarDojo(option('sync_site'));
    set('Newlist', $Newlist);
    return html('admin/sync_updated.html.php');

}


?>