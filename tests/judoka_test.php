<?php
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'lib/judoka.model.php';


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


class TestOfJudoka extends UnitTestCase 
{

function testDummy()
	{
		$this->assertTrue(1); 
	}



}

$test = &new TestOfJudoka();
$test->run(new HtmlReporter());
?>