<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
 ActionAid CRM!

 copyright (c) 2012-2015 by  Collins Riungu


---------------------------------------------------------------------*/
class Mleadsettings extends CI_Model{



   function __construct(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
		parent::__construct();
   }


public function allSources(){
$sqlStr ="SELECT * FROM ngo_lead_sources WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();



}

public function allStages(){
$sqlStr ="SELECT * FROM ngo_lead_stages WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();


	
}

public function allPriorities(){
$sqlStr ="SELECT * FROM ngo_lead_priorities WHERE NOT bRetired ;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();


	
}

public function allGroups(){
$sqlStr ="SELECT * FROM ngo_leadgroups WHERE NOT bRetired ;";
        $query = $this->db->query($sqlStr);
   return $query->result();


  
}

public function singleSource($id){
$sqlStr ="SELECT * FROM ngo_lead_sources WHERE NOT bRetired AND id = ?;";
	      $query = $this->db->query($sqlStr, array($id));
	 return $query->result();



}

public function singleGroup($id){
$sqlStr ="SELECT * FROM ngo_leadgroups WHERE NOT bRetired AND id=?;";
        $query = $this->db->query($sqlStr, array($id));
   return $query->result();

}

public function singleStage($id){
$sqlStr ="SELECT * FROM ngo_lead_stages WHERE NOT bRetired AND id=?;";
	      $query = $this->db->query($sqlStr, array($id));
	 return $query->result();


	
}

public function singlePriority($id){
$sqlStr ="SELECT * FROM ngo_lead_priorities WHERE NOT bRetired AND id=?;";
	      $query = $this->db->query($sqlStr, array($id));
	 return $query->result();


	
}


public function addPriority(){
$priority_name= $this->input->post('priority_name', TRUE);
   $sqlStr =
         "INSERT INTO ngo_lead_priorities
         SET 
         priority_name=".$this->db->escape($priority_name).",
         dte_created=NOW();";
       
    $query = $this->db->query($sqlStr);
    return true;


	
}


public function addStage(){
$stage_name= $this->input->post('stage_name', TRUE);
   $sqlStr =
         "INSERT INTO ngo_lead_stages
         SET 
         stage_name=".$this->db->escape($stage_name).",
         dte_created=NOW();";
       
    $query = $this->db->query($sqlStr);
    return true;


	
}

public function addGroup(){
$groupName= $this->input->post('groupName', TRUE);
   $sqlStr =
         "INSERT INTO ngo_leadgroups
         SET 
         groupName=".$this->db->escape($groupName).",
         dteCreated=NOW();";
       
    $query = $this->db->query($sqlStr);
    return true;


  
}

public function addSource(){
$source_name= $this->input->post('source_name', TRUE);
   $sqlStr =
         "INSERT INTO ngo_lead_sources
         SET 
         source_name=".$this->db->escape($source_name).",
         dte_created=NOW();";
       
    $query = $this->db->query($sqlStr);
    return true;


	
}

public function updateSource($id){
$source_name= $this->input->post('source_name', TRUE);
   $sqlStr =
         "UPDATE ngo_lead_sources
         SET 
         source_name=".$this->db->escape($source_name)."
          WHERE  id=".$this->db->escape($id).";";
       
    $query = $this->db->query($sqlStr);
    return true;


	
}

public function updateGroup($id){
$groupName= $this->input->post('groupName', TRUE);
   $sqlStr =
         "UPDATE ngo_leadgroups
         SET 
         groupName=".$this->db->escape($groupName)."
          WHERE  id=".$this->db->escape($id).";";
       
    $query = $this->db->query($sqlStr);
    return true;


  
}

public function updateStage($id){
$stage_name= $this->input->post('stage_name', TRUE);
   $sqlStr =
         "UPDATE ngo_lead_stages
         SET 
         stage_name=".$this->db->escape($stage_name)."
          WHERE  id=".$this->db->escape($id).";";
       
    $query = $this->db->query($sqlStr);
    return true;


	
}

public function updatePriority($id){
$priority_name= $this->input->post('priority_name', TRUE);
   $sqlStr =
         "UPDATE ngo_lead_priorities
         SET 
         priority_name=".$this->db->escape($priority_name)."
          WHERE  id=".$this->db->escape($id).";";
       
    $query = $this->db->query($sqlStr);
    return true;


	
}


public function deletePriority($id){
$sqlStr =
         "UPDATE ngo_lead_priorities
         SET 
         bRetired=1
          WHERE  id=".$this->db->escape($id).";";
       
    $query = $this->db->query($sqlStr);
    return true;


	
}

public function deleteStage($id){
$sqlStr =
         "UPDATE ngo_lead_stages
         SET 
         bRetired=1
          WHERE  id=".$this->db->escape($id).";";
       
    $query = $this->db->query($sqlStr);
    return true;


	
}

public function deleteSource($id){
$sqlStr =
         "UPDATE ngo_lead_sources
         SET 
         bRetired=1
          WHERE  id=".$this->db->escape($id).";";
       
    $query = $this->db->query($sqlStr);
    return true;


	
}

public function deleteGroup($id){
$sqlStr =
         "UPDATE ngo_leadgroups
         SET 
         bRetired=1
          WHERE  id=".$this->db->escape($id).";";
       
    $query = $this->db->query($sqlStr);
    return true;


  
}

 }