<?php
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'lib/dojo.model.php';


/**
 * option function.
 *
 * This function is a mock of the option function in index.php
 * needed to provide version number which is used in dojo.model.php
 * if this function not included, tests fail.
 *
 * @access public
 * @param mixed $var
 * @return void
 */
function option($var)
{
	return '0.7.0';
}

class TestOfDojolist extends UnitTestCase 
{


	function testFind_Dojo_all()
	{
		$this->assertTrue(Find_Dojo_all());
	}
	/*
	function testFind_dojo_empty() {
		$this->assertFalse(Find_dojo());
	}
	*/
	function testFind_dojo_doesnotexist()
	{
		$this->assertFalse(Find_dojo('fake'));
	}
	function testFind_dojo_Alresford()
	{
		$this->assertTrue(Find_dojo('Alresford Judo Club'));
	}
	function testFind_dojo_AlresfordDetails()
	{
		$xml = Find_dojo('Alresford Judo Club');
		$text = $xml->DojoName;
		//print_r($text);
		$this->assertEqual($text, 'ALRESFORD JUDO CLUB');
	}


	function testCreate_dojo()
	{
		if (Find_dojo('test_dojo')->DojoName != 'test_dojo') {

			$dojo_array = array(
			                    'DojoName' => 'test_dojo', 
			                    'ClubWebsite' => 'url', 
			                    'Latitude' => '0', 
			                    'Longitude' => '0', 
			                    'GUID' => guid() 
			                    );
			Create_dojo($dojo_array);
			$xml = Find_dojo('test_dojo');
			$text = $xml->DojoName;
			$this->assertEqual($text, 'test_dojo');


		} else {
			$this->fail('test_dojo found prior to create test');
		}

	}

	function testGUIDisPresent()
	{
		$xml = Find_dojo('test_dojo');
		$text = $xml->GUID;
		$this->assertPattern(
		'/^\{?[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\}?$/i', 
		$text
		);
	}


	function testUpdatedisPresent()
	{
		$xml = Find_dojo('test_dojo');
		$text = $xml->Updated;

		// Friday, October 29, 2010 02:16
		$this->assertTrue($text);
	}

	function testUpdatedisRight()
	{
		$xml = Find_dojo('test_dojo');
		$text = $xml->Updated;

		// Friday, October 29, 2010 02:16
		$this->assertPattern('/^[A-Za-z]*+,/i', $text);
	}



	// --------------------------------------
	// *** test_dojo is deleted at this point
	// --------------------------------------


	function testDelete_dojo()
	{
		if (Find_dojo('test_dojo')) {
			Delete_dojo('test_dojo');
			$this->assertFalse(Find_dojo('test_dojo'), 'test_dojo was not deleted');
		} else {
			$this->fail('test_dojo did not exist prior to delete test');
		}
	}


	function testNoExtraDojoTagInTest()
	{
		// This tests for issue http://github.com/lancew/DojoList/issues#issue/6

		$tempXML = Load_Xml_data();
		$xmlText = $tempXML->asXML();
		$pattern = '#<Dojo/>#';
		$result = preg_match($pattern, $xmlText);
		//echo "result:".$result;
		$this->assertFalse(
		              $result, 
		              'The test for <Dojo/> tags at the end of the file failed'
		              );
	}

	function testGeoAddress()
	{
		$latlng = geoAddress('25 Kauri Road, whenuapai, Auckland, New Zealand');
		//print_r($latlng);
		$this->assertEqual($latlng[0], (float)'-36.7959750', 'Latitude found');
		$this->assertEqual($latlng[1], (float)'174.6368070', 'Longitude found');
	}






}

$test = &new TestOfDojolist();
$test->run(new HtmlReporter());
?>