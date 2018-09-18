<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public $displayData;

	function __construct(){
	  parent::__construct();
	  $this->load->library('form_validation');
	  $this->displayData = array();   
   }

	// redirect if needed, otherwise display the user list
   function index(){
	  $this->login();
   }

   

	public function login(){
		$loggedin = isloggedin(FALSE);
		$requestRefererer = reffererpage();
		if ($requestRefererer == '' || $requestRefererer == 'Login/login' || $requestRefererer == 'Login/lock' || $requestRefererer == 'Login/logout') {
		   $requestRefererer = 'Dashboard';
		}

		if ($loggedin){
			// redirect them to the login page
			preredirect($requestRefererer,'refresh');
		}
		else{      		
			//check if any data has been posted
			$posteduserData = $this->input->post(NULL, FALSE);
			if (sizeof($posteduserData) > 0) {
				  $remember = $this->input->post('rememberme');
				  $username = $this->input->post('username');
				  $password = $this->input->post('password');

				  

				  $this->form_validation->set_rules('username', 'Username/Email', 'trim|required');
				  $this->form_validation->set_rules('password', 'Password', 'trim|required');

				  //if  validation fails
				  if ($this->form_validation->run() == FALSE){				  	
					$errorMessage = strip_tags(validation_errors());
					$errorMessage = str_replace("\n", "<br>", $errorMessage);
					$this->displayData['error'] = array('icon'=>'edit', 'alert'=>$errorMessage);
				  }
				  else{
					  $rememberMe = TRUE;

					  //access log data
					  $userid = dbtabledatarecordexists('users', 'username', $username, FALSE, TRUE);
						$accesslogdata = array('user'=>$userid, 'datetime'=>date('Y-m-d H:i:s'), 'type'=>'Login');
						if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
							$accesslogdata['remote_address'] = $_SERVER['REMOTE_ADDR'];
						}
						if (array_key_exists('REMOTE_HOST', $_SERVER)) {
							$accesslogdata['remote_host'] = $_SERVER['REMOTE_HOST'];
						}
						if (array_key_exists('REMOTE_USER', $_SERVER)) {
							$accesslogdata['remote_host_user'] = $_SERVER['REMOTE_USER'];
						}
						if (array_key_exists('REMOTE_PORT', $_SERVER)) {
							$accesslogdata['remote_port'] = $_SERVER['REMOTE_PORT'];
						}

					if ($this->ion_auth->login($username, $password, $rememberMe)) {
						$accesslogdata['status'] = '1';
						setflashnotifacation('message', array('icon'=>'sentiment_satisfied', 'image'=>site_url('files/Files/outputmainimage/users/'.USERID), 'alert'=>'Login Successful'));
						$loggedin = TRUE;
						
					}
					else{
						$accesslogdata['status'] = '0';
						$this->displayData['error'] = array('icon'=>'block', 'title'=>'Login Failed', 'alert'=>'Please ensure you have the right login redentials');
					}
					if (!indevelopmentmode()) {
						addupdatedbtablerecord('access_log', $accesslogdata, '0', FALSE, FALSE);
					}
				  }
			}
			
			if ($loggedin) {				
				preredirect($requestRefererer);
			}
			else{
				$this->displayData['title']        = 'Login';
				$this->displayData['pageTitle']    = breadcrumb('Login');
				$this->displayData['mainTemplate'] = 'forms/users/login';
				$this->displayData['nav'] = '';		      
				renderpage($this->displayData);
			}
				
				
		}
			

	}


	public function unlock(){
		//check if any data has been posted
		$requestRefererer = 'Dashboard';
		if ($this->session->has_userdata('lockurl')) {				           	
			$requestRefererer = $this->session->userdata('lockurl');
		}
		else if ($requestRefererer == '' || $requestRefererer == 'Login/login' || $requestRefererer == 'Login/logout' || $requestRefererer == 'Login/unlock'){
			$requestRefererer = 'Dashboard';
		}



		$posteduserData = $this->input->post(NULL, FALSE);
		if (sizeof($posteduserData) > 0) {			
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//if  validation fails
			if ($this->form_validation->run() == FALSE){
				$errorMessage = maticon('vpn_key', 'white-text').'<br>'.strip_tags(validation_errors());
				$errorMessage = str_replace("\n", "<br>", $errorMessage);
				$this->displayData['strerror']        = $errorMessage;
			}
			else{
				$password = $this->input->post('password');
				if (isloggedin(FALSE)) {					
					if ($this->ion_auth->unlock($password)) {
					setflashnotifacation('message', array('icon'=>'lock_open', 'alert'=>'Account Unlocked'));
						preredirect($requestRefererer);
					}
					else{
						setflashnotifacation('error', array('icon'=>'error', 'alert'=>'Unlock Failed'));
						preredirect('Login/unlock');
					}
				}
				else{
					preredirect('Login/login');
				}
					

			}
		}
		$this->displayData['title']        = 'Unlock';
		$this->displayData['pageTitle']    = breadcrumb('Unlock');
		$this->displayData['mainTemplate'] = 'forms/users/unlock';
		$this->displayData['nav'] = '';		      
		renderpage($this->displayData);

	}

	


	// log the user in
	function appuserlogin(){
	   $response = array();
	   if (isset($_POST['identity']) && isset($_POST['password'])) {
			$identity  = $_POST['identity'];
			$password   = $_POST['password'];
			$remember = true;
				if ($this->ion_auth->login($identity, $password, $remember)){
					$user = $this->ion_auth->user()->row();
						// success
						$response["success"] = 1;
						$response["message"] = $user->last_name." ".$user->first_name." Logged in successfully";
						$userDetails = array();
						$userDetails["u_id"] = $user->id;
						$userDetails["u_name"] = $user->username;
						$userDetails["u_email"] = $user->email;
						$userDetails["u_lname"] = $user->last_name;
						$userDetails["u_fname"] = $user->first_name;
				
						// user node
						$response["userDetails"] = array();			 
						array_push($response["userDetails"], $userDetails);
		 
					// echoing JSON response
					echo json_encode($response);

				}
				else{
					$response["success"] = 0;
					$response["message"] = "Login Failed.";
					// echoing JSON response
					echo json_encode($response);
				}
	   }
	   else if (!isset($_POST['identity']) && isset($_POST['password'])) {
	   
			// required field is missing
			$response["success"] = 0;
			$response["message"] = "User Login Email/Username is required";
		 
			// echoing JSON response
			echo json_encode($response);
	   }

	   else if (isset($_POST['identity']) && !isset($_POST['password'])) {
	   
			// required field is missing
			$response["success"] = 0;
			$response["message"] = "Password is required";
		 
			// echoing JSON response
			echo json_encode($response);
	   }
		
	   

	}


	


	public function forgotpassword(){
		//check if any data has been posted
		$posteduserData = $this->input->post(NULL, FALSE);
		if (sizeof($posteduserData)>0) {
			$this->form_validation->set_rules('useremail', 'Email', 'trim|required');

			//if  validation fails
			  if ($this->form_validation->run() == FALSE){
				$errorMessage = maticon('edit', 'white-text').'<br>'.strip_tags(validation_errors());
				$errorMessage = str_replace("\n", "<br>", $errorMessage);
				$this->displayData['strerror']        = $errorMessage;
			  }

			  else{
					$identity_column = $this->config->item('identity','ion_auth');
					$identity = $this->ion_auth->where($identity_column, $this->input->post('useremail'))->users()->row();

					if(empty($identity)) {
						$this->ion_auth->set_error('forgot_password_email_not_found');

						setflashnotifacation('message', $this->ion_auth->errors());
						preredirect("Auth/forgot_password", 'refresh');
					}
					// run the forgotten password method to email an activation code to the user
					$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

					if ($forgotten){
						// if there were no errors
						setflashnotifacation('message', array('alert'=>$this->ion_auth->messages()));
						preredirect("Login", 'refresh'); //we should display a confirmation page here instead of the login page
					}
					else{
						setflashnotifacation('error', array('icon'=>'error', 'alert'=>$this->ion_auth->errors()));
						preredirect("Login/forgotpassword", 'refresh');
					}

				}


		}
			$this->displayData['title']        = 'Reset Password';
			$this->displayData['pageTitle']    = '<span class="mdl-chip waves-effect waves-teal"><span class="mdl-chip__contact mdl-color--white mdl-color-text--teal">'.maticon('person', 'normal-text').'</span><span class="mdl-chip__text">Forgot Password</span> </span> <span class="spacer"></span>'.maticon('alarm', 'tiny').'<small> '.date('l, FdS Y H:i').'</small>';
			$this->displayData['mainTemplate'] = 'forms/users/forgotpass';
			$this->displayData['nav'] = '';		      
			renderpage($this->displayData);
			



	}
	public function lock(){
		$requestRefererer = reffererpage();
		if ($requestRefererer=='') {
		   $requestRefererer = 'Dashboard';
		}

		if ($this->ion_auth->logged_in()) {
			if (!$this->ion_auth->locked()) {
				if ($this->ion_auth->lock()) {
					$this->session->set_userdata('lockurl', $requestRefererer);
					if (isajaxrequest()) {
						$this->unlock();
					}
					else{
						preredirect('Login/unlock');
					}
				}
			}
			else{
				setflashnotifacation('error', array('icon'=>'sentiment_neutral', 'alert'=>'Your Account is already Locked'));
				preredirect('Login/login');
			}
				
		}
		else{

		}

	}


	public function logout(){
		if (isloggedin(FALSE)) {   			
			//access log data
						$accesslogdata = array('user'=>USERID, 'datetime'=>date('Y-m-d H:i:s'), 'type'=>'Logout');
						if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
							$accesslogdata['remote_address'] = $_SERVER['REMOTE_ADDR'];
						}
						if (array_key_exists('REMOTE_HOST', $_SERVER)) {
							$accesslogdata['remote_host'] = $_SERVER['REMOTE_HOST'];
						}
						if (array_key_exists('REMOTE_USER', $_SERVER)) {
							$accesslogdata['remote_host_user'] = $_SERVER['REMOTE_USER'];
						}
						if (array_key_exists('REMOTE_PORT', $_SERVER)) {
							$accesslogdata['remote_port'] = $_SERVER['REMOTE_PORT'];
						}
						$accesslogdata['status'] = '1';
						$this->ion_auth->logout();
						if (!indevelopmentmode()) {
							addupdatedbtablerecord('access_log', $accesslogdata, '0', FALSE, FALSE);
						}

		}
		if (isajaxrequest()) {
			$this->login();
		}
		else{
			preredirect('Login/login');
		}
		
		
			  
	}





}