<?php
/**
 * DojoList Sync Data Model file
 *
 * This model abstracts data access away from the dojo model.
 *
 * PHP version 5
 *
 * LICENSE: please see the AGPL license file is data/agpl-3.0.txt
 *
 * @category  SyncModel
 * @package   DojoList
 * @author    Lance Wicks <lw@judocoach.com>
 * @copyright 2011 Lance Wicks
 * @license   http://www.gnu.org/licenses/agpl.html  AGPL License 3.0
 * @link      http://github.com/lancew/DojoList
 */


function LoadFarXML($file = 'data/dojo.xml')
{
	return simplexml_load_file($file);
}

function DojoNotInLocal($file)
{
    $farxml = LoadFarXML($file);
    $localxml = Load_Xml_data();
    
    $fardojolist = array();
    $localdojolist = array();
    
	foreach ($farxml->Dojo as $fardojo) {
    // ===============================   
        $fardojolist[] = (string)$fardojo->DojoName;        
        
    // ================================    
    }
    
    foreach ($localxml->Dojo as $localdojo) {
    // ===============================   
        $localdojolist[] = (string)$localdojo->DojoName;        
        
    // ================================    
    }
    
    
    $result = array_diff($fardojolist, $localdojolist);
    
	
	return count($result);	
}

function ListDojoNotInLocal($file)
{
    $farxml = LoadFarXML($file);
    $localxml = Load_Xml_data();
    
    $fardojolist = array();
    $localdojolist = array();
    
	foreach ($farxml->Dojo as $fardojo) {
    // ===============================   
        $fardojolist[] = (string)$fardojo->DojoName;        
        
    // ================================    
    }
    
    foreach ($localxml->Dojo as $localdojo) {
    // ===============================   
        $localdojolist[] = (string)$localdojo->DojoName;        
        
    // ================================    
    }
    
    
    $result = array_diff($fardojolist, $localdojolist);
    
	
	
	ImportDojoNotInLocal($file);
	
	return $result;	
}

function ImportDojoNotInLocal($file)
{
    $farxml = LoadFarXML($file);
    $localxml = Load_Xml_data();
    
    $fardojolist = array();
    $localdojolist = array();
    
	foreach ($farxml->Dojo as $fardojo) {
    // ===============================   
        $fardojolist[] = (string)$fardojo->DojoName;        
        
    // ================================    
    }
    
    foreach ($localxml->Dojo as $localdojo) {
    // ===============================   
        $localdojolist[] = (string)$localdojo->DojoName;        
        
    // ================================    
    }
    
    
    $result = array_diff($fardojolist, $localdojolist);
    $url = str_ireplace('data/dojo.xml','', option('sync_site'));
    //echo $url;
    foreach($result as $dojo){
        
        $link = $url.'api/dojo/'.str_ireplace(' ','%20',$dojo);
        //echo $link.'<br />';
        $json_data =  file_get_contents($link);
        //echo $json_data;
        $data = json_decode($json_data,TRUE);
        //print_r($data);
        Create_dojo($data);
        
    }
	
	
	
	return $result;	
}



function NewerFarDojo($file)
{
    $farxml = LoadFarXML($file);
    $localxml = Load_Xml_data();
    
    $fardojolist = array();
    $fardojolist_up = array();
    $localdojolist = array();
    $localdojolist_up = array();
    
    
    $count = 0;
    $flag = 0;
	foreach ($farxml->Dojo as $fardojo) {
    // ===============================   
        $fardojolist[$count] = (string)$fardojo->DojoName; 
        $fardojolist_up[$count] = (string)$fardojo->Updated;        
        $count++;
    // ================================    
    }
    
    $count = 0;
    foreach ($localxml->Dojo as $localdojo) {
    // ===============================   
        $localdojolist[$count] = (string)$localdojo->DojoName;   
        $localdojolist_up[$count] = (string)$localdojo->Updated;    
        $count++;
    // ================================    
    }

    //echo $localdojolist[0].' - '.$localdojolist_up[0].'<br />'; 
    
    
    $count = 0;
    foreach ($fardojolist_up as $update)
    {
        if(strtotime($fardojolist_up[$count]) > strtotime($localdojolist_up[$count]))
        {
            //echo $fardojolist[$count].' - far:'.$fardojolist_up[$count].' local:'.$localdojolist_up[$count].'<br />'; 
            //echo $fardojolist[$count].'<br />';
            $flag++;
        }
        $count++;
    }
    return $flag;
}

function ListNewerFarDojo($file)
{
    $farxml = LoadFarXML($file);
    $localxml = Load_Xml_data();
    
    $fardojolist = array();
    $fardojolist_up = array();
    $localdojolist = array();
    $localdojolist_up = array();
    
    $newlist = array();
    
    $count = 0;
    
	foreach ($farxml->Dojo as $fardojo) {
    // ===============================   
        $fardojolist[$count] = (string)$fardojo->DojoName; 
        $fardojolist_up[$count] = (string)$fardojo->Updated;        
        $count++;
    // ================================    
    }
    
    $count = 0;
    foreach ($localxml->Dojo as $localdojo) {
    // ===============================   
        $localdojolist[$count] = (string)$localdojo->DojoName;   
        $localdojolist_up[$count] = (string)$localdojo->Updated;    
        $count++;
    // ================================    
    }

    //echo $localdojolist[0].' - '.$localdojolist_up[0].'<br />'; 
    
    
    $count = 0;
    foreach ($fardojolist_up as $update)
    {
        if(strtotime($fardojolist_up[$count]) > strtotime($localdojolist_up[$count]))
        {
            //echo $fardojolist[$count].' - far:'.$fardojolist_up[$count].' local:'.$localdojolist_up[$count].'<br />'; 
            //echo $fardojolist[$count].'<br />';
            $newlist[]=$localdojolist[$count];
        }
        $count++;
    }
    return $newlist;
}



?>