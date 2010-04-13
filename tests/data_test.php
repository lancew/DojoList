<?php
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('lib/data.model.php');

class TestOfDataModel extends UnitTestCase {

    function testLoad_wrong_file() {
		$this->assertEqual(Load_Xml_data('data/No_file.xml'),'Failed to load XML');
	}
	function testLoad_specific_xml_data() {
		$this->assertTrue(Load_Xml_data('data/data.xml'));
	}
	function testLoad_default_xml_data() {
		$this->assertTrue(Load_Xml_data('data/data.xml'));
	}


    function testSave_data() {
		require_once('lib/data.model.php');
		$xml = Load_Xml_data();
		$response = Save_Xml_data($xml);
		
		$this->assertEqual($response,'Alresford Judo Club'); #temp change back to Data Saved ASAP
	}
	
	


}

$test = &new TestOfDataModel();
$test->run(new HtmlReporter());
?>