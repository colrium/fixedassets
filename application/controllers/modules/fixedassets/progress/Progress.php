<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Progress extends CI_Controller {
	function __construct(){
      parent::__construct();
       	// Set necessary headers 
       	header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');  	
      	$this->load->helper('file');
      	$this->load->library('csvimport');
		
   }

public function csvProgressImport(){
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
	if ($this->session->has_userdata('importProgress')) {
		$progress = $this->session->userdata('importProgress');
				echo "data: $progress" . PHP_EOL;
				  echo PHP_EOL;
				  flush();	
	}
	else{
		$progress = 0;
	}
		if ($progress == 100) {
			$this->session->unset_userdata('importProgress');
		}
		while ($progress > 0) {		
			echo "data: $progress" . PHP_EOL;
			echo PHP_EOL;
			flush();
		}
		

	sleep(1);

}

}