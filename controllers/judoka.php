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

require_once 'lib/judoka.model.php';

/**
 * view - Displays a single Judoka in a HTML page
 *
 * @return Judoka html page
 */
function Judoka_View() 
{
    $target = params('judoka');
    $target = str_replace('%20', ' ', $target);
    set('Judoka', Find_judoka($target));
    return html('judoka/view.html.php');
}