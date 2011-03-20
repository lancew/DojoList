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
 * About_page function.
 * 
 * @access public
 * @return void
 */
function About_page()
{
	return html('about.html.php');
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


/**
 * Websites_list function.
 * 
 * @access public
 * @return void
 */
function Websites_list()
{
	//set('DojoList', Find_Dojo_all());
	set('DojoList', Websites());
	return html('websites_list.html.php');
}


/**
 * search function.
 * 
 * @access public
 * @return void
 */
function search()
{
	$term = params('term');
	set('term', $term);
	$term = strtolower($term);

	// Things to do, search the names of dojo forst, needs to be fuzzy
	// then search address fields
	// Set the result by default to nothing found, 
	// overwritten later if anything found.
	$result = "";



	//Identical dojo name match
	if (Find_dojo($term)) {

		$result 
            .= '<a href="'.
            url_for('dojo', $term).
            '">'.
            $term.
            '</a> (Identical Dojo Name match)';

		//echo $result;
	} else {

        //Find partial matches
		$Dojo = Sorted_dojo();
		foreach ($Dojo as $item) {
			$pos = strpos(strtolower($item), $term);

			if ($pos === false) {
				// string needle NOT found in haystack
			} else {
				$result 
				    .= '<a href="'.
				    url_for('dojo', $item).
				    '">'.
				    $item.
				    '</a> (partial match on name)<br />';
				// string needle found in haystack
			}

		}
	}
    

    //Search the address for the term
    $xml = Find_Dojo_all();
    
    foreach ($xml->Dojo as $dojo) {
		
		$pos = strpos(strtolower($dojo->DojoAddress), $term);
		
		if ($pos === false) {
				// string needle NOT found in haystack
        } else {

				$result 
				    .= '<a href="'.
				    url_for('dojo', $dojo->DojoName).
				    '">'.
				    $dojo->DojoName.
				    '</a> (partial match on address)<br />';
				    // string needle found in haystack
        }
		
		
	}

    //use same array to search on coach name
    foreach ($xml->Dojo as $dojo) {
		
		$pos = strpos(strtolower($dojo->CoachName), $term);
		
		if ($pos === false) {
				// string needle NOT found in haystack
        } else {
            $result 
                .= '<a href="'.
                url_for('dojo', $dojo->DojoName).
                '">'.
                $dojo->DojoName.
                '</a> (partial match on coach name)<br />';
				// string needle found in haystack
        }
		
		
	}

    //use same array to search on contact name
    foreach ($xml->Dojo as $dojo) {
		
		$pos = strpos(strtolower($dojo->ContactName), $term);
		
		if ($pos === false) {
				// string needle NOT found in haystack
        } else {
            $result 
                .= '<a href="'.
                url_for('dojo', $dojo->DojoName).
                '">'.
                $dojo->DojoName.
                '</a> (partial match on contact name)<br />';
				// string needle found in haystack
        }
		
		
	}






    // If no results found say so.
	if ($result == '') {
		$result = 'No results found';
	}

    //set results and render the results page
	set('results', $result);
	return html('search_results.html.php');
}


?>