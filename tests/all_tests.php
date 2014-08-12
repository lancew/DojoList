<?php
require_once 'simpletest/autorun.php';



	// option function dummy to solve issue in tests of sync as we are not loading the entire framework
	function option($option)
	{
	  if ($option == 'version') {
	   return 'test';
	  } else {
	  return 'http://dev.dojolist/data/dojo.xml';
	}
	}

class AllTests extends TestSuite {
	function AllTests()
	{
		$this->TestSuite('All tests');
		$this->addFile('tests/dojo_test.php');
		$this->addFile('tests/data_test.php');
		$this->addFile('tests/rss_test.php');
		//$this->addFile('tests/sync_test.php');
	}
}
?>
