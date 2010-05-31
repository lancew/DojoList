<?php
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('lib/rss.php');


class TestOfRSS extends UnitTestCase {

    
   	function testLoad_RSS_file() {
		$this->assertTrue(Load_RSS_data());
	}	
	
        
    function testDelete_oldest_rss() {
        $text = Delete_oldest_rss();
        $this->assertEqual($text, 'data/dojo.rss');
    
    }
    
    function testAdd_rss_item() {
        $item_array = array('description' => 'test_add');
        //print_r($item_array);
		Add_rss_item($item_array);      
    
    }
    

		


}

$test = &new TestOfRSS();
$test->run(new HtmlReporter());
?>