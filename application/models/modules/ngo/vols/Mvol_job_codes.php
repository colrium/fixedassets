<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM!
//
// copyright (c) 2015 by  Collins Riungu
// Nairobi Kenya
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
---------------------------------------------------------------------
      $this->load->model('vols/mvol_job_codes', 'cVJobCodes');
---------------------------------------------------------------------*/


class Mvol_job_codes extends CI_Model{

   function strVolJobCodes(
                 $sRpt,
                 $bReport,     $lStartRec,    $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $bAllJobCodes = $sRpt->lJobCodeID <= 0;

      $jCodes = array();
      $this->prepJobCodeArray($jCodes, $sRpt, $bAllJobCodes, $lNumJobCodes);
      if ($lNumJobCodes == 0){
         return('There are no job codes defined in your database.');
      }

         // load job code hours by shift
      $this->loadShiftJobCodesViaMonth($jCodes, $sRpt, $bAllJobCodes);

         // load unscheduled job code hours
      $this->loadUnJobCodesViaMonth($jCodes, $sRpt, $bAllJobCodes);

      return($this->strFormatJobCodeRpt($jCodes, $sRpt));
   }

   function prepJobCodeArray(&$jCodes, $sRpt, $bAllJobCodes, &$lNumJobCodes){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $masterCodes = array();
      $jcList = new mlist_generic;
      $jcList->enumListType = CENUM_LISTTYPE_VOLJOBCODES;
      if ($bAllJobCodes){
         $jcList->genericLoadList();
         $lNumJobCodes = count($jcList->listItems);
         if ($lNumJobCodes == 0) return;
         foreach ($jcList->listItems as $listItem){
            $masterCodes[$listItem->lKeyID] = new stdClass;
            $mc = &$masterCodes[$listItem->lKeyID];
            $mc->strJobCode = $listItem->strListItem;
            $mc->sngNumShiftHours = 0.0;
            $mc->sngNumUnHours = 0.0;
         }
         $masterCodes[-1] = new stdClass;
         $mc = &$masterCodes[-1];
         $mc->strJobCode = '(no job code assigned)';
         $mc->sngNumShiftHours = 0.0;
         $mc->sngNumUnHours = 0.0;
      }else {
         $lNumJobCodes = 1;
         $masterCodes[$sRpt->lJobCodeID] = new stdClass;
         $mc = &$masterCodes[$sRpt->lJobCodeID];
         $mc->strJobCode = $jcList->genericLoadListItem($sRpt->lJobCodeID);
         $mc->sngNumShiftHours = 0.0;
         $mc->sngNumUnHours = 0.0;
      }

      for ($idx=1; $idx<=12; ++$idx){
         $jCodes[$idx] = new stdClass;
         $jc = &$jCodes[$idx];
         $jc->lMonth = $idx;
         $jc->strMonth = strXlateMonth($idx);
         $jc->hours = arrayCopy($masterCodes);
      }
   }

   function loadShiftJobCodesViaMonth(&$jCodes, $sRpt, $bAllJobCodes){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bAllJobCodes){
         $strWhereJC = '';
      }else {
         $strWhereJC = ' AND vs_lJobCode='.$sRpt->lJobCodeID.' ';
      }

      $sqlStr =
        'SELECT vs_lJobCode, MONTH(ved_dteEvent) AS lMonth, SUM(vsa_dHoursWorked) AS sngNumHrs
         FROM ngo_vol_events_dates
            INNER JOIN ngo_vol_events_dates_shifts        ON vs_lEventDateID       = ved_lKeyID
            INNER JOIN ngo_vol_events_dates_shifts_assign ON vsa_lEventDateShiftID = vs_lKeyID
         WHERE NOT vs_bRetired AND NOT vsa_bRetired
            AND YEAR(ved_dteEvent)='.$sRpt->lYear.' '.$strWhereJC.'
         GROUP BY MONTH(ved_dteEvent), vs_lJobCode
         ORDER BY MONTH(ved_dteEvent), vs_lJobCode;';

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

      $idx = 0;
      if ($numRows > 0){
         foreach ($query->result() as $row){
            if (is_null($row->vs_lJobCode)){
               $lJobCode = -1;
            }else {
               $lJobCode = (int)$row->vs_lJobCode;
            }
            $jCodes[$row->lMonth]->hours[$lJobCode]->sngNumShiftHours = (float)$row->sngNumHrs;
         }
      }
   }

   function loadUnJobCodesViaMonth(&$jCodes, $sRpt, $bAllJobCodes){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      if ($bAllJobCodes){
         $strWhereJC = '';
      }else {
         $strWhereJC = ' AND vsa_lJobCode='.$sRpt->lJobCodeID.' ';
      }

      $sqlStr =
        'SELECT vsa_lJobCode, MONTH(vsa_dteActivityDate) AS lMonth, SUM(vsa_dHoursWorked) AS sngNumHrs
         FROM ngo_vol_events_dates_shifts_assign
         WHERE NOT vsa_bRetired
            AND YEAR(vsa_dteActivityDate)='.$sRpt->lYear.' '.$strWhereJC.'
         GROUP BY MONTH(vsa_dteActivityDate), vsa_lJobCode
         ORDER BY MONTH(vsa_dteActivityDate), vsa_lJobCode;';

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

      $idx = 0;
      if ($numRows > 0){
         foreach ($query->result() as $row){
            if (is_null($row->vsa_lJobCode)){
               $lJobCode = -1;
            }else {
               $lJobCode = (int)$row->vsa_lJobCode;
            }
            $jCodes[$row->lMonth]->hours[$lJobCode]->sngNumUnHours = (float)$row->sngNumHrs;
         }
      }
   }

   function strFormatJobCodeRpt($jCodes, $sRpt){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $lNumCodes = count($jCodes[1]->hours);
      $strOut =
         '<br>
          <table class="enpRptC">
             <tr>
                <td colspan="5" class="enpRptTitle">
                   Volunteer Job Codes for the Year '.$sRpt->lYear.'
                </td>
             </tr>';
      $strOut .= '
            <tr>
               <td class="enpRptLabel">
                  Month
               </td>
               <td class="enpRptLabel">
                  Job Code
               </td>
               <td class="enpRptLabel">
                  Hours (Shift)
               </td>
               <td class="enpRptLabel">
                  Hours (Unscheduled)
               </td>
               <td class="enpRptLabel">
                  Total
               </td>
            </tr>';

      $bEven = true;
      $sngTotTot = 0.0;
      for ($idx=1; $idx<=12; ++$idx){
         $sngTotMoShift = $sngTotMoUn = 0.0;
         if ($bEven){
            $strBG = 'background-color: #f6f6f6;';
         }else {
            $strBG = '';
         }
         $bEven = !$bEven;

         $jc = &$jCodes[$idx];
         $strOut .= '
             <tr>
               <td class="enpRpt" rowspan='.($lNumCodes+1).' style="width: 80pt; '.$strBG.'">
                  <b>'.strLinkView_VolsJobCodeViaMonth($sRpt->lYear, $idx, $sRpt->lJobCodeID, 'View monthly details', true).'&nbsp;'
                  .$jc->strMonth.'
               </td>';

         $bFirst = true;
         foreach ($jc->hours as $lJCID=>$hours){
            if (!$bFirst){
               $strOut .= '<tr class="makeStripe">'."\n";
               $bFirst = false;
            }
            $strOut .= '
                <td class="enpRpt" style="width: 160pt; '.$strBG.' ">'
                   .htmlspecialchars($hours->strJobCode).'
                </td>
                <td class="enpRpt" style="width: 50pt; text-align: right; padding-right: 10px; '.$strBG.' ">'
                   .number_format($hours->sngNumShiftHours, 2).'
                </td>
                <td class="enpRpt" style="width: 50pt; text-align: right; padding-right: 10px; '.$strBG.' ">'
                   .number_format($hours->sngNumUnHours, 2).'
                </td>
                <td class="enpRpt" style="width: 50pt; text-align: right; padding-right: 10px; '.$strBG.' ">'
                   .number_format($hours->sngNumShiftHours+$hours->sngNumUnHours, 2).'
                </td>
             </tr>';
             $sngTotMoShift += $hours->sngNumShiftHours;
             $sngTotMoUn    += $hours->sngNumUnHours;
         }

         $strOut .= '
            <tr>
               <td class="enpRpt" style=" '.$strBG.' ">
                  <b>Total:</b>
               </td>
               <td class="enpRpt" style="width: 50pt; text-align: right; padding-right: 10px; '.$strBG.' "><b>'
                  .number_format($sngTotMoShift, 2).'</b>
               </td>
               <td class="enpRpt" style="width: 50pt; text-align: right; padding-right: 10px; '.$strBG.' "><b>'
                  .number_format($sngTotMoUn, 2).'</b>
               </td>
               <td class="enpRpt" style="width: 50pt; text-align: right; padding-right: 10px; '.$strBG.' "><b>'
                  .number_format($sngTotMoShift + $sngTotMoUn, 2).'</b>
               </td>
               
            </tr>';
      }

      $strOut .= '</table>';
      return($strOut);
   }




   /* -----------------------------------------------------------
          M O N T H L Y   D E T A I L   R E P O R T
      ----------------------------------------------------------- */
   function strVolJobCodeMonthlyDetail(
                 $sRpt,
                 $bReport,     $lStartRec,    $lRecsPerPage){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $bAllJobCodes = $sRpt->lJobCodeID <= 0;
      $strOut = '<br>';
      $strMoYr = strXlateMonth($sRpt->lMonth).' '.$sRpt->lYear;
      
      $strOut .= $this->strShiftJobCodesDetailsViaMonth($strMoYr, $sRpt, $bAllJobCodes);
      $strOut .= $this->strUnJobCodesDetailsViaMonth($strMoYr, $sRpt, $bAllJobCodes);
      return($strOut);
   }      


   function strShiftJobCodesDetailsViaMonth($strMoYr, $sRpt, $bAllJobCodes){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $genumDateFormat;
      
      $strOut = '
            <table class="enpRptC" style="width: 600pt;">
                <tr>
                   <td colspan="6" class="enpRptTitle">
                      Job Code Details for Scheduled Shifts: '.$strMoYr.'
                   </td>
                </tr>
                <tr>
                   <td class="enpRptLabel">
                      Event
                   </td>
                   <td class="enpRptLabel">
                      Shift/Date
                   </td>
                   <td class="enpRptLabel">
                      Volunteer
                   </td>
                   <td class="enpRptLabel">
                      Job Code
                   </td>
                   <td class="enpRptLabel">
                      Hours
                   </td>
                </tr>
                ';
      if ($bAllJobCodes){
         $strWhereJC = '';
      }else {
         $strWhereJC = ' AND vs_lJobCode='.$sRpt->lJobCodeID.' ';
      }

      $sqlStr =
        'SELECT vs_lJobCode, ved_dteEvent, vsa_dHoursWorked, vsa_lVolID, vem_lKeyID, ved_lKeyID,
            jc.lgen_strListItem AS strJobCode,
            vem_strEventName, vs_strShiftName,
            pe_strFName, pe_strLName
         FROM ngo_vol_events_dates
            INNER JOIN ngo_vol_events_dates_shifts        ON vs_lEventDateID       = ved_lKeyID
            INNER JOIN ngo_vol_events_dates_shifts_assign ON vsa_lEventDateShiftID = vs_lKeyID
            INNER JOIN ngo_vol_events                     ON ved_lVolEventID       = vem_lKeyID
            INNER JOIN ngo_volunteers                     ON vol_lKeyID            = vsa_lVolID
            INNER JOIN ngo_donors                   ON vol_lPeopleID         = pe_lKeyID
            LEFT  JOIN ngo_lists_generic   AS jc          ON vs_lJobCode           = jc.lgen_lKeyID
         WHERE NOT vs_bRetired AND NOT vsa_bRetired
            AND YEAR (ved_dteEvent)='.$sRpt->lYear.'
            AND MONTH(ved_dteEvent)='.$sRpt->lMonth.'
            AND vsa_dHoursWorked > 0
            '.$strWhereJC.'
         ORDER BY vem_strEventName, strJobCode, ved_dteEvent, pe_strLName, pe_strFName, pe_lKeyID;';

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

      $idx = 0;
      $sngTotHrs = 0.0;
      if ($numRows > 0){
         foreach ($query->result() as $row){
            $dteEvent = dteMySQLDate2Unix($row->ved_dteEvent);
            $strJobCode = ($row->strJobCode.'' == '') ? '(not set)' : htmlspecialchars($row->strJobCode);
            $strOut .= '
                <tr class="makeStripe">
                   <td class="enpRpt" style="width: 150pt;">'
                      .strLinkView_VolEvent($row->vem_lKeyID, 'View event', true).'&nbsp;'
                      .htmlspecialchars($row->vem_strEventName).'
                   </td>
                   <td class="enpRpt" style="width: 130pt;">'
                      .strLinkView_VolEventDate($row->ved_lKeyID, 'View event date and shifts', true).'&nbsp;'
                      .htmlspecialchars($row->vs_strShiftName).'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                      .date($genumDateFormat, $dteEvent).'
                   </td>
                   <td class="enpRpt" style="width: 130pt;">'
                      .strLinkView_Volunteer($row->vsa_lVolID, 'Volunteer Record', true).'&nbsp;'
                      .htmlspecialchars($row->pe_strLName.', '.$row->pe_strFName).'
                   </td>
                   <td class="enpRpt" style="width: 100pt;">'
                      .$strJobCode.'
                   </td>
                   <td class="enpRpt" style="width: 35pt; padding-right: 10px; text-align: right;">'
                      .number_format($row->vsa_dHoursWorked, 2).'
                   </td>
                </tr>';
            $sngTotHrs += $row->vsa_dHoursWorked;
         }
      }
      
      $strOut .= '
          <tr>
             <td class="enpRpt" colspan="4"><b>
                Total:</b>
             </td>
             <td class="enpRpt" style="width: 35pt; padding-right: 10px; text-align: right;"><b>'
                .number_format($sngTotHrs, 2).'</b>
             </td>
          </tr>';
      
      $strOut .= '</table>'."\n";
      return($strOut);
   }

   function strUnJobCodesDetailsViaMonth($strMoYr, $sRpt, $bAllJobCodes){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $genumDateFormat;
      
      $strOut = '<br><br>
            <table class="enpRptC" style="width: 600pt;">
                <tr>
                   <td colspan="4" class="enpRptTitle">
                      Job Code Details for Unschedule Volunteers: '.$strMoYr.'
                   </td>
                </tr>
                <tr>
                   <td class="enpRptLabel">
                      Date
                   </td>
                   <td class="enpRptLabel">
                      Volunteer
                   </td>
                   <td class="enpRptLabel">
                      Job Code
                   </td>
                   <td class="enpRptLabel">
                      Hours
                   </td>
                </tr>
                ';
      if ($bAllJobCodes){
         $strWhereJC = '';
      }else {
         $strWhereJC = ' AND vsa_lJobCode='.$sRpt->lJobCodeID.' ';
      }
      $sqlStr =
        'SELECT vsa_lJobCode, vsa_dHoursWorked, vsa_lVolID,
            jc.lgen_strListItem AS strJobCode, vsa_dteActivityDate,
            pe_strFName, pe_strLName
         FROM ngo_vol_events_dates_shifts_assign 
            INNER JOIN ngo_volunteers                     ON vol_lKeyID            = vsa_lVolID
            INNER JOIN ngo_donors                   ON vol_lPeopleID         = pe_lKeyID
            LEFT  JOIN ngo_lists_generic   AS jc          ON vsa_lJobCode          = jc.lgen_lKeyID
         WHERE NOT vsa_bRetired
            AND YEAR (vsa_dteActivityDate)='.$sRpt->lYear.'
            AND MONTH(vsa_dteActivityDate)='.$sRpt->lMonth.'
            AND vsa_dHoursWorked > 0
            '.$strWhereJC.'
         ORDER BY strJobCode, vsa_dteActivityDate, pe_strLName, pe_strFName, pe_lKeyID;';

      $query = $this->db->query($sqlStr);
      $numRows = $query->num_rows();

      $idx = 0;
      $sngTotHrs = 0.0;
      if ($numRows > 0){
         foreach ($query->result() as $row){
            $dteActivity = dteMySQLDate2Unix($row->vsa_dteActivityDate);
            $strJobCode = ($row->strJobCode.'' == '') ? '(not set)' : htmlspecialchars($row->strJobCode);
            $strOut .= '
                <tr class="makeStripe">
                   <td class="enpRpt" style="width: 130pt;">'
                      .date($genumDateFormat, $dteActivity).'
                   </td>
                   <td class="enpRpt" style="width: 130pt;">'
                      .strLinkView_Volunteer($row->vsa_lVolID, 'Volunteer Record', true).'&nbsp;'
                      .htmlspecialchars($row->pe_strLName.', '.$row->pe_strFName).'
                   </td>
                   <td class="enpRpt" style="width: 100pt;">'
                      .$strJobCode.'
                   </td>
                   <td class="enpRpt" style="width: 35pt; padding-right: 10px; text-align: right;">'
                      .number_format($row->vsa_dHoursWorked, 2).'
                   </td>
                </tr>';
            $sngTotHrs += $row->vsa_dHoursWorked;
         }
      }
      
      $strOut .= '
          <tr>
             <td class="enpRpt" colspan="3"><b>
                Total:</b>
             </td>
             <td class="enpRpt" style="width: 35pt; padding-right: 10px; text-align: right;"><b>'
                .number_format($sngTotHrs, 2).'</b>
             </td>
          </tr>';
      
      $strOut .= '</table>'."\n";
      return($strOut);
   }   

}
