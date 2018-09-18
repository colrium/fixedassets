<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
 ActionAid CRM!

 copyright (c) 2012-2015 by  Collins Riungu


---------------------------------------------------------------------*/
class Monlinereg extends CI_Model{



   function __construct(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
    parent::__construct();
   }


public function loadSettings(){
$sqlStr ="SELECT * FROM ngo_onlinereg;";
        $query = $this->db->query($sqlStr);
   return $query->result();



}


public function updateSettings($id){
$donorRegEmail= $this->input->post('donorRegEmail', TRUE);
$existingdonorRegEmail = $this->input->post('existingdonorRegEmail', TRUE);
$friendRegEmail = $this->input->post('friendRegEmail', TRUE);
$existingfriendRegEmail = $this->input->post('existingfriendRegEmail', TRUE);
$consumerKey = $this->input->post('consumerKey', TRUE);
$consumerSecret = $this->input->post('consumerSecret', TRUE);
$paypalUrl = $this->input->post('paypalUrl', TRUE);

   $sqlStr =
         "UPDATE ngo_onlinereg
         SET 
         donorRegEmail = ".$this->db->escape($donorRegEmail).",
         existingdonorRegEmail = ".$this->db->escape($existingdonorRegEmail).",
         friendRegEmail = ".$this->db->escape($friendRegEmail).",
         existingfriendRegEmail = ".$this->db->escape($existingfriendRegEmail).",
         consumerKey = ".$this->db->escape($consumerKey).",
         consumerSecret = ".$this->db->escape($consumerSecret).",
         paypalUrl = ".$this->db->escape($paypalUrl)."

          WHERE  id=?;";
       
    $query = $this->db->query($sqlStr, array($id));
    return true;


  
}




 }