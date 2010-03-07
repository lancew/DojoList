<?php
require_once('../lib/simpletest/unit_tester.php');
require_once('../lib/simpletest/reporter.php');
require_once('../lib/dojo.model.php');

class TestOfDojolist extends UnitTestCase {

	function testDojo_Positive() {
		$this->assertTrue(positive());
	}
	function testFind_Dojo_all() {
		$this->assertTrue(Find_Dojo_all());
	}
 
}

$test = &new TestOfDojolist();
$test->run(new HtmlReporter());
?>