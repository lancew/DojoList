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


function LoadFarXML($file)
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

?>