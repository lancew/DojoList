<?php
 
# GET /
function main_page() {
    return html('main.html.php');
}

function html_list() {
	if (file_exists('data/dojo.xml')) {
	$xml = simplexml_load_file('data/dojo.xml');
	} else {
		exit('Failed to open dojo.xml.');
	}

	$dojo_list = '';
	foreach ($xml->Dojo as $dojo) {
		 $dojo_list[] =$dojo->ClubName;
	}
	#print_r($dojo_list);
	set('DojoList', $xml);

	
    return html('main.html_list.html.php');
}