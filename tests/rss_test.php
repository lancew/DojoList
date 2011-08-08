<?php
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'lib/rss.php';

// Setting this to prevent error when running from CLI
$_SERVER['SERVER_NAME'] = 'dev.dojolist';


class TestOfRSS extends UnitTestCase
{


	
	function TestLoadRssFile()
	{
		$this->assertTrue(Load_RSS_data());
	}


	function TestDeleteOldestRss()
	{
		$text = Delete_oldest_rss();
		$this->assertEqual($text, 'data/dojo.rss');

	}

	function TestAddRssItem()
	{
		$item_array = array('description' => 'test_add');
		//print_r($item_array);
		Add_rss_item($item_array);
		
		//Now test RSS from dojo create is correct
		require_once 'lib/dojo.model.php';
		
		

			$dojo_array = array(
			                    'DojoName' => 'test_dojo_rss_test', 
			                    'ClubWebsite' => 'url', 
			                    'Latitude' => '0', 
			                    'Longitude' => '0', 
			                    'GUID' => guid() 
			                    );
			Create_dojo($dojo_array);
			     
			Delete_dojo('test_dojo_rss_test');

	}





}

$test = &new TestOfRSS();
$test->run(new HtmlReporter());
?>