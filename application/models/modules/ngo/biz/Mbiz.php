<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM!
//
// copyright (c) 2014 by  Collins Riungu
// Nairobi Kenya
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------
      $this->load->model('admin/madmin_aco', 'clsACO');
      $this->load->model('biz/mbiz', 'clsBiz');
---------------------------------------------------------------------
   lNumBizRecords            ()
   clearBizRecord            ()
   lCreateNewBizRec          ()
   updateBizRec              ()
   bizInfoLight              ()

   loadBizRecsViaBID         ($lBID)
   loadBizDirectoryPage      ($strWhereExtra, $lStartRec, $lRecsPerPage){
   loadBizRecs               ($bIncludeSpon, $bIncludeGiftSum){

   loadBasicBizInfo          ()

   contactList               ($bViaBID, $bViaPID, $bViaConRecID)
   strBizContactPeopleIDList ()
   lNumContacts              ($bViaBID, $bViaPID)
   deleteBizContact          ($bViaBID, $bViaPID, $bViaConRecID, $lGroupID)
   retireSingleBizCon        ($lBizConID, &$lGroupID)
   lAddNewBizContact         ($lPID, $lBizRelID)
   updateBizContact          ($lConID, $lBizRelID, $bSoftCash)
   removeBizContact          ($lConID)

   logBizConRetire           ($lBizConID, &$lGroupID)
   strBizHTMLSummary         ()

---------------------------------------------------------------------*/


//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class Mbiz extends CI_Model{

   public
      $lBID,
      $strBizName,     $strSafeName,
      $strAddr1,       $strAddr2,       $strCity,
      $strState,       $strCountry,     $strZip,
      $strPhone,       $strEmail,       $strEmailFormatted,
      $lACO,           $strACO,         $strCurSymbol,
      $strFlag,        $strFlagImage,   $bNoGiftAcknowledge,
      $lAttributedTo,  $lImportID,      $lImportRecID,
      $lOriginID,      $lLastUpdateID,  $dteMysqlBirthDate,
      $dteMysqlDeath,  $dteOrigin,      $dteLastUpdate,
      $strStaffCFName, $strStaffCLName, $strStaffLFName,
      $strStaffLLName;

   public
      $lIndustryID, $strIndustry, $lPID;

   public
      $lConRecID, $contacts, $lNumContacts, $lNumFdata;

   public $bizRecs, $sqlWhereExtra, $sqlOrderExtra, $sqlLimitExtra;

   public $lNumContactsNames, $contactsNames;

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->clearBizRecord();
   }

   public function lNumBizRecords(){
      $sqlStr =
        'SELECT COUNT(*) AS lNumRecs
         FROM ngo_donors
         WHERE pe_bBiz AND NOT pe_bRetired;';

      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((integer)$row->lNumRecs);
   }

   private function clearBizRecord(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $this->lIndustryID    = $this->strIndustry = $this->lPID = null;
      $this->contacts = $this->lNumContacts = $this->lConRecID = null;
      $this->sqlSelectExtra = $this->sqlWhereExtra = $this->sqlOrderExtra = $this->sqlLimitExtra = '';
   }

   public function lCreateNewBizRec(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $glUserID, $glChapterID;

      $clsUFC = new muser_fields_create;

      $sqlStr =
       "INSERT INTO ngo_donors
        SET
             pe_lOriginID    = $glUserID,
             pe_dteOrigin    = NOW(), "
            .$this->strBizSQLCommon();
      $query = $this->db->query($sqlStr);
      $this->lBID = $lBID = $this->db->insert_id();

//      $result = mysql_query($sqlStr);
//      if (bSQLError('SQL error on line '.__LINE__.', file '.__FILE__.', function '.__FUNCTION__, $sqlStr) ) {
//         screamForHelp('Unexpected SQL error');
//      }
//
//      $this->lBID = $lBID = mysql_insert_id();

         //--------------------------------------------------------
         // create blank/default records for all the personalized
         // people tables
         //--------------------------------------------------------
      $clsUFC->enumTType = CENUM_CONTEXT_BIZ;
      $clsUFC->loadTablesViaTType();
      if ($clsUFC->lNumTables > 0){
         foreach ($clsUFC->userTables as $clsTable){
            $clsUFC->createSingleEmptyRec($clsTable, $lBID);
         }
      }
      return($this->lBID);
   }

   public function updateBizRec($lBID){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $glUserID, $glChapterID;

      if (is_null($this->lBID)) screamForHelp('BIZ ID NOT SET!<br>error on <b>line:</b> '.__LINE__.'<br><b>file: </b>'.__FILE__.'<br><b>function: </b>'.__FUNCTION__);
      $sqlStr =
       'UPDATE ngo_donors
        SET '.$this->strBizSQLCommon()."
        WHERE pe_lKeyID=?;";
      $query = $this->db->query($sqlStr, array($lBID));

//      $result = mysql_query($sqlStr);
//      if (bSQLError('SQL error on line '.__LINE__.', file '.__FILE__.', function '.__FUNCTION__, $sqlStr) ) {
//         screamForHelp('Unexpected SQL error');
//      }
   }

   private function strBizSQLCommon(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $glUserID = USERID;
      $biz = &$this->bizRecs[0];
      if (is_null($biz->lAttributedTo)){
         $strAttrib = 'null';
      }else {
         $strAttrib = (integer)$biz->lAttributedTo;
      }

      return('
          pe_strLName        = '.strPrepStr($biz->strBizName).',
          pe_strAddr1        = '.strPrepStr($biz->strAddr1).',
          pe_strAddr2        = '.strPrepStr($biz->strAddr2).',
          pe_strCity         = '.strPrepStr($biz->strCity).',
          pe_strState        = '.strPrepStr($biz->strState).',
          pe_strCountry      = '.strPrepStr($biz->strCountry).',
          pe_strZip          = '.strPrepStr($biz->strZip).',
          pe_strPhone        = '.strPrepStr($biz->strPhone).',
          pe_strCell         = '.strPrepStr($biz->strCell).',
          pe_strFax          = '.strPrepStr($biz->strFax).',
          pe_strWebSite      = '.strPrepStr($biz->strWebSite).',
          pe_strNotes        = '.strPrepStr($biz->strNotes).',
          pe_strSalutation   = '.strPrepStr('').',

          pe_strEmail        = '.strPrepStr($biz->strEmail).",
          pe_lACO            = $biz->lACO,
          pe_lAttributedTo   = $strAttrib,
          pe_bBiz            = 1,
          pe_lBizIndustryID  = $biz->lIndustryID,

          pe_lLastUpdateID   = $glUserID ");
   }

   public function bizInfoLight(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      if (is_null($this->lBID)) screamForHelp('BIZ ID NOT SET!<br>error on <b>line:</b> '.__LINE__.'<br><b>file: </b>'.__FILE__.'<br><b>function: </b>'.__FUNCTION__);

      $sqlStr =
        "SELECT
            pe_strLName
         FROM ngo_donors
         WHERE pe_lKeyID=$this->lBID
            AND NOT pe_bRetired;";
      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

//      $result = mysql_query($sqlStr);
//      if (bSQLError('SQL error on line '.__LINE__.', file '.__FILE__.', function '.__FUNCTION__, $sqlStr) ) {
//         screamForHelp('Unexpected SQL error');
//      }else{
//         $numRows = mysql_num_rows($result);
      if ($numRows==0) {
         echo('<font face="monospace" style="font-size: 8pt;">'.__FILE__.' Line: <b>'.__LINE__.":</b><br><b>\$sqlStr=</b><br>".nl2br($sqlStr)."<br><br></font>\n");
         screamForHelp('UNEXPECTED EOF<br>error on <b>line:</b> '.__LINE__.'<br><b>file: </b>'.__FILE__.'<br><b>function: </b>'.__FUNCTION__);
      }else {
//         $row = mysql_fetch_array($result);
         $row = $query->row();
         $this->strBizName         = $row->pe_strLName;
         $this->strSafeName        = htmlspecialchars($this->strBizName);
      }
//      }
   }

   public function loadBizRecsViaBID($lBID, $bIncludeSpon=false, $bIncludeGiftSum=false){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      if (is_array($lBID)){
         $this->sqlWhereExtra = ' AND pe_lKeyID IN ('.implode(',', $lBID).') ';
      }else {
         $this->sqlWhereExtra = " AND pe_lKeyID=$lBID ";
      }
      $this->loadBizRecs($bIncludeSpon, $bIncludeGiftSum);
   }

   function loadBizDirectoryPage($strWhereExtra, $lStartRec, $lRecsPerPage,
                                 $bIncludeSpon,  $bIncludeGiftSum){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->sqlLimitExtra = " LIMIT $lStartRec, $lRecsPerPage ";
      $this->sqlWhereExtra = $strWhereExtra;
      $this->sqlOrderExtra = 'ORDER BY pe_strLName, pe_strFName, pe_strMName, pe_lKeyID ';
      $this->loadBizRecs($bIncludeSpon, $bIncludeGiftSum);
   }

   public function loadBizRecs($bIncludeSpon, $bIncludeGiftSum){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $clsACO = new madmin_aco;
      $this->bizRecs = array();

      $sqlStr =
        "SELECT
            pe_lKeyID,
            pe_strLName,
            pe_strAddr1,       pe_strAddr2,
            pe_strCity,        pe_strState,      pe_strCountry,
            pe_strZip,         pe_strPhone,      pe_strCell,      pe_strEmail,
            pe_lAttributedTo,  pe_strImportID,   pe_strImportID,  pe_strNotes,
            pe_strFax,         pe_strWebSite,
            pe_lOriginID,      pe_lLastUpdateID, pe_lBizIndustryID,
            tblIndustry.lgen_strListItem AS strIndustry,

            pe_lACO, aco_strFlag, aco_strName, aco_strCurrencySymbol,
            tblAttrib.lgen_strListItem AS strAttrib,

            usersC.first_name AS strCFName, usersC.last_name AS strCLName,
            usersL.first_name AS strLFName, usersL.last_name AS strLLName,
            UNIX_TIMESTAMP(pe_dteOrigin)     AS dteOrigin,
            UNIX_TIMESTAMP(pe_dteLastUpdate) AS dteLastUpdate
            $this->sqlSelectExtra
         FROM ngo_donors
            INNER JOIN users AS usersC ON pe_lOriginID      = usersC.id
            INNER JOIN users AS usersL ON pe_lLastUpdateID  = usersL.id
            INNER JOIN ngo_admin_aco             ON pe_lACO           = aco_lKeyID
            LEFT  JOIN ngo_lists_generic AS tblIndustry ON pe_lBizIndustryID = tblIndustry.lgen_lKeyID
            LEFT  JOIN ngo_lists_generic AS tblAttrib   ON pe_lAttributedTo  = tblAttrib.lgen_lKeyID
         WHERE ngo_pe_bBiz
            $this->sqlWhereExtra
            AND NOT pe_bRetired
         $this->sqlOrderExtra
         $this->sqlLimitExtra;";
      $query = $this->db->query($sqlStr);

      $this->lNumBizRecs = $query->num_rows();
      if ($this->lNumBizRecs == 0) {
         $this->bizRecs[0] = null;
      }else {
         $idx = 0;
         if ($bIncludeGiftSum){
            $clsGifts = new mdonations;
            $clsGifts->bUseDateRange = false;
            $clsGifts->cumulativeOpts = new stdClass;
            $clsGifts->cumulativeOpts->enumCumulativeSource = 'biz';
         }

         if ($bIncludeSpon){
            $clsSpon = new msponsorship;
         }

         foreach ($query->result() as $row){
            $this->bizRecs[$idx] = new stdclass;
            $biz = &$this->bizRecs[$idx];
            $biz->lKeyID             = $lBID = $this->lBID = $row->pe_lKeyID;
            $biz->strBizName         = $row->pe_strLName;
            $biz->strSafeName        = htmlspecialchars($biz->strBizName);
            $biz->lIndustryID        = $row->pe_lBizIndustryID;
            $biz->strIndustry        = $row->strIndustry;

            $biz->strAddr1           = $row->pe_strAddr1;
            $biz->strAddr2           = $row->pe_strAddr2;
            $biz->strCity            = $row->pe_strCity;
            $biz->strState           = $row->pe_strState;
            $biz->strCountry         = $row->pe_strCountry;
            $biz->strZip             = $row->pe_strZip;
            $biz->strPhone           = $row->pe_strPhone;
            $biz->strCell            = $row->pe_strCell;
            $biz->strFax             = $row->pe_strFax;     
            $biz->strWebSite         = $row->pe_strWebSite;

            $biz->strAddress         =
                        strBuildAddress(
                                 $biz->strAddr1, $biz->strAddr2,   $biz->strCity,
                                 $biz->strState, $biz->strCountry, $biz->strZip,
                                 true);

            $biz->strEmail           = $row->pe_strEmail;
            $biz->strEmailFormatted  = strBuildEmailLink($biz->strEmail, '', false, '');

            $biz->strNotes           = $row->pe_strNotes;

            $biz->lACO               = $row->pe_lACO;
            $biz->strACO             = $row->aco_strName;
            $biz->strCurSymbol       = $row->aco_strCurrencySymbol;
            $biz->strFlag            = $row->aco_strFlag;
            $biz->strFlagImage       = $clsACO->strFlagImage($biz->strFlag, $biz->strACO);

            $biz->lAttributedTo      = $row->pe_lAttributedTo;
            $biz->strAttrib          = $row->strAttrib;
            $biz->lImportID          = $row->pe_strImportID;

            $biz->strImportRecID     = $row->pe_strImportID;
            $biz->lOriginID          = $row->pe_lOriginID;
            $biz->lLastUpdateID      = $row->pe_lLastUpdateID;

            $biz->dteOrigin          = $row->dteOrigin;
            $biz->dteLastUpdate      = $row->dteLastUpdate;

            $biz->strStaffCFName     = $row->strCFName;
            $biz->strStaffCLName     = $row->strCLName;
            $biz->strStaffLFName     = $row->strLFName;
            $biz->strStaffLLName     = $row->strLLName;

            $biz->contactList = $this->contactList(true, false, false);

               //-------------------
               // sponsorship
               //-------------------
            if ($bIncludeSpon){
               $clsSpon->sponsorshipInfoViaPID($lBID);
               $biz->lNumSponsorship = $lNumSpons = $clsSpon->lNumSponsors;
               if ($lNumSpons == 0){
                  $biz->sponInfo = null;
               }else {
                  $biz->sponInfo = $clsSpon->sponInfo;
               }
            }

               //-------------------
               // cumulative gifts
               //-------------------
            if ($bIncludeGiftSum){
               $clsGifts->lPeopleID = $lBID;
               $clsGifts->cumulativeOpts->enumMoneySet = 'all';

               $clsGifts->cumulativeOpts->bSoft = false;
               $clsGifts->cumulativeDonation($clsACO, $biz->lNumHardGifts);
               $biz->lNumACODonationGroups_hard = $clsGifts->lNumCumulative;
               $biz->donationsViaACO_hard       = $clsGifts->cumulative;

               $clsGifts->cumulativeOpts->bSoft = true;
               $clsGifts->cumulativeDonation($clsACO, $biz->lNumSoftGifts);
               $biz->lNumACODonationGroups_soft = $clsGifts->lNumCumulative;
               $biz->donationsViaACO_soft       = $clsGifts->cumulative;
            }else {
               $biz->lNumACODonationGroups_hard =
               $biz->donationsViaACO_hard       =
               $biz->lNumACODonationGroups_soft =
               $biz->donationsViaACO_soft       = null;
            }
            ++$idx;
         }
      }
   }

   public function loadBasicBizInfo(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      global $gbDev;

      $clsACO = new madmin_aco;
      if (is_null($this->lBID)) screamForHelp('BIZ ID NOT SET!<br>error on <b>line:</b> '.__LINE__.'<br><b>file: </b>'.__FILE__.'<br><b>function: </b>'.__FUNCTION__);

      $sqlStr =
        "SELECT
            pe_strLName,
            pe_strAddr1,       pe_strAddr2,
            pe_strCity,        pe_strState,      pe_strCountry,
            pe_strZip,         pe_strPhone,      pe_strCell,      pe_strEmail,
            pe_lAttributedTo,  pe_strImportID,   pe_strImportID,
            pe_lOriginID,      pe_lLastUpdateID, pe_lBizIndustryID, lgen_strListItem,

            pe_lACO, aco_strFlag, aco_strName, aco_strCurrencySymbol,

            usersC.first_name AS strCFName, usersC.last_name AS strCLName,
            usersL.first_name AS strLFName, usersL.last_name AS strLLName,
            UNIX_TIMESTAMP(pe_dteOrigin)     AS dteOrigin,
            UNIX_TIMESTAMP(pe_dteLastUpdate) AS dteLastUpdate
         FROM ngo_donors
            INNER JOIN users AS usersC ON pe_lOriginID      = usersC.id
            INNER JOIN users AS usersL ON pe_lLastUpdateID  = usersL.id
            INNER JOIN ngo_admin_aco             ON pe_lACO           = aco_lKeyID
            LEFT  JOIN ngo_lists_generic         ON pe_lBizIndustryID = lgen_lKeyID
         WHERE pe_lKeyID=".strPrepStr($this->lBID)."
            AND NOT pe_bRetired;";
      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

//      $result = mysql_query($sqlStr);
//      if (bSQLError('SQL error on line '.__LINE__.', file '.__FILE__.', function '.__FUNCTION__, $sqlStr) ) {
//         screamForHelp('Unexpected SQL error');
//      }else{
//         $numRows = mysql_num_rows($result);
      if ($numRows==0) {
         if ($gbDev) echo('<font face="monospace" style="font-size: 8pt;">'.__FILE__.' Line: <b>'.__LINE__.":</b><br><b>\$sqlStr=</b><br>".nl2br($sqlStr)."<br><br></font>\n");
         screamForHelp('UNEXPECTED EOF<br>error on <b>line:</b> '.__LINE__.'<br><b>file: </b>'.__FILE__.'<br><b>function: </b>'.__FUNCTION__, true);
      }else {
//         $row = mysql_fetch_array($result);
         $row = $query->row();

         $this->strBizName         = $row->pe_strLName;
         $this->strSafeName        = htmlspecialchars($this->strBizName);
         $this->lIndustryID        = $row->pe_lBizIndustryID;
         $this->strIndustry        = $row->lgen_strListItem;

         $this->strAddr1           = $row->pe_strAddr1;
         $this->strAddr2           = $row->pe_strAddr2;
         $this->strCity            = $row->pe_strCity;
         $this->strState           = $row->pe_strState;
         $this->strCountry         = $row->pe_strCountry;
         $this->strZip             = $row->pe_strZip;
         $this->strPhone           = $row->pe_strPhone;
         $this->strCell            = $row->pe_strCell;
         $this->strAddress         =
                     strBuildAddress(
                              $this->strAddr1, $this->strAddr2,   $this->strCity,
                              $this->strState, $this->strCountry, $this->strZip,
                              true);

         $this->strEmail           = $row->pe_strEmail;
         $this->strEmailFormatted  = strBuildEmailLink($this->strEmail, '', false, '');

         $this->lACO               = $row->pe_lACO;
         $this->strACO             = $row->aco_strName;
         $this->strCurSymbol       = $row->aco_strCurrencySymbol;
         $this->strFlag            = $row->aco_strFlag;
         $this->strFlagImage       = $clsACO->strFlagImage($this->strFlag, $this->strACO);

         $this->lAttributedTo      = $row->pe_lAttributedTo;
         $this->lImportID          = $row->pe_strImportID;

         $this->strImportRecID     = $row->pe_strImportID;
         $this->lOriginID          = $row->pe_lOriginID;
         $this->lLastUpdateID      = $row->pe_lLastUpdateID;

         $this->dteOrigin          = $row->dteOrigin;
         $this->dteLastUpdate      = $row->dteLastUpdate;

         $this->strStaffCFName     = $row->strCFName;
         $this->strStaffCLName     = $row->strCLName;
         $this->strStaffLFName     = $row->strLFName;
         $this->strStaffLLName     = $row->strLLName;

         $this->contactList(true, false, false);
      }
//      }
   }

   public function financialData($bViaBID, $bViaPID){
      if ($bViaBID){
         $strWhere = " AND biz_pple_id=".strPrepStr($this->lBID)." ";
      }elseif ($bViaPID){
         $strWhere = " AND biz_pple_id=".strPrepStr($this->lPID)." ";
      }else {
         $strWhere = '';
      }
      $sqlStr ="SELECT * FROM ngo_fin_proj_data
         WHERE 1 $strWhere";
      $query = $this->db->query($sqlStr);
      $this->lNumFdata = $numRows = $query->num_rows();
      return $query->result();

   }
    

   public function saveFinRecord(){

         $biz_pple_id = $this->input->post('biz_pple_id', TRUE);
         $objective_desc = $this->input->post('objective', TRUE);
         $total_asked_amount=$this->input->post('total_asked_amount', TRUE);
         $years = $this->input->post('years', TRUE);
         $status = $this->input->post('status', TRUE);
         $success_perc = $this->input->post('success_perc', TRUE);
         $lead_person = $this->input->post('lead_person', TRUE);
         $start_year= $this->input->post('start_year', TRUE);
         $restriction = $this->input->post('restriction', TRUE);
         $country_focus = $this->input->post('country_focus', TRUE);
         $amount_planned = $this->input->post('amount_planned', TRUE);

        
        $sqlStr ="INSERT INTO ngo_fin_proj_data 
        SET 
        biz_pple_id=".$this->db->escape($biz_pple_id).",
        objective=".$this->db->escape($objective_desc).",
        total_asked_amount=".$this->db->escape($total_asked_amount).",
        years=".$this->db->escape($years).",
        status=".$this->db->escape($status).",
        restriction=".$this->db->escape($restriction).",
        start_year=".$this->db->escape($start_year).",
        country_focus=".$this->db->escape($country_focus).",
        lead_person=".$this->db->escape($lead_person).",
        amount_planned=".$this->db->escape($amount_planned).",
        success_perc=".$this->db->escape($success_perc).";";
      $this->db->query($sqlStr);
      
      return true;



   }
   public function deleteFinRecord($id){

        $sqlStr ="DELETE FROM  ngo_fin_proj_data
         WHERE id=".strPrepStr($id).";";
      $this->db->query($sqlStr);
      
      return true;
      
   }

   public function updateFinRecord(){
      
         $id = $this->input->post('id', TRUE);
         $objective_desc = $this->input->post('objective_desc', TRUE);
         $total_asked_amount = $this->input->post('total_asked_amount', TRUE);
         $years =  $this->input->post('years', TRUE);
         $status = $this->input->post('status', TRUE);
         $success_perc = $this->input->post('success_perc', TRUE);
         $lead_person = $this->input->post('lead_person', TRUE);
         $start_year= $this->input->post('start_year', TRUE);
         $restriction = $this->input->post('restriction', TRUE);
         $country_focus = $this->input->post('country_focus', TRUE);
         $amount_planned = $this->input->post('amount_planned', TRUE);

        $sqlStr ="UPDATE ngo_fin_proj_data 
        SET 
        total_asked_amount=".$this->db->escape($total_asked_amount).",
        objective= ".$this->db->escape($objective_desc).",        
        years=".$this->db->escape($years).",
        status=".$this->db->escape($status).",
        restriction=".$this->db->escape($restriction).",
        start_year=".$this->db->escape($start_year).",
        country_focus=".$this->db->escape($country_focus).",
        lead_person=".$this->db->escape($lead_person).",
        amount_planned=".$this->db->escape($amount_planned).",
        success_perc=".$this->db->escape($success_perc)."
         WHERE id=".$this->db->escape($id).";";
      $this->db->query($sqlStr);
      
      return true;
      
   }


   public function contactList($bViaBID, $bViaPID, $bViaConRecID, $strWhere = '', $strLimit = ''){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $this->contacts = array();

      if ($bViaBID){
         $strWhere = " AND biz_pple_id=".strPrepStr($this->lBID)." ";
      }elseif ($bViaPID){
         $strWhere = " AND biz_pple_id=".strPrepStr($this->lPID)." ";
      }elseif ($bViaConRecID){
         $strWhere = " AND biz_pple_id=".strPrepStr($this->lConRecID)." ";
      }

      $sqlStr =
        "SELECT   *
            
         FROM ngo_contacts
         
            
           
         WHERE 1 $strWhere

         
            
            AND NOT bRetired
         
         $strLimit;";
      $query = $this->db->query($sqlStr);

      $this->lNumContacts = $numRows = $query->num_rows();
      $this->contacts = array();
      if ($numRows > 0){
         $idx = 0;
         foreach ($query->result() as $row) {
            $this->contacts[$idx] = new stdClass;
            $cRec = &$this->contacts[$idx];

            $cRec->lBizConRecID      = $row->id;
            $cRec->lBizID            = $row->biz_pple_id;
            $cRec->strBizName        = "";
            $cRec->lPeopleID         = "";
            $cRec->lBizRelID         = "";
            $cRec->strRelationship   = $row->position;
            $cRec->bSoftCash         = "";
            $cRec->strFName          = $strFName = $row->first_name;
            $cRec->strLName          = $strLName = $row->last_name;
            $cRec->strMName          = $strMName = $row->middle_name;
            $cRec->strTitle          = $strTitle = $row->title;
            $cRec->strPreferred      = $strPreferred = "";

            $cRec->strSafeName       = htmlspecialchars(
                                                            strBuildName(false, $strTitle, $strPreferred,
                                                                            $strFName, $strLName, $strMName));
            $cRec->strSafeNameLF     = htmlspecialchars(
                                                            strBuildName(true, $strTitle, $strPreferred,
                                                                            $strFName, $strLName, $strMName));


            $cRec->strAddr1          = "";
            $cRec->strAddr2          = "";
            $cRec->strCity           = "";
            $cRec->strState          = "";
            $cRec->strCountry        = "";
            $cRec->strZip            = "";
            $cRec->strPhone          = "";
            $cRec->strCell           = $row->phone;
            $cRec->strEmail          = $row->email;
            $cRec->strEmailFormatted = strBuildEmailLink($cRec->strEmail, '', false, '');

            $cRec->strAddress        =
                        strBuildAddress(
                                 $cRec->strAddr1, $cRec->strAddr2,   $cRec->strCity,
                                 $cRec->strState, $cRec->strCountry, $cRec->strZip,
                                 true);

            $cRec->lOriginID       = "";
            $cRec->dteOrigin       = "";
            $cRec->lLastUpdateID   = "";
            $cRec->dteLastUpdate   = "";

            ++$idx;
         }
      }
   }

   public function strBizContactPeopleIDList(){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $strList = '';
      $this->contactList(true, false, false);
      if ($this->lNumContacts > 0) {
         foreach($this->contacts as $clsID){
            $strList .= ', '.$clsID->lPeopleID;
         }
         $strList = substr($strList, 2);
      }
      return($strList);
   }

   public function lNumContacts($bViaBID, $bViaPID){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      if ($bViaBID){
         $strWhere = " AND biz_pple_id=".strPrepStr($this->lBID)." ";
      }elseif ($bViaPID){
         $strWhere = " AND biz_pple_id=".strPrepStr($this->lPID)." ";
      }else {
         $strWhere = '';
      }

      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM ngo_contacts
            
         WHERE 1 $strWhere

            AND NOT bRetired;";
      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

//      $result = mysql_query($sqlStr);
//      if (bSQLError('SQL error on line '.__LINE__.', file '.__FILE__.', function '.__FUNCTION__, $sqlStr) ) {
//         screamForHelp('Unexpected SQL error');
//      }else{
//         $numRows = mysql_num_rows($result);
      if ($numRows==0) {
         return(0);
      }else {
         $query = $this->db->query($sqlStr);
         return((integer)$row->lNumRecs);
      }
//      }
   }

   public function lNumFdata($bViaBID, $bViaPID){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      if ($bViaBID){
         $strWhere = " AND biz_pple_id=".strPrepStr($this->lBID)." ";
      }elseif ($bViaPID){
         $strWhere = " AND biz_pple_id=".strPrepStr($this->lPID)." ";
      }else {
         $strWhere = '';
      }

      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM ngo_fin_proj_data            
         WHERE 1 $strWhere;";
      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();


      if ($numRows==0) {
         return(0);
      }else {
         $query = $this->db->query($sqlStr);
         return((integer)$row->lNumRecs);
      }
   }

   public function deleteBizContact($bViaBID, $bViaPID, $bViaConRecID, $lGroupID){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $this->contactList($bViaBID, $bViaPID, $bViaConRecID);
      foreach ($this->contacts as $clsCon){
         $this->retireSingleBizCon($clsCon->lBizConRecID, $lGroupID);
      }
   }



     private function logBizConRetire($lBizConID, &$lGroupID){
   //-----------------------------------------------------------------------
   // caller must first call $this->peopleInfoLight();
   //-----------------------------------------------------------------------
      $clsRecycle = new recycleBin;

      $clsRecycle->lForeignID      = strPrepStr($lBizConID);
      $clsRecycle->strTable        = 'ngo_biz_contacts';
      $clsRecycle->strRetireFN     = 'bc_bRetired';
      $clsRecycle->strKeyIDFN      = 'bc_lKeyID';
      $clsRecycle->strNotes        = 'Retired business contact '.str_pad($lBizConID, 5, '0', STR_PAD_LEFT);
      $clsRecycle->lGroupID        = strPrepStr($lGroupID);
      $clsRecycle->enumRecycleType = 'Business Contact';

      $clsRecycle->addRecycleEntry();
   }

   public function strBizHTMLSummary(){
   //-----------------------------------------------------------------------
   // assumes user has called $clsBiz->loadBizRecsViaBID($lBID)
   //-----------------------------------------------------------------------
      $params = array('enumStyle' => 'terse');
      $clsRpt = new generic_rpt($params);
      $clsRpt->setEntrySummary();

      $lBID = $this->lBID;
      $biz = &$this->bizRecs[0];
      $strOut =
          $clsRpt->openReport('', '')
         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Business Name:')
         .$clsRpt->writeCell (strLinkView_BizRecord($lBID, 'View business record', true).'&nbsp;'
                              .$biz->strSafeName
                              .'&nbsp;&nbsp;(business ID: '
                              .str_pad($lBID, 5, '0', STR_PAD_LEFT).')'
                             )
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Address:')
         .$clsRpt->writeCell ($biz->strAddress)
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Industry:')
         .$clsRpt->writeCell (htmlspecialchars($biz->strIndustry))
         .$clsRpt->closeRow  ()

         .$clsRpt->closeReport('<br>');

      return($strOut);
   }

   

   

   public function removeBizContact($lConID){
   //-----------------------------------------------------------------------
   //
   //-----------------------------------------------------------------------
      $glUserID = USERID;

      $sqlStr =
           "UPDATE ngo_biz_contacts
            SET
               bc_bRetired      = 1,
               bc_lLastUpdateID = $glUserID,
               bc_dteLastUpdate = NOW()
            WHERE bc_lKeyID=".$this->db->escape($lConID).";";
      $query = $this->db->query($sqlStr);
//      $result = mysql_query($sqlStr);
//      if (bSQLError('SQL error on line '.__LINE__.', file '.__FILE__.', function '.__FUNCTION__, $sqlStr) ) {
//         screamForHelp('Unexpected SQL error');
//      }
   }



   function loadFinrec($finid){
    $sqlStr =
           "SELECT * FROM ngo_fin_proj_data WHERE id=".$this->db->escape($finid).";";
            $query = $this->db->query($sqlStr);
      return $query->result();  

   }


   function loadContactNameDirectoryPage($strWhereExtra, $lStartRec, $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlLimitExtra = " LIMIT $lStartRec, $lRecsPerPage ";
      $this->sqlWhereExtra = $strWhereExtra;

      $sqlStr =
           "SELECT *
               
            FROM ngo_contacts
               
            WHERE NOT bRetired
               AND biz_pple_id = ".strPrepStr($this->lBID)."
            
               $sqlLimitExtra;";

      $query = $this->db->query($sqlStr);

      $this->lNumContactsNames = $numRows = $query->num_rows();
      $this->contactsNames = array();
      if ($numRows > 0){
         $idx = 0;
         foreach ($query->result() as $row) {
            $this->contactsNames[$idx] = new stdClass;
            $cRec = &$this->contactsNames[$idx];

            $cRec->lPeopleID         = $row->id;
            $cRec->strFName          = $strFName = $row->first_name;
            $cRec->strLName          = $strLName = $row->last_name;
            $cRec->strMName          = $strMName = $row->middle_name;
            $cRec->address           = $straddress = $row->address;
            $cRec->strTitle          = $strTitle = $row->title;
            $cRec->strPreferred      = $strPreferred = "";

            $cRec->strSafeName       = htmlspecialchars(
                                                            strBuildName(false, $strTitle, $strPreferred,
                                                                            $strFName, $strLName, $strMName));
            $cRec->strSafeNameLF     = htmlspecialchars(
                                                            strBuildName(true, $strTitle, $strPreferred,
                                                                            $strFName, $strLName, $strMName));


            $cRec->strAddr1          = "";
            $cRec->strAddr2          = "";
            $cRec->strCity           = "";
            $cRec->strState          = "";
            $cRec->strCountry        = "";
            $cRec->strZip            = "";
            $cRec->strPhone          = "";
            $cRec->strCell           = $row->phone;
            $cRec->strEmail          = $row->email;
            $cRec->strEmailFormatted = strBuildEmailLink($cRec->strEmail, '', false, '');

            $cRec->strAddress        =
                        strBuildAddress(
                                 $cRec->strAddr1, $cRec->strAddr2,   $cRec->strCity,
                                 $cRec->strState, $cRec->strCountry, $cRec->strZip,
                                 true);

            $cRec->biz = $this->bizViaContactPID($cRec->lPeopleID, $cRec->lNumBiz);

            ++$idx;
         }
      }
   }

    public function bizViaContactPID($lPeopleID, &$lNumBiz){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $biz = array();
      $sqlStr =
        "SELECT
            id, biz_pple_id, first_name, last_name, middle_name,
            title, position, email, phone, address
         FROM ngo_contacts
            INNER JOIN ngo_donors  ON pe_lKeyID           = biz_pple_id
            LEFT  JOIN ngo_lists_generic ON position = lgen_lKeyID
         WHERE NOT bRetired
            AND biz_pple_id=".strPrepStr($lPeopleID)."
            AND NOT pe_bRetired
            ORDER BY pe_strLName, lgen_strListItem, id;";
      $query = $this->db->query($sqlStr);
      $lNumBiz = $query->num_rows();
      if ($lNumBiz > 0){
         $idx = 0;
         foreach ($query->result() as $row) {
            $biz[$idx] = new stdClass;
            $b = &$biz[$idx];
            $b->contactID       = $row->id;
            $b->bizID           = $row->biz_pple_id;
            $b->peopleID        = $row->bc_lContactID;
            $b->relationshipID  = $row->bc_lBizContactRelID;
            $b->strBizName      = $row->pe_strLName;
            $b->strBizSafeName  = htmlspecialchars($row->pe_strLName);
            $b->strRelationship = $row->lgen_strListItem;

            ++$idx;
         }
      }
      return($biz);
   }



  public function addNewContact($lBizID){
      $title = $this->input->post('title', TRUE);
      $first_name = $this->input->post('first_name', TRUE);
      $middle_name = $this->input->post('middle_name', TRUE);
      $last_name = $this->input->post('last_name', TRUE);
      $mobile = $this->input->post('mobile', TRUE);
      $address = $this->input->post('address', TRUE);
      $email = $this->input->post('email', TRUE);
      $position = $this->input->post('relationship', TRUE);

   $sqlStr =
       "INSERT INTO ngo_contacts
        SET
               title = ".$this->db->escape($title).",
               biz_pple_id = ".$this->db->escape($lBizID).",
               first_name = ".$this->db->escape($first_name).",
               middle_name = ".$this->db->escape($middle_name).",
               last_name = ".$this->db->escape($last_name).",
               phone = ".$this->db->escape($mobile).",
               address = ".$this->db->escape($address).",
               email=".$this->db->escape($email).",
               position=".$this->db->escape($position)."; ";
      $query = $this->db->query($sqlStr);

      return true;

  }

public function loadContactRel(){
   $sqlStr =
       "SELECT * FROM ngo_lists_generic
        WHERE NOT lgen_bRetired AND lgen_enumListType='bizContactRel'";
      $query = $this->db->query($sqlStr);
      return $query->result();


}


public function loadContactRecord($lBizID, $conID){

   $sqlStr =
       "SELECT * FROM ngo_contacts
        WHERE NOT bRetired AND biz_pple_id=".strPrepStr($lBizID)." AND id=".strPrepStr($conID)." ";
      $query = $this->db->query($sqlStr);
      return $query->result();

}

public function updateContact($conID){
      $title = $this->input->post('title', TRUE);
      $first_name = $this->input->post('first_name', TRUE);
      $middle_name = $this->input->post('middle_name', TRUE);
      $last_name = $this->input->post('last_name', TRUE);
      $mobile = $this->input->post('mobile', TRUE);
      $email = $this->input->post('email', TRUE);
      $position = $this->input->post('relationship', TRUE);

   $sqlStr =
       "UPDATE ngo_contacts
        SET
               title = ".$this->db->escape($title).",
               first_name =".$this->db->escape($first_name).",
               middle_name = ".$this->db->escape($middle_name).",
               last_name = ".$this->db->escape($last_name).",
               phone = ".$this->db->escape($mobile).",
               email=".$this->db->escape($email).",
               position=".$this->db->escape($position)."
        WHERE id = ".$this->db->escape($conID).";";
      $query = $this->db->query($sqlStr);

      return true;




}

public function deleteContact($conID){
     

   $sqlStr =
       "UPDATE ngo_contacts
        SET
               bRetired = 1
        WHERE id = ".$this->db->escape($conID).";";
      $query = $this->db->query($sqlStr);

      return true;




}







}

?>