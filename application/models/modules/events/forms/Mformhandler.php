<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mformhandler extends CI_Model{

	function __construct(){
		parent::__construct();		     
	}



	public function saveupdateevent($recId, $data){		
		$setSql = " SET ";
		$iteratingindex = 0;
		$finalarrindex = sizeof($data)-1;

		foreach ($data as $key => $value) {
			if($iteratingindex < $finalarrindex){
				$setSql .= "$key = ".prepsqlstringvar($value).", ";
			}
			elseif ($iteratingindex == $finalarrindex) {
				$setSql .= "$key = ".prepsqlstringvar($value)." ";
			}
			$iteratingindex++;
		}
		if ($recId == 0) {
			$sqlStr = "INSERT INTO events_events $setSql";
			$query = $this->db->query($sqlStr);
			return $this->db->insert_id();
		}
		else{
			$sqlStr = "UPDATE events_events $setSql WHERE id = ".prepsqlstringvar($recId).";";
			$query = $this->db->query($sqlStr);
			return $recId;
		}
	}

	public function getdayevents($date, $month, $year){
		$sqlStr ="SELECT COUNT(*) FROM events_events WHERE 1 AND is_active AND DAY(start_date) = ".prepsqlstringvar($date)." AND  MONTH(start_date) = ".prepsqlstringvar($month)." AND YEAR(start_date) = ".prepsqlstringvar($year).";";
		$query = $this->db->query($sqlStr);
		$result = $query->result();
		return $result;
	}





































}