<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Maccess extends CI_Model {

    function __construct(){
        parent::__construct();
    }




    public function enterpasshist($id, $pass){
    	$sqlStr = "SELECT * FROM ngo_pass_history WHERE userId = ".strPrepStr($id)." ORDER BY id ASC;";
	    $query = $this->db->query($sqlStr);
	 	$prevpasses = $query->result();
	 	if (sizeof($prevpasses) < 5) {
	 		$sqlStrinsert = "INSERT INTO ngo_pass_history SET userId = ".strPrepStr($id).", password = PASSWORD(".strPrepStr($pass).");";
	    	$query = $this->db->query($sqlStrinsert);
	    	return true;
	 	}
	 	else{
	 		$deleterec = $prevpasses[0];
	 		$deleterecid = $deleterec->id;
	 		$sqlStr = "DELETE FROM ngo_pass_history WHERE id = ".strPrepStr($deleterecid).";";
	    	$query = $this->db->query($sqlStr);

	    	$sqlStrinsert = "INSERT INTO ngo_pass_history SET userId = ".strPrepStr($id).", password = PASSWORD(".strPrepStr($pass).");";
	    	$query = $this->db->query($sqlStrinsert);
	    	return true;
	 	}

    }

    
    public function passhistexists($id, $pass){ 
    	$sqlStr = "SELECT * FROM ngo_pass_history WHERE userId = ".strPrepStr($id)." AND password = PASSWORD(".strPrepStr($pass).");";
	    $query = $this->db->query($sqlStr);
	 	$prevpasses = $query->result();
	 	if (sizeof($prevpasses)>0) {
	 		return true;
	 	}
	 	else{
	 		return false;
	 	}
    }









 }

