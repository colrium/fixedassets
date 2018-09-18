<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
 ActionAid CRM!

 copyright (c) 2012-2015 by  Collins Riungu


---------------------------------------------------------------------*/
class Mcurrency extends CI_Model{



   function __construct(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
		parent::__construct();
   }

public function loadRecords(){
$sqlStr =
         "SELECT *
          FROM ngo_currency_conversion
          WHERE bRetired  = ?;";
       
    $query = $this->db->query($sqlStr, array(0));
    return $query->result();
   
}

public function loadRecord($id){

   $sqlStr =
         "SELECT *
          FROM ngo_currency_conversion
          WHERE
             bRetired  = ? AND id = ?;";
       
    $query = $this->db->query($sqlStr, array(0, $id));
    return $query->result();
   
   
}

public function updateRecord($id){
  $rate= $this->input->post('rate', TRUE);
   $sqlStr =
         "UPDATE ngo_currency_conversion
         SET 
         rate='$rate',
         update_date= NOW()
          WHERE  id = ?;";
       
    $query = $this->db->query($sqlStr, array($id));
    return true;
   
   
}









}

?>