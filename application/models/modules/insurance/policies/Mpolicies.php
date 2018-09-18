<?php
class Mpolicies extends CI_Model{

	function __construct(){
	    parent::__construct();     
	}



public function loadRecord($recId){
	$sqlStr ="SELECT * FROM policies WHERE policyId = $recId LIMIT 0,1;";
 	$query = $this->db->query($sqlStr);
	return $query->result();

}



















}