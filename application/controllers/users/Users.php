<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public $displayData;
	function __construct(){
		parent::__construct();
		isadmin();
			$this->displayData = array();  
			isloggedin(TRUE);
			isadmin(TRUE);
			$this->load->model('users/musers','clsUsr');
			$this->load->library('form_validation');
			$this->displayData = array();
			$this->displayData['module'] = 'modules';
			$this->displayData['nav'] = $this->mnav_brain_jar->navData('modules');
		
		 
	}

	// redirect if needed, otherwise display the user list
	function index(){
		$this->usergroups();
		
	}

	
	

	public function usergroups(){
		$this->load->config('ion_auth', TRUE);
		$tables  = $this->config->item('tables', 'ion_auth');
		$groupstable = $tables['groups'];
		$debugger_group = $this->config->item('debug_group', 'ion_auth');
		$admin_group = $this->config->item('admin_group', 'ion_auth');
		$this->displayData['title']        = 'User Groups';
		$this->displayData['usergroups']    = dbtablerecords($groupstable, array(), FALSE);
		$this->displayData['debbugersgroup']    = $debugger_group;
		$this->displayData['adminsgroup']    = $admin_group;
		$this->displayData['dbfields']    = dbtablefields($groupstable);
		$this->displayData['pageTitle']    = breadcrumb('User Groups');
		$this->displayData['mainTemplate'] = 'forms/users/usergroupslist';
		renderpage($this->displayData);
	}

	function allusers(){
		$this->load->config('ion_auth', TRUE);
		$tables  = $this->config->item('tables', 'ion_auth');
		$userstable = $tables['users'];
		$users = dbtablerecords($userstable, array(), FALSE);
		foreach ($users as $k => $user){
			$users[$k]->groups = $this->ion_auth->get_users_groups($user->id);
		}
		$this->displayData['users'] = $users;
		$this->displayData['title']        = 'Users';
		$this->displayData['pageTitle']    = breadcrumb('All Users');
		$this->displayData['mainTemplate'] = 'forms/users/userslist';
		renderpage($this->displayData);
	}

	function deletegroup($groupId){
		$this->ion_auth->delete_group($groupId);
		setflashnotifacation('message', array('icon'=>'check_circle', 'alert'=>'User Group Deleted Successfully'));
		preredirect('users/Users/usergroups/');
	}

	

	public function addedituser($recId=0){
		if (isdebugger(FALSE, $recId)) {
			isdebugger(TRUE);
		}
		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData)>0) {
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$phone = $this->input->post('phone');
			$password = $this->input->post('password');
			$usergroup = $this->input->post('usergroup');
			$this->form_validation->set_rules('username', $this->fieldnames->getFieldName('username', 'users'), 'required');
			$this->form_validation->set_rules('email', $this->fieldnames->getFieldName('email', 'users'), 'required');
			$this->form_validation->set_rules('first_name', $this->fieldnames->getFieldName('first_name', 'users'), 'required');
			$this->form_validation->set_rules('last_name', $this->fieldnames->getFieldName('last_name', 'users'), 'required');
			if ($recId=='0') {            
				$this->form_validation->set_rules('password', $this->fieldnames->getFieldName('password', 'users'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
				$this->form_validation->set_rules('repeat_password', $this->fieldnames->getFieldName('repeat_password', 'users'), 'required|matches[password]');
			}
			else{
				if ($password != '') {
					$this->form_validation->set_rules('password', $this->fieldnames->getFieldName('password', 'users'), 'min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
					$this->form_validation->set_rules('repeat_password', $this->fieldnames->getFieldName('repeat_password', 'users'), 'required|matches[password]');
				}            
			}

			//validation fails
			if ($this->form_validation->run() == FALSE){
				$errorMessage = strip_tags(validation_errors());
				setflashnotifacation('formerror', array('icon'=>'edit', 'alert'=>$errorMessage));
			}
			//else validation succeeds
			else{
				$additional_data = array('first_name' => $first_name, 'last_name' => $last_name);
				if ($recId=='0') {
					//check if email and username exist
					if (!$this->ion_auth->email_check($email) && !$this->ion_auth->username_check($username)){
						$newuserid = $this->ion_auth->register($username, $password, $email, $additional_data, $usergroup);
						if ($newuserid != FALSE) {
							$recId = $newuserid;
							if (sizeof($usergroup)>0) {
								$this->ion_auth->add_to_group($usergroup, $recId);
								setflashnotifacation('message', array('icon'=>'check_circle', 'alert'=>'User Created Successfully'));
								preredirect('users/Users/addedituser/'.$newuserid);
							}
						}

					}
					else{
						if ($this->ion_auth->email_check($email)) {
							setflashnotifacation('error', array('icon'=>'error', 'alert'=>'Email: <i>'.$email.'</i> Already Exists. Please choose a different email'));
						}
						else{
							setflashnotifacation('error', array('icon'=>'error', 'alert'=>'Username: <i>'.$username.'</i> Already Exists. Please choose a different username'));
						}
					}
				}
				else{
					if ($password != '') {
						$userdata = array('email' => $email, 'first_name' => $first_name,  'last_name' => $last_name, 'phone' => $phone, 'password' => $password);
					}
					else{
						$userdata = array('email' => $email, 'first_name' => $first_name,  'last_name' => $last_name, 'phone' => $phone);
					}
					
					$this->ion_auth->update($recId, $userdata);
					$ingroups = $this->clsUsr->useringroups($recId);
						if (sizeof($ingroups)) {
							foreach ($ingroups as $key => $value) {
								if (!in_array($value, $usergroup)) {
									$this->ion_auth->remove_from_group($value, $recId);
								}
							}
						}
						if (sizeof($usergroup)) {
							foreach ($usergroup as $key => $value) {
								if (!in_array($value, $ingroups)) {
									$this->ion_auth->add_to_group($value, $recId);
								}
							}
						}
						setflashnotifacation('message', array('icon'=>'check_circle', 'alert'=>'User Updated Successfully'));
						preredirect('users/Users/addedituser/'.$recId);                                      

				}
			}
		}
			if ($recId=='0') {
				$this->displayData['title']        = 'Add User';
				$this->displayData['pageTitle']    = breadcrumb('Add User');
			}
			else{
				$this->displayData['title']        = 'Edit User';
				$this->displayData['details']        = $this->clsUsr->loaduser($recId);
				$this->displayData['usergroups']        = $this->clsUsr->useringroups($recId);
				$this->displayData['pageTitle']    = breadcrumb('Edit User');
			}
			$this->displayData['recId']        = $recId;
			$this->displayData['groups']        = $this->clsUsr->loadusergroups();
			$this->displayData['mainTemplate'] = 'forms/users/addedituser';
			renderpage($this->displayData);
	}

	public function addeditgroup($recId='0'){
		$this->load->config('ion_auth', TRUE);
		$tables  = $this->config->item('tables', 'ion_auth');
		$groupstable = $tables['groups'];
		$priveledgestable = $tables['priveledges'];
		$priveledgesallocstable = $tables['priveledgeallocs'];
		$debugger_group = $this->config->item('debug_group', 'ion_auth');
		$admin_group = $this->config->item('admin_group', 'ion_auth');

		$this->displayData['priveledgestable']        = $priveledgestable;
		$this->displayData['priveledgesallocstable']        = $priveledgesallocstable;
		$this->displayData['debugger_group']        = $debugger_group;
		$this->displayData['admin_group']        = $admin_group;


		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData)>0) {
			
	
			$this->form_validation->set_rules('name', $this->fieldnames->getFieldName('name', 'groups'), 'trim|required');
			$this->form_validation->set_rules('description', $this->fieldnames->getFieldName('description', 'groups'), 'trim');


			 //validation fails
			if ($this->form_validation->run() == FALSE){
				$errorMessage = maticon('edit', 'white-text').'<br>'.strip_tags(validation_errors());
				$errorMessage = str_replace("\n", "<br>", $errorMessage);
				setflashnotifacation('formerror', $errorMessage);
			}
			//else validation succeeds
			else{
				$name = $this->input->post('name');
				$description = $this->input->post('description');

				$priveledgevalues = $this->input->post('priveledgevalue');
				$datavalues = $this->input->post('datavalue');

				if (is_null($priveledgevalues)) {
					$priveledgevalues = array();
				}

				if (is_null($datavalues)) {
					$datavalues = array();
				}

				$data = array('name'=>$name, 'description'=>$description);
				$groupid = addupdatedbtablerecord($groupstable, $data, $recId, FALSE, FALSE);
				$recId = $groupid;

				if ($recId != '0') {
					$priveledgeparams = array();
					$priveledgeparams['where']['equalto'] = array('target'=>'group', 'targetid'=>$recId);
					$priveledgedefs = dbtablerecords($priveledgestable, array(), FALSE);

					$grppriveledges = dbtablerecords($priveledgesallocstable, $priveledgeparams, FALSE);

					if (is_array($grppriveledges) && sizeof($grppriveledges) > 0) {
						foreach ($grppriveledges as $grppriveledge) {
							deletedbtablerecord($priveledgesallocstable, $grppriveledge->id);
						}
					}
					if (is_array($priveledgedefs) && sizeof($priveledgedefs) > 0) {
						foreach ($priveledgedefs as $priveledgedef) {
							$priveledgesavedata = array();
							$priveledgesavedata['target'] = 'group';
							$priveledgesavedata['targetid'] = $recId;
							$priveledgesavedata['priveledgeid'] = $priveledgedef->id;
							if (array_key_exists($priveledgedef->name, $priveledgevalues)) {
								$priveledgesavedata['value'] = $priveledgevalues[$priveledgedef->name];
							}
							else{
								$priveledgesavedata['value'] = '0';
							}
							if (array_key_exists($priveledgedef->name, $datavalues)) {
								$priveledgesavedata['datavalue'] = $datavalues[$priveledgedef->name];
							}
							else{
								$priveledgesavedata['datavalue'] = '';
							}
							$priveledgeid = addupdatedbtablerecord($priveledgesallocstable, $priveledgesavedata, 0, FALSE, FALSE);



						}
					}
				}
			}



		}

			if ($recId=='0') {
				$this->displayData['title']        = 'Add Group';
				$this->displayData['pageTitle']    = breadcrumb('Add User Group');
			}
			else{
				$this->displayData['title']        = 'Edit Group';
				$this->displayData['details']        = $this->clsUsr->loadusergroup($recId);
				$this->displayData['pageTitle']    = breadcrumb('Edit User Group');
			}
			$this->displayData['recId']        = $recId;
			$this->displayData['mainTemplate'] = 'forms/users/addeditgroup';
			$this->displayData['recId']        = $recId;
			renderpage($this->displayData);
			
		 
	}

	public function changepassword(){      
		isloggedin(TRUE);
			$postedData = $this->input->post(NULL, FALSE);
			if (sizeof($postedData)>0) {
				$this->form_validation->set_rules('oldpassword', 'Current Password', 'required');
				$this->form_validation->set_rules('newpassword', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[repeatnewpassword]');
				$this->form_validation->set_rules('repeatnewpassword', 'Repeat New Password', 'required');
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
						preredirect('Login/logout', 'refresh');
					}
					else{
						$errorMessage = maticon('vpn_key', 'white-text').'<br>'.strip_tags($this->ion_auth->errors());
						$errorMessage = str_replace("\n", "<br>", $errorMessage);
						$this->displayData['strerror']        = $errorMessage;                  
					}

				}
			}

				$this->displayData['title']        = 'Change Password';
				$this->displayData['pageTitle']    = breadcrumb('Change Password');
				$this->displayData['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->displayData['mainTemplate'] = 'forms/users/change_password';
				$this->displayData['nav'] = $this->mnav_brain_jar->navData();
				renderpage($this->displayData);
				
		

	}

	public function deleteusers(){
		$users = $this->input->post('userlistchckbox');
		foreach ($users as $key => $value) {
			if($value != 1 && $value != USERID){
				$this->ion_auth->delete_user($value);
			}
			
		}

		$returnData['valmessage']        = maticon('delete', 'spaced-text medium').'<br>Users Deleted';
		$returnData['valstatus']        = '1';
		
		 echo jsonEncode($returnData);
	}

	public function deleteuser($recId){
		$deleted = $this->ion_auth->delete_user($recId);

		setflashnotifacation('message', maticon('delete', 'spaced-text').' User Deleted');
		preredirect('users/Users/allusers', 'refresh');
	}


	public function addmarkers(){
		$users = $this->input->post('userlistchckbox');
		$returnData = array();
		 if ($this->datalib->addmakers($users)) {
				$returnData['valmessage']        = maticon('verified_user', 'spaced-text medium').'<br>Makers Added';
				$returnData['valstatus']        = '1';
		 }
		 else{
				$returnData['valmessage']        = maticon('block', 'spaced-text medium').'<br>Makers Add Error';
				$returnData['valstatus']        = '0';
		 }
		 echo jsonEncode($returnData);


	}

	public function addcheckers(){
		$returnData = array();
		$users = $this->input->post('userlistchckbox');
		 if ($this->datalib->addcheckers($users)) {
				$returnData['valmessage']        = maticon('verified_user', 'spaced-text medium').'<br>Checkers Added';
				$returnData['valstatus']        = '1';
		 }
		 else{
				$returnData['valmessage']        = maticon('block', 'spaced-text medium').'<br>Checkers Add Error';
				$returnData['valstatus']        = '0';
		 }
		 echo jsonEncode($returnData);


	}

	public function removemarkers(){
		$returnData = array();
		$users = $this->input->post('userlistchckbox');
		 if ($this->datalib->removemakers($users)) {
				$returnData['valmessage']        = maticon('verified_user', 'spaced-text medium').'<br>Makers Removed';
				$returnData['valstatus']        = '1';
		 }
		 else{
				$returnData['valmessage']        = maticon('block', 'spaced-text medium').'<br>Makers Remove Error';
				$returnData['valstatus']        = '0';
		 }
		 echo jsonEncode($returnData);


	}

	public function removecheckers(){
		$returnData = array();
		$users = $this->input->post('userlistchckbox');
		 if ($this->datalib->removecheckers($users)) {
				$returnData['valmessage']        = maticon('verified_user', 'spaced-text medium').'<br>Checkers Removed';
				$returnData['valstatus']        = '1';
		 }
		 else{
				$returnData['valmessage']        = maticon('block', 'spaced-text medium').'<br>Checkers Remove Error';
				$returnData['valstatus']        = '0';
		 }
		 echo jsonEncode($returnData);


	}

	
	public function validatemarkerchecker(){
		$returnData = array();
		$markerpassword = $this->input->post('markerpass', true);
		$checkerpassword = $this->input->post('checkerpass', true);

		$makerValidated = false;
		$checkerValidated = false;

		$this->form_validation->set_rules('markerpass', 'Marker Password', 'required');
		$this->form_validation->set_rules('checkerpass', 'Checker Password', 'required');

				//validation fails
				if ($this->form_validation->run() == FALSE){
					$errorMessage = maticon('vpn_key', 'spaced-text').'<br>'.strip_tags(validation_errors());
					$errorMessage = str_replace("\n", "<br>", $errorMessage);
					$returnData['valmessage']        = $errorMessage;

					$returnData['valstatus']        = '0';

				}
				//else validation succeeds
				else{
					$makers = $this->datalib->getmakers();
					$checkers = $this->datalib->getcheckers();

					foreach ($makers as $maker) {
						if ($this->ion_auth->is_password($maker->userid, $markerpassword)) {
							$makerValidated = true;
						}
					}
					foreach ($checkers as $checker) {
						if ($this->ion_auth->is_password($checker->userid, $checkerpassword)) {
							$checkerValidated = true;
						}
					}

					if ($makerValidated && $checkerValidated) {
						$returnData['valmessage']        = maticon('verified_user', 'spaced-text medium').'<br>Maker Checker Validated';
						$returnData['valstatus']        = '1';
					}
					else{
						if (!$makerValidated && !$checkerValidated) {
							$returnData['valmessage']        = maticon('block', 'medium white-text').'<br>Both Maker and Checker Validation failed!';
							$returnData['valstatus']        = '0';
						}
						else if($makerValidated && !$checkerValidated){
							$returnData['valmessage']        = maticon('block', 'medium white-text').'<br>Checker Validation failed!';
							$returnData['valstatus']        = '0';
						}
						else if(!$makerValidated && $checkerValidated){
							$returnData['valmessage']        = maticon('block', 'medium white-text').'<br>Maker Validation failed!';
							$returnData['valstatus']        = '0';
						}
						else{
							$returnData['valmessage']        = maticon('block', 'medium white-text').'<br>Unknown Validation error!';
							$returnData['valstatus']        = '0';
						}                  
					}

				}

				echo jsonEncode($returnData);

		

	}


	






























}