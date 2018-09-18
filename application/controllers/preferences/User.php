<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/


class User extends CI_Controller {
	public $displayData;

	function __construct(){
		parent::__construct();
		isloggedin(TRUE);
		$this->load->helper('file');
		$this->displayData = array();
		$this->displayData['module'] = 'modules';
		$this->displayData['nav'] = $this->mnav_brain_jar->navData('modules');
	}


	function index(){
		$this->preferences('system');
	}	

	function preferences($module){
		$userid = USERID;
		$modules = $this->config->item('fortmodules');
		$modulename = 'System';
		if (array_key_exists($module, $modules)) {
		   	$modulename = $modules[$module];
		}
		else if ($module=='system' || $module=='modules') {
			$module = 'system';
		}
		else{
			$module = 'system';
		}

		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData)>0) {			
			$newpreferences = array();
			$newpreferences[$module] = $postedData;

			
			if (updateuserpreferences($userid, $newpreferences)) {
				setflashnotifacation('message', maticon('save', 'medium').' Preferences Saved'); 
				preredirect('preferences/User/preferences/'.$module, 'refresh');
			}
		}
		$this->displayData['module'] = $module;		
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($module);
		$this->displayData['title'] = $modulename.' User Preferences';
		$this->displayData['preferences'] = userpreferences($module);
		$this->displayData['preferencesname'] =  $modulename.' User Preferences';
		$this->displayData['pageTitle'] = breadcrumb($modulename.' Preferences');
		$this->displayData['mainTemplate'] = 'preferences/userpreferences';

		renderpage($this->displayData);            
   }

   public function profile(){
         $userId = USERID;
         //check if any data has been posted
         $posteduserData = $this->input->post(NULL, FALSE);
         if (sizeof($posteduserData)>0) {
            $username = $this->input->post('username');
               $email = $this->input->post('email');
               $first_name = $this->input->post('first_name');
               $last_name = $this->input->post('last_name');
               $phone = $this->input->post('phone');
               $this->form_validation->set_rules('username', $this->fieldnames->getFieldName('username', 'users'), 'required');
               $this->form_validation->set_rules('email', $this->fieldnames->getFieldName('email', 'users'), 'required');
               $this->form_validation->set_rules('first_name', $this->fieldnames->getFieldName('first_name', 'users'), 'required');
               $this->form_validation->set_rules('last_name', $this->fieldnames->getFieldName('last_name', 'users'), 'required');     
               

               //validation fails
               if ($this->form_validation->run() == FALSE){
                  $errorMessage = maticon('edit', 'white-text').'<br>'.strip_tags(validation_errors());
                  $errorMessage = str_replace("\n", "<br>", $errorMessage);
                  $this->displayData['strerror']        = $errorMessage;
               }
               //else validation succeeds
               else{
                  $data = array(
                           'first_name' => $first_name,
                           'last_name' => $last_name,
                           'email' => $email,
                           'phone' => $phone
                            );
                  if ($this->ion_auth->update($userId, $data)) {
                     setflashnotifacation('message', maticon('person', 'white-text').'<br>Profile updated');
                     preredirect('users/User/profile');
                  }
                  else{
                     setflashnotifacation('formerror', maticon('person', 'white-text').'<br> Profile updated error');
                     preredirect('users/User/profile');
                  }

               }
         }
            $this->displayData['recId']        = $userId;
            $this->displayData['mainimage']        = $this->datalib->loadentitymainimage('users', $userId);
            $this->displayData['images']        = $this->datalib->loadentityimages('users', $userId);
            $this->displayData['details']        = $this->datalib->loadrecordfromtable('users', 'id', $userId);
            $this->displayData['title']        = 'Edit Profile';
            $this->displayData['pageTitle']    = ' '.CENUM_CHIP_POINTER.' '.breadcrumb('Edit Profile');
            $this->displayData['mainTemplate'] = 'forms/users/userprofile';
             $this->displayData['nav'] = $this->mnav_brain_jar->navData('modules');           
             renderpage($this->displayData);
         
            
      
   }


   public function changepassword(){
      $this->form_validation->set_rules('oldpassword', 'Current Password', 'required');
      $this->form_validation->set_rules('newpassword', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[repeatnewpassword]');
      $this->form_validation->set_rules('repeatnewpassword', 'Repeat New Password', 'required');
      isloggedin(TRUE);
         $postedData = $this->input->post(NULL, FALSE);
         if (sizeof($postedData)>0) {
            //validation fails
            if ($this->form_validation->run() == FALSE){
               $errorMessage = maticon('edit', 'white-text').'<br>'.strip_tags(validation_errors());
               $errorMessage = str_replace("\n", "<br>", $errorMessage);
               $this->displayData['strerror']        = $errorMessage;
            }
            //else validation succeeds
            else{
               $identity = $this->session->userdata('identity');

               $change = $this->ion_auth->change_password($identity, $this->input->post('oldpassword'), $this->input->post('newpassword'));

               if ($change){
                  //if the password was successfully changed
                  $errorMessage = maticon('vpn_key', 'white-text').'<br>'.strip_tags($this->ion_auth->messages());
                  $errorMessage = str_replace("\n", "<br>", $errorMessage);
                  setflashnotifacation('message', $errorMessage);
                  preredirect('Login/logout');
               }
               else{
                  $errorMessage = maticon('vpn_key', 'white-text').'<br>'.strip_tags($this->ion_auth->errors());
                  $errorMessage = str_replace("\n", "<br>", $errorMessage);
                  $this->displayData['strerror']        = $errorMessage;                  
               }

            }
         }

            $this->displayData['title']        = 'Change Password';
            $this->displayData['pageTitle']    = ' '.CENUM_CHIP_POINTER.' '.breadcrumb('Change Password');
            $this->displayData['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->displayData['mainTemplate'] = 'forms/users/change_password';
            $this->displayData['nav'] = $this->mnav_brain_jar->navData();
            renderpage($this->displayData);
            
   }






























}