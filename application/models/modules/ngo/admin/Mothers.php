<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
 ActionAid CRM!

 copyright (c) 2012-2015 by  Collins Riungu


---------------------------------------------------------------------*/
class Mothers extends CI_Model{



   function __construct(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
		parent::__construct();
   }




public function loadExpected(){
$sqlStr =
         "SELECT *
          FROM ngo_expected_amounts;";
       
    $query = $this->db->query($sqlStr);
    return $query->result();
	
}

public function updateExpectedAmount(){
$year = $this->input->post('year', TRUE);
$amount = $this->input->post('amount', TRUE);
$sqlStr =
         "UPDATE ngo_expected_amounts 
         SET
         year=".$this->db->escape($year).",
         amount=".$this->db->escape($amount)."
         WHERE id=1;";
       
    $query = $this->db->query($sqlStr);
    return true;

}














}

?>