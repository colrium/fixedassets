<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM!
//
// Collins Riungu
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
---------------------------------------------------------------------
      $this->load->model('reports/mreports', 'clsReports');
---------------------------------------------------------------------*/

//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class Mreports extends CI_Model{
   public $sRpt;


   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
   }

   function createReportSessionEntry($reportAttributes){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------   
      $reportID = random_string('unique');
      $_SESSION[CS_NAMESPACE.'Reports'][$reportID] = new stdClass;
      $this->sRpt = &$_SESSION[CS_NAMESPACE.'Reports'][$reportID];
      $this->sRpt->reportID = $reportID;
      
      foreach ($reportAttributes as $strType=>$value){
         $this->sRpt->$strType = $value;
         $this->sRpt->strExportLabel = 'Export this report';
      }
   }

   function loadReportSessionEntry($reportID, &$sRpt){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------   
      $sRpt = clone $_SESSION[CS_NAMESPACE.'Reports'][$reportID];
   }
   
   
}