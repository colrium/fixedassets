<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verauth{

function __construct(){ 
	$this->load->config('cogs', TRUE); 
	$this->load->model('mstart', 'clsStrt'); 		
}


public function __get($var){
    return get_instance()->$var;
  }


public function organisation(){

	$orgName = $this->config->item('auth_org', 'cogs');
	if (!isset($orgName) && empty($orgName)) {
		$orgName = 'Fort Technologies. Copyright 2016';
	}
	return $orgName;
}

public function configLogkeys(){
	$verKeys = $this->config->item('log_keys', 'cogs');
	if (!isset($verKeys) && empty($verKeys)) {
		$verKeys = 1;
	}
	return $verKeys;
}

public function noOfdbLogKeys(){
		$verKeys = $this->config->item('log_keys', 'cogs');
		$total = $this->clsStrt->noOfdbLogKeys();
		return $total;
}

public function probeLogKeys(){
	if ($this->noOfdbLogKeys() > $this->configLogkeys()) {
		$this->clsStrt->probeLogKeys($this->configLogkeys());
	}
}

public function isLogKeysExceeded(){
	if ($this->noOfdbLogKeys() >= $this->configLogkeys()) {
		$this->probeLogKeys();
		return true;		
	}
	else{

		return false;
	}
}













}