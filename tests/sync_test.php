<?php
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'lib/sync.model.php';
require_once 'lib/data.model.php';
require_once 'lib/dojo.model.php';



	// option function dummy to solve issue in tests of sync as we are not loading the entire framework
	function option($name){
	   return 'http://dev.dojolist/data/dojo.xml';
	
	}

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
        
        $result = DojoNotInLocal('data/dojo_test.xml');
        $this->assertEqual($result, 1, 'DojoNotInLocal returned '.$result.' not 1');
        
    }
    
     function testListDojoNotInLocal()
    {
        
        $result = ListDojoNotInLocal('data/dojo_test.xml');
        //print_r($result);
        foreach($result as $dojo) {
            $this->assertEqual($dojo, 'testtttt', 'ListDojoNotInLocal returned '.$result.' not testtt');
        }
    }
    
    
	   
	function testDojoUpdatedInFar()
	{
	   $result = NewerFarDojo('data/dojo_test.xml');
	   $this->assertEqual($result, 1, 'NewerFarDojo returned '.$result.' not 1');
	
	}
	
	
	
	

}

$test = &new TestOfSyncModel();
$test->run(new HtmlReporter());
?>