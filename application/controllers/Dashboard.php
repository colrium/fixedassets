<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public $displayData = array();

	function __construct(){
		parent::__construct();	
		$this->displayData['module'] = 'system';

	}

	public function index(){
		isloggedin(TRUE);
		$defaultmodule = $this->config->item('defaultmodule');
		$defaultmodule = trim($defaultmodule);
		if (strlen($defaultmodule) > 0) {
			$modulesanchorprefixes = $this->config->item('modulesanchorprefixes');
			preredirect($modulesanchorprefixes[$defaultmodule], 'refresh');
		}
		else{
			$this->displayData['title']        = 'Module Dashboard';
			$this->displayData['pageTitle']    = breadcrumb('Dashboard');
			$this->displayData['mainTemplate'] = 'dashboard';
			$this->displayData['nav'] = $this->mnav_brain_jar->navData('modules');      
			renderpage($this->displayData);
		}

		
	}

	public function modules(){
			$this->displayData['title']        = 'Modules';
			$this->displayData['pageTitle']    = breadcrumb('Modules Dashboard');
			$this->displayData['mainTemplate'] = 'dashboard';
			$this->displayData['nav'] = $this->mnav_brain_jar->navData('modules');      
			renderpage($this->displayData);
			
	}


	

	public function test(){
		$path = FCPATH;
		$path = str_replace('/', '\\', $path);
		$path .= 'index.php dashboard test1 Mutugi cli';
		$cmd = 'schtasks.exe /CREATE /SC MINUTE /TN "Test Task 2" /TR "php.exe  '.$path.'" /RU "NT AUTHORITY\LOCALSERVICE"';
		exec($cmd, $op);
		print_r($op);
	}

	public function test1($to = 'World', $from = 'system'){
		$t = time();
		$time = date("Y-m-d H:i:s",$t);
		$content = "Hello {$to} at ".$time." From {$from}";
		$this->load->helper('file');
		write_file('./temp/test.txt', $content);
	}

	public function test2(){
		$path = FCPATH;
		$path = str_replace('/', '\\', $path);
		$path .= 'index.php dashboard test1 "Collins"';
		$cmd = 'schtasks.exe /CREATE /SC MINUTE /TN "Test Task" /TR "php.exe  '.$path.'" /RU System';
		print_r($cmd);

	}



	public function test3(){
		$newrecId = addupdatedbtablerecord('fixedassets_assetlist', array('assetCode'=>'test001new'), 0, FALSE, FALSE);
		print_r($newrecId);

	}


}
