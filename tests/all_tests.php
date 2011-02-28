<?php
require_once 'simpletest/autorun.php';

class AllTests extends TestSuite {
	function AllTests()
	{
		$this->TestSuite('All tests');
		//$this->addFile('tests/dojo_test.php');
		$this->addFile('tests/data_test.php');
		$this->addFile('tests/rss_test.php');
		$this->addFile('tests/sync_test.php');
	}
}
?>