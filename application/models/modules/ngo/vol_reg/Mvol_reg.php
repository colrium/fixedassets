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
      $this->load->model('vol_reg/mvol_reg', 'volReg');
--------------------------------------------------------------------

---------------------------------------------------------------------*/


class Mvol_reg extends CI_Model{
   public
       $regRecs, $lNumRegRecs,
       $strWhereExtra, $strOrder;

   public $lNumSkillTot, $lNumSkills, $skills, $bSkillsMissing,
          $lMissingSkills, $lOnFormSkills;

   public $lNumStyleSheets, $styleSheets;

   public $lNumTables, $utables;

   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();

      $this->regRecs = null;
      $this->lNumRegRecs = 0;
      $this->strWhereExtra = $this->strOrder = '';

      $this->lNumSkillTot = $this->lNumSkills = 0;
      $this->lMissingSkills = $this->lOnFormSkills = 0;
      $this->skills = null;
      $this->bSkillsMissing = false;

      $this->lNumStyleSheets = 0;
      $this->styleSheets     = null;

      $this->lNumTables = 0;
      $this->utables    = null;
   }

   function loadVolRegFormsViaRFID($lRegFormID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->strWhereExtra = " AND vreg_lKeyID=$lRegFormID ";
      $this->loadVolRegForms();
   }

   function loadVolRegFormsViaHash($strHash){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->strWhereExtra = ' AND vreg_strURLHash='.strPrepStr($strHash).' ';
      $this->loadVolRegForms();
   }

   function loadVolRegForms(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->regRecs = array();

      if ($this->strOrder == ''){
         $strOrder = ' vreg_strFormName, vreg_lKeyID ';
      }else {
         $strOrder = $this->strOrder;
      }
      $sqlStr = "
         SELECT
            vreg_lKeyID, vreg_strFormName, vreg_strDescription,
            vreg_strIntro, vreg_strSubmissionText, vreg_strBannerOrg, vreg_strBannerTitle,
            vreg_strCSSFN, vreg_strHexBGColor, vreg_strContact,
            vreg_strContactPhone, vreg_strContactEmail, vreg_strWebSite,
            vreg_strURLHash,

                 -- standard display fields
            vreg_bShowFName, vreg_bShowLName, vreg_bShowAddr, vreg_bShowEmail,
            vreg_bShowPhone,  vreg_bShowCell, vreg_bShowBDay, 
            vreg_bShowDisclaimer, vreg_strDisclaimerAck, vreg_strDisclaimer, 
            vreg_lLogoImageID, vreg_lVolGroupID,

            vreg_bFNameRequired, vreg_bLNameRequired, vreg_bAddrRequired, vreg_bEmailRequired,
            vreg_bPhoneRequired, vreg_bCellRequired,
            vreg_bBDateRequired, vreg_bDisclaimerAckRqrd,

            vreg_bPermEditContact,   vreg_bPermPassReset,      vreg_bPermViewGiftHistory,
            vreg_bPermEditJobSkills, vreg_bPermViewHrsHistory, vreg_bPermAddVolHours,
            vreg_bVolShiftSignup,

            vreg_bCaptchaRequired,

            vreg_bRetired, vreg_lOriginID, vreg_lLastUpdateID,

            UNIX_TIMESTAMP(vreg_dteOrigin)     AS dteOrigin,
            UNIX_TIMESTAMP(vreg_dteLastUpdate) AS dteLastUpdate,
            uc.first_name AS strUCFName, uc.last_name AS strUCLName,
            ul.first_name AS strULFName, ul.last_name AS strULLName
         FROM ngo_vol_reg
            INNER JOIN users   AS uc ON uc.id=vreg_lOriginID
            INNER JOIN users   AS ul ON ul.id=vreg_lLastUpdateID

         WHERE NOT vreg_bRetired $this->strWhereExtra
         ORDER BY $strOrder;";
      $query = $this->db->query($sqlStr);
      $this->lNumRegRecs = $numRows = $query->num_rows();

      if ($numRows==0) {
         $this->regRecs[0] = new stdClass;
         $rRec = &$this->regRecs[0];
         $rRec->lKeyID               =
         $rRec->strFormName          =
         $rRec->strDescription       =
         $rRec->strIntro             =
         $rRec->strSubmissionText    = 
         $rRec->strBannerOrg         =
         $rRec->strBannerTitle       =
         $rRec->strCSSFN             =
         $rRec->strHexBGColor        =
         $rRec->strContact           =
         $rRec->strContactPhone      =
         $rRec->strContactEmail      =
         $rRec->strWebSite           =
         $rRec->strURLHash           =
         $rRec->lLogoImageID         =
         $rRec->lVolGroupID          =

         $rRec->bShowFName           =
         $rRec->bShowLName           =
         $rRec->bShowAddr            =
         $rRec->bShowEmail           =
         $rRec->bShowPhone           =
         $rRec->bShowCell            =

         $rRec->bShowBDay            = null;
         
         $rRec->bShowDisclaimer      =
         $rRec->strDisclaimerAck     =
         $rRec->strDisclaimer        =

         $rRec->bFNameRequired       =
         $rRec->bLNameRequired       =
         $rRec->bAddrRequired        =
         $rRec->bEmailRequired       =
         $rRec->bBDateRequired       =
         $rRec->bDisclaimerAckRqrd   =

         $rRec->bPermEditContact     =
         $rRec->bPermPassReset       =
         $rRec->bPermViewGiftHistory =
         $rRec->bPermEditJobSkills   =
         $rRec->bPermViewHrsHistory  =
         $rRec->bPermAddVolHours     =
         $rRec->bVolShiftSignup      = 

         $rRec->bCaptchaRequired     =

         $rRec->bRetired             =

         $rRec->lOriginID            =
         $rRec->lLastUpdateID        =
         $rRec->dteOrigin            =
         $rRec->dteLastUpdate        =
         $rRec->strUCFName           =
         $rRec->strUCLName           =
         $rRec->strULFName           =
         $rRec->strULLName           = null;
      }else {
         $idx = 0;
         foreach ($query->result() as $row) {
            $this->regRecs[$idx] = new stdClass;
            $rRec = &$this->regRecs[$idx];

            $rRec->lKeyID               = $row->vreg_lKeyID;
            $rRec->strFormName          = $row->vreg_strFormName;
            $rRec->strDescription       = $row->vreg_strDescription;
            $rRec->strIntro             = $row->vreg_strIntro;
            $rRec->strSubmissionText    = $row->vreg_strSubmissionText;
            $rRec->strBannerOrg         = $row->vreg_strBannerOrg;
            $rRec->strBannerTitle       = $row->vreg_strBannerTitle;
            $rRec->strCSSFN             = $row->vreg_strCSSFN;
            $rRec->strHexBGColor        = $row->vreg_strHexBGColor;
            $rRec->strContact           = $row->vreg_strContact;
            $rRec->strContactPhone      = $row->vreg_strContactPhone;
            $rRec->strContactEmail      = $row->vreg_strContactEmail;
            $rRec->strWebSite           = $row->vreg_strWebSite;
            $rRec->strURLHash           = $row->vreg_strURLHash;
            $rRec->lLogoImageID         = $row->vreg_lLogoImageID;
            $rRec->lVolGroupID          = $row->vreg_lVolGroupID;
            $rRec->strVolRegFormURL     = site_url('vol_reg/vol/register/'.$rRec->strURLHash);

            $rRec->lLogoImageID         = $row->vreg_lLogoImageID;

            $rRec->bShowFName           = (boolean)$row->vreg_bShowFName;
            $rRec->bShowLName           = (boolean)$row->vreg_bShowLName;
            $rRec->bShowAddr            = (boolean)$row->vreg_bShowAddr;
            $rRec->bShowEmail           = (boolean)$row->vreg_bShowEmail;
            $rRec->bShowPhone           = (boolean)$row->vreg_bShowPhone;
            $rRec->bShowCell            = (boolean)$row->vreg_bShowCell;

            $rRec->bShowBDay            = (boolean)$row->vreg_bShowBDay;

               // disclaimer
            $rRec->bShowDisclaimer      = (boolean)$row->vreg_bShowDisclaimer;
            $rRec->strDisclaimerAck     = $row->vreg_strDisclaimerAck;
            $rRec->strDisclaimer        = $row->vreg_strDisclaimer;
            $rRec->bDisclaimerAckRqrd   = (boolean)$row->vreg_bDisclaimerAckRqrd;

            $rRec->bFNameRequired       = (boolean)$row->vreg_bFNameRequired;
            $rRec->bLNameRequired       = (boolean)$row->vreg_bLNameRequired;
            $rRec->bAddrRequired        = (boolean)$row->vreg_bAddrRequired;
            $rRec->bEmailRequired       = (boolean)$row->vreg_bEmailRequired;
            $rRec->bPhoneRequired       = (boolean)$row->vreg_bPhoneRequired;
            $rRec->bCellRequired        = (boolean)$row->vreg_bCellRequired;

            $rRec->bBDateRequired       = (boolean)$row->vreg_bBDateRequired;

            $rRec->bPermEditContact     = (boolean)$row->vreg_bPermEditContact;
            $rRec->bPermPassReset       = (boolean)$row->vreg_bPermPassReset;
            $rRec->bPermViewGiftHistory = (boolean)$row->vreg_bPermViewGiftHistory;
            $rRec->bPermEditJobSkills   = (boolean)$row->vreg_bPermEditJobSkills;
            $rRec->bPermViewHrsHistory  = (boolean)$row->vreg_bPermViewHrsHistory;
            $rRec->bPermAddVolHours     = (boolean)$row->vreg_bPermAddVolHours;
            $rRec->bVolShiftSignup      = (boolean)$row->vreg_bVolShiftSignup;

            $rRec->bCaptchaRequired     = (boolean)$row->vreg_bCaptchaRequired;

            $rRec->bRetired             = (boolean)$row->vreg_bRetired;

            $rRec->lOriginID            = $row->vreg_lOriginID;
            $rRec->lLastUpdateID        = $row->vreg_lLastUpdateID;
            $rRec->dteOrigin            = $row->dteOrigin;
            $rRec->dteLastUpdate        = $row->dteLastUpdate;
            $rRec->strUCFName           = $row->strUCFName;
            $rRec->strUCLName           = $row->strUCLName;
            $rRec->strULFName           = $row->strULFName;
            $rRec->strULLName           = $row->strULLName;

            ++$idx;
         }
      }
   }

   function setLogoImageTag($lRegFormIDX=0){
   /*-----------------------------------------------------------------------
      assumes user has called $this->loadVolRegForms()

      caller must include
            $this->load->model  ('img_docs/mimage_doc',   'clsImgDoc');
            $this->load->helper ('img_docs/image_doc');
   -----------------------------------------------------------------------*/
      $rRec = &$this->regRecs[$lRegFormIDX];
      $lImageID = $rRec->lLogoImageID;

      $rRec->strLogoImageTag = null;

      if (!is_null($rRec->lLogoImageID)){
         $cImg = new mimage_doc;
         $cImg->bLoadContext = false;
         $cImg->loadDocImageInfoViaID($lImageID);
         
         $bImgAvail = $cImg->lNumImageDocs > 0;

         if ($bImgAvail){
            $imgDoc = &$cImg->imageDocs[0];
            
            $rRec->strLogoImageTag = '<div style="text-align: center;"><img src="'.base_url().substr($imgDoc->strPath, 2)
                           .'/'.$imgDoc->strSystemFN.'" '.$imgDoc->imageSize[3].'></div>';
         }
      }
   }

   function loadVolRegFormSkills($lFormID, $bLoadAllSkills){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bLoadAllSkills){
         $this->loadAllJobSkills($lFormID);
      }else {
         $this->loadJobSkillsOnFormOnly($lFormID);
      }
   }

   private function loadAllJobSkills($lFormID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->skills = array();
      $this->lNumSkills = 0;

      $sqlStr = 'DROP TABLE IF EXISTS ngo_tmp_reg_skills;';
      $query = $this->db->query($sqlStr);

      $sqlStr = '
            CREATE TEMPORARY TABLE IF NOT EXISTS ngo_tmp_reg_skills (
              tjs_lKeyID      int(11) NOT NULL AUTO_INCREMENT,
              tjs_lRegSkillID int(11) NOT NULL COMMENT \'Foreign key to vol_reg_skills\',
              tjs_lSkillID    int(11) NOT NULL COMMENT \'Foreign key to generic list table\',
              PRIMARY KEY         (tjs_lKeyID),
              KEY tjs_lRegSkillID (tjs_lRegSkillID),
              KEY vrs_lSkillID    (tjs_lSkillID)
            ) ENGINE=MyISAM  DEFAULT CHARSET=latin1;';
      $query = $this->db->query($sqlStr);

      $sqlStr = "
          INSERT INTO ngo_tmp_reg_skills (tjs_lRegSkillID, tjs_lSkillID)
            SELECT vrs_lKeyID, vrs_lSkillID
            FROM vol_reg_skills
            WHERE vrs_lRegFormID=$lFormID;";
      $query = $this->db->query($sqlStr);

      $sqlStr = "
         SELECT
            lgen_lKeyID, lgen_strListItem, tjs_lRegSkillID
         FROM ngo_lists_generic
            LEFT JOIN ngo_tmp_reg_skills ON lgen_lKeyID=tjs_lSkillID
         WHERE NOT lgen_bRetired
            AND lgen_enumListType='".CENUM_LISTTYPE_VOLSKILLS."'
         ORDER BY lgen_strListItem, tjs_lRegSkillID;";

      $query = $this->db->query($sqlStr);
      $this->lNumSkillTot = $numRows = $query->num_rows();

      if ($numRows==0) {
         $this->lNumSkills = 0;
         $this->skills[0] = new stdClass;
         $skill = &$this->skills[0];

         $skill->lRegFormID =
         $skill->bOnForm    =
         $skill->lSkillID   =
         $skill->strSkill   = null;
      }else {
         $idx = 0;
         foreach ($query->result() as $row) {
            $this->skills[$idx] = new stdClass;
            $skill = &$this->skills[$idx];

            $skill->lSkillID   = $row->lgen_lKeyID;
            $skill->strSkill   = $row->lgen_strListItem;

            $skill->lRegFormID = $row->tjs_lRegSkillID;
            $skill->bOnForm    = !is_null($row->tjs_lRegSkillID);
            if ($skill->bOnForm) ++$this->lNumSkills;
            ++$idx;
         }
      }
   }

   private function loadJobSkillsOnFormOnly($lFormID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->bSkillsMissing = false;
      $this->lMissingSkills = $this->lOnFormSkills = 0;
      $this->skills = array();
      $sqlStr = "
            SELECT
               vrs_lKeyID, vrs_lRegFormID, vrs_lSkillID,
               lgen_lKeyID, lgen_strListItem, lgen_bRetired
            FROM ngo_vol_reg_skills
               LEFT JOIN ngo_lists_generic ON vrs_lSkillID=lgen_lKeyID
            WHERE vrs_lRegFormID=$lFormID
            ORDER BY lgen_strListItem, vrs_lKeyID;";

      $query = $this->db->query($sqlStr);
      $this->lNumSkillTot = $this->lNumSkills = $numRows = $query->num_rows();

      if ($numRows==0) {
         $this->skills[0] = new stdClass;
         $skill = &$this->skills[0];

         $skill->lKeyID     =
         $skill->lRegFormID =
         $skill->lSkillID   =
         $skill->bMissing   =
         $skill->strSkill   = null;
      }else {
         $idx = 0;
         foreach ($query->result() as $row) {
            $this->skills[$idx] = new stdClass;
            $skill = &$this->skills[$idx];

            $skill->lKeyID     = $row->vrs_lKeyID;
            $skill->lRegFormID = $row->vrs_lRegFormID;
            $skill->lSkillID   = $row->vrs_lSkillID;

               // has the skill list item been removed?
            if (is_null($row->lgen_lKeyID) || $row->lgen_bRetired){
               $skill->bMissing      = true;
               $this->bSkillsMissing = true;
               $skill->strSkill      = '#error#';
               ++$this->lMissingSkills;
            }else {
               $skill->bMissing = false;
               $skill->strSkill = $row->lgen_strListItem;
               ++$this->lOnFormSkills;
            }
            ++$idx;
         }
      }
   }

   function lNumVolRecsViaRegFormID($lRegFormID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT COUNT(*) AS lNumRecs
         FROM ngo_volunteers
            INNER JOIN ngo_donors ON pe_lKeyID=vol_lPeopleID
         WHERE NOT vol_bRetired
            AND NOT pe_bRetired
            AND vol_lRegFormID = $lRegFormID;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((int)$row->lNumRecs);            
   }   



   function updateJobSkillFields($lRegFormID, $lNumSkills, &$jobSkills){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
         // out with the old
      $this->deleteJobSkillsFields($lRegFormID);

         // in with the new
      if ($lNumSkills > 0){
         foreach ($jobSkills as $skill){
            if ($skill->bShow){
               $this->insertJobSkill($lRegFormID, $skill->lSkillID);
            }
         }
      }
   }

   function deleteJobSkillsFields($lRegFormID){
      $sqlStr =
          "DELETE FROM ngo_vol_reg_skills
           WHERE vrs_lRegFormID=$lRegFormID;";
      $query = $this->db->query($sqlStr);
   }

   private function insertJobSkill($lRegFormID, $lSkillID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "INSERT INTO ngo_vol_reg_skills
         SET
            vrs_lRegFormID=$lRegFormID,
            vrs_lSkillID=$lSkillID;";
      $query = $this->db->query($sqlStr);
   }

/*   
   function removeVolRegForm($lVolRegFormID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $glUserID = USERID;
      $sqlStr =
        "UPDATE vol_reg
         SET
            vreg_bRetired = 1,
            vreg_lLastUpdateID = $glUserID,
            vreg_dteLastUpdate = NOW()
         WHERE vreg_lKeyID=$lVolRegFormID;";
      $query = $this->db->query($sqlStr);

      $this->deleteJobSkillsFields($lVolRegFormID);
      $this->deletePTableFields($lVolRegFormID);
   }
*/
   function availableStyleSheets(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->lNumStyleSheets = 0;
      $this->styleSheets     = array();

      $strDirPath = './css/vol_reg';
      $dirFiles = get_filenames($strDirPath);
      if ($dirFiles !== false){
         sort($dirFiles, SORT_STRING);
         foreach ($dirFiles as $strFN){
            if (strtoupper(substr($strFN, -4))=='.CSS'){
               $this->styleSheets[$this->lNumStyleSheets] = $strFN;
               ++$this->lNumStyleSheets;
            }
         }
      }
   }

   function strCSSDropDown($strDDLName, $strMatch, $bAddBlank){
   //---------------------------------------------------------------------
   // caller must previously call $this->availableStyleSheets()
   //---------------------------------------------------------------------
      $strOut = '<select name="'.$strDDLName.'">'."\n";
      if ($bAddBlank){
         $strOut .= '<option value="">&nbsp;</option>'."\n";
      }

      if ($this->lNumStyleSheets > 0){
         $bMatch = false;
         foreach ($this->styleSheets as $strFN){
            if ($strMatch==$strFN){
               $bMatch = true;
               break;
            }
         }
         if (!$bMatch){
            $strMatch = 'default.css';
         }

         foreach ($this->styleSheets as $strFN){
            $strOut .= '<option value="'.$strFN.'" '.($strMatch==$strFN ? 'selected' : '').'>'
                        .htmlspecialchars($strFN).'</option>'."\n";
         }
      }
      $strOut .= '</select>'."\n";
      return($strOut);
   }

   function bShowRequiredUFFields($lRegFormID, $lTableID, $lFieldID, &$bShow, &$bRequired){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $bShow = $bRequired = false;

      $sqlStr =
        "SELECT vruf_bRequired
         FROM ngo_vol_reg_uf
         WHERE vruf_lRegFormID=$lRegFormID
            AND vruf_lTableID=$lTableID
            AND vruf_lFieldID=$lFieldID;";
      $query = $this->db->query($sqlStr);
      if ($query->num_rows() != 0){
         $row = $query->row();
         $bShow = true;
         $bRequired = $row->vruf_bRequired;
      }
   }

   function strPublicUFTable($lTableID, $lFormID, $strDefault){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT vrtl_strLabel
         FROM ngo_vol_reg_table_labels
         WHERE vrtl_lRegFormID = $lFormID
            AND vrtl_lTableID=$lTableID;";
      $query = $this->db->query($sqlStr);
      if ($query->num_rows() == 0){
         return($strDefault);
      }else {
         $row = $query->row();
         return($row->vrtl_strLabel);
      }
   }

/*   
   private function insertPTableField($lRegFormID, $lTableID, $lFieldID, $bRequired){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "INSERT INTO vol_reg_uf
         SET
            vruf_lRegFormID=$lRegFormID,
            vruf_lTableID=$lTableID,
            vruf_lFieldID=$lFieldID,
            vruf_bRequired=".($bRequired ? '1' : '0').',
            vruf_strLabel=\'\';';
      $query = $this->db->query($sqlStr);
   }

   function updatePTableFields($lRegFormID, $lNumTables, &$userTables){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
         // out with the old
      $this->deletePTableFields($lRegFormID);

         // in with the new
      if ($lNumTables > 0){
         foreach ($userTables as $utable){
            if ($utable->lNumFields > 0){
               foreach ($utable->fields as $field){
                  if ($field->enumFieldType!=CS_FT_LOG){
                     if ($field->bShow){
                        $this->insertPTableField($lRegFormID, $utable->lKeyID, $field->pff_lKeyID, $field->bRequired);
                     }
                  }
               }
            }
         }
      }
   }

   private function deletePTableFields($lRegFormID){
      $sqlStr =
          "DELETE FROM vol_reg_uf
           WHERE vruf_lRegFormID=$lRegFormID;";
      $query = $this->db->query($sqlStr);
   }
*/


   function loadPTablesForDisplay($lRegFormID, &$clsUF, $bLoadFields=true){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->utables = array();

      $sqlStr =
           "SELECT DISTINCT
               vruf_lRegFormID, vruf_lTableID,
               pft_strUserTableName, pft_strDataTableName, pft_bMultiEntry
            FROM ngo_vol_reg_uf
               INNER JOIN ngo_uf_tables ON vruf_lTableID=pft_lKeyID

            WHERE vruf_lRegFormID=$lRegFormID
               AND NOT pft_bRetired AND NOT pft_bHidden
            ORDER BY pft_strUserTableName, vruf_lTableID;";

      $query = $this->db->query($sqlStr);
      $this->lNumTables = $numRows = $query->num_rows();

      if ($numRows==0) {
         $this->utables[0] = new stdClass;
         $utable = &$this->utables[0];
         
         $utable->lRegFormID        =
         $utable->lTableID          =
         $utable->strUserTableName  =
         $utable->strDataTableName  =         
         $utable->bMultiEntry       = 
         $utable->ufields           = null;         
      }else {
         $idx = 0;
         foreach ($query->result() as $row) {
            $this->utables[$idx] = new stdClass;
            $utable = &$this->utables[$idx];

            $utable->lRegFormID        = $row->vruf_lRegFormID;
            $utable->lTableID          = $lTableID = $row->vruf_lTableID;
            $utable->strUserTableName  = $row->pft_strUserTableName;
            $utable->strDataTableName  = $row->pft_strDataTableName;
            $utable->bMultiEntry       = $row->pft_bMultiEntry;
            $utable->strFieldPrefix    = $clsUF->strGenUF_KeyFieldPrefix($lTableID);

            if ($bLoadFields){
               $utable->ufields = array();
               $this->loadTableFieldsForDisplay($utable->ufields, $utable->lNumFields, $utable->lRegFormID, $utable->lTableID);
            }
            ++$idx;
         }
      }
   }

   private function loadTableFieldsForDisplay(&$ufields, &$lNumFields, $lRegFormID, $lTableID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lNumFields = 0;

      $sqlStr =
           "SELECT
               vruf_lKeyID,
               vruf_lFieldID, vruf_bRequired, vruf_strLabel,
               pff_lKeyID, pff_lTableID, pff_lSortIDX, pff_strFieldNameInternal,
               pff_strFieldNameUser, pff_strFieldNotes, pff_enumFieldType, pff_bConfigured,
               pff_lCurrencyACO

            FROM ngo_vol_reg_uf
               INNER JOIN ngo_uf_fields ON vruf_lFieldID=pff_lKeyID

            WHERE vruf_lRegFormID=$lRegFormID
               AND vruf_lTableID=$lTableID
            ORDER BY pff_lSortIDX, pff_strFieldNameUser, vruf_lFieldID;";


      $query = $this->db->query($sqlStr);
      $lNumFields = $query->num_rows();

      if ($lNumFields > 0) {
         $idx = 0;
         foreach ($query->result() as $row) {
            $ufields[$idx] = new stdClass;
            $ufield = &$ufields[$idx];

            $ufield->lKeyID               = $row->vruf_lKeyID;
            $ufield->lFieldID             = $row->vruf_lFieldID;
            $ufield->bRequired            = $row->vruf_bRequired;
            $ufield->strLabel             = $row->vruf_strLabel;
            $ufield->lTableID             = $row->pff_lTableID;
            $ufield->lSortIDX             = $row->pff_lSortIDX;
            $ufield->strFieldNameInternal = $row->pff_strFieldNameInternal;
            $ufield->strFieldNameUser     = $row->pff_strFieldNameUser;
            $ufield->strFieldNotes        = $row->pff_strFieldNotes;
            $ufield->enumFieldType        = $row->pff_enumFieldType;
            $ufield->bConfigured          = $row->pff_bConfigured;
            $ufield->lCurrencyACO         = $row->pff_lCurrencyACO;

            ++$idx;
         }
      }
   }

 }
