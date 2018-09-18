<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifacations{

	public function __construct(){
   
	}


public function __get($var){
    return get_instance()->$var;
  }

public function usernotifacations(){
   $notifacations = array();
   return $notifacations;
   
}

public function desktopnotifacation($notifacation){

	

}





}