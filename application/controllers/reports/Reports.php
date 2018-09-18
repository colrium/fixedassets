<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	public $displayData = array();
	public $referer;

	function __construct(){
		parent::__construct();
		isloggedin(TRUE);
		$this->refererpage = reffererpage();
		if ($this->refererpage == '') {
			$this->refererpage = 'Dashboard';
		}
		$this->displayData['module'] = 'system';
		$this->displayData['nav'] = $this->mnav_brain_jar->navData('system'); 
	}

	public function index(){

	}

	public function addeditreport($recId,$module='system', $step=1){
		$table = 'reports';
		$stepdescriptions = array('Define Report', 'Select Report Columns', 'Define Data Filters');

		if ($recId != '0') {
			if (!dbtablerecordexists($recId, $table)) {
				setflashnotifacation('error', array('icon'=>'folder_open', 'alert'=>'Sorry! That record does not exist in '.$this->moduletablesnames[$table]));
				preredirect($this->refererpage, 'refresh');
			}
			else{
				$details = dbtablerecord($recId, $table, FALSE);
				$this->displayData['details']    = $details;
				$module = $details->module;
			}
		}
		else {
			$step = 1;
		}
		$nextstep = $step;


		if ($module != 'system' && !array_key_exists($module, $this->config->item('fortmodules'))) {
			setflashnotifacation('error', array('icon'=>'error', 'alert'=>'Sorry! Module does not exist!'));
			preredirect($this->refererpage, 'refresh');
		}

		//check for and save posted data
		$postedData = $this->input->post(NULL, FALSE);
		$originalpostedData = $postedData;
		if (sizeof($postedData)>0) {
			if (array_key_exists('fields', $originalpostedData)) {
				$record = dbtablerecord($recId, $table, FALSE);
				$fieldsarray = $this->input->post('fields');
				$postedData = objecttoarrayrecursivecast($record);
				$postedData['fields'] = json_encode($fieldsarray);
				$nextstep = 3;
			}
			if (array_key_exists('name', $originalpostedData)) {
				$nextstep = 2;
				if ($recId == '0') {
					$postedData['user'] = USERID;
					$postedData['module'] = $module;
				}
			}
			else if (array_key_exists('filters', $originalpostedData)) {
				$reportfilters = array();
				foreach ($postedData['filters'] as $key => $value) {
					$reportfilters[$key] = new stdClass;
					$reportfilters[$key]->filter = $value;
					$reportfilters[$key]->filtervalue = $postedData['filtervalues'][$key];
					$reportfilters[$key]->totals = 0;
					if (array_key_exists('totals', $postedData)) {
						if (array_key_exists($key, $postedData['totals'])) {
							$reportfilters[$key]->totals = $postedData['totals'][$key];
						}
					}
						
				}
				$record = dbtablerecord($recId, $table, FALSE);
				$recordarr = objecttoarrayrecursivecast($record);
				$postedData = $recordarr;
				$postedData['filters'] = json_encode($reportfilters);
			}

			$newRecId = addupdatedbtablerecord($table, $postedData, $recId, TRUE, TRUE);			
			if (!array_key_exists('strerror', $this->displayData)) {
				setflashnotifacation('message', array('icon'=>'save', 'alert'=>($recId=='0'? 'Record added to '.dbmoduletablename($table).' successfully' : dbmoduletablename($table).' record updated successfully')));
				//redirect
				if ($step > 3) {
					preredirect('reports/Reports/customreports/'.$module);
				}
				else{
					preredirect('reports/Reports/addeditreport/'.$newRecId.'/'.$module.'/'.$nextstep);
					
				}
				
			}
		}

		
		$this->displayData['table'] = $table;
		$this->displayData['tables'] = dbmoduletables($module);
		$this->displayData['recId']        = $recId;
		$this->displayData['step'] = $step;
		$this->displayData['stepdescription'] = $stepdescriptions[$step-1];
		$this->displayData['title']        = ($recId == '0') ? 'Add Report' : 'Edit Report';
		$this->displayData['pageTitle']    = breadcrumb(($recId == 0) ? 'Add Report' : 'Edit Report');
		$this->displayData['mainTemplate'] 	= 'reports/addeditreport';
		$this->displayData['module'] = $module;
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($module);
		renderpage($this->displayData);

	}

	public function customreports($module='system'){
		$table = 'reports';

		$privateparams=array();
		$privateparams['where'] = array();
		$privateparams['where']['equalto'] = array('module'=>$module, 'private'=>'1', 'user'=>USERID);
		$privatereports = dbtablerecords($table, $privateparams, FALSE, TRUE, FALSE);

		$publicparams=array();
		$publicparams['where'] = array();
		$publicparams['where']['equalto'] = array('module'=>$module, 'private'=>'0');
		$publicreports = dbtablerecords($table, $publicparams, FALSE, TRUE, FALSE);

		$reports = array();
		if (is_array($publicreports) && is_array($privatereports)) {
			$reports = array_merge($privatereports, $publicreports);
		}
		elseif (!is_array($publicreports) && is_array($privatereports)) {
			$reports = $privatereports;
		}
		elseif (is_array($publicreports) && !is_array($privatereports)) {
			$reports = $publicreports;
		}



		
		$this->displayData['reports'] = $reports;
		$this->displayData['table'] = $table;
		$this->displayData['fields']    	= dbtablefields($table);
		$this->displayData['title']        = 'Custom Reports';
		$this->displayData['pageTitle']    = breadcrumb('Custom Reports');
		$this->displayData['mainTemplate'] 	= 'reports/customreports';
		$this->displayData['module'] = $module;
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($module);
		renderpage($this->displayData);
	}

	public function generatereport($recId){
		$table = 'reports';
		if ($recId != '0') {
			if (!dbtablerecordexists($recId, $table)) {
				setflashnotifacation('error', array('icon'=>'folder_open', 'alert'=>'Sorry! That record does not exist in '.$this->moduletablesnames[$table]));
				preredirect($this->refererpage, 'refresh');
			}
		}


		$reportdetails =  dbtablerecord($recId, $table, FALSE);
		$module = $reportdetails->module;

		$genrepparams = array();
		$payload = dbtablerecords($reportdetails->entity, $genrepparams, FALSE, TRUE, FALSE);

		$this->displayData['table'] = $table;
		$this->displayData['payload'] = $payload;
		$this->displayData['reportentityfields'] = dbtablefields($reportdetails->entity);
		$this->displayData['reportfields'] = json_decode($reportdetails->fields);
		$this->displayData['title']        = $reportdetails->name;
		$this->displayData['pageTitle']    = breadcrumb($reportdetails->name);
		$this->displayData['mainTemplate'] 	= 'reports/generatereport';
		$this->displayData['module'] = $module;
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($module);
		renderpage($this->displayData);
	}





















}