<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Install extends CI_Controller {

	function __construct(){
        parent::__construct();	
		$this->load->helper('url');
		$this->load->helper('file');

	}
	
	function index(){
			$displayData['title']        = 'Install';
		    $displayData['pageTitle']    = '<span class="mdl-chip waves-effect modules-chip"><span class="mdl-chip__contact '.getcolorclass(10).'"></span><span class="mdl-chip__text">Install</span> </span>'.' '.mdlmediachip(maticon('alarm', getcolorclass(5).' normal-text'), '<small class="'.getcolorclass(5).'"> '.date('l, FdS Y H:i').'</small>', 'class="mdl-chip waves-effect waves-light '.getcolorclass().'"');
		    $displayData['mainTemplate'] = 'utilities/install';
		    $displayData['nav'] = '';		      
		    renderpage($displayData);
		    
	}
	
	// -----------------------------------------------------------------------------------
	
	/*
	 * Install the script here
	 */
	function installsystem(){
		$db_verify				=	$this->check_db_connection();
		
		if($db_verify == true){
			// Replace the database settings
			$db_host 			=	$this->input->post('db_host');
			$db_name 			=	$this->input->post('db_name');
			$db_user 			=	$this->input->post('db_user');
			$db_password 	=	$this->input->post('db_password');
			

			$data 			= read_file('./application/config/database.php');
			$data 			= str_replace('db_name',		$db_name,		$data);
			$data 			= str_replace('db_user',		$db_user,		$data);
			$data 			= str_replace('db_pass',		$db_password,	$data);						
			$data 			= str_replace('db_host',		$db_host,		$data);
			write_file('./application/config/database.php', $data);
			
			// Replace new default routing controller
			$data2 			= read_file('./application/config/routes.php');
			$data2 			= str_replace('Install','Dashboard',$data2);
			write_file('./application/config/routes.php', $data2);
			
			
			// Run the installer sql schema		
			$link 			= @mysql_connect($db_host , $db_user , $db_password);
			mysql_select_db($db_name, $link);
			$temp_line 		= '';
			$lines 			= file('./catalog/database/install.sql');
			foreach ($lines as $line){
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;
				$temp_line .= $line;
				if (substr(trim($line), -1, 1) == ';'){
					mysql_query($temp_line) or print('Error performing query \'<strong>' . $temp_line . '\': ' . mysql_error() . '<br /><br />');
					$temp_line = '';
				}			

			}
			
		}
		else{
			setflashnotifacation('message', maticon('error', 'medium').'<br>Database Connection Failed'); 
	        preredirect('utilities/Install'); 
		}
	}
	
	// -------------------------------------------------------------------------------------------------
	
	/* 
	 * Database validation check from user input settings
	 */
	function check_db_connection(){
		$link	=	@mysql_connect($this->input->post('db_host'),
						$this->input->post('db_user'),
							$this->input->post('db_password'));
		if(!$link){
			@mysql_close($link);
		 	return false;
		}
		
		$db_selected	=	mysql_select_db($this->input->post('db_name'), $link);
		if (!$db_selected){
			@mysql_close($link);
		 	return false;
		}
		
		@mysql_close($link);
		return true;
	}


	function uninstallmodule(){
		$postedData = $this->input->post(NULL, FALSE);
		//if data has been posted
		if (sizeof($postedData)>0) {


		}
		
	}



	
	
}

/* End of file install.php */
/* Location: ./system/application/controllers/install.php */