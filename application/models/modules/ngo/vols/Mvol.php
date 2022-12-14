<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM!
//
// copyright (c) 2012-2015 by  Collins Riungu
// Nairobi Kenya
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
---------------------------------------------------------------------
      $this->load->model('vols/mvol', 'clsVol');
---------------------------------------------------------------------
   loadVolRecsViaVolID         ($lVolID, $bIncludeInactive)
   loadVolRecsViaPeopleID      ($lPeopleID, $bIncludeInactive)
   loadVolRecs                 ()
   lAddNewVolunteer            ()
   bVolStatusViaPID            ($lPID, &$lVolID, &$bInactive, &$dteInactive, &$dteVolStart)
   activateDeactivateVolunteer ($lVolID, $bActivate)
   volHTMLSummary              ()
   loadVolDirectoryPage        ($strWhereExtra, $lStartRec, $lRecsPerPage)
---------------------------------------------------------------------*/


//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class Mvol extends CI_Model{
   public
       $lVolID, $lPeopleID, $volRecs, $lNumVolRecs,
       $strWhereExtra, $strOrderExtra, $sqlLimitExtra;


   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->lVolID = $this->lPeopleID = $this->volRecs = $this->lNumVolRecs = null;
      $this->strWhereExtra = $this->strOrderExtra = $this->sqlLimitExtra = '';
   }

   public function lNumVols($enumType){
   //---------------------------------------------------------------------
   // $enumType: active / inactive / all
   //---------------------------------------------------------------------
      switch ($enumType){
         case 'active':
            $strWhere = 'AND NOT vol_bInactive ';
            break;
         case 'inactive':
            $strWhere = 'AND vol_bInactive ';
            break;
         case 'all':
            $strWhere = '';
            break;
         default:
            screamForHelp($enumType.': invalid type<br>error on line '.__LINE__.',<br>file '.__FILE__.',<br>function '.__FUNCTION__);
            break;
      }
      $sqlStr =
        "SELECT COUNT(*) AS lNumVols
         FROM `ngo_volunteers`
            INNER JOIN ngo_donors ON `vol_lPeopleID`=pe_lKeyID
         WHERE
            NOT `vol_bRetired`
            AND NOT pe_bRetired
            $strWhere;";
      $query = $this->db->query($sqlStr);
      if ($query->num_rows() == 0){
         return(0);
      }else {
         $row = $query->row();
         return((integer)$row->lNumVols);
      }
   }

   public function loadVolRecsViaVolID($lVolID, $bIncludeInactive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (is_array($lVolID)){
         $this->strWhereExtra = ' AND vol_lKeyID IN ('.implode(',', $lVolID).') ';
      }else {
         $this->strWhereExtra = " AND vol_lKeyID = $lVolID ";
      }
      if (!$bIncludeInactive){
         $this->strWhereExtra .= ' AND NOT vol_bInactive ';
      }
      $this->loadVolRecs();
   }

   public function loadVolRecsViaPeopleID($lPeopleID, $bIncludeInactive){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (is_array($lPeopleID)){
         $this->strWhereExtra = ' AND vol_lPeopleID IN ('.implode(',', $lPeopleID).') ';
      }else {
         $this->strWhereExtra = " AND vol_lPeopleID = $lPeopleID ";
      }
      if (!$bIncludeInactive){
         $this->strWhereExtra .= ' AND NOT vol_bInactive ';
      }
      $this->loadVolRecs();
   }

   public function lVolIDViaPeopleID($lPeopleID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT vol_lKeyID
         FROM ngo_volunteers
         WHERE
            NOT vol_bRetired
            AND vol_lPeopleID = $lPeopleID;";
      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();
      if ($numRows==0) {
         return(null);
      }else {
         $row = $query->row();
         return($row->vol_lKeyID);
      }
   }

   public function loadVolRecs(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $this->volRecs = array();
      $clsPeople = new mpeople;

      if ($this->strOrderExtra.'' == ''){
         $this->strOrderExtra = ' ORDER BY pe_strLName, pe_strFName, pe_strMName, vol_lKeyID ';
      }

      $sqlStr =
        "SELECT
            vol_lKeyID, vol_lPeopleID, vol_bInactive, vol_lRegFormID,
            vol_Notes, vol_bRetired, vol_lOriginID, vol_lLastUpdateID,
            UNIX_TIMESTAMP(vol_dteInactive) AS dteInactive,

            vreg_strFormName, vreg_strURLHash,

            pe_strLName, pe_strFName,
            pe_strMName, pe_bRetired,
            pe_strPreferredName, pe_strTitle,
            pe_strAddr1, pe_strAddr2,
            pe_strCity,  pe_strState,
            pe_strZip,   pe_strCountry,
            pe_strEmail, pe_strPhone, pe_strCell,
            pe_lHouseholdID,

            UNIX_TIMESTAMP(vol_dteOrigin)     AS dteOrigin,
            UNIX_TIMESTAMP(vol_dteLastUpdate) AS dteLastUpdate,
            uc.first_name AS strUCFName, uc.last_name AS strUCLName,
            ul.first_name AS strULFName, ul.last_name AS strULLName

         FROM ngo_volunteers
            INNER JOIN ngo_donors        ON vol_lPeopleID  = pe_lKeyID
            INNER JOIN users   AS uc ON uc.id   = vol_lOriginID
            INNER JOIN users   AS ul ON ul.id   = vol_lLastUpdateID
            LEFT  JOIN ngo_vol_reg             ON vol_lRegFormID = vreg_lKeyID

         WHERE
            NOT vol_bRetired AND NOT pe_bRetired
            $this->strWhereExtra
         $this->strOrderExtra
         $this->sqlLimitExtra;";

      $query = $this->db->query($sqlStr);
      $this->lNumVolRecs = $numRows = $query->num_rows();

      if ($numRows==0) {
         $this->volRecs[0] = new stdClass;
         $vRec = &$this->volRecs[0];

         $vRec->lKeyID         =
         $vRec->lPeopleID      =
         $vRec->lHouseholdID   =
         $vRec->bInactive      =
         $vRec->Notes          =
         $vRec->bRetired       =
         $vRec->dteInactive    =

         $vRec->strLName       =
         $vRec->strFName       =
         $vRec->strMName       =
         $vRec->strSafeNameFL  =

         $vRec->bRetired       =
         $vRec->strAddr1       =
         $vRec->strAddr2       =
         $vRec->strCity        =
         $vRec->strState       =
         $vRec->strZip         =
         $vRec->strCountry     =
         $vRec->strEmail       =
         $vRec->strPhone       =
         $vRec->strCell        =

         $vRec->lOriginID      =
         $vRec->lLastUpdateID  =
         $vRec->dteOrigin      =
         $vRec->dteLastUpdate  =
         $vRec->strUCFName     =
         $vRec->strUCLName     =
         $vRec->strULFName     =
         $vRec->strULLName     = null;
      }else {
         $idx = 0;
         foreach ($query->result() as $row) {

            $this->volRecs[$idx] = new stdClass;
            $vRec = &$this->volRecs[$idx];

            $vRec->lKeyID           = (int)$row->vol_lKeyID;
            $vRec->lPeopleID        = (int)$row->vol_lPeopleID;
            $vRec->lHouseholdID     = $lHID = (int)$row->pe_lHouseholdID;
            $vRec->strHouseholdName = $clsPeople->strHouseholdNameViaHID($lHID);

            $vRec->bInactive        = $row->vol_bInactive;
            $vRec->Notes            = $row->vol_Notes;
            $vRec->bRetired         = $row->vol_bRetired;
            $vRec->dteInactive      = $row->dteInactive;

            $vRec->strLName         = $strLName = $row->pe_strLName;
            $vRec->strFName         = $strFName = $row->pe_strFName;
            $vRec->strMName         = $strMName = $row->pe_strMName;
            $vRec->strTitle         = $strTitle = $row->pe_strTitle;
            $vRec->strPreferred     = $strPreferred = $row->pe_strPreferredName;

            $vRec->lRegFormID       = (int)$row->vol_lRegFormID;
            $vRec->strFormName      = $row->vreg_strFormName;
            $vRec->strURLHash       = $row->vreg_strURLHash;

            $vRec->strSafeName      = $vRec->strSafeNameFL =
                                         htmlspecialchars(
                                                            strBuildName(false, $strTitle, $strPreferred,
                                                                            $strFName, $strLName, $strMName));
            $vRec->strSafeNameLF    = htmlspecialchars(
                                                         strBuildName(true, $strTitle, $strPreferred,
                                                                         $strFName, $strLName, $strMName));

            $vRec->bRetired          = $row->pe_bRetired;
            $vRec->strAddr1          = $row->pe_strAddr1;
            $vRec->strAddr2          = $row->pe_strAddr2;
            $vRec->strCity           = $row->pe_strCity;
            $vRec->strState          = $row->pe_strState;
            $vRec->strZip            = $row->pe_strZip;
            $vRec->strCountry        = $row->pe_strCountry;
            $vRec->strEmail          = $strEmail = $row->pe_strEmail;
            $vRec->strEmailFormatted = strBuildEmailLink($strEmail, '', false, '');

            $vRec->strPhone         = $row->pe_strPhone;
            $vRec->strCell          = $row->pe_strCell;
            $vRec->strAddress       =
                     strBuildAddress(
                              $vRec->strAddr1, $vRec->strAddr2,   $vRec->strCity,
                              $vRec->strState, $vRec->strCountry, $vRec->strZip,
                              true);

            $vRec->lOriginID        = $row->vol_lOriginID;
            $vRec->lLastUpdateID    = $row->vol_lLastUpdateID;
            $vRec->dteOrigin        = $row->dteOrigin;
            $vRec->dteLastUpdate    = $row->dteLastUpdate;
            $vRec->strUCFName       = $row->strUCFName;
            $vRec->strUCLName       = $row->strUCLName;
            $vRec->strULFName       = $row->strULFName;
            $vRec->strULLName       = $row->strULLName;

            ++$idx;
         }
      }
   }

   public function lAddNewVolunteer(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $glUserID = USERID;

      $clsUFC = new muser_fields_create;

      if (!isset  ($this->volRecs[0]->lRegFormID) ||
           is_null($this->volRecs[0]->lRegFormID)){
         $strRegFormID = 'null';
      }else {
         $strRegFormID = (int)$this->volRecs[0]->lRegFormID;
      }

      $sqlStr =
           'INSERT INTO ngo_volunteers
            SET
               vol_lPeopleID     = '.$this->volRecs[0]->lPeopleID.',
               vol_bInactive     = 0,
               vol_dteInactive   = NULL,
               vol_Notes         = '.strPrepStr($this->volRecs[0]->Notes).",
               vol_bRetired      = 0,
               vol_lRegFormID    = $strRegFormID,
               vol_lOriginID     = $glUserID,
               vol_lLastUpdateID = $glUserID,
               vol_dteOrigin     = NOW(),
               vol_dteLastUpdate = NOW()
            ON DUPLICATE KEY UPDATE
               vol_bInactive     = 0,
               vol_dteInactive   = NULL;";

      $query = $this->db->query($sqlStr);
      $this->volRecs[0]->lKeyID = $lKeyID = $this->db->insert_id();

         //--------------------------------------------------------
         // create blank/default records for all the personalized
         // people tables
         //--------------------------------------------------------
      $clsUFC->enumTType = CENUM_CONTEXT_VOLUNTEER;
      $clsUFC->loadTablesViaTType();
      if ($clsUFC->lNumTables > 0){
         foreach ($clsUFC->userTables as $clsTable){
            $clsUFC->createSingleEmptyRec($clsTable, $lKeyID);
         }
      }
      return($lKeyID);
   }

   function bVolStatusViaPID($lPID, &$lVolID, &$bInactive, &$dteInactive, &$dteVolStart){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $lVolID = $bInactive = $dteInactive = null;
      $sqlStr =
        "SELECT
            vol_lKeyID, vol_bInactive,
            UNIX_TIMESTAMP(vol_dteInactive) AS dteInactive,
            UNIX_TIMESTAMP(vol_dteOrigin)   AS dteOrigin
         FROM ngo_volunteers
         WHERE
            NOT vol_bRetired
            AND vol_lPeopleID=$lPID;";

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();
      if ($numRows==0) {
         return(false);
      }else {
         $row = $query->row();
         $lVolID      = (int)$row->vol_lKeyID;
         $bInactive   = (boolean)$row->vol_bInactive;
         $dteInactive = $row->dteInactive;
         $dteVolStart = $row->dteOrigin;
         return(true);
      }
   }

   public function activateDeactivateVolunteer($lVolID, $bActivate){
      $glUserID = USERID;

      if ($bActivate){
         $strDateIn = '';
      }else {
         $strDateIn = ', vol_dteInactive=NOW() ';
      }
      $sqlStr =
           'UPDATE ngo_volunteers
            SET
               vol_bInactive     = '.($bActivate ? '0': '1').",
               vol_lLastUpdateID = $glUserID
               $strDateIn
            WHERE vol_lKeyID=$lVolID;";

      $this->db->query($sqlStr);
   }

   public function volHTMLSummary($idx){
   //-----------------------------------------------------------------------
   // assumes user has called $clsVol->loadVolRecs(...
   //-----------------------------------------------------------------------
      global $gdteNow, $genumDateFormat;

      $strOut = '';
      $params = array('enumStyle' => 'terse');
      $clsRpt = new generic_rpt($params);
      $clsRpt->setEntrySummary();

      $lVolID = $this->volRecs[$idx]->lKeyID;
      $volRec = &$this->volRecs[$idx];
      $lPID = $volRec->lPeopleID;
      $strOut .=
          $clsRpt->openReport('', '')

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Name:')
         .$clsRpt->writeCell ($volRec->strSafeName.'&nbsp;&nbsp;&nbsp;(people ID '
                                 .str_pad($lPID, 5, '0', STR_PAD_LEFT)
                                 .strLinkView_PeopleRecord($lPID, 'View People Record', true).')')
         .$clsRpt->closeRow  ()
/*
         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('People ID:')
         .$clsRpt->writeCell (strLinkView_PeopleRecord($lPID, 'View People Record', true)
                            .' '.str_pad($lPID, 5, '0', STR_PAD_LEFT))
         .$clsRpt->closeRow  ()
*/
         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Volunteer ID:')
         .$clsRpt->writeCell (str_pad($lVolID, 5, '0', STR_PAD_LEFT).'&nbsp;'
                             .strLinkView_Volunteer($lVolID, 'View Volunteer Record', true))
         .$clsRpt->closeRow  ();

      if ($volRec->bInactive){
         $strVol = '<i>Inactive since '.date($genumDateFormat, $volRec->dteInactive);
      }else {
         $strVol = 'Active';
      }
      $strOut .=
          $clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Volunteer Status:')
         .$clsRpt->writeCell ($strVol)
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Address:')
         .$clsRpt->writeCell ($volRec->strAddress)
         .$clsRpt->closeRow  ()

         .$clsRpt->closeReport('');
      return($strOut);
   }

   function loadVolDirectoryPage($strWhereExtra, $lStartRec, $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->sqlLimitExtra = " LIMIT $lStartRec, $lRecsPerPage ";
      $this->strWhereExtra = $strWhereExtra;
      if ($this->strOrderExtra == ''){
         $this->strOrderExtra = 'ORDER BY pe_strLName, pe_strFName, pe_strMName, vol_lKeyID ';
      }
      $this->loadVolRecs();
   }

}



?>