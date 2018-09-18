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
class Mfundraising extends CI_Model{

   public $strWhereExtra, $lNumLogRecs, $logRecs;

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
   }



 public function saveNew($amount_kes, $amount_gbp){
   $lead_name = $this->input->post('lead_name', TRUE);
   $theme = $this->input->post('theme', TRUE);
   $requirements = $this->input->post('requirements', TRUE);
   $submission_deadline = $this->input->post('submission_deadline', TRUE);
   $title = $this->input->post('title', TRUE);
   $donor = $this->input->post('donor', TRUE);
   $amount = $this->input->post('amount', TRUE);
   $period = $this->input->post('period', TRUE);
   $status = $this->input->post('status', TRUE);
   $donor_cur = $this->input->post('donor_cur', TRUE);
   $comment = $this->input->post('comment', TRUE);
   $amount_realized_ytd = $this->input->post('amount_realized_ytd', TRUE);
   $fundraising_gap = $this->input->post('fundraising_gap', TRUE);
   $realized_cur=$this->input->post('realized_cur', TRUE);

    $sqlStr =
         "INSERT INTO ngo_fundraising_log
          SET 
             lead_name    = '$lead_name',
             theme    = '$theme',
             requirements    = '$requirements',
             submission_deadline  = '$submission_deadline',
             title    = '$title',
             donor    = '$donor',
             amount = $amount,
             amount_kes = $amount_kes,
             amount_gbp = $amount_gbp,
             period = '$period',
             status = '$status',
             amount_realized_ytd = '$amount_realized_ytd',
             realized_cur = '$realized_cur',
             donor_cur = '$donor_cur',
             comment = '$comment',            
             dteOrigin = NOW(),
             bRetired  = 0;";

      $this->db->query($sqlStr);
      return($this->db->insert_id());
 }


 public function loadRecord($logID){
    $sqlStr =
           "SELECT
               *
            FROM ngo_fundraising_log
            WHERE NOT bRetired
            AND logID=$logID;";
    $query = $this->db->query($sqlStr);
    return ($query->result());


 }
 public function loadDocs($logID){
   $sqlStr =
           "SELECT
               *
            FROM ngo_log_docs
            WHERE  logID=$logID;";
    $query = $this->db->query($sqlStr);
    return ($query->result());

 }
 public function deleteFile($id){
  $sqlStr =
           "DELETE FROM ngo_log_docs
               WHERE id=$id
            ";
         $query = $this->db->query($sqlStr);
    
    return true;
   
 }
 public function loadRecordvia($logID){
    $sqlStr =
           "SELECT
               *
            FROM ngo_fundraising_log
            WHERE NOT bRetired
            AND logID=$logID;";
    $query = $this->db->query($sqlStr);
    
    $this->lNumLogRecs = $query->num_rows();
      if ($this->lNumLogRecs == 0) {
         $this->logRecs[0] = null;
      }else {
         
         $this->logRecs = array();
         foreach ($query->result() as $row){

            $log->lKeyID             =  $row->pe_lKeyID;
            $log->logDonor           = $row->donor;
            
            }
          }
            


 }


 public function addDoc($new_name, $logID, $ext){
   $name = $this->input->post('file_name', TRUE);
   $sqlStr =
           "INSERT INTO ngo_log_docs
               
            SET 
              logID=$logID,
              file_name='$name',
              file_ext='$ext',
              new_name='$new_name'            
            ";
         $query = $this->db->query($sqlStr);
    return true;

 }

 public function loadRecords(){
    $sqlStr =
           "SELECT
               *
            FROM ngo_fundraising_log
            WHERE NOT bRetired
            ";
         $query = $this->db->query($sqlStr);
    return $query->result();
 }

 public function deleteRecord($logID){
    $glUserID = USERID;
   $sqlStr =
           "UPDATE ngo_fundraising_log
               SET bRetired=1
            WHERE logID=$logID
            ";
         $query = $this->db->query($sqlStr);
  $sqlRec =
          "INSERT INTO ngo_recycle_bin
           SET 
           rb_lGroupID=0,
           rb_lForeignID=$logID,
           rb_enumRecycleType = 'fundLog',
           rb_strDescription = 'Retired fundraising Log $logID',
           rb_strTable = 'ngo_fundraising_log',
           rb_strKeyIDFN = 'logID',
           rb_strRetireFN = 'bRetired',
           rb_lOriginID=$glUserID,
           rb_dteOrigin=NOW();";
      $this->db->query($sqlRec);
    
    return true;
 }

 public function updateRecord($logID, $amount_gbp, $amount_kes){

    $lead_name = $this->input->post('lead_name', TRUE);
   $theme = $this->input->post('theme', TRUE);
   $requirements = $this->input->post('requirements', TRUE);
   $submission_deadline = $this->input->post('submission_deadline', TRUE);
   $title = $this->input->post('title', TRUE);
   $donor = $this->input->post('donor', TRUE);
   $amount = $this->input->post('amount', TRUE);
   $period = $this->input->post('period', TRUE);
   $status = $this->input->post('status', TRUE);
    $donor_cur = $this->input->post('donor_cur', TRUE);
   $comment = $this->input->post('comment', TRUE);
   $amount_realized_ytd = $this->input->post('amount_realized_ytd', TRUE);
    $realized_cur=$this->input->post('realized_cur', TRUE);

    $sqlStr =
         "UPDATE  ngo_fundraising_log
          SET 
             lead_name    = '$lead_name',
             theme    = '$theme',
             requirements    = '$requirements',
             submission_deadline  = '$submission_deadline',
             title    = '$title',
             donor    = '$donor',
             amount = $amount,
             amount_kes = $amount_kes,
             amount_gbp = $amount_gbp,
             period = '$period',
             status = '$status',
             amount_realized_ytd= $amount_realized_ytd,
             realized_cur = '$realized_cur',
             donor_cur = '$donor_cur',
             comment = '$comment',            
             dteUpdated = NOW()
         WHERE logID=$logID;";

      $this->db->query($sqlStr);
      return true;
    


 }
public function loadKESExchangeRate($from_cur){
  $sqlStr =
           "SELECT
               *
            FROM ngo_currency_conversion
            WHERE bRetired=0 AND from_cur='$from_cur' AND to_cur='kes'";
         $query = $this->db->query($sqlStr);
    return $query->result();

}

public function loadGBPExchangeRate($from_cur){
  $sqlStr =
           "SELECT
               *
            FROM ngo_currency_conversion
            WHERE bRetired=0 AND from_cur='$from_cur' AND to_cur='gbp'";
         $query = $this->db->query($sqlStr);
    return $query->result();

}




















}
