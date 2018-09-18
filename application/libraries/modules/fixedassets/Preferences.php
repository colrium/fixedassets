<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Preferences {
	public $currency, $defaultdepreciationmethod, $dateformat, $systempreferences, $userpreferences;

	public function __construct(){
		$this->initialize();
	}


	public function __get($var){
	    return get_instance()->$var;
	}

	private function initialize(){
		
		$this->currency = 'KES';
		$this->defaultdepreciationmethod = 1;
	}


	public function systempreferences(){
		$params = array();
		$params['where']['equalto'] = array('id'=>'1');
		$preferences = dbtablerecords('fixedassets_preferences', $params, FALSE);

		if (is_array($preferences)) {
			$this->systempreferences = $preferences[0];
		}

	}

	public function userpreferences($userid=FALSE){
		$params = array();
		$params['where']['equalto'] = array('id'=>'1');
		$preferences = dbtablerecords('fixedassets_preferences', $params, FALSE);

	}




















}


?>