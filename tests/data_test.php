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

    function testGet_string_between()
	{
		//require_once 'lib/data.model.php';
		$result = Get_string_between('addda', 'a', 'a');
		$this->assertEqual($result, 'ddd', 'test Get_string_between'); 
		
	}
	
	function testValidate_fields_Dojoname()
	{
		$result = Validate_field('1Lwtest', 'DojoName');
		//echo '-'.$result.'-';
		$this->assertEqual($result, 'Dojo Name: Must be alphanumeric only', 'test Validate_field Dojoname'); 
		$result = Validate_field('Lwtest', 'DojoName');
		//echo '-'.$result.'-';
		$this->assertEqual($result, null, 'test Validate_field Dojoname 2'); 
		
	}

   


}

$test = &new TestOfDataModel();
$test->run(new HtmlReporter());
?>