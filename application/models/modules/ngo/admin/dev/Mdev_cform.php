<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM!
//
// copyright (c) 2014 by  Collins Riungu
// Nairobi Kenya
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
---------------------------------------------------------------------
      $this->load->model('admin/dev/mdev_cform', 'cFDev');
--------------------------------------------------------------------

---------------------------------------------------------------------*/


class Mdev_cform extends CI_Model{
   public
       $customForms, $lNumCustomForms,
       $strWhereExtra, $strOrder;

   public $lNumTables, $utables;

   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();

   }
   
   public function buildCFormLog(&$strOut){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------  
      $cform = new mcustom_forms;
      
         // cform log dates will be based on "Today's Visit" entries
      $sqlStr =
         'SELECT 
            uf000002_lForeignKey AS lClientID, 
            uf000002_lOriginID AS lUserID, 
            uf000002_dteOrigin AS dteForm
          FROM ngo_uf_000002 
          WHERE NOT uf000002_bRetired;';      
      $query = $this->db->query($sqlStr);

      $lNumEntries = $query->num_rows();
      if ($lNumEntries > 0) {
         foreach ($query->result() as $row){
            $this->insertLogEntry($row->lClientID, $row->lUserID, $row->dteForm);
         }
      }
      $strOut = $lNumEntries.' entries added to the custom form log';
   }

   function insertLogEntry($lClientID, $lUserID, $dteForm){
      $sqlStr =
         "INSERT INTO ngo_custom_form_log
          SET
             cfl_lCFormID   = 1,
             cfl_lForeignID = ".$this->db->escape($lClientID).",
             cfl_lOriginID  = ".$this->db->escape($lUserID).",
             cfl_dteOrigin  = ".$this->db->escape($dteForm).";";
      $query = $this->db->query($sqlStr);
   }
   
}


