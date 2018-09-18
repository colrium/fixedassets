<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

	function defaultmodulepreferences($module=FALSE){
		$CI = & get_instance();
		$modules = $CI->config->item('fortmodules');
		$modulespreferences = $CI->config->item('modulespreferences');
		$defaultpreferences = array();
		
		if (!array_key_exists('system', $modules)) {
			$modules['system'] = 'System';
		}
		foreach ($modules as $key => $value) {
			$defaultpreferences[$key] = $modulespreferences[$key];
		}
		if ($module!=FALSE && array_key_exists($module, $defaultpreferences)) {
			$defaultpreferences = arraytoobjectrecursivecast($defaultpreferences[$module]);
		}
		else{
			$allmodulespreferences = array();
			foreach ($defaultpreferences as $dpkey => $dpvalue) {
				$allmodulespreferences[$dpkey] = arraytoobjectrecursivecast($dpvalue);
			}
			$defaultpreferences = $allmodulespreferences;
		}
		return $defaultpreferences;
	}

	function defaultuserpreferences($module=FALSE){
		$CI = & get_instance();
		$modules = $CI->config->item('fortmodules');
		$defaultpreferences = array();
		$defaultpreferences['system'] = array('desktopalerts'=>'1', 'emailalerts'=>'0', 'dayspredatealert'=>'7', 'dayspostdatealert'=>'2', 'alertemailaddress'=>'user@user.com', 'dateformat'=>'1', 'datefields'=>array(), 'datapresentationview'=>'datatables', 'loudlinks'=>'0');
		foreach ($modules as $key => $value) {
			$defaultpreferences[$key] = array('desktopalerts'=>'1', 'emailalerts'=>'0', 'dayspredatealert'=>'7', 'dayspostdatealert'=>'2', 'alertemailaddress'=>'user@user.com', 'dateformat'=>'1', 'datefields'=>array(), 'datapresentationview'=>'datatables', 'loudlinks'=>'0');
		}
		if ($module!=FALSE && array_key_exists($module, $defaultpreferences)) {
			return arraytoobjectrecursivecast($defaultpreferences[$module]);
		}
		return $defaultpreferences;
	}

	function systempreferences($name='', $fkvalues=TRUE){
		$CI = & get_instance();
		$params=array();
		$params['where']['equalto'] = array('prefId'=>'1');
		$preferences = dbtablerecords('system_prefs', $params, FALSE, $fkvalues);
		$preferences = $preferences[0];
		if ($name!='') {
			return $preferences->$name;
		}
		return $preferences;
	}

	function modulepreferences($module='system', $name=FALSE, $fkvalues=TRUE){
		$CI = & get_instance();		
		$table = 'preferences';
		$preference = '';
		$modules = $CI->config->item('fortmodules');
		if ($module != 'system' && !array_key_exists($module, $modules)) {
			$module='system';
		}
		$defaultpreferences = defaultmodulepreferences($module);		
		$allpreferences = defaultmodulepreferences($module);
		$params = array();
		$params["where"]["equalto"] = array('module'=>$module);
		$preferences = dbtablerecords($table, $params, FALSE, $fkvalues);
		if (is_array($preferences)) {
			if (sizeof($preferences) > 0) {
				$preferences = $preferences[0]->preferences;
				$preferences = json_decode($preferences);
				$preferences = objecttoarrayrecursivecast($preferences);
			}
			else{
				$jsonpreferences = json_encode($defaultpreferences);
				$dbsavedata = array('module'=>$module, 'preferences'=>$jsonpreferences); 
				$preferencesid = addupdatedbtablerecord($table, $dbsavedata, '0', FALSE, FALSE);
				$preferences = dbtablerecords($table, $params, FALSE, $fkvalues);
				$preferences = $preferences[0]->preferences;
				$preferences = json_decode($preferences);
				$preferences = objecttoarrayrecursivecast($preferences);

			}
				
		}
		else{
			$jsonpreferences = json_encode($defaultpreferences);
			$dbsavedata = array('module'=>$module, 'preferences'=>$jsonpreferences); 
			$preferencesid = addupdatedbtablerecord($table, $dbsavedata, '0', FALSE, FALSE);
			$preferences = dbtablerecords($table, $params, FALSE, $fkvalues);
			$preferences = $preferences[0]->preferences;
			$preferences = json_decode($preferences);
			$preferences = objecttoarrayrecursivecast($preferences);
		}
		if ($name != FALSE) {
				if (array_key_exists($name, $preferences)) {
					$preference = $preferences[$name];
					if ($name=='dateformat' || $name=='defaultdateformat') {
						$details = dbtablerecord($preference,'dateformats');
						if ($details != FALSE) {
							$preference = $details->format;
						}
						else{
							$preference = 'Y-m-d';
						}
					}
					if ($name=='locale' || $name=='currency' || $name=='defaultcurrency') {
						$details = dbtablerecord($preference,'countries');
						if ($details != FALSE) {
							$preference = $details->currency_symbol;
						}
						else{
							$preference = 'Y-m-d';
						}
					}
				}
		}
		else{
				$preference = arraytoobjectrecursivecast($preferences);
		}
				
		

		
		return $preference;

	}

	function userpreferences($module='system', $name=FALSE, $user=FALSE, $fkvalues=TRUE){		
		$table = 'user_preferences';
		$preference = '';
		if ($user == FALSE) {
			$user = USERID;
		}

		$defaultpreferences = defaultuserpreferences();
		
		$params = array();
		$params['where']['equalto'] = array('user'=>$user);
		$preferences = dbtablerecords($table, $params, FALSE, $fkvalues);
		if ($preferences != FALSE) {
			$preferences = $preferences[0]->preferences;
			$preferences = json_decode($preferences);
			$preferences = objecttoarrayrecursivecast($preferences);
		}
		else{
			$preferences = $defaultpreferences;
			$jsonpreferences = json_encode($defaultpreferences);
			$dbsavedata = array('user'=>$user, 'preferences'=>$jsonpreferences); 
			addupdatedbtablerecord($table, $dbsavedata, 0, FALSE, FALSE);
		}
		if ($module == 'system' || array_key_exists($module, $preferences)) {
			if ($name != FALSE) {
				if (array_key_exists($name, $preferences[$module])) {
					$preference = $preferences[$module][$name];
					if ($name=='dateformat') {
						$details = dbtablerecord($preference,'dateformats');
						if ($details != FALSE) {
							$preference = $details->format;
						}
						else{
							$preference = 'Y-m-d';
						}
					}
				}
			}
			else{
				$preference = arraytoobjectrecursivecast($preferences[$module]);
			}
				
		}

		
		return $preference;

	}

	function updateuserpreferences($userid, $newpreferences){
		$table = 'user_preferences';
		$recId = 0;
		$savedata = array();
		$defaultpreferences = defaultuserpreferences();
		$currentpreferences = $defaultpreferences;
		$params = array();
		$params['where']['equalto'] = array('user'=>$userid);
		$allpreferences = dbtablerecords($table, $params, FALSE, FALSE);
		if (is_array($allpreferences) && sizeof($allpreferences)>0) {
			$recId = $allpreferences[0]->id;
			$currentpreferences = json_decode($allpreferences[0]->preferences);
			$currentpreferences = objecttoarrayrecursivecast($currentpreferences);
		}
		else{			
			$savedata['user'] = $userid;
			$savedata['preferences'] = json_encode($currentpreferences);
			addupdatedbtablerecord($table, $savedata, $recId, FALSE, FALSE);
			return updateuserpreferences($userid, $newpreferences);
		}
		foreach ($newpreferences as $module => $modulepreferences) {
			if (array_key_exists($module, $currentpreferences)) {
				if (sizeof($currentpreferences[$module]) != sizeof($newpreferences[$module])) {
					$differences = array_diff_assoc($currentpreferences[$module], $newpreferences[$module]);
					foreach ($differences as $dkey => $dvalue) {
						if ($currentpreferences[$module][$dkey] == '1') {
							$newpreferences[$module][$dkey]='0';
						}
					}
				}
				$currentpreferences[$module] = array_merge($currentpreferences[$module], $newpreferences[$module]);
			}
		}
		$savedata['preferences'] = json_encode($currentpreferences);
		addupdatedbtablerecord($table, $savedata, $recId, FALSE, FALSE);
		return TRUE;
	}

	function monetaryformat($value = 0.00, $currency = FALSE){
		$currencysymbol = '';
		if ($currency == FALSE) {
			$currencysymbol = systempreferences('sys_currency');
		}

		return $currencysymbol.' '.$value;
	}

	function formatmoduledate($date = FALSE, $module='system'){
		$dateformat = userpreferences($module, 'dateformat');
		return date($dateformat,strtotime($date));
	}


	function formatmoduledatetimeformat($date = FALSE, $module='system'){
		$dateformat = userpreferences($module, 'dateformat').' H:i:s';
		return date($dateformat,strtotime($date));
	}