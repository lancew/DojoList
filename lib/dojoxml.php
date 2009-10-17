<?php


function load_dojo() {
	if (file_exists('data/dojo.xml')) {
		$xml = simplexml_load_file('data/dojo.xml');
		return($xml);
	} else {
		return(0);
	}

}

