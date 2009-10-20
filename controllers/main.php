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

	set('DojoList', $xml);

	
    return html('main.html_list.html.php');
}