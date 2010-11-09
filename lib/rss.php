<?php
/**
 * DojoList RSS file
 *
 * This file is the library to create the RSS feed for the site.
 *
 * PHP version 5
 *
 * LICENSE: please see the AGPL license file is data/agpl-3.0.txt
 *
 * @category  RSS
 * @package   DojoList
 * @author    Lance Wicks <lw@judocoach.com>
 * @copyright 2009 Lance Wicks
 * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
 * @link      http://github.com/lancew/DojoList
 */
require_once 'lib/data.model.php'; 


function Load_RSS_data($file = 'data/dojo.rss')
{

	if (file_exists($file)) {
		$xml = simplexml_load_file($file);
	} else {
		return 'Failed to load RSS';
	}
	return $xml;
}



function Save_RSS_data($xml, $file = 'data/dojo.rss')
{
	$fh = fopen($file, 'w') or die("can't open file");
	fwrite($fh, $xml);
	fclose($fh);
    return $file;
}


function RSS_header()
{
    
    $rss_header = '<?xml version="1.0"?>
    <rss version="2.0">
	<channel>
		<title>DojoList Updates</title>
		<link>http://www.dojolist.org/</link>
		<description>Updates to Dojo listings</description>';
	date_default_timezone_set('Europe/London');
	$date = date(DATE_RFC822);
	$rss_header .= "<lastBuildDate>$date</lastBuildDate>";
		
	$rss_header .= '<generator>DojoList</generator>
	';	
	return $rss_header;	

}

function Delete_Oldest_rss($max_items='20')
{
    $new_rss = RSS_header();
    $item_count = 0;
    $rss = Load_RSS_data();
    foreach ($rss->channel->item as $item) {
        if ($item_count < $max_items) {
            $new_rss .= '
            ';
            $new_rss .= $item->asXML();
            $new_rss .= '
            ';
        }
        //echo $item_count.':'.$max_items; 
        $item_count++;
	}
	$new_rss .= '</channel></rss>';
	return(Save_RSS_data($new_rss));
}
 


function Add_Rss_item($item_array = null)
{
    $new_rss = RSS_header();
    $item_count = 0;
    $rss = Load_RSS_data();
    $desc = $item_array['description'];
    $pubDate = date(DATE_RFC822);
    $guid = str_replace(' ', '', $pubDate);
    $guid = str_replace(',', '', $guid);
    
    $new_rss .= "
    <item>
			<title>$desc</title>
			<description>$desc</description>
			<pubDate>$pubDate</pubDate>
			<guid>$guid</guid>
    </item>
    ";
    
    foreach ($rss->channel->item as $item) {
	       //print_r($item);
	       $new_rss .= '
	       ';
	       $new_rss .= $item->asXML();
	       $new_rss .= '
	       ';
	 
        //echo $item_count.':'.$max_items; 
        $item_count++;
	}
	$new_rss .= '</channel></rss>';
	Save_RSS_data($new_rss);
	Delete_oldest_rss();
 

    
}

 
 
 
 ?>