<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*---------------------------------------------------------------------
FORT TECHNOLOGIES SYSTEM
Developed By Mutugi Riungu 2016
NO ALTERATIONS OR CODE REUSE IS AUTHORIZED     
---------------------------------------------------------------------*/
class Reminders{

	public function __construct(){
	    isloggedin(TRUE);
	}


  public function __get($var){
    return get_instance()->$var;
  }


  public function addEditReminder($details){

  }


























 }