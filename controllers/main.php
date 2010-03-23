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
    set('DojoList', Find_Dojo_all());
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

function DojoLogo ()
{
	//header("Content-type: image/png");
	//$target = params('dojo');
    //$target = str_replace('%20', ' ', $target);
    //$xml = Find_dojo($target);
    //echo base64_decode($xml->DojoLogo);
    $img = 'iVBORw0KGgoAAAANSUhEUgAAANQAAADUAQMAAADeEJ9bAAAABlBMVEX///8AAABVwtN+AAACDElEQVRYhe2YW3LDQAgEuQH3vyU3IEwjrR1/az5c5bWTyNuqMstjQIn4rS9f3V0d885ZURVzPVs2xoeMrK6MvS52Xazn+zsFWubMBVtONkedV1W2eNmZ7OiU08eYNjPe7CnOfbZMTInzsf7l2dMMPt8tW+Ts166HjX/nNYfHgrlnYjs/PkbiTm22CnMsmv0sH6P2Q1lLiSqNVKk2RuouUeZSLJlhY1SGnC2mg4vcvjYwRHXuGHe3RKHxd/hYUpIlS5S8im+Gj4WOql+hm0oaFKc0DYxGRV3KnPVA3r3KwegWCjBXuV3Sx5qL5vilEt06tTFtlvRmwpvksPSubGw9nXJw06PyTcoNrFA7VSN/i/I8Ovg8k/hUb4CLNkKUbQzPqkTysmVtsjFGQwZGOj/KUEamqCqjFNTVOn0uG6sdamKTSXNxHKlzMKxAbJL7UJ4qG7sHDGWt5EDxPXOWg20r1MEZvjEmfKy2UzBpSOMYci6tc7BcC8YUnZ+ho/Lo4POMIV9PTju36fB1N0cHQ8yl47IGw6KtTOKGwgV3KK86feya8ZuRe11xxn0Hoy9eLYr0ldgd7XmevfJXEpTUyZ27Dnb/L6EZcDSa1qs1GlgR3O2MRYkitT62z9o7Jdbl8vKyIsDRO7khClbGA30CQ8oab2d/nO22CmYf2WrzysU2l/J6vNjkvSvFwX7ri9cfxvO0cXziBywAAAAASUVORK5CYII=';
     header('Content-type: image/png');
	 echo base64_decode($img);
}


?>