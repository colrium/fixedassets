<?php
class Mcovers extends CI_Model{

	function __construct(){
	    parent::__construct();     
	}


public function loadRecord($table="", $pkColmn="", $recId=""){
	if ($table!="" && $recId!="" && $pkColmn!="") {
		$sqlStr ="SELECT * FROM $table WHERE $pkColmn = $recId AND NOT bRetired;";
	 	$query = $this->db->query($sqlStr);
		return $query->result();
	}
	else{
		$returnData = array();
		return $returnData;
	}

}

public function loadAllRecords($table=""){
	if ($table!="") {
		$sqlStr ="SELECT * FROM $table WHERE NOT bRetired;";
	 	$query = $this->db->query($sqlStr);
		return $query->result();
	}
	else{
		$returnData = array();
		return $returnData;
	}

}

























}