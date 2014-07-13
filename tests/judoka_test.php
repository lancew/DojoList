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

	function testBasicJudokaClass ()
	{
		$j = new Judoka();
		$this->assertIsA($j, 'Judoka');

		$j->given_name ='Matthias';
		$j->family_name = 'Fischer';
		$j->email = 'fake@ippon.org';

		$this->assertEqual($j->given_name, 'Matthias');
		$this->assertEqual($j->family_name, 'Fischer');
		$this->assertEqual($j->email, 'fake@ippon.org');
		// {91CD7910-26DC-058A-853A-06F31266A86F}
		$this->assertPattern('/^\{\d|\w{8}-\d|\w{4}-\d|\w{4}-\d|\w{4}-\d|\w{8}\}$/', $j->uuid);

	}


function testDummy()
	{
		$this->assertTrue(1); 
	}



}

$test = &new TestOfJudoka();
$test->run(new HtmlReporter());
?>