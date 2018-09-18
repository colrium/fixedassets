<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*---------------------------------------------------------------------
FORT TECHNOLOGIES SYSTEM
Developed By Mutugi Riungu 2016  
---------------------------------------------------------------------*/
class SysExeption extends Exception{

	const THROW_NONE    = 0;
    const THROW_NONEXITENTRECORD  = 1010;
    const THROW_DEFAULT = 2;

	// Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }


  public function __get($var){
    return get_instance()->$var;
  }






















 }
