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
require_once 'lib/judoka.model.php';

/**
 * Dojo Create - Displays create new dojo page
 *
 * @return unknown
 */
function Dojo_create() 
{
    return html('dojo/create.html.php');
}


/**
 * Dojo Create Add - writes dojo to XML file, then displays page saying job done.
 *
 * @return unknown
 */
function Dojo_Create_add() 
{
    if (!Validate_form($_POST) ) {
        $resp = recaptcha_check_answer(
            option('recaptcha_private_key'),
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]
        );

        if ($resp->is_valid ) {

            Create_dojo($_POST, $_FILES);
            $DojoName = clean_name($_POST["DojoName"]);
            set('DojoName', $DojoName);
            admin_create_kml();
            return render('dojo/create_add.html.php');

        } else {
            // set the error code so that we can display it
            halt('Failed to add new Dojo: '.$resp->error);

        }
    } else {
        set('Errors', Validate_form($_POST));
        return render('dojo/validation_error.html.php');
    }

}


/**
 * Admin Edit - Displays a page with a list of existing Dojo to edit
 *
 * @return unknown
 */
function Dojo_edit() 
{
    set('DojoList', Find_Dojo_all());
    return html('dojo/edit.html.php');
}


/**
 * Admin Edit Form - Displays the edit form, showing Dojo with pre-existing data
 *
 * @return unknown
 */
function Dojo_editform() 
{
    $DojoName = params('dojo');
    $DojoName = str_replace('%20', ' ', $DojoName);
    $xml = Find_Dojo_all();
    $dojo_data = '';
    foreach ( $xml->Dojo as $dojo ) {
        if ($dojo->DojoName == $DojoName ) {
            set('Dojo', $dojo);
            print( $dojo );
        }
    }
    return html('dojo/edit_form.html.php');
}


/**
 * Admin EditForm End - Writes changes from edit to XML file.
 *
 * @return unknown
 */
function Dojo_Editform_end() 
{
    if (!Validate_form($_POST) ) {
        $resp = recaptcha_check_answer(
            option('recaptcha_private_key'),
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]
        );
        if ($resp->is_valid ) {

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
    rel="cc:attributionURL">Lance Wicks</a>
     is licensed under a <a rel="license"
     href="http://creativecommons.org/licenses/by-nc-sa/2.0/uk/">
     Creative Commons Attribution-Noncommercial-Share Alike 2.0
     UK: England &amp; Wales License</a>.
     Some data imported from www.judoworldmap.com by
     Ulrich Wisser under a Creative Commons NC-SA License. -->';

            foreach ( $xml->Dojo as $dojo ) {
                if ($dojo->DojoName == $DojoName ) {
                    foreach ( $_POST as $field => $value ) {
                        $DojoOrigEmail = $dojo->ContactEmail;
                        unset($dojo->$field);
                        if ($field != 'recaptcha_challenge_field'
                            && $field != 'recaptcha_response_field'
                            && $field != 'MAX_FILE_SIZE'
                            && $field != 'delete_logo'
                        ) {
                            $clean_field = strip_tags(addslashes($field));
                            $clean_value = strip_tags(addslashes($value));
                            $dojo->addChild($clean_field, $clean_value);
                        }
                        if ($field === 'delete_logo' ) {
                            unset($dojo->DojoLogo);
                        }
                    }

                    // start of if ($_FILES... section,
                    // encodes and adds an upload logo file



                    //  if ($_FILES["DojoLogo"]["name"]) {
                    //      save_image('DojoLogo');
                    //  }

                    // end of if ($_FILES... section.

                    // Coach Photo section.



                    //if ($_FILES["CoachPhoto"]["name"]) {
                    //    save_image('CoachPhoto');
                    //}

                    // Coach Photo section


                    // update the Updated field
                    date_default_timezone_set("UTC");
                    $time = date("l, F d, Y h:i", time());
                    $dojo->Updated = $time;


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
            $subject =  _("A change has been made to ") .$DojoName;
            $html_dojoname = str_ireplace(' ', '%20', $DojoName);

            $message
                = _("Hello, a change has been made to the listing for the dojo ").
                $DojoName.
                _(' which this email address was/is associated with. You can check the details by visiting ').
                option('site_url').
                '/dojo/'.
                $html_dojoname;

            $headers = 'From: noreply@dojolist.org' . "\r\n";
            $message = wordwrap($message, 70);

            mail($to, $subject, $message, $headers);

            set('DojoName', $DojoName);
            admin_create_kml();
            set('DojoName', $DojoName);

            $source_url = 'http://'.$_SERVER['SERVER_NAME'].'/dojo/'.$DojoName;
            $description
                = $DojoName.
                ' Dojo was updated. <a href="'.
                $source_url.
                '">'.
                $DojoName.
                '</a>';
            $rss_array = array( 'description' => $description );
            Add_rss_item($rss_array);

            return html('dojo/edit_end.html.php');
        } else {
            // set the error code so that we can display it
            halt('Failed to edit Dojo: '.$resp->error);

        }
    } else {
        set('Errors', Validate_form($_POST));
        return render('dojo/validation_error.html.php');
    }
}


/**
 * Admin Delete - Displays list of Dojo so user can choose one to delete.
 *
 * @return unknown
 */
function Dojo_delete() 
{
    $DojoName = params('dojo');
    set('DojoName', $DojoName);
    return html('dojo/delete_recaptcha.html.php');
}


/**
 * Admin Delete End - Once dojo selected to be deleted, write changes to XML
 *
 * @return unknown
 */
function Dojo_Delete_end() 
{
    if ($_POST["recaptcha_response_field"] ) {
        $Dojo_Name = params('dojo');
        Delete_dojo($Dojo_Name);
        set('DojoName', $Dojo_Name);
        admin_create_kml();
        return html('dojo/delete_end.html.php');
    } else {
        halt('no recaptcha provided');
    }

}

/**
 * view - Displays a single Dojo in a HTML page
 *
 * @return dojo html page
 */
function Dojo_view() 
{
    $target = params('dojo');
    $target = str_replace('%20', ' ', $target);

    $dojo = Find_dojo($target);
    $dojo->judoka = Find_judoka_by_dojo($dojo->GUID);
  
    set('Dojo', Find_dojo($target));
    set('Judoka', Find_judoka_by_dojo($dojo->GUID));

    return html('dojo/view.html.php');
}

?>
