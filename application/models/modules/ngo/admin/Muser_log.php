<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//---------------------------------------------------------------------
// copyright (c) 2011-2013
// Nairobi Kenya 78759
//
// author: Mutugi Riungu
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
/*---------------------------------------------------------------------
   $this->load->model('admin/muser_log', 'clsUserLog');
---------------------------------------------------------------------*/

class Muser_log extends CI_Model{
   public
      $el_lKeyID,
      $el_lUserID,
      $el_enumApp,
      $el_dteLogDate,
      $el_bLoginSuccessful,
      $el_str_Remote_Addr,
      $el_str_Remote_Host,
      $el_str_Remote_Port;

   function __construct(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
		parent::__construct();

      $this->el_lKeyID           =
      $this->el_lUserID          =
      $this->el_enumApp          =
      $this->el_dteLogDate       =
      $this->el_bLoginSuccessful =
      $this->el_str_Remote_Addr  =
      $this->el_str_Remote_Host  =
      $this->el_str_Remote_Port  = null;
   }

   function lAddLogEntry($bSuccess, $strUserName){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bSuccess){
         if (is_null($this->el_lUserID)) screamForHelp('UNITIALIZED CLASS</b><br>error on <b>line:</b> '.__LINE__.'<br><b>file:</b> '.__FILE__.'<br><b>function:</b> '.__FUNCTION__);
      }

      $sqlStr =
         'INSERT INTO ngo_admin_usage_log
          SET
               el_lUserID         = '.strDBValueConvert_INT($this->el_lUserID).',
               el_str_Remote_Addr = '.strPrepStr(@$_SERVER['REMOTE_ADDR']).',
               el_enumApp         = '.strPrepStr($this->el_enumApp).',
               el_strUserName     = '.strPrepStr($strUserName).',
               el_bLoginSuccessful= '.($bSuccess ? '1' : '0').',
               el_str_Remote_Host = '.strPrepStr(@$_SERVER['REMOTE_HOST']).',
               el_str_Remote_Port = '.strPrepStr(@$_SERVER['REMOTE_PORT']).';';
      $query = $this->db->query($sqlStr);
      return($this->db->insert_id());
   }


      /*----------------------------------------------------
                R E P O R T S
      ----------------------------------------------------*/
   function lNumRecsUsageViaUserReport(
                        &$sRpt,
                        $bUseLimits,     $lStartRec,    $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bUseLimits){
         $strLimit = " LIMIT $lStartRec, $lRecsPerPage ";
      }else {
         $strLimit = '';
      }

      $sqlStr =
           "SELECT id
            FROM users
            WHERE 1
            $strLimit;";
      $query = $this->db->query($sqlStr);
      return($query->num_rows());
   }   
      
   function lNumRecsLoginLogReport(
                        $sRpt,
                        $bUseLimits,     $lStartRec,    $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------   
      $lUserID = $sRpt->lUserID;
      if (is_null($lUserID)){
         $strWhere = ' 1 ';
      }else {
         $strWhere = " el_lUserID=$lUserID ";
      }
      if ($bUseLimits){
         $strLimit = " LIMIT $lStartRec, $lRecsPerPage ";
      }else {
         $strLimit = '';
      }

      $sqlStr =
           "SELECT `el_lKeyID`
            FROM ngo_admin_usage_log
            WHERE $strWhere
            $strLimit;";

      $query = $this->db->query($sqlStr);
      return($query->num_rows());
   }

   function strLoginLogUserReportExport(&$sRpt,   $reportID,
                                        $bReport, $lStartRec, $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bReport){
         return($this->strLoginUserReport($sRpt, $lStartRec, $lRecsPerPage));
      }else {
         return($this->strLoginUserExport($sRpt));
      }
   }
   
   function strLoginUserReport($sRpt, $lStartRec, $lRecsPerPage){
      global $genumDateFormat;
   
      $strLimit = " LIMIT $lStartRec, $lRecsPerPage ";

      $sqlStr =
        "SELECT
            COUNT(el_lKeyID) AS lNumLogins, 
            MAX(UNIX_TIMESTAMP(el_dteLogDate)) AS dteMostRecent,
            id, 
            username, first_name, last_name,
            active
         FROM users
            LEFT JOIN ngo_admin_usage_log   ON el_lUserID=id
         WHERE 1
         GROUP BY id
         ORDER BY last_name, first_name, username, id
         $strLimit;";

      $strOut = 
         '<table class="enpRptC">
            <tr>
               <td class="enpRptLabel">
                  User ID
               </td>
               <td class="enpRptLabel">
                  User
               </td>
               <td class="enpRptLabel">
                  User Name
               </td>
               <td class="enpRptLabel">
                  Login Count
               </td>               
               <td class="enpRptLabel">
                  Most Recent Login
               </td>               
            </tr>';
            
      $query = $this->db->query($sqlStr);
      foreach ($query->result() as $row){
         $lUserID   = $row->id;
         $bInactive = $row->active;
         if ($bInactive){
            $strStyle = 'color: #999;';
         }else {
            $strStyle = '';
         }
         
         $lLogInCnt = $row->lNumLogins;
         if ($lLogInCnt==0){
            $strLogInCnt = ' - ';
            $strDateLastLogin = '<small>(none)</small>';
            $strLinkDetails   = '';
         }else {
            $strLogInCnt      = number_format($lLogInCnt);
            $strDateLastLogin = date($genumDateFormat.' H:i:s', $row->dteMostRecent); 
            $strLinkDetails   = '&nbsp;'.strLinkView_UserLogins($lUserID, 'View login details', true);  
         }
       
         $strOut .= '
            <tr class="makeStripe">
               <td class="enpRpt" style="'.$strStyle.'">'
                  .strLinkView_User($lUserID, 'View User Record', true).'&nbsp;'
                  .str_pad($lUserID, 5, '0', STR_PAD_LEFT).'
               </td>
               <td class="enpRpt" style="'.$strStyle.'">'
                  .htmlspecialchars($row->username).'
               </td>
               <td class="enpRpt" style="'.$strStyle.'">'
                  .htmlspecialchars($row->first_name.' '.$row->last_name).'
               </td>
               <td class="enpRpt" style="'.$strStyle.' text-align: center;">'
                  .$strLogInCnt.$strLinkDetails.'
               </td>            
               <td class="enpRpt" style="'.$strStyle.'">'
                  .$strDateLastLogin.'
               </td>               
            </tr>';
      }            
            
      $strOut .= '</table><br>';
      return($strOut);            
   }   
   
   function strLoginLogReportExport(&$sRpt,   $reportID,
                                      $bReport, $lStartRec, $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bReport){
         return($this->strLoginLogReport($sRpt, $lStartRec, $lRecsPerPage));
      }else {
         return($this->strLoginLogExport($sRpt));
      }
   }

   function strLoginLogReport(&$sRpt, $lStartRec, $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $genumDateFormat;
      $strLimit = " LIMIT $lStartRec, $lRecsPerPage ";
      
      $lRptUserID = $sRpt->lUserID;
      if ($lRptUserID <= 0){
         $strUserWhere = '';
      }else {
         $strUserWhere = " AND el_lUserID=$lRptUserID ";
      }

      $sqlStr =
        "SELECT
            el_lKeyID, id, el_enumApp,
            UNIX_TIMESTAMP(el_dteLogDate) AS dteLog,
            el_strUserName, el_bLoginSuccessful, el_str_Remote_Addr, el_str_Remote_Host, el_str_Remote_Port,
            username, first_name, last_name
         FROM ngo_admin_usage_log
            LEFT JOIN users   ON el_lUserID=id
         WHERE 1 $strUserWhere
         ORDER BY el_dteLogDate DESC, el_lKeyID DESC
         $strLimit;";

      $query = $this->db->query($sqlStr);
      $strOut = 
         '<table class="enpRptC">
            <tr>
               <td class="enpRptLabel">
                  User
               </td>
               <td class="enpRptLabel">
                  User Name
               </td>
               <td class="enpRptLabel">
                  Date
               </td>
               <td class="enpRptLabel">
                  Remote Address
               </td>
               <td class="enpRptLabel">
                  Remote Host
               </td>
               <td class="enpRptLabel">
                  Remote Port
               </td>               
            </tr>';
            
      foreach ($query->result() as $row){
         $bFailed = !$row->el_bLoginSuccessful || is_null($row->id);
         if ($bFailed){
            $strColor = 'color: #bf0000;';
            $strFailed = ' (login failed)';
         }else {
            $strColor = 'color: #000;';
            $strFailed = '';
         }
         $lUserID = $row->id;
         if (is_null($lUserID)){
            $strUserLink = '';
         }else {
            $strUserLink = strLinkView_User($lUserID, 'View User Record', true).'&nbsp;';
         }
         $strOut .= '
               <tr class="makeStripe">
                  <td class="enpRpt" style="'.$strColor.'">'
                     .$strUserLink
                     .trim(htmlspecialchars($row->first_name.' '.$row->last_name).$strFailed).'
                  </td>
                  <td class="enpRpt" style="'.$strColor.'">'
                     .htmlspecialchars($row->username).'
                  </td>
                  <td class="enpRpt" style="'.$strColor.'">'
                     .date($genumDateFormat.' H:i:s', $row->dteLog).'
                  </td>
                  <td class="enpRpt" style="'.$strColor.' text-align: center;">'
                     .$row->el_str_Remote_Addr.'
                  </td>
                  <td class="enpRpt" style="'.$strColor.' text-align: center;">'
                     .$row->el_str_Remote_Host.'
                  </td>
                  <td class="enpRpt" style="'.$strColor.' text-align: center;">'
                     .$row->el_str_Remote_Port.'
                  </td>
               </tr>';
      }        

      $strOut .= '</table><br>';
      return($strOut);
   }










}



?>