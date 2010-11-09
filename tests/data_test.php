<?php
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'lib/data.model.php';

class TestOfDataModel extends UnitTestCase {


	function testLoad_wrong_file()
	{
		$this->assertEqual(Load_Xml_data('data/No_file.xml'), 'Failed to load XML');
	}
	function testLoad_specific_xml_data()
	{
		$this->assertTrue(Load_Xml_data('data/data.xml'));
	}
	function testLoad_default_xml_data()
	{
		$this->assertTrue(Load_Xml_data('data/data.xml'));
	}

	/*
    function testLoad_test_xml_data() {
        $tempXML = Load_Xml_data('data/test.xml');
		$xmlText = $tempXML->asXML();
		$pattern = '#<DojoName>test_dojo</DojoName>#';
		$result = preg_match($pattern, $xmlText);
		$this->assertTrue($result);

	}
    */


	function testSave_data()
	{
		require_once 'lib/data.model.php';
		$xml = Load_Xml_data('data/test.xml');
		$response = Save_Xml_data($xml, 'data/test1.xml');
		//temp change back to Data Saved ASAP
		$this->assertTrue(file_exists('data/test1.xml')); 
		unlink('data/test1.xml');
	}





}

$test = &new TestOfDataModel();
$test->run(new HtmlReporter());
?>