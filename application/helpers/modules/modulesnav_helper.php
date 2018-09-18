<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

function modulesnav(){
		$navData = '<ul class="collapsible flat-ui borderless" data-collapsible="accordion">
										<li>
												<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('folder', 'spaced-text').' File</div>
												<div class="collapsible-body padded-left">
													<div class="collection">
														'.systemfilemenu().'
														'.systemmodulesdatabase().'
													</div>
												</div>
										</li>';
					if (isadmin(FALSE)) {
						$navData .= '<li>
												<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('people', 'spaced-text').' Users</div>
												<div class="collapsible-body padded-left">
													<div class="collection">
														'.systemusermanagementmenu().'
													</div>
												</div>
										</li>


										<li>
												<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('folder', 'spaced-text').' System Data</div>
												<div class="collapsible-body padded-left">
													<div class="collection">
														'.systemdatavarsMenu().'
													</div>
												</div>
										</li>

										<li>
												<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('poll', 'spaced-text').' Reports</div>
												<div class="collapsible-body padded-left">
													<div class="collection">
														'.systemReportsMenu().'
														'.customreportsmenu('system').'
													</div>
												</div>
										</li>



										<li>
												<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Preferences</div>
												<div class="collapsible-body padded-left">
													<div class="collection">
														'.systemmodulespreferences().'
													</div>
												</div>
										</li>';
						}

										
										
	$navData .= '</ul>';
	
	return $navData;	
}

function systemfilemenu(){
	$strOut = '';
	if (isadmin(FALSE)){
			$strOut .= '<a href="#excelimport-modal" id="importbtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger">'.maticon('assignment_returned', 'spaced-text').' Import From Spreadsheet</a>';
	}
	return $strOut;
}


function systemusermanagementmenu(){
	$CI = & get_instance();
		$strOut = '';
		if (isadmin()){
			$strOut .= anchor('users/Users/allusers', maticon('assignment_ind', 'spaced-text').' Users', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor('users/Users/usergroups', maticon('people', 'spaced-text').' User Groups', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			if (!$CI->verauth->isLogKeysExceeded()) {
				$strOut .= anchor('users/Users/addedituser/0', maticon('person_add', 'spaced-text').' Create User', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			}
		}
		
		return $strOut;
}

function systemmodulesdatabase($module='all'){
	$strOut = '';
	$CI = & get_instance();  
	$modules = $CI->config->item('fortmodules');
	$moduleName = '';
	if ($module == 'none' || $module == '' || $module == 'system') {
		$moduleName = '';
	}
	else{
		if (array_key_exists($module, $modules)) {
			$moduleName = $modules[$module];
		}    
	}
		
		$strOut .= '<a href="#dbbackupmodal" id="backupdbbtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger">'.maticon('cloud_queue', 'spaced-text').' Backup '.$moduleName.' Database</a>';
		$strOut .= anchor('utilities/Database/optimizedb', maticon('healing', 'spaced-text').' Optimize '.$moduleName.' Database', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		if (isadmin()){
			$strOut .= '<a href="#restoredbmodal" id="restorebtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger">'.maticon('history', 'spaced-text').' Restore '.$moduleName.' Database</a>';
		}
		if (isdebugger(FALSE)) {
			$strOut .= '<a href="#" onclick="confirmEmptyDatabase(\''.$module.'\');" class="main-link collection-item borderless full-width waves-effect waves-dark"> '.maticon('delete_forever', 'spaced-text').' Empty '.$moduleName.' Database </a>';
		}
		return $strOut;
}

function systemmodulespreferences(){
	$CI = & get_instance();
		$strOut = '';
		if (isadmin()) {
			$strOut .= anchor('preferences/System/inputpreferences/system', maticon('build', 'spaced-text').' Input Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor('preferences/System/tablepreferences/system', maticon('folder', 'spaced-text').' Tables Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor('preferences/System/preferences', maticon('settings', 'spaced-text').' System Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');      
		}
		if (isdebugger()) {
			if (ENVIRONMENT == 'development') {
				$strOut .= anchor('preferences/System/refreshfieldnames/system', maticon('autorenew', 'spaced-text').' Refresh Input Fields', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			}
			$strOut .= anchor('preferences/System/priveledges', maticon('verified_user', 'spaced-text').' System Priveledges', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');      
			$strOut .= anchor('preferences/System/colorscheme', maticon('color_lens', 'spaced-text').' Color Scheme', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		}

		return $strOut;
}



function systemdatavarsMenu(){
	$CI = & get_instance();
	$strOut = '';
	if (isdebugger()) {
			$strOut .= anchor('system/Filemanager', maticon('folder', 'spaced-text').' File Manager', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor('system/Data/accountingcountries', maticon('map', 'spaced-text').' Accounting Countries', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor('system/Data/dateformats', maticon('date_range', 'spaced-text').' Date Formats', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor('system/Data/paymentmodes', maticon('local_atm', 'spaced-text').' Payment Modes', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor('system/Data/employees', maticon('assignment_ind', 'spaced-text').' Employees', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor('system/Data/notifacations', maticon('notifications', 'spaced-text').' Notifacations', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor('system/Data/recyclebin', maticon('delete_sweep', 'spaced-text').' Recycle Bin', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
	}


	return $strOut;
}



function systemReportsMenu(){
		$strOut = '';
		return $strOut;
}

function customreportsmenu($module){
		$strOut = '';
		$CI = & get_instance();  
		$modules = $CI->config->item('fortmodules');
		if (!array_key_exists($module, $modules)) {
				$module = 'system';
		}

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

		foreach ($reports as $report) {
			$strOut .= anchor('reports/Reports/generatereport/'.$report->id, maticon($report->icon, 'spaced-text').' '.$report->name, 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		}

		$strOut .= anchor('reports/Reports/addeditreport/0/'.$module.'/1', maticon('add', 'spaced-text').' New Report Wizard', 'class="main-link collection-item borderless teal-text full-width waves-effect waves-dark"');
		$strOut .= anchor('reports/Reports/customreports/'.$module, maticon('list', 'spaced-text').' Reports Directory', 'class="main-link collection-item borderless blue-text full-width waves-effect waves-dark"');
		return $strOut;
}