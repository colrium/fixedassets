<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM!
//
// copyright (c) 2013 by  Collins Riungu
// Nairobi Kenya
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
---------------------------------------------------------------------
      $this->load->model('financials/mdeposits', 'clsDeposits');
---------------------------------------------------------------------


---------------------------------------------------------------------*/

//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class Mfund extends CI_Model{

   public $whereExtra, $whereExtra2, $sdate1, $sdate2, $cdate1, $cdate2;

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
   }

 
  
  public function loadReport(){
  	$sdate1 = date($this->input->post('sdate1', TRUE));
  	$sdate2 = date($this->input->post('sdate2', TRUE));
  	$cdate1 = date($this->input->post('cdate1', TRUE));
  	$cdate2 = date($this->input->post('cdate2', TRUE));
  	$status = $this->input->post('status', TRUE);
  	$whereExtra="";
  	//submission date where clause
  	if ($sdate1!="" && $sdate2!=""){
  	$whereExtra .= "AND submission_deadline BETWEEN '".$sdate1."' AND '".$sdate2."' ";	
  	}

  	else if($sdate1!="" && $sdate2==""){
  	$whereExtra .= "AND submission_deadline = '".$sdate1."' ";	
  	}
  	else if($sdate1=="" && $sdate2!=""){
  	$whereExtra .= "AND submission_deadline = '".$sdate2."' ";	
  	}

  	else if($sdate1=="" && $sdate2==""){
  	$whereExtra .= "";	
  	}


  	//creation date where clause
  	if ($cdate1!="" && $cdate2!=""){
  	$whereExtra .= " AND dteOrigin BETWEEN '".$cdate1."' AND '".$cdate2."' ";	
  	}

  	else if($cdate1=="" && $cdate2!=""){
  		$whereExtra .= " AND dteOrigin = '".$cdate2."'";	
  		
  	}

  	else if($cdate1!="" && $cdate2==""){
  		$whereExtra .= " AND dteOrigin = '".$cdate1."'";
  	} 

  	if ($status=="1" || $status==""){
  		$whereExtra .= "";
  	}
  	else{
  		
  		$whereExtra .= " AND status = '".$status."'";
  	}
  	
  	
    $sqlStr =
         "SELECT * FROM ngo_fundraising_log
          WHERE
             bRetired  = 0 $whereExtra;";
       
    $query = $this->db->query($sqlStr);
    return $query->result();


  }

  public function loadSummarrySuccess($cdate12, $cdate22){

  	  	
	
 	$sqlStr =
         "SELECT Sum(`ngo_fundraising_log`.`amount_kes`) AS `total_succ`
          FROM `ngo_fundraising_log` AS `ngo_fundraising_log`
          WHERE
             `ngo_fundraising_log`.`bRetired`  = 0 AND `ngo_fundraising_log`.`status`='successful' AND `ngo_fundraising_log`.`dteOrigin` BETWEEN '".date($cdate12)."' AND '".date($cdate22)."';";
       
    $query = $this->db->query($sqlStr);
    return $query->result();

 }
 public function loadSummarryUnsuccess($cdate12, $cdate22){

  	
  	

 	
 	$sqlStr =
         "SELECT Sum(`ngo_fundraising_log`.`amount_kes`) AS `total_unsucc`
          FROM `ngo_fundraising_log` AS `ngo_fundraising_log`
          WHERE
             `ngo_fundraising_log`.`bRetired`  = 0 AND `ngo_fundraising_log`.`status`='unsuccessful'  AND `ngo_fundraising_log`.`dteOrigin` BETWEEN '".date($cdate12)."' AND '".date($cdate22)."';";
       
    $query = $this->db->query($sqlStr);
    return $query->result();

 }
 public function loadSummarryUnconverted( $cdate12, $cdate22){

 	
 	$sqlStr =
         "SELECT Sum(`ngo_fundraising_log`.`amount_kes`) AS `total_uncon`
          FROM `ngo_fundraising_log` AS `ngo_fundraising_log`
          WHERE
             `ngo_fundraising_log`.`bRetired`  = 0 AND `ngo_fundraising_log`.`status`!='successful'  AND `ngo_fundraising_log`.`status`!='unsuccessful' AND `ngo_fundraising_log`.`dteOrigin` BETWEEN '".$cdate12."' AND '".$cdate22."';";
       
    $query = $this->db->query($sqlStr);
    return $query->result();

 }






}