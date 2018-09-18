<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*---------------------------------------------------------------------
FORT TECHNOLOGIES SYSTEM
Developed By Mutugi Riungu 2016
NO ALTERATIONS OR CODE REUSE IS AUTHORIZED     
---------------------------------------------------------------------*/
class Setglobal{

	public function __construct(){
		if (isloggedin(FALSE)){
			$this->setGlobals();
		}
		else{
			$this->setDefaultGlobals();
		}    
	}


	public function __get($var){
		return get_instance()->$var;
	}

	public function setGlobals(){
				
				$user = $this->ion_auth->user()->row();
					global $userFName, $userLName, $userName, $userDateFormat, $userMetrics, $userID, $userEmail, $userLastLogin;

					$userID = $user->id;
					$userEmail = $user->email;
					$userName = $user->username;
					$userFName = $user->first_name;
					$userLName = $user->last_name;
					$userLastLogin = $user->last_login;
					$licOrganisation = $this->config->item('auth_org', 'cogs');

				// Logged in user Details

					define('USERID',          $userID);
					define('USERNAME',        $userName);
					define('USERFNAME',       $userFName);
					define('USERLNAME',       $userLName);
					define('USEREMAIL',       $userEmail);
					define('AUTHORG',         $licOrganisation);
					define('USERLASTLOGIN',   $userLastLogin);
					define('USERDTEFORMAT',   'dS F Y');
			 
		 
	}

	public function setDefaultGlobals(){
					define('USERID',          "");
					define('USERNAME',        "");
					define('USERFNAME',       "");
					define('USERLNAME',       "");
					define('USEREMAIL',       "");
					define('AUTHORG',         'Fort Technologies. Copyright 2016');
					define('USERLASTLOGIN',   "");
					define('USERDTEFORMAT',   'dS F Y');


	}





}