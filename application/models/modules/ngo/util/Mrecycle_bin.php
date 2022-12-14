<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//---------------------------------------------------------------------
// ActionAid CRM!
//
// Collins Riungu
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
/*---------------------------------------------------------------------


---------------------------------------------------------------------
      $this->load->model('util/mrecycle_bin', 'clsRecycle');
---------------------------------------------------------------------*/


//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class Mrecycle_bin extends CI_Model{

   public
      $lForeignID, $strTable, $strRetireFN, $strKeyIDFN,
      $strNotes, $lGroupID, $enumRecycleType;


   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();

      $this->lForeignID = $this->strTable = $this->strRetireFN =
      $this->strKeyIDFN = $this->strNotes =
      $this->lGroupID   = $this->enumRecycleType = null;
   }

   function addRecycleEntry(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $glUserID = USERID;

      $varGroupID = (is_null($this->lGroupID) ? 0 : $this->lGroupID);

      $sqlStr =
        "INSERT INTO ngo_recycle_bin
         SET
            rb_lGroupID        = $varGroupID,
            rb_enumRecycleType = ".strPrepStr($this->enumRecycleType).',
            rb_strDescription  = '.strPrepStr(substr($this->strNotes, 0, 255)).',
            rb_strTable        = '.strPrepStr($this->strTable).',
            rb_strKeyIDFN      = '.strPrepStr($this->strKeyIDFN).',
            rb_strRetireFN     = '.strPrepStr($this->strRetireFN).",
            rb_lForeignID      = $this->lForeignID,
            rb_lOriginID       = $glUserID,
            rb_lLastUpdateID   = $glUserID,
            rb_dteOrigin       = NOW(),
            rb_dteLastUpdate   = NOW();";

      $query = $this->db->query($sqlStr);

      if (is_null($this->lGroupID)){
         $this->lGroupID = $lKeyID = mysql_insert_id();
         $sqlStr = "UPDATE recycle_bin SET rb_lGroupID=$lKeyID WHERE rb_lKeyID=$lKeyID;";
      $query = $this->db->query($sqlStr);
      }
   }


}



?>