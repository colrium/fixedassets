<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcalendar extends CI_Model{

   
   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
   }




 public function dateLoad($displayDate, $user){
$date2=date('Y-m-d', $displayDate);
$sqlStr =
         "SELECT DISTINCT re_lKeyID, re_strTitle,re_strReminderNote
            FROM 
                  ngo_reminders
               INNER JOIN ngo_reminders_dates  ON rd_lRemID    =re_lKeyID
               INNER JOIN ngo_reminders_inform ON ri_lRemDateID=rd_lKeyID
            WHERE 
               rd_dteEndDisplayDate >= ".strPrepStr($date2)."
               AND rd_dteDisplayDate    = ".strPrepStr($date2)."

               AND (ri_lUserID=$user OR ri_lUserID=-1)
              
               AND NOT re_bRetired";
       
    $query = $this->db->query($sqlStr);
    return $query->result();





 }

  public function todayLoad($user){

$sqlStr =
         "SELECT DISTINCT re_lKeyID, re_strTitle,re_strReminderNote
            FROM 
                  ngo_reminders
               INNER JOIN ngo_reminders_dates  ON rd_lRemID    =re_lKeyID
               INNER JOIN ngo_reminders_inform ON ri_lRemDateID=rd_lKeyID
            WHERE 
               rd_dteEndDisplayDate >= CURDATE()
               AND rd_dteDisplayDate    = CURDATE()
               AND (ri_lUserID=$user OR ri_lUserID=-1)
              
               AND NOT re_bRetired";
       
    $query = $this->db->query($sqlStr);
    return $query->result();





 }

 public function viewReminder($id){
$sqlStr =
         "SELECT *
            FROM 
                  ngo_reminders
               
            WHERE 
               re_lKeyID=$id
               AND NOT re_bRetired";
       
    $query = $this->db->query($sqlStr);
    return $query->result();

 }
public function loadReminderFollowips($id){
$sqlStr =
         "SELECT *
            FROM 
                  ngo_reminders_followup
               
            WHERE 
               rfu_lRemID=$id";
       
    $query = $this->db->query($sqlStr);
    return $query->result();

 }
public function addFollowup($id, $userId){
$follow_up = $this->input->post('follow_up', TRUE);

$sqlStr =
         "INSERT INTO 
                      ngo_reminders_followup
               SET  rfu_lRemID=$id,
                    rfu_strFollowUpNote='$follow_up',
                    rfu_lUserID=$userId,
                    rfu_dteOfNote=NOW()
                    ";
       
    $query = $this->db->query($sqlStr);
    return true;



}



















































}
?>