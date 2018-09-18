<?php
class Musers extends CI_Model{

function __construct(){
      parent::__construct();

}


function loaduser($recId){
	$sqlStr ="SELECT * FROM users WHERE id = '$recId' LIMIT 0,1;";
 	$query = $this->db->query($sqlStr);
 	$records = $query->result();
	if (sizeof($records)>0) {
		return $records[0];
	}
	else{
		return false;
	}
}

function loadusergroup($recId){
	$sqlStr ="SELECT * FROM groups WHERE id = '$recId';";
 	$query = $this->db->query($sqlStr);
	$records = $query->result();
	if (sizeof($records)>0) {
		return $records[0];
	}
	else{
		return false;
	}	
}

function loadusergroups(){
	$sqlStr ="SELECT * FROM groups;";
 	$query = $this->db->query($sqlStr);
	return $query->result();
}

function createupdateusergroup($recId, $details=array()){
	$sqlStrSet = '';
	if (sizeof($details)>0) {
		$sqlStrSet .= ' SET ';
		$i=0;
		foreach ($details as $key => $value) {
			if ($i != (sizeof($details)-1)) {
				$sqlStrSet .= $key." = '".$value."', ";
			}
			else{
				$sqlStrSet .= $key." = '".$value."' ";
			}
			$i++;
		}
	}

	if ($recId==0) {
		$sqlStr ="INSERT INTO  groups $sqlStrSet;";
		$query = $this->db->query($sqlStr);
		return $this->db->insert_id();
	}
	else{
		$sqlStr ="UPDATE  groups $sqlStrSet WHERE id='$recId';";
		$query = $this->db->query($sqlStr);
		return $recId;
	}
		
	
 	
	
}

function useringroups($recId){
	$sqlStr ="SELECT * FROM users_groups WHERE user_id = '$recId';";
 	$query = $this->db->query($sqlStr);
	$records = $query->result();
	$returnarr =array();

	foreach ($records as $record) {
		array_push($returnarr, $record->group_id);
	}

	return $returnarr;
}




































}