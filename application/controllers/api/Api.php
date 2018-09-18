<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Author: Collins Mutugi Riungu
*		  colrium@gmail.com
*         @mutugiriungu
*
*
* Requirements: PHP5 or above
*
*/
class Api extends CI_Controller {

	public $displayData;

	function __construct(){
		parent::__construct();
		$this->displayData = array();
		$this->displayData['module'] = 'system';
	}

	function login(){
		$returndata = array();
		$returndata['success'] = 0;
		$returndata['message'] = 'Unsuccessful';
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData)>0) {
			if (array_key_exists('username', $postedData) && array_key_exists('password', $postedData)) {
				if ($this->ion_auth->login($postedData['username'], $postedData['password'], true)) {
					$user = $this->ion_auth->user()->row();         
					$sess_cookie_name = $this->config->item('sess_cookie_name');
					$identity_cookie_name = $this->config->item('identity_cookie_name', 'ion_auth');
					$remember_cookie_name = $this->config->item('remember_cookie_name', 'ion_auth');
					$headers = $this->input->request_headers();
					$returndata['success'] = 1;
					$returndata['message'] = 'Successful';
					$returndata['message'] = session_id();
					$returndata['testheaders'] = $headers;
					$returndata['userdetails'] = objecttoarrayrecursivecast($user);
					$returndata['userdetails']['cookie'] = $sess_cookie_name.'='.session_id().';'.$identity_cookie_name.'='.$returndata['userdetails']['username'].';'.$remember_cookie_name.'='.$returndata['userdetails']['remember_code'];
					$returndata['userdetails']['password'] = '';
					$returndata['userdetails']['debugger'] = 0;
					$returndata['userdetails']['admin'] = 0;
					$returndata['userdetails']['mainimage'] = 0;

					
										

					if (isdebugger(FALSE, $user->id)) {
						$returndata['userdetails']['debugger'] = 1;
					}                    
					if (isadmin(FALSE, $user->id)) {
						$returndata['userdetails']['admin'] = 1;
					}

					if (dbhasmainimage('users', $user->id)) {
						$returndata['userdetails']['mainimage'] = 1;
					}
					
				}
				else{
					$returndata['success'] = 0;
					$returndata['message'] = 'Login Failed';
				}
			}
			else {
				$returndata['success'] = 0;
				$returndata['message'] = 'Missing Credentials';
			}

		}
		else{
			$returndata['success'] = 0;
			$returndata['message'] = 'Missing Credentials';
		}
		$this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($returndata, JSON_UNESCAPED_SLASHES))->_display();
		exit;
	}
	function haspriveledge($priveledge, $module='system'){
		if (haspriveledge($priveledge, $module)) {            
			$this->output->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output("Allowed")->_display();
			exit;
		}
		else{			
			$this->output->set_status_header(403)->set_content_type('text/plain', 'utf-8')->set_output("Not Allowed")->_display();
			exit;
		}
		
	}

	function appconfig($datatype='json'){
		$payload = array();

		$this->config->load('colors');
		$primaryColor = $this->config->item('primary_color');
		$primaryDarkColor = $this->config->item('primary_dark_color');
		$accentColor = $this->config->item('accent_color');

		$mods = $this->config->item('fortmodules');
		$modsiconsconfig = $this->config->item('fortmodulesicons');
		$modsanchorprefixes = $this->config->item('modulesanchorprefixes');
		$modcolorsconfig = $this->config->item('modulescolorclasses');
		$modsicons = array();
		$modcolorshex = array();
		$modcolors = array();
		foreach ($mods as $key => $value) {
			if (array_key_exists($key, $modsiconsconfig)) {
				$modsicons[$key] = $modsiconsconfig[$key];
			}
			else{
				$modsicons[$key] = 'folder_open';
			}
			if (array_key_exists($key, $modcolorsconfig)) {
				$modcolorshex[$key] = materialcolors($modcolorsconfig[$key], 'string');
			}
			else{
				$modcolorshex[$key] = $primaryColor;
			}
		}

		$payload = array();
		$payload['name'] = modulename('system');
		$payload['colors'] = array();
		$payload['colors']['colorPrimary'] = $primaryColor;
		$payload['colors']['colorPrimaryDark'] = $primaryDarkColor;
		$payload['colors']['colorAccent'] = $accentColor;
		$payload['modules'] = array();
		$payload['modules']['active'] = $mods;
		$payload['modules']['icons'] = $modsicons;
		$payload['modules']['colors'] = $modcolorshex;
		if ($datatype=='json') {
			$this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($payload, JSON_UNESCAPED_SLASHES))->_display();
		}
		exit;
	}

	function getnotifacations(){
		$allnotifacations = array();
		if (isloggedin(FALSE)) {
			$allnotifacations["unseen"] = getnotifacations(FALSE, FALSE, FALSE, TRUE);
			$allnotifacations["seen"] = getnotifacations(FALSE);
			$this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($allnotifacations, JSON_UNESCAPED_SLASHES))->_display();
			exit;
		}        	
		
	}

	function getemails(){
		$payload = array();
		if (isloggedin(FALSE)) {
			
		}
			
		$this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($payload, JSON_UNESCAPED_SLASHES))->_display();
		exit;
	}


	function saveupdate($entity){
		$returndata = array();
		$returndata['success'] = 0;
		$returndata['message'] = 'Unsuccessful';
		$table = $entity;
		//check for and save posted data
		$postedData = $this->input->post(NULL, FALSE);
		$recId = genrandomstrid(11);
		if (sizeof($postedData)>0) {
			if (isloggedin(FALSE)) {
				$newRecId = addupdatedbtablerecord($table, $postedData, '0', TRUE, TRUE);
				if ($newRecId) {
					$returndata['success'] = 1;
					$returndata['message'] = 'Successful';
				}
				else{
					$returndata['success'] = -2;
					$returndata['message'] = 'Save Error';
				}
			}
			else{
				$returndata['success'] = -1;
				$returndata['message'] = 'Not Logged In';
			}
			
		}
		else{
			$returndata['success'] = 0;
			$returndata['message'] = 'No data parsed';
		}
		$this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($returndata, JSON_UNESCAPED_SLASHES))->_display();
		exit;
	}

	function getrecords(){
		//check for and save posted data
		$returndata = array();
		$table = $this->input->post_get('entity', TRUE);
		$params = array();
		$keys = $this->input->post_get('keys', TRUE);
		$keys = boolval($keys);

		$filter = $this->input->post_get('filter', TRUE);
		$equalto = $this->input->post_get('is', TRUE);
		$notequalto = $this->input->post_get('not', TRUE);
		$search = $this->input->post_get('search', TRUE);
		$like = $this->input->post_get('like', TRUE);
		$select = $this->input->post_get('select', TRUE);
		$column = $this->input->post_get('column', TRUE);
		$join = $this->input->post_get('join', TRUE);
		$joinon = $this->input->post_get('on', TRUE);
		$groupby = $this->input->post_get('groupby', TRUE);
		if ($select && $column) {
			$params['select'] = array();
			$selectsarr = explode("+", $select);
			$columnsarr = explode("+", $column);
			$lastselect = sizeof($selectsarr);
				
			for ($j=0; $j < $lastselect; $j++) {
				$colarr = explode(":", $columnsarr[$j]);
				if (sizeof($colarr)==2) {
					$params['select'][$selectsarr[$j]] = array($colarr[0]=>$colarr[1]);
				}
				else{
					if (!array_key_exists($selectsarr[$j], $params['select'])) {
						$params['select'][$selectsarr[$j]] = array($colarr[0]);
					}
					else{
						if (!in_array($colarr[0], $params['select'][$selectsarr[$j]])) {
							$params['select'][$selectsarr[$j]] = array($colarr[0]);
						}
					}
				}
			}
			
		}
		if ($filter && ($equalto || $notequalto)) {			
			if ($equalto) {
				$params['where']['equalto'] = array($filter=>$equalto);
			}
			if ($notequalto) {
				$params['where']['notequalto'] = array($filter=>$notequalto);
			}
		}
		if ($search && $like) {
			$params['where']['like'] = array($search=>$like);
		}

		if ($join && $joinon) {
			$params['joins'] = array();
			$joinsarr = explode("+", $join);
			$jointsarr = explode("+", $joinon);
			$expectedlastjoint = sizeof($joinsarr);
			$lastjoint = sizeof($jointsarr);

			if ($lastjoint > $expectedlastjoint) {
				$lastjoint = $expectedlastjoint;
			}
			if ($lastjoint > 0) {
				for ($i=0; $i < $lastjoint; $i++) { 
					$jointarr = explode(":", $jointsarr[$i]);
					if (sizeof($jointarr) == 2) {
						$params['joins'][$joinsarr[$i]] = array($jointarr[0]=>$jointarr[1]);
					}
				}
			}
				
			
		}
		
		if ($groupby) {
			$params['groupby'] = array($groupby);
		}
		

		if (isloggedin(FALSE)) {
			$records = dbtablerecords($table, $params, FALSE, $keys, FALSE, FALSE);
			if (is_array($records)) {
				$returndata = $records;
			}
			$this->output->set_header('HTTP/1.0 200 OK')->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($returndata, JSON_UNESCAPED_SLASHES))->_display();
			exit;
		}
		else{
			$this->output->set_header('HTTP/1.0 200 OK')->set_status_header(401)->set_content_type('application/json', 'utf-8')->set_output(json_encode(array(), JSON_UNESCAPED_SLASHES))->_display();
			exit;
		}
	}

	function getrecordscount(){
		//check for and save posted data
		$returndata = 0;
		$table = $this->input->post_get('entity', TRUE);
		$params = array();
		$keys = $this->input->post_get('keys', TRUE);
		$keys = boolval($keys);

		$filter = $this->input->post_get('filter', TRUE);
		$equalto = $this->input->post_get('is', TRUE);
		$notequalto = $this->input->post_get('not', TRUE);
		$search = $this->input->post_get('search', TRUE);
		$like = $this->input->post_get('like', TRUE);		
		
		
		if ($filter && ($equalto || $notequalto)) {			
			if ($equalto) {
				$params['where']['equalto'] = array($filter=>$equalto);
			}
			if ($notequalto) {
				$params['where']['notequalto'] = array($filter=>$notequalto);
			}
		}
		if ($search && $like) {
			$params['where']['like'] = array($search=>$like);
		}

		
		
		

		if (isloggedin(FALSE)) {
			$returndata = dbtablerecordscount($table, $params);

			$this->output->set_header('HTTP/1.0 200 OK')->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output($returndata)->_display();
			exit;
		}
		else{
			$this->output->set_header('HTTP/1.0 200 OK')->set_status_header(401)->set_content_type('text/plain', 'utf-8')->set_output($returndata)->_display();
			exit;
		}
	}


	function getentities($module='system'){
		$entities = array();
		if (isloggedin(FALSE)) {            
			$entities = dbmoduletablenames($module);
		}            
		$this->output->set_header('HTTP/1.0 200 OK')->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($entities, JSON_UNESCAPED_SLASHES))->_display();
		exit;
	}

	function mpesac2b($module='system'){
		$entities = array();
		if (isloggedin(FALSE)) {            
			$entities = dbmoduletablenames($module);
		}            
		$this->output->set_header('HTTP/1.0 200 OK')->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($entities, JSON_UNESCAPED_SLASHES))->_display();
		exit;
	}

	function userpriveledges(){
		$returndata = array();
		$module = $this->input->post_get('module', TRUE);
		$userid = $this->input->post_get('userid', TRUE);
		if (isloggedin(FALSE)) {            
			$returndata = userpriveledges($module, $userid);
		}   
		$this->output->set_header('HTTP/1.0 200 OK')->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($returndata, JSON_UNESCAPED_SLASHES))->_display();
		exit;

	}



















}