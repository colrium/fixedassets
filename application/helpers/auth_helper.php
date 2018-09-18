<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	

	function islocked(){
		$CI = &get_instance();
		$locked = $CI->ion_auth->locked();
		
		return $locked;
	}

	function isloggedin($login=FALSE){
		$CI =&get_instance();
		$loggedin = $CI->ion_auth->logged_in();
		if ($loggedin) {
			$locked = islocked();
			if ($locked) {
				if (isajaxrequest()) {
					$CI->output->set_status_header(423)->set_content_type('text/plain', 'utf-8')->set_output("Account Locked")->_display();
				}
			}
			if ($login != FALSE && $locked) {
				if (isajaxrequest()) {
					$CI->output->set_status_header(401)->set_content_type('text/plain', 'utf-8')->set_output("Account Locked")->_display();
					return FALSE;
				}
				else{
					preredirect('Login/unlock', 'refresh');
				}
				
			}
			else{
				return TRUE;
			}

		}
		else{
					
			if ($login != FALSE) {
				if (isajaxrequest()) {
					$CI->output->set_status_header(401);
				}
				else{
					preredirect('Login/login', 'refresh');
				}	
			}
			else{
				return FALSE;
			}
		}
	}

	

	function isadmin($goback=FALSE, $userid=FALSE){
		$CI =& get_instance();

		$admin = $CI->ion_auth->is_admin($userid) || $CI->ion_auth->is_debugger($userid);
		$refererpage = reffererpage();
		$requestingUrl = 'Dashboard';
		if ($refererpage != '') {
			$requestingUrl = $refererpage;
		}
		if (!$admin && $goback) {
			if (isajaxrequest()) {
				$CI->output->set_status_header(403)->set_output("Sorry. Access has been denied. You dont have Administrative priviledges")->_display();
			}
			else{
				setflashnotifacation('error', array('icon'=>'block', 'alert'=>'Sorry. Access has been denied. You dont have Administrative priviledges'));
				preredirect($requestingUrl, 'refresh');
			}
			
		}
	   
		return $admin;
	}




	function isdebugger($goback=FALSE, $userid=FALSE){
		$CI =& get_instance();
		$debugger = $CI->ion_auth->is_debugger($userid);
		$refererpage = reffererpage();
		$requestingUrl = 'Dashboard';
		if ($refererpage != '') {
			$requestingUrl = $refererpage;
		}
		if (!$debugger && $goback) {
			if (isajaxrequest()) {
				$CI->output->set_status_header(403)->set_output("Sorry. Access has been denied. You dont have Super Administrative priviledges")->_display();
			}
			else{
				setflashnotifacation('error', array('icon'=>'block', 'alert'=>'Sorry. Access has been denied. You dont have Super Administrative priviledges'));
				preredirect($requestingUrl, 'refresh');
			}
			
		}
		return $debugger;
	}
	function ismaker($userid=FALSE){
		$CI =& get_instance();
		return FALSE;
	}
	function ischecker($userid=FALSE){
		$CI =& get_instance();
		return FALSE;
	}

	function isadmingroup($groupname){
		$CI = & get_instance();
		return $CI->ion_auth->is_admingroup($groupname);
	}

	function isdebuggergroup($groupname){
		$CI = & get_instance();
		return $CI->ion_auth->is_debuggergroup($groupname);
	}
	function userpriveledges($module='system', $userid=FALSE){
		$CI =& get_instance();
		if (!is_string($module)) {
			$module = 'all';
		}

		$priviledges = $CI->ion_auth->userpriveledges($userid);
		if (array_key_exists($module, $priviledges)) {
			$priviledges = $priviledges[$module];
		}
		return $priviledges;
	}

	function haspriveledge($priveledge, $module='fixedassets', $goback=FALSE, $data=FALSE, $userid = FALSE){
		$CI =& get_instance();
		$haspriveledge = FALSE;
		if ($userid == FALSE) {
			if (defined('USERID')) {
				$userid = USERID;
			}
			else{
				return FALSE;
			}
		}
		if (isadmin(FALSE)) {
			$haspriveledge = TRUE;
		}
		else{
			$haspriveledge = $CI->ion_auth->haspriveledge($priveledge, $module, $data, $userid);
		}

		$refererpage = reffererpage();
		$requestingUrl = 'Dashboard';
		if ($refererpage != '') {
			$requestingUrl = $refererpage;
		}
		if (!$haspriveledge && $goback != FALSE) {
			if (isajaxrequest()) {
				$CI->output->set_status_header(403)->set_output("Sorry. Unauthorized Access has been denied.")->_display();
			}
			else{
				setflashnotifacation('error', array('icon'=>'block', 'alert'=>'Sorry. Unauthorized Access has been denied.'));
				preredirect($requestingUrl, 'refresh');
			}
		}
		return $haspriveledge;
	}

	function addpriveledgeallocations($params = array()){
		if (is_array($params)) {
			if (array_key_exists('priveledgeid', $params) && array_key_exists('target', $params) && array_key_exists('targetid', $params) && array_key_exists('value', $params)) {
				if(!array_key_exists('datavalue', $params)){
					$params['datavalue'] = '';
				}
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}

	
	
