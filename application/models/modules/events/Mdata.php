<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdata extends CI_Model{

	function __construct(){
		parent::__construct();		     
	}



	public function getmonthevents($month, $year){
		$sqlStr ="SELECT * FROM events_events WHERE 1 AND is_active AND MONTH(start_date) = ".prepsqlstringvar($month)." AND YEAR(start_date) = ".prepsqlstringvar($year).";";
		$query = $this->db->query($sqlStr);
		$result = $query->result();
		return $result;
	}

	public function getevent($recId){
		$eventfields = getTableFields('events_events');
		$selectSQL = '';
		$sqlStr ="SELECT * FROM events_events WHERE 1 AND is_active AND MONTH(start_date) = ".prepsqlstringvar($month)." AND YEAR(start_date) = ".prepsqlstringvar($year).";";
		$query = $this->db->query($sqlStr);
		$result = $query->result();
		return $result;
	}

	public function getdayevents($date, $month, $year){
		$sqlStr ="SELECT COUNT(*) FROM events_events WHERE 1 AND is_active AND DAY(start_date) = ".prepsqlstringvar($date)." AND  MONTH(start_date) = ".prepsqlstringvar($month)." AND YEAR(start_date) = ".prepsqlstringvar($year).";";
		$query = $this->db->query($sqlStr);
		$result = $query->result();
		return $result;
	}





































}