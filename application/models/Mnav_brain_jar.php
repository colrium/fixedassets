<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Mnav_brain_jar extends CI_Model{

	 function __construct(){
			parent::__construct();
		 
	 }

	public function navData($module=""){
		$CI = & get_instance();
		$modules = $CI->config->item('fortmodules');
		$modulesicons = $CI->config->item('fortmodulesicons');
		$modulesanchorprefixes = $CI->config->item('modulesanchorprefixes');

		$modnav = '';
		
		if (array_key_exists($module, $modules)) {
			# code...
		}



		if ($module=="" || $module=="modules" || $module=="system") {
				$this->load->helper('modules/modulesnav');
				$modnav = modulesnav();
		}
		else if (array_key_exists($module, $modules) && array_key_exists($module, $modulesanchorprefixes)) {
				$this->load->helper($modulesanchorprefixes[$module].'nav');
				if (function_exists('modulenav')){
					$modnav = modulenav();
				}
				
		}
		else{
				$this->load->helper('modules/modulesnav');
				$modnav = modulesnav();
			
		}
	 return $modnav;
		
	}


}