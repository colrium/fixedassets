<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM               copyright (c) 2015  Collins Riungu
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------*/

class Mtraining extends CI_Model{

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
   }

   function loadUserTrainingByYear($lYear, &$lNumUsers, &$training){
   //---------------------------------------------------------------------
   // return info about users who received training during the
   // specified year
   //---------------------------------------------------------------------
      $training = array();

         // load the personalized user table "Staff Training"
      $this->cUFSchema->loadUFSchemaViaAttachTypeUserTabName(
                      CENUM_CONTEXT_USER, 'Staff Training', $lTableID, true);

         // short-cut to our table of interest
      $staff = &$this->cUFSchema->schema[$lTableID];

         // field info for date of training
      $lIDX_DateOfTraining = $this->cUFSchema->lFieldIdxViaUserFieldName($lTableID, 'Date of Training', true);
      $strFN_DateOfTraining = $staff->fields[$lIDX_DateOfTraining]->strFieldNameInternal;

         // field name for "retired", or deleted record flag
      $strFN_Retired = $staff->strFieldPrefix.'_bRetired';

         /* this sequel statement resolves to
               SELECT COUNT(*) AS lNumRecs, id, first_name, last_name
               FROM uf_000083 INNER JOIN users ON uf000083_lForeignKey=id
               WHERE YEAR(uf000083_001841)=2013 AND NOT uf000083_bRetired
               ORDER BY last_name, first_name;
         */
      $sqlStr =
        "SELECT COUNT(*) AS lNumTraining, id, first_name, last_name
         FROM $staff->strDataTableName
            INNER JOIN users ON $staff->strDataTableFID=id
         WHERE YEAR($strFN_DateOfTraining) = ?
            AND $strFN_Retired = ?
         ORDER BY last_name, first_name;";

      $query = $this->db->query($sqlStr, array($lYear, 0));
      $lNumUsers = $query->num_rows();
      if ($lNumUsers > 0) {
         $idx = 0;
         foreach ($query->result() as $row){
            $training[$idx] = new stdClass;
            $training[$idx]->userID       = (int)$row->id;
            $training[$idx]->lNumTraining = (int)$row->lNumTraining;
            $training[$idx]->strFName     = $row->first_name;
            $training[$idx]->strLName     = $row->last_name;
            ++$idx;
         }
      }
   }

   function loadUserTrainingDDLValue($strCourseName, &$lNumUsers, &$training){
   //---------------------------------------------------------------------
   // return info about users who received training during the
   // specified year
   //---------------------------------------------------------------------
      $training = array();

         // load the personalized user table "Staff Training"
      $this->cUFSchema->loadUFSchemaViaAttachTypeUserTabName(
                      CENUM_CONTEXT_USER, 'Staff Training', $lTableID, true);

         // short-cut to our table of interest
      $staff = &$this->cUFSchema->schema[$lTableID];

         // field info for date of training
      $lIDX_DateOfTraining = $this->cUFSchema->lFieldIdxViaUserFieldName($lTableID, 'Date of Training', true);
      $strFN_DateOfTraining = $staff->fields[$lIDX_DateOfTraining]->strFieldNameInternal;

         // field info for subject
      $lIDX_Subject = $this->cUFSchema->lFieldIdxViaUserFieldName($lTableID, 'Subject', true);
      $strFN_Subject = $staff->fields[$lIDX_Subject]->strFieldNameInternal;

         // field info for duration
      $lIDX_Duration = $this->cUFSchema->lFieldIdxViaUserFieldName($lTableID, 'Duration', true);
      $strFN_Duration = $staff->fields[$lIDX_Duration]->strFieldNameInternal;

         // field info for notes
      $lIDX_Notes = $this->cUFSchema->lFieldIdxViaUserFieldName($lTableID, 'Notes', true);
      $strFN_Notes = $staff->fields[$lIDX_Notes]->strFieldNameInternal;

         // load the Drop-down list entries
      $this->cUFSchema->loadDDLValues($lTableID);

         // field name for "retired", or deleted record flag
      $strFN_Retired = $staff->strFieldPrefix.'_bRetired';

         // find the foreign key associated with the caller's course name
      $lDDL_FID = $this->lID_Via_Field_Value($staff->fields[$lIDX_Subject], $strCourseName);


         /* this sequel statement resolves to
               SELECT
                  id, first_name, last_name,
                  UNIX_TIMESTAMP(uf000083_001841) AS dteTraining,
                  uf000083_001843 AS strNotes,
                  uduration.ufddl_strDDLEntry AS strDuration
               FROM uf_000083
                  INNER JOIN users ON uf000083_lForeignKey=id
                  INNER JOIN uf_ddl AS uduration ON uduration.ufddl_lKeyID=uf000083_001844
               WHERE uf000083_001842=2656
                  AND NOT uf000083_bRetired
               ORDER BY last_name, first_name, uf000083_001841;
         */
      $sqlStr =
        "SELECT id, first_name, last_name,
             UNIX_TIMESTAMP($strFN_DateOfTraining) AS dteTraining,
             $strFN_Notes AS strNotes,
             uduration.ufddl_strDDLEntry AS strDuration
         FROM $staff->strDataTableName
            INNER JOIN users ON $staff->strDataTableFID=id
            INNER JOIN ngo_uf_ddl AS uduration ON uduration.ufddl_lKeyID=$strFN_Duration
         WHERE $strFN_Subject = ?
            AND $strFN_Retired =?
         ORDER BY last_name, first_name, $strFN_DateOfTraining;";

      $query = $this->db->query($sqlStr, array($lDDL_FID, '0'));
      $lNumUsers = $query->num_rows();
      if ($lNumUsers > 0) {
         $idx = 0;
         foreach ($query->result() as $row){
            $training[$idx] = new stdClass;
            $training[$idx]->userID       = (int)$row->id;
            $training[$idx]->strDuration  = $row->strDuration;
            $training[$idx]->strNotes     = $row->strNotes;
            $training[$idx]->dteTraining  = (int)$row->dteTraining;
            $training[$idx]->strFName     = $row->first_name;
            $training[$idx]->strLName     = $row->last_name;
            ++$idx;
         }
      }
   }

   function lID_Via_Field_Value($field, $strCourseName){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lReturn = null;

      for ($idx = 0; $idx < $field->lNumDDL; ++$idx){
         if ($field->ddlInfo[$idx]->strDDLEntry == $strCourseName){
            $lReturn = $field->ddlInfo[$idx]->lKeyID;
            break;
         }
      }
      return($lReturn);
   }










}