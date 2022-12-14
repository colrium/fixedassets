<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
   __construct
   lNumReminders         ($enumRemType, $lFID, $bCurrentFuture)
   loadReminders         ()
   strHTMLOneLineLink    ($clsSingleRem)
   informListViaRemID    ($lRemID, &$lUserIDs)
   loadInformListViaRemID($lRemDateID, &$informList, &$lNumToInform)
   loadDatesViaRemID     ($lRemID, &$dates, &$lNumDates)
   loadFollupUpsViaRemID ($lRemID, &$followUpNotes, &$lNumFollowUps)
   innerViaRemType       ($enumRemType, &$strInner, &$strSelectExtra)
   lInsertReminderBase   ()
   lInsertReminderDate   ($lRemID, $dteStart, $dteEnd)
   lInsertReminderUser   ($lRemDateID, $lUserID)
   setReminderTypeHeader ($lFID, $enumRemType)
   bOKToView             ($clsSingleRem, $lUserID)
   lNumPast              ($clsSingleRem, $dteCheck, &$lIdxLastPast)
   lNumFuture            ($clsSingleRem, $dteCheck, &$lIdxFirstFuture)
   lNumPastFuture        ($clsSingleRem, $dteCheck, $bPast, &$lIdxOfInterest)
   lCurrentRemIdx        ($clsSingleRem, $dteCheck)
   addFollowup           ($lRemID, $strFollowup)
   removeReminder        ($lRemID)
   loadEnumTypeList      ($enumRemType)

//---------------------------------------------------------------------
// Reminder types are defined in def_LNP.php
//
---------------------------------------------------------------------
      $this->load->model('reminders/mreminders', 'clsRem');
---------------------------------------------------------------------*/

class Mreminders extends CI_Model{

   public $lRID, $lInformUserID, $enumRemType, $enumRemTypeList, $lFID, $bCurrentFuture,
          $dteStart, $dteEnd, $enumSort, $enumLookupType;

//          $bViaRID, $bViaInformUserID, $bViaEnumRemType, $bViaFID,
//          $ViaEnumRemTypeFID;

   public $reminders, $lNumReminders;

   public function __construct(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
		parent::__construct();
      $this->lRID   = $this->lInformUserID  = $this->enumRemType     =
      $this->lFID   = $this->bCurrentFuture = $this->dteStart        =
      $this->dteEnd = $this->enumSort       = $this->enumRemTypeList = null;

      $this->reminders = $this->lNumReminders = null;
      
      $this->enumLookupType = null;

//      $this->bViaRID = $this->bViaInformUserID = $this->bViaEnumRemType =
//      $this->bViaEnumRemTypeFID = $this->bViaFID = false;
   }

   private function strCurrentFutureWhere(){
      $lPreviewDays = $this->config->item('dl_reminderPreviewDays');
      return(' AND rd_dteEndDisplayDate >= '.strPrepDate(time())."
               AND rd_dteDisplayDate    <= DATE_ADD(NOW(),INTERVAL $lPreviewDays DAY)  ");
   }
   
   public function lNumReminders($enumRemType, $lFID, $bCurrentFuture, $lUserID=null){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID, $gdteNow;
      
      if (is_null($lUserID)) $lUserID = $glUserID;

      if ($bCurrentFuture){
         $lPreviewDays = $this->config->item('lnp_reminderPreviewDays');
         $strWhereDate = $this->strCurrentFutureWhere();
//                         ' AND rd_dteEndDisplayDate >= '.strPrepDate($gdteNow).' '
//                        .' AND rd_dteDisplayDate    <= DATE_ADD(NOW(),INTERVAL $lPreviewDays DAY))  ' ;
      }else {
         $strWhereDate = '';
      }

      $this->loadEnumTypeList($enumRemType);
      $lNumRems = 0;

      if ($enumRemType==CENUM_CONTEXT_USER){
         $strForeignWhere = '';
      }else {
         $strForeignWhere = " AND re_lForeignID=$lFID ";
      }

         // -1 user ID used to indicate "all users"
      foreach ($this->enumRemTypeList as $enumET){
         $sqlStr =
           'SELECT DISTINCT re_lKeyID
            FROM ngo_reminders
               INNER JOIN ngo_reminders_dates  ON rd_lRemID    =re_lKeyID
               INNER JOIN ngo_reminders_inform ON ri_lRemDateID=rd_lKeyID
            WHERE re_enumSource='.strPrepStr($enumET)."
               $strForeignWhere
               AND (ri_lUserID=$lUserID OR ri_lUserID=-1)
               $strWhereDate
               AND NOT re_bRetired;";
         $query = $this->db->query($sqlStr);
/*               
$zzzlPos = strrpos(__FILE__, '\\'); $zzzlLen=strlen(__FILE__);
$zzzstrFile=substr(__FILE__, strrpos(__FILE__, '\\',-(($zzzlLen-$zzzlPos)+1)));
echoT('<font class="debug">'.$zzzstrFile.' Line: <b>'.__LINE__.":</b><br><b>\$sqlStr=</b><br>".nl2br(htmlspecialchars($sqlStr))."<br></font>\n");
$zzzlPos = strrpos(__FILE__, '\\'); $zzzlLen=strlen(__FILE__); echo('<font class="debug">'.substr(__FILE__, strrpos(__FILE__, '\\',-(($zzzlLen-$zzzlPos)+1))) .': '.__LINE__
.":\$numRows = ".$query->num_rows()." <br><br></font>\n");
*/               
         
         $lNumRems += $query->num_rows();               
      }
      return($lNumRems);
   }

   public function loadReminders(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gdteNow, $glUserID;

      $sqlWhere = '';

      $this->innerViaRemType($this->enumRemType, $strInner, $strSelectExtra, $sqlWhere);

      $this->reminders = array();
      $this->lNumReminders = 0;
      $strDteNow     = strPrepDate($gdteNow);
      $strInnerOrder = '';

      $lPreviewDays = $this->config->item('dl_reminderPreviewDays');

      switch ($this->enumLookupType){
         case 'ViaRID':
            if (is_null($this->lRID) || is_null($this->enumRemType)){
               screamForHelp('Class not initializaed: $this->lRID / $this->enumRemType<br>error on <b>line:</b> '.__LINE__.'<br><b>file: </b>'.__FILE__.'<br><b>function: </b>'.__FUNCTION__);
            }
            $sqlWhere .= "AND re_lKeyID=$this->lRID ";
            break;
         case 'ViaEnumRemTypeFID':
            $sqlWhere .= "AND re_lForeignID=$this->lFID AND re_enumSource=".strPrepStr($this->enumRemType).' ';
            break;
         case 'CurrentViaEnumRemTypeUserID':
            $sqlWhere .= "AND (ri_lUserID IN (-1, $glUserID)) AND re_enumSource=".strPrepStr($this->enumRemType).' ';
            break;
            case 'CurrentViaEnumRemTypeFID':
            $sqlWhere .= $this->strCurrentFutureWhere()."
                         AND re_lForeignID=$this->lFID
                         AND re_enumSource=".strPrepStr($this->enumRemType).' ';
            break;

         default:
            screamForHelp($this->enumLookupType.': Unknown Reminder lookup type<br>error on <b>line:</b> '.__LINE__.'<br><b>file: </b>'.__FILE__.'<br><b>function: </b>'.__FUNCTION__);
      }

      if ($this->enumSort      == 'currentFirst' ||
         $this->enumLookupType == 'CurrentViaEnumRemTypeFID'){
         $strInnerOrder .=
                  ' INNER JOIN ngo_reminders_dates ON rd_lRemID=re_lKeyID ';
      }

      if ($this->enumLookupType=='CurrentViaEnumRemTypeUserID'){
         $strInnerOrder .= ' INNER JOIN ngo_reminders_inform ON rd_lRemID=re_lKeyID ';
      }

      switch ($this->enumSort){
         case 'currentFirst':
            $strOrder = " ((rd_dteDisplayDate <= $strDteNow) AND (rd_dteEndDisplayDate >= $strDteNow)) DESC,
                          rd_dteDisplayDate DESC, re_lKeyID ";
            break;
         case 'keyID':
         default:
            $strOrder = ' re_lKeyID ';
            break;
      }

      $sqlStr =
        "SELECT DISTINCT
            re_lKeyID, re_enumSource, re_lForeignID, re_strTitle,
            re_strReminderNote, re_lOriginID, re_lLastUpdateID,
            UNIX_TIMESTAMP(re_dteOrigin) AS dteOrigin,
            UNIX_TIMESTAMP(re_dteLastUpdate) AS dteLastUpdate
            $strSelectExtra

         FROM ngo_reminders
            $strInner
            $strInnerOrder
         WHERE NOT re_bRetired $sqlWhere
         ORDER BY $strOrder;";
       
/*
if ($this->enumRemType=='gift'){

$zzzlPos = strrpos(__FILE__, '\\'); $zzzlLen=strlen(__FILE__); echo('<font class="debug">'.substr(__FILE__, strrpos(__FILE__, '\\',-(($zzzlLen-$zzzlPos)+1))) .': '.__LINE__
.":\$strInner = $strInner <br></font>\n");
$zzzlPos = strrpos(__FILE__, '\\'); $zzzlLen=strlen(__FILE__); echo('<font class="debug">'.substr(__FILE__, strrpos(__FILE__, '\\',-(($zzzlLen-$zzzlPos)+1))) .': '.__LINE__
.":\$strInnerOrder = $strInnerOrder <br></font>\n");


$zzzlPos = strrpos(__FILE__, '\\'); $zzzlLen=strlen(__FILE__); echo('<font class="debug">'.substr(__FILE__, strrpos(__FILE__, '\\',-(($zzzlLen-$zzzlPos)+1))) .': '.__LINE__
.":\$this->enumLookupType = ".$this->enumLookupType." <br></font>\n");

$zzzlPos = strrpos(__FILE__, '\\'); $zzzlLen=strlen(__FILE__);
$zzzstrFile=substr(__FILE__, strrpos(__FILE__, '\\',-(($zzzlLen-$zzzlPos)+1)));
echoT('<font class="debug">'.$zzzstrFile.' Line: <b>'.__LINE__.":</b><br><b>\$sqlStr=</b><br>".nl2br(htmlspecialchars($sqlStr))."<br><br></font>\n");
}
*/
      $query = $this->db->query($sqlStr);
      $this->lNumReminders = $numRows = $query->num_rows();
      if ($numRows==0) {
         $this->reminders[0] = new stdClass;
         $this->reminders[0]->lKeyID          =
         $this->reminders[0]->enumSource      =
         $this->reminders[0]->lForeignID      =
         $this->reminders[0]->strFIDName      =
         $this->reminders[0]->strTitle        =
         $this->reminders[0]->strReminderNote =
         $this->reminders[0]->lOriginID       =
         $this->reminders[0]->lLastUpdateID   =
         $this->reminders[0]->dteOrigin       =
         $this->reminders[0]->dteLastUpdate   =
         $this->reminders[0]->dates           =
         $this->reminders[0]->informList      =
         $this->reminders[0]->followUpNotes   = null;
      }else {
         $idx = 0;
          foreach ($query->result() as $row)   {
            $this->reminders[$idx] = new stdClass;
            $this->reminders[$idx]->lKeyID          = $lRemID = $row->re_lKeyID;
            $this->reminders[$idx]->enumSource      = $row->re_enumSource;
            $this->reminders[$idx]->lForeignID      = $row->re_lForeignID;
            $this->reminders[$idx]->strFIDName      = $row->strFIDName;
            $this->reminders[$idx]->strTitle        = $row->re_strTitle;
            $this->reminders[$idx]->strReminderNote = $row->re_strReminderNote;
            $this->reminders[$idx]->lOriginID       = $row->re_lOriginID;
            $this->reminders[$idx]->lLastUpdateID   = $row->re_lLastUpdateID;
            $this->reminders[$idx]->dteOrigin       = $row->dteOrigin;
            $this->reminders[$idx]->dteLastUpdate   = $row->dteLastUpdate;

            $this->reminders[$idx]->dates           = array();
            $this->loadDatesViaRemID($lRemID, $this->reminders[$idx]->dates, $this->reminders[$idx]->lNumDates);

            $this->reminders[$idx]->followUpNotes   = array();
            $this->loadFollupUpsViaRemID($lRemID, $this->reminders[$idx]->followUpNotes, $this->reminders[$idx]->lNumFollowUps);
            ++$idx;
         }
      }
   }

   public function strHTMLOneLineLink($clsSingleRem){
   /*---------------------------------------------------------------------
      sample call:
      $clsRem->loadReminders();

      if ($clsRem->lNumReminders > 0){
         foreach ($clsRem->reminders as $clsSingleRem){
            $strRemLink = $clsRem->strHTMLOneLineLink($clsSingleRem);
         }
      }
   ---------------------------------------------------------------------*/
      global $genumDateFormat;

      $enumRemType = $clsSingleRem->enumSource;
      $lFID        = $clsSingleRem->lForeignID;
      switch ($enumRemType){
         case CENUM_CONTEXT_PEOPLE:
            $people = new mpeople;
            $people->lPeopleID = $lFID;
            $people->peopleInfoLight();
            $strRemLink = 'people reminder for '.$people->strSafeName
                         .strLinkView_PeopleRecord($lFID, 'View people record', true);
            break;

         case CENUM_CONTEXT_BIZ:
            $clsBiz = new mbiz;
            $clsBiz->lBID = $lFID;
            $clsBiz->bizInfoLight();
            $strRemLink = 'business reminder for '.$clsBiz->strSafeName
                         .strLinkView_BizRecord($lFID, 'View business record', true);
            break;

         case CENUM_CONTEXT_CLIENT:
            $clsClient = new mclients;
            $clsClient->loadClientsViaClientID($lFID);
            $strRemLink = 'client reminder for '.$clsClient->clients[0]->strSafeName.' '
                         .strLinkView_ClientRecord($lFID, 'View client record', true);
            break;

         case CENUM_CONTEXT_GIFT:
            $clsGifts = new mdonations;
            $clsGifts->loadGiftViaGID($lFID);
            $gift = $clsGifts->gifts[0];
            $strRemLink = 'gift reminder for '
                         .$gift->strACOCurSymbol
                         .number_format($gift->gi_curAmnt, 2).' '
                         .$gift->strSafeName.' of '
                         .date($genumDateFormat, $gift->gi_dteDonation).' '
                         .strLinkView_GiftsRecord($lFID, 'View gift record', true);
            break;

         case CENUM_CONTEXT_USER:
            $clsUser = new muser_accts;
            $clsUser->loadSingleUserRecord($lFID);
            $user = &$clsUser->userRec[0];
            $strRemLink = 'user reminder for '
                         .$user->strSafeName.' '
                         .strLinkView_User($lFID, 'View user record', true);
            break;

         case CENUM_CONTEXT_SPONSORSHIP:
            $cSpon = new msponsorship;
            $cSpon->sponsorInfoViaID($lFID);
            $strRemLink = 'sponsorship reminder for sponsor '
                         .$cSpon->sponInfo[0]->strSponSafeNameFL.' '
                         .strLinkView_Sponsorship($lFID, 'View sponsorship record', true);

            break;

         case CENUM_CONTEXT_LOCATION:
         case CENUM_CONTEXT_VOLUNTEER:
         default:
            screamForHelp($enumRemType.': Switch type not implemented</b><br>error on <b>line:</b> '.__LINE__.'<br><b>file:</b> '.__FILE__.'<br><b>function:</b> '.__FUNCTION__);
            break;
      }
      return($strRemLink);
   }

   public function informListViaRemID($lRemID, &$lUserIDs){
      $lUserIDs = array();
      $sqlStr =
           "SELECT DISTINCT ri_lUserID
            FROM ngo_reminders_inform
               INNER JOIN ngo_reminders_dates ON rd_lKeyID=ri_lRemDateID
            WHERE rd_lRemID=$lRemID
            ORDER BY ri_lUserID;";
      $query = $this->db->query($sqlStr);
      if ($query->num_rows() > 0)      {
         foreach ($query->result() as $row){
            $lUserIDs[] = $row->ri_lUserID;
         }
      }
   }

   public function loadInformListViaRemID($lRemDateID, &$informList, &$lNumToInform){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT
            ri_lKeyID, ri_lRemDateID, ri_lUserID,
            ri_bViewed, ri_bHidden,
            first_name, last_name
         FROM ngo_reminders_inform
            LEFT JOIN users ON ri_lUserID=id
         WHERE ri_lRemDateID=$lRemDateID
         ORDER BY last_name, first_name, ri_lUserID, ri_lKeyID;";

      $query = $this->db->query($sqlStr);
      
         $lNumToInform = $numRows = $query->num_rows();
         for ($idx=0; $idx<$numRows; ++$idx) {
            $row = $query->result[$idx];
            $informList[$idx] = new stdClass;
            $informList[$idx]->lKeyID       = $row['ri_lKeyID'];
            $informList[$idx]->lRemDateID   = $row['ri_lRemDateID'];
            $informList[$idx]->lUserID      = $row['ri_lUserID'];
            $informList[$idx]->strFirstName = $row['first_name'];
            $informList[$idx]->strLastName  = $row['last_name'];
            $informList[$idx]->strSafeName  = htmlspecialchars($row['first_name'].' '.$row['last_name']);
            $informList[$idx]->bViewed      = $row['ri_bViewed'];
            $informList[$idx]->bHidden      = $row['ri_bHidden'];
         }
      
   }

   public function loadDatesViaRemID($lRemID, &$dates, &$lNumDates){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT
            rd_lKeyID, rd_lRemID,
            UNIX_TIMESTAMP(rd_dteDisplayDate) AS dteDisplayStart,
            UNIX_TIMESTAMP(rd_dteEndDisplayDate) AS dteDisplayEnd
         FROM ngo_reminders_dates
         WHERE rd_lRemID=$lRemID
         ORDER BY rd_dteDisplayDate, rd_dteEndDisplayDate, rd_lKeyID;";

      $query = $this->db->query($sqlStr);
     
         $lNumDates = $numRows = $query->num_rows();


  
   foreach ($query->result() as $row){
         $idx=0;
            $dates[$idx] = new stdClass;
            $dates[$idx]->lKeyID          = $lRemDateID = $row->rd_lKeyID;
            $dates[$idx]->lRemID          = $row->rd_lRemID;
            $dates[$idx]->dteDisplayStart = $row->dteDisplayStart;
            $dates[$idx]->dteDisplayEnd   = $row->dteDisplayEnd;
            $dates[$idx]->strdteDisplayStart   = date('m/d/Y',$row->dteDisplayStart);
            $dates[$idx]->strdteDisplayEnd     = date('m/d/Y',$row->dteDisplayEnd);
            $dates[$idx]->informList      = array();
            $this->loadInformListViaRemID($lRemDateID, $dates[$idx]->informList, $dates[$idx]->lNumToInform);


            ++$idx;



   }



      
   }

   public function loadFollupUpsViaRemID($lRemID, &$followUpNotes, &$lNumFollowUps){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "SELECT
            rfu_lKeyID, rfu_lRemID, rfu_lUserID, rfu_strFollowUpNote,
            UNIX_TIMESTAMP(rfu_dteOfNote) AS dteOfNote,
            first_name, last_name
         FROM ngo_reminders_followup
            INNER JOIN users ON rfu_lUserID=id
         WHERE rfu_lRemID=$lRemID
         ORDER BY rfu_dteOfNote, rfu_lKeyID;";

     $query = $this->db->query($sqlStr);

         $lNumFollowUps = $numRows = $query->num_rows();
         for ($idx=0; $idx<$numRows; ++$idx) {
            $row2 =$query->result(); 
            $row = $row2[$idx];
            $followUpNotes[$idx] = new stdClass;
            $followUpNotes[$idx]->lKeyID          = $row->rfu_lKeyID;
            $followUpNotes[$idx]->lRemID          = $row->rfu_lRemID;
            $followUpNotes[$idx]->lUserID         = $row->rfu_lUserID;
            $followUpNotes[$idx]->strFollowUpNote = $row->rfu_strFollowUpNote;
            $followUpNotes[$idx]->dteOfNote       = $row->dteOfNote;
            $followUpNotes[$idx]->strFirstName    = $row->first_name;
            $followUpNotes[$idx]->strLastName     = $row->last_name;
            $followUpNotes[$idx]->strSafeName     = $row->first_name.' '.$row->last_name;
         }
      
   }

   public function innerViaRemType($enumRemType, &$strInner, &$strSelectExtra, &$sqlWhere){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strInner = $strSelectExtra = '';

      switch ($enumRemType){
         case CENUM_CONTEXT_PEOPLE:
            $strInner       = ' INNER JOIN ngo_donors ON re_lForeignID=pe_lKeyID ';
            $strSelectExtra = ', CONCAT(pe_strFName, \' \', pe_strLName) AS strFIDName ';
            $sqlWhere       = ' AND NOT pe_bRetired ';
            break;

         case CENUM_CONTEXT_BIZ:
            $strInner       = ' INNER JOIN ngo_donors ON re_lForeignID=pe_lKeyID ';
            $strSelectExtra = ', pe_strLName AS strFIDName ';
            $sqlWhere       = ' AND NOT pe_bRetired ';
            break;

         case CENUM_CONTEXT_GIFT:
            $strInner       = ' INNER JOIN ngo_gifts        ON re_lForeignID=gi_lKeyID
                                INNER JOIN ngo_donors ON gi_lForeignID=pe_lKeyID ';
            $strSelectExtra = ', pe_bBiz, pe_strFName, pe_strLName AS strFIDName ';
            $sqlWhere       = ' AND NOT pe_bRetired AND NOT gi_bRetired ';
            break;

         case CENUM_CONTEXT_CLIENT:
            $strInner       = ' INNER JOIN ngo_client_records ON re_lForeignID=cr_lKeyID ';
            $strSelectExtra = ', CONCAT(cr_strFName, \' \', cr_strLName) AS strFIDName ';
            $sqlWhere       = ' AND NOT cr_bRetired ';
            break;

         case CENUM_CONTEXT_USER:
            $strInner       = ' INNER JOIN users ON re_lForeignID=id ';
            $strSelectExtra = ', CONCAT(first_name, \' \', last_name) AS strFIDName ';
            $sqlWhere       = ' ';
            break;

         case CENUM_CONTEXT_SPONSORSHIP:
            $strInner       = ' INNER JOIN ngo_sponsor      ON re_lForeignID=sp_lKeyID
                                INNER JOIN ngo_donors ON sp_lForeignID=pe_lKeyID ';
            $strSelectExtra = ', pe_bBiz, pe_strFName, pe_strLName AS strFIDName ';
            $sqlWhere       = ' AND NOT pe_bRetired AND NOT sp_bRetired ';
            break;

         case CENUM_CONTEXT_LOCATION:
            $strInner       = ' INNER JOIN ngo_client_location ON re_lForeignID=cl_lKeyID ';
            $strSelectExtra = ', cl_strLocation AS strFIDName ';
            $sqlWhere       = ' AND NOT cl_bRetired ';
            break;

         case CENUM_CONTEXT_VOLUNTEER:
            $strInner       = ' INNER JOIN ngo_donors ON re_lForeignID=pe_lKeyID ';
            $strSelectExtra = ', CONCAT(pe_strFName, \' \', pe_strLName) AS strFIDName ';
            $sqlWhere       = ' AND NOT pe_bRetired  ';
            break;

         case CENUM_CONTEXT_GENERIC:
            break;

         default:
            screamForHelp($enumRemType.': Switch type not implemented</b><br>error on <b>line:</b> '.__LINE__.'<br><b>file:</b> '.__FILE__.'<br><b>function:</b> '.__FUNCTION__);
            break;

      }
   }

   public function lInsertReminderBase(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $glUserID = USERID;

      $sqlStr =
        'INSERT INTO ngo_reminders
         SET '.$this->strSQLCommonRemBase().',
            re_enumSource = '.strPrepStr($this->reminders[0]->enumSource).',
            re_lForeignID = '.$this->reminders[0]->lForeignID.",
            re_lOriginID  = $glUserID,
            re_dteOrigin  = NOW(),
            re_bRetired   = 0;";
      $this->db->query($sqlStr);
      return($this->reminders[0]->lKeyID = $this->db->insert_id());

      
   }

   private function strSQLCommonRemBase(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $glUserID = USERID;
      return('
          re_strTitle        = '.strPrepStr($this->reminders[0]->strTitle).',
          re_strReminderNote = '.strPrepStr($this->reminders[0]->strReminderNote).",
          re_lLastUpdateID   = $glUserID ");
   }

   public function lInsertReminderDate($lRemID, $dteStart, $dteEnd){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "INSERT INTO ngo_reminders_dates
         SET
            rd_lRemID            = $lRemID,
            rd_dteDisplayDate    = ".strPrepDate($dteStart).',
            rd_dteEndDisplayDate = '.strPrepDate($dteEnd).';';


      $this->db->query($sqlStr);
      return($this->db->insert_id());

      
   }

   public function lInsertReminderUser($lRemDateID, $lUserID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
        "INSERT INTO ngo_reminders_inform
         SET
            ri_lRemDateID = $lRemDateID,
            ri_lUserID    = $lUserID,
            ri_bViewed    = 0,
           	ri_bHidden    = 0;";
     $this->db->query($sqlStr);
      return($this->db->insert_id());
      
   }

   public function bOKToView($clsSingleRem, $lUserID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if (isset($clsSingleRem->dates)){
         foreach($clsSingleRem->dates as $clsRemDate){
            foreach($clsRemDate->informList as $clsUserOK){
               $lUserID = $clsUserOK->lUserID;
               if (($lUserID == -1) || ($lUserID == $lUserID)) return(true);
            }
         }
      }
      return(false);
   }

   public function lNumPast($clsSingleRem, $dteCheck, &$lIdxLastPast){
   //---------------------------------------------------------------------
   // number of reminder dates prior to $dteCheck
   //---------------------------------------------------------------------
      return($this->lNumPastFuture($clsSingleRem, $dteCheck, true, $lIdxLastPast));
   }

   public function lNumFuture($clsSingleRem, $dteCheck, &$lIdxFirstFuture){
   //---------------------------------------------------------------------
   // number of reminder dates after to $dteCheck
   //---------------------------------------------------------------------
      return($this->lNumPastFuture($clsSingleRem, $dteCheck, false, $lIdxFirstFuture));
   }

   private function lNumPastFuture($clsSingleRem, $dteCheck, $bPast, &$lIdxOfInterest){
   //---------------------------------------------------------------------
   // number of reminder dates befor/after to $dteCheck
   //---------------------------------------------------------------------
      $lCount = 0;
      $lIdx   = 0;
      $bFirstFuture = true;
      foreach($clsSingleRem->dates as $clsRemDate){
         if ($bPast){
            if (($clsRemDate->dteDisplayStart < $dteCheck) &&
                ($clsRemDate->dteDisplayEnd < $dteCheck)){
               ++$lCount;
               $lIdxOfInterest = $lIdx;
            }
         }else {
            if ($clsRemDate->dteDisplayStart > $dteCheck){
               ++$lCount;
               if ($bFirstFuture){
                  $lIdxOfInterest = $lIdx;
                  $bFirstFuture   = false;
               }
            }
         }
         ++$lIdx;
      }
      return($lCount);
   }

   public function lCurrentRemIdx($clsSingleRem, $dteCheck, $bUsePreview=true){
   //---------------------------------------------------------------------
   // index for the first reminder that is current
   //---------------------------------------------------------------------
      if ($bUsePreview){
         $lPreviewDays = $this->config->item('dl_reminderPreviewDays');
         $lDaysOfFuturePast = $lPreviewDays*24*60*60;
      }else {
         $lDaysOfFuturePast = 0;
      }

      $lIdx = 0;
      foreach($clsSingleRem->dates as $clsRemDate){
         $dteStart = $clsRemDate->dteDisplayStart - $lDaysOfFuturePast;
         if (($dteStart                  <= $dteCheck) &&
             ($clsRemDate->dteDisplayEnd >= $dteCheck)){
            return($lIdx);
         }
         ++$lIdx;
      }
      return(null);
   }

   public function addFollowup($lRemID, $strFollowup){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $glUserID = USERID;

      $sqlStr =
        "INSERT INTO ngo_reminders_followup
         SET
            rfu_lRemID          = $lRemID,
            rfu_lUserID         = $glUserID,
            rfu_strFollowUpNote = ".strPrepStr($strFollowup).',
            rfu_dteOfNote=NOW();';

     $result = $this->db->query($sqlStr);
      return true;
      
   }

   public function removeReminder($lRemID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $glUserID = USERID;

      $sqlStr =
          "UPDATE ngo_reminders
          SET
             re_bRetired      = 1,
             re_lLastUpdateID = $glUserID
          WHERE re_lKeyID=$lRemID;";
      $result = $this->db->query($sqlStr);
      
   }

   public function loadEnumTypeList($enumRemType){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->enumRemTypeList = array();

      if ($enumRemType==CENUM_CONTEXT_USER){
         $this->enumRemTypeList[0] = CENUM_CONTEXT_PEOPLE;
         $this->enumRemTypeList[1] = CENUM_CONTEXT_BIZ;
         $this->enumRemTypeList[2] = CENUM_CONTEXT_SPONSORSHIP;
         $this->enumRemTypeList[3] = CENUM_CONTEXT_CLIENT;
         $this->enumRemTypeList[4] = CENUM_CONTEXT_LOCATION;
         $this->enumRemTypeList[5] = CENUM_CONTEXT_GIFT;
         $this->enumRemTypeList[6] = CENUM_CONTEXT_VOLUNTEER;
         $this->enumRemTypeList[7] = CENUM_CONTEXT_USER;
         $this->enumRemTypeList[8] = CENUM_CONTEXT_GENERIC;
      }else {
         $this->enumRemTypeList[0] = $enumRemType;
      }
   }


}




?>