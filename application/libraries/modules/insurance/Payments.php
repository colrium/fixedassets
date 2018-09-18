<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*---------------------------------------------------------------------
FORT TECHNOLOGIES SYSTEM
Developed By Mutugi Riungu 2016
NO ALTERATIONS OR CODE REUSE IS AUTHORIZED     
---------------------------------------------------------------------*/
class Payments{

	public function __construct(){
	   isloggedin(TRUE);
	      $this->load->model('mstart','clsStrt');
	    
	    $displayData = array();   
	}


  public function __get($var){
    return get_instance()->$var;
  }


  public function addEditPayment($details = array()){
  	$table = 'insurance_payments';
	$pkColmn ='paymentId';
	$askingPageChip = ' ';
	$recId = '0';

	if (array_key_exists('recId', $details)) {
		$recId = $details['recId'];
	}
	if (array_key_exists('paymentAmount', $details)) {
		$displayData['paymentAmount'] = $details['paymentAmount'];
	}
	if (array_key_exists('paymentClient', $details)) {
		$displayData['paymentClient'] = $details['paymentClient'];
	}
	if (array_key_exists('paymentCover', $details)) {
		$displayData['paymentCover'] = $details['paymentCover'];
	}
	if (array_key_exists('paymentMode', $details)) {
		$displayData['paymentMode'] = $details['paymentMode'];
	}
	if (array_key_exists('paymentDate', $details)) {
		$displayData['paymentDate'] = $details['paymentDate'];
	}
	if (array_key_exists('askingPageChip', $details)) {
		$askingPageChip = $details['askingPageChip'];
	}
	

	if ($recId == '0') {
		$displayData['pageTitle']    = CENUM_MODULES_CHIP.' '.CENUM_CHIP_POINTER.' '.INSURANCE_DASHBOARD_CHIP.''.$askingPageChip.''.CENUM_CHIP_POINTER.' '.mdlchip('Add Payment');
		$displayData['title']        = 'Add Payment';
		$displayData['page']        = 'paymentform';
	}
	else{
		$displayData['pageTitle']    = CENUM_MODULES_CHIP.' '.CENUM_CHIP_POINTER.' '.INSURANCE_DASHBOARD_CHIP.''.$askingPageChip.''.CENUM_CHIP_POINTER.' '.mdlchip('Edit Payment');
		$details = $this->clsData->loadrecordfromtable($table, $pkColmn, $recId);
	    $displayData['details']      =  $details;
		$displayData['title']        = 'Edit claim';
		$displayData['page']        = 'paymentform';      
	}			
		$displayData['recId'] = $recId;    
		$displayData['mainTemplate'] = INSURANCE_PREFIX.'forms/payments/addEdit';
		$displayData['nav'] = $this->mnav_brain_jar->navData('insurance');
		renderpage($displayData);
	    
  }

  public function loadPayment($recId){
  	$details = $this->clsData->loadrecordfromtable('insurance_payments', 'paymentId', $recId);
  	return $details;
  }

  public function loadPaymentsBy($column, $data){
  	$records = $this->clsData->loadrecordsfromtable('insurance_payments', "WHERE NOT bRetired AND $column = '$data'");
  	return $records;
  }




























 }