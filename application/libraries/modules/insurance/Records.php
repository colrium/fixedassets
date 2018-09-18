<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*---------------------------------------------------------------------
FORT TECHNOLOGIES SYSTEM
Developed By Mutugi Riungu 2016
NO ALTERATIONS OR CODE REUSE IS AUTHORIZED     
---------------------------------------------------------------------*/
class Records{

	public function __construct(){
	    isloggedin(TRUE);
	      $this->load->model('mstart','clsStrt');
	      $this->load->helper(INSURANCE_PREFIX.'formatdata');
	   
	    $displayData = array();   
	}


  public function __get($var){
    return get_instance()->$var;
  }


 public function view($details=array()){
 	$rectype="";
 	$recId="";
    if ($rectype!="" && $recId!="") {
      $table = entityTable($rectype);
      $pkColmn = entityPK($rectype);
      $maintemplate = entityviewpage($rectype);
      $details = $this->clsData->loadrecordfromtable($table, $pkColmn, $recId);

      $displayData['title']        = 'view '.humanize($rectype);
      $displayData['page']        = $rectype.'view';
      $displayData['recId']        = $recId;
      $displayData['details']      =  $details;
      $displayData['pageTitle']    = CENUM_MODULES_CHIP.' '.CENUM_CHIP_POINTER.' '.INSURANCE_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('View '.humanize($rectype));
      $displayData['nav'] = $this->mnav_brain_jar->navData('insurance');
      $displayData['mainTemplate'] = $maintemplate;
      renderpage($displayData);
      
    }
    else{
      showsystemerror(3);
    }
    
}

















}
