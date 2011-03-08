<?php
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'lib/sync.model.php';
require_once 'lib/data.model.php';
require_once 'lib/dojo.model.php';


class TestOfSyncModel extends UnitTestCase {

	
	function testLoadFarXMLHTTP()
	{
		$this->assertTrue(LoadFarXML('http://dev.dojolist/data/dojo.xml'), 'LoadFarXML() the local xml via http');
		
	}
	
	
	function testLoopFarDojo()
	{
	   $xml = LoadFarXML('http://dev.dojolist/data/dojo.xml');
	  
	   $count = 0;
	   $text = '';
	   foreach ($xml->Dojo as $dojo) {
		if($count === 0){
		  $text = $dojo->DojoName;
		  $count++;
		  }
		}
		
		$this->assertEqual($text, 'Alresford Judo Club', 'First Dojo is '.$text.'not "Alresford Judo Club"');
	}

	 function testAlresfordInFarAndLocal()
	{
	   $xml = LoadFarXML('http://hampshirejudo.org.uk/dojolist/data/dojo.xml');
	  
	   $count = 0;
	   $text = '';
	   foreach ($xml->Dojo as $dojo) {
		if($count === 0){
		  $text = $dojo->DojoName;
		  $count++;
		  }
		}
		
		$result = Find_dojo($text);
		//$result = Dojo_in_local('blahblah');
		
		
		$this->assertTrue($result, 'Alresford is in local and far xml');
	} 
	  	   
	   

    
    
    function testDojoNotInLocal()
    {
        
        $result = DojoNotInLocal('http://hampshirejudo.org.uk/dojolist/data/dojo.xml');
        $this->assertEqual($result, 1, 'DojoNotInLocal returned '.$result.' not 1');
        
    }
	   
	function testDojoUpdatedInFar()
	{
	   $result = NewerFarDojo('http://hampshirejudo.org.uk/dojolist/data/dojo.xml');
	   $this->assertEqual($result, 1, 'NewerFarDojo returned '.$result.' not 1');
	
	}
	

}

$test = &new TestOfSyncModel();
$test->run(new HtmlReporter());
?>