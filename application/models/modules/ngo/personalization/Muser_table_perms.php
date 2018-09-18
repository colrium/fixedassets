<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
 ActionAid CRM!

 copyright (c) 2013-2015 by  Collins Riungu
 Nairobi Kenya

 This software is provided under the GPL.
 Please see http://www.gnu.org/copyleft/gpl.html for details.

-------------------------------------------------------------------
      $this->load->model('personalization/muser_table_perms', 'tperms');
---------------------------------------------------------------------

-------------------------------------------------------------------*/

class Muser_table_perms extends CI_Model{

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
   }

   function bAccessable($lTableID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbAdmin, $gbStandardUser, $gUserPerms, $gbVolLogin;

      if ($gbAdmin)    return(true);
      if ($gbVolLogin) return(false);
   }

   function loadUserTableAccess($lUserID, &$lNumTables){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $arrayOut = array();
      $lNumTables = 0;
      $sqlStr =
         'SELECT ppr_lTableID
          FROM ngo_groups_parent
             INNER JOIN ngo_groups_child ON gc_lGroupID=gp_lKeyID
             INNER JOIN ngo_uf_table_perms ON ppr_lGroupID=gp_lKeyID
          WHERE gp_enumGroupType='.strPrepStr(CENUM_CONTEXT_USER)."
             AND gc_lForeignID=$lUserID
          ORDER BY ppr_lTableID;";

      $query = $this->db->query($sqlStr);
      $lNumTables = $query->num_rows();

      if ($lNumTables > 0) {
         foreach ($query->result() as $row){
            $arrayOut[] = $row->ppr_lTableID;
         }
      }
      return($arrayOut);
   }
   
   
   function groupsViaTableID($lTableID, &$lNumGroups, &$groupIDs){
   //---------------------------------------------------------------------
   // return an array that indicates what groups have access to 
   // a specified personalized table; if $lNumGroups==0, table is 
   // universally accessable.
   //---------------------------------------------------------------------   
      $groupIDs = array();
      $lNumGroups = 0;
      $sqlStr =
        "SELECT ppr_lGroupID, gp_strGroupName
         FROM ngo_uf_table_perms 
            INNER JOIN ngo_groups_parent ON ppr_lGroupID=gp_lKeyID
         WHERE ppr_lTableID=$lTableID
         ORDER BY gp_strGroupName, ppr_lGroupID;";    
      $query = $this->db->query($sqlStr);
      $lNumGroups = $query->num_rows();

      if ($lNumGroups > 0) {
         $idx = 0;
         foreach ($query->result() as $row){
            $groupIDs[$idx] = new stdClass;
            $groupIDs[$idx]->lGroupID     = $row->ppr_lGroupID;
            $groupIDs[$idx]->strGroupName = $row->gp_strGroupName;
            ++$idx;
         }
      }
   }

   function allUserGroupsWithTableID($lTableID, &$lNumGroups, &$groups){
   //---------------------------------------------------------------------
   // return an array that indicates what groups have access to 
   // a specified personalized table; if $lNumGroups==0, table is 
   // universally accessable.
   //---------------------------------------------------------------------   
      $groupIDs = array();
      $lNumGroups = 0;
      $sqlStr =
        'SELECT gp_lKeyID, gp_strGroupName
         FROM ngo_groups_parent  
         WHERE gp_enumGroupType='.strPrepStr(CENUM_CONTEXT_USER).'
         ORDER BY gp_strGroupName, gp_lKeyID;';    
      $query = $this->db->query($sqlStr);
      $lNumGroups = $query->num_rows();

      if ($lNumGroups > 0) {
         $idx = 0;
         foreach ($query->result() as $row){
            $groups[$idx] = new stdClass;
            $groups[$idx]->lGroupID         = $row->ppr_lGroupID;
            $groups[$idx]->strGroupName     = $row->gp_strGroupName;
            ++$idx;
         }
      }
   }
   
   function bTableAllGroups($lTableID){
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs 
         FROM ngo_uf_table_perms
         WHERE ppr_lTableID=$lTableID;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return($row->lNumRecs==0);         
   }
   
   
}

