<?php
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('lib/data.model.php');

class TestOfRSS extends UnitTestCase {

    
   	function testLoad_RSS_file() {
		$this->assertTrue(Load_Xml_data('data/dojo.rss'));
	}	
	
    function testRSS_Channel_Title() {
        $rss = Load_Xml_data('data/dojo.rss');
        //print_r($rss);
        $text = $rss->channel->title;
        $this->assertEqual($text, 'DojoList Updates');
    }
    
    function testRSS_Item_Description() {
        $rss = Load_Xml_data('data/dojo.rss');
        //print_r($rss->channel->item[0]->description[0]);
        $text = $rss->channel->item[0]->description;
        $pattern = '#test123#';
		$result = preg_match($pattern, $text);
		$this->assertTrue($result);
    }


}

$test = &new TestOfRSS();
$test->run(new HtmlReporter());
?>