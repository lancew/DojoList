<?php
require_once('lib/simpletest/unit_tester.php');
require_once('lib/simpletest/reporter.php');
require_once('lib/dojo.model.php');

class TestOfDojolist extends UnitTestCase {

	function testDojo_Positive() {
		$this->assertTrue(positive());
	}
	function testDojo_Negative() {
		$this->assertFalse(negative());
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
}

$test = &new TestOfDojolist();
$test->run(new HtmlReporter());
?>