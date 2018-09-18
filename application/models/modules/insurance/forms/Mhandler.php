<?php
class Mhandler extends CI_Model{

	function __construct(){
	    parent::__construct();     
	}





function recSaveUpdate($data, $recId='0', $table, $pkColumn){
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
		$sqlExtra .= ", dteCreated = NOW(), usrCreated = $actionuser";
		$sqlStr ="INSERT INTO $table SET $sqlExtra;";
		$query = $this->db->query($sqlStr);
		$recordId = $this->db->insert_id();

	}
	else{
		$sqlExtra .= ", dteModified = NOW(), usrModified = $actionuser";
		$sqlStr ="UPDATE $table SET $sqlExtra WHERE $pkColumn = $recId;";
		$query = $this->db->query($sqlStr);
		$recordId = $recId;
	}
	return $recordId;
	
}
















}