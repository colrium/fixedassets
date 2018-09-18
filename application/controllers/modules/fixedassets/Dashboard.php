<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public $displayData;
	public $userpreferences;

	function __construct(){
		parent::__construct();
		isloggedin(TRUE);
		$this->load->library(FIXEDASSETS_PREFIX.'depreciation');
    	$this->load->library(FIXEDASSETS_PREFIX.'preferences');

	  	$this->displayData = array();

	  	$this->load->model(FIXEDASSETS_PREFIX.'assets/massets','clsAssets');
      	$this->load->model(FIXEDASSETS_PREFIX.'functions/mfunctions','clsFunc');

	  	
	  	$this->displayData['module'] = 'fixedassets'; 
	  	$this->userpreferences =  userpreferences('fixedassets');
	  	$this->displayData['preferences'] = $this->userpreferences;
	  	$this->displayData['entitiesicons'] = dbmoduletableicons($this->displayData['module']);
		$this->displayData['entitiesnames'] = dbmoduletablenames($this->displayData['module']);
		$this->displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
   }

	public function index(){
	  $this->dashboard();
	}

	public function dashboard(){
		$this->displayData['title']        = 'Dashboard';
		$divisionsdata = array();
		$fkfields = dbtablefields('fixedassets_assetlist', 'isFK', '1');
		$this->displayData['criterias'] = dbtablefields('fixedassets_assetlist', 'isFK', '1');
    	$this->displayData['pageTitle']    = breadcrumb('Dashboard');
    	$this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'dashboard';
        
        renderpage($this->displayData);
    	
	}



	public function record($recId){
		$record = array();
		$details = dbtablerecord($recId, 'fixedassets_assetlist', TRUE);
		$fields = dbtablefields('fixedassets_assetlist');

		$record['image'] = site_url('files/Files/outputmainimage/fixedassets_assetlist/'.$recId);
		$record['barcode'] = generateBarcode($details->assetCode, 'html', '60', 'black');

		$record['details'] = $details;
		$record['fields'] = array();
		foreach ($fields as $field) {
			$record['fields'][$field->initialName] = $field->setName;
		}
		

		$record['depreciation'] = array();
		$record['depreciation']['variables'] = $this->depreciation->deprecreciationvars($recId);
    	$record['depreciation']['annual'] = $this->depreciation->depreciationdata($recId, 'yearsdata');
    	$record['depreciation']['month'] = $this->depreciation->depreciationdata($recId, 'monthsdata');

    	$notebookparams = array();
    	$notebookparams['where']['equalto'] = array('entity' => 'fixedassets_assetlist', 'record'=>$details->assetID);
    	$notebookentries = dbtablerecords('actions_log', $notebookparams, FALSE, TRUE);
    	$notebookfields = dbtablefields('actions_log');
    	if (!is_array($notebookentries)) {
    		$notebookentries = array();
    	}
    	$record['notebook'] = array();
    	$record['notebook']['fields'] = array();
    	foreach ($notebookfields as $notebookfield) {
    		$record['notebook']['fields'][$notebookfield->initialName] = $notebookfield->setName;
    	}
    	$record['notebook']['entries'] = $notebookentries;



    	$response = json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    	header('Content-Type: application/json');
		echo $response;
	}



	public function jsonassets($criteria, $criteriaId){			
			$params = array();
			$nonincludedlocs = array('isDisposed' => '1');
			if ($criteria == 'all') {
				$params['where']['notequalto'] = $nonincludedlocs;
			}			
			else if ($criteria == 'search') {
				$params = array('where' => array('notequalto'=> $nonincludedlocs));
				$params['where']['like'] = array($criteriaId);
			}
			else{
				if ($criteria != 'isDisposed') {
					$params['where']['equalto'] = array($criteria => $criteriaId);
					$params['where']['notequalto'] = $nonincludedlocs;
				}
				else{
					$params['where']['equalto'] = array($criteria => $criteriaId);
				}
					
			}


			$assetRecords = dbtablerecords('fixedassets_assetlist', $params, FALSE);
			if ($assetRecords == FALSE) {
				$assetRecords = array();
			}
			$tableFields = dbtablefields('fixedassets_assetlist', 'isDashShown', '1');
			$data = array('payloadfields'=>$tableFields, 'payload'=>$assetRecords);
			header('Content-Type: application/json');
			echo json_encode($data);
	}



	public function jsonassetslist($criteria='all', $criteriaId='all'){
			$timeStart = microtime(true);
			$params = array();
			$nonincludedlocs = array('isDisposed' => '1');
			if ($criteria == 'all') {
				$params['where']['notequalto'] = $nonincludedlocs;
			}			
			else if ($criteria == 'search') {
				$params = array('where' => array('notequalto'=> $nonincludedlocs));
				$params['where']['like'] = array($criteriaId);
			}
			else{
				if ($criteria != 'isDisposed') {
					$params['where']['equalto'] = array($criteria => $criteriaId);
					$params['where']['notequalto'] = $nonincludedlocs;
				}
				else{
					$params['where']['equalto'] = array($criteria => $criteriaId);
				}
					
			}



			$assetRecords = dbtablerecords('fixedassets_assetlist', $params, FALSE);
			$tableFields = dbtablefields('fixedassets_assetlist');
			$timeaftergetdata =  microtime(true);


			$jsonrecords = json_encode($assetRecords);
			$timeafterjsonEncode = microtime(true);


			$viewSelection = array('loadcriteria'=>$criteria, 'loadcriteriaid'=>$criteriaId);
			$this->session->set_userdata($viewSelection);
			$timeafterSessionSet = microtime(true);

			
			echo $jsonrecords;
			

	}

	public function ajaxsecondarylocationsselect($recId=1){
		$table='fixedassets_secondaryloc';
		$datacolumn='primLocId';
		$params = array();
		$params['where']['equalto'] = array($datacolumn=>$recId);
		$records = dbtablerecords($table, $params, FALSE);
		$select = maticon('folder_open', 'spaced-text').' No '.$this->fieldnames->getFieldName('assetSecLoc').' exists';

		$options = array();
		if (is_array($records) && sizeof($records)>0) {
			foreach ($records as $record) {
				$options[$record->seclocID] = $record->seclocIdentifier;
			}


			$select = chosenselect('assetSecLoc', $options, '', $this->fieldnames->getFieldName('assetSecLoc'), 'assetSecLoc');
		}
			

		
  		echo $select;


	}



	public function ajaxdepreciationprojection($years='-1', $buyingPrice='-1', $serviceDte='-1', $salvageVal='-1', $depMethod='-1', $percUsage='-1'){

		$depreciationdata = array();
    	$depreciationdata['method'] = $depMethod;
		$depreciationdata['life'] = $years;
		$depreciationdata['salvagevalue'] = $salvageVal;
		$depreciationdata['startdate'] = $serviceDte;
		$depreciationdata['price'] = $buyingPrice;
		$depreciationdata['percentageuse'] = $percUsage;
      echo $this->depreciation->getdepreciation('', 'monthlytable', '', $depreciationdata);      
    }

	

	public function echocalculateMonthlyDepreciation($years='-1', $buyingPrice='-1', $serviceDte='-1', $salvageVal='-1', $depMethod='-1', $percUsage='-1'){

		$depreciationdata = array();
    	$depreciationdata['method'] = $depMethod;
		$depreciationdata['life'] = $years;
		$depreciationdata['salvagevalue'] = $salvageVal;
		$depreciationdata['startdate'] = $serviceDte;
		$depreciationdata['price'] = $buyingPrice;
		$depreciationdata['percentageuse'] = $percUsage;
      echo $this->depreciation->getdepreciation('', 'monthlytable', '', $depreciationdata);      
    }

    public function echocalculateAnnualDepreciation($years='-1', $buyingPrice='-1', $serviceDte='-1', $salvageVal='-1', $depMethod='-1', $percUsage='-1'){
    	$depreciationdata = array();
    	$depreciationdata['method'] = $depMethod;
		$depreciationdata['life'] = $years;
		$depreciationdata['salvagevalue'] = $salvageVal;
		$depreciationdata['startdate'] = $serviceDte;
		$depreciationdata['price'] = $buyingPrice;
		$depreciationdata['percentageuse'] = $percUsage;
      echo $this->depreciation->getdepreciation('', 'yearlytable', '', $depreciationdata);
    }

    public function test(){

    	print_r(userpriveledges("fixedassets"));
    }

    public function test2(){
    	$this->load->library(FIXEDASSETS_PREFIX.'depreciation');
    	$data = $this->depreciation->straightlinedata(1, 'monthsdata');
    	print_r($data);
    }
    public function test3(){
    	$this->load->library(FIXEDASSETS_PREFIX.'depreciation');
    	$data = $this->depreciation->deprecreciationvars(1);
    	print_r($data);
    }

    

    
}

