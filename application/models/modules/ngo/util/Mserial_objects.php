<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
      $this->load->model('util/mserial_objects', 'cSO');
-----------------------------------------------------------------------*/

class Mserial_objects extends CI_Model{


   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();

   }
   
   function lSaveObject(&$theObject){
      $prepedObject = strPrepStr(serialize($theObject));
      $sqlStr = "INSERT INTO ngo_serial_objects SET so_object= $prepedObject;";
      $this->db->query($sqlStr);
      return($this->db->insert_id());      
   }
   
   function objLoadObject($lKeyID){
      $sqlStr = "SELECT ngo_so_object FROM serial_objects WHERE so_lKeyID = $lKeyID;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return(unserialize($row->so_object));
   }
   
   function removeOldObjects($lNumDaysOld){
      $sqlStr = "DELETE FROM ngo_serial_objects WHERE so_dteCreated < DATE_SUB(NOW(), INTERVAL $lNumDaysOld DAY);";
      $this->db->query($sqlStr);
   }
   
   
}


