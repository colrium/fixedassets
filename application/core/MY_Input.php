<?php
class MY_Input extends CI_Input {

    function __construct()
    {
        parent::__construct();
    }
    //Overide ip_address() with your own function
    function ip_address() 
    {
        //Obtain the IP address however you'd like, you may want to do additional validation, etc..
        $correct_ip_address = $_SERVER['HTTP_X_CLIENT_IP'];
        if (!isset($correct_ip_address) && empty($correct_ip_address)) {
              $correct_ip_address  = '0.0.0.0';
          }  
        return $correct_ip_address;
    }
}