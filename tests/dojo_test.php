<?php
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('lib/dojo.model.php');

class TestOfDojolist extends UnitTestCase {

	
	function testFind_Dojo_all() {
		$this->assertTrue(Find_Dojo_all());
	}
	function testFind_dojo_empty() {
		$this->assertFalse(Find_dojo());
	} 
	function testFind_dojo_doesnotexist() {
		$this->assertFalse(Find_dojo('fake'));
	} 
	function testFind_dojo_Alresford() {
		$this->assertTrue(Find_dojo('Alresford Judo Club'));
	}	
	function testFind_dojo_AlresfordDetails() {
		$xml = Find_dojo('Alresford Judo Club');
		$text = $xml->DojoName;
		$this->assertEqual($text,'Alresford Judo Club');
	}		
	
	function testCreate_dojo() {
		$this->assertEqual(Create_dojo(), 'Dojo Created');
	}
	
}

$test = &new TestOfDojolist();
$test->run(new HtmlReporter());
?>