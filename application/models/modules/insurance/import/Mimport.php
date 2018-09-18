<?php
class Mimport extends CI_Model{

	function __construct(){
	    parent::__construct();     
	}





function importclientrecord($data, $recId='0'){
	$actionuser = USERID;
	$sqlExtra = '';
	$index = 0;
	$datasize = sizeof($data);
	$lastindex = $datasize - 1;
	foreach ($data as $key => $value) {
		if ($index < $lastindex) {
			$sqlExtra .= " ".$key." = '".$value."', ";
		}
		else{
			$sqlExtra .= " ".$key." = '".$value."' ";
		}
		$index++;
	}
	if ($recId=='0') {
		$sqlStr ="INSERT INTO insurance_clients SET $sqlExtra;";
		$query = $this->db->query($sqlStr);
		$recordId = $this->db->insert_id();

	}
	else{
		$sqlStr ="UPDATE insurance_clients SET $sqlExtra WHERE clientId = $recId;";
		$query = $this->db->query($sqlStr);
		$recordId = $recId;
	}
	return $recordId;
	
}
















}