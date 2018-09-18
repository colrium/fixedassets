<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Msms extends CI_Model{
 
 public function __construct()
        {
                parent::__construct();
        }

	 public function getPhones(){
	 $sqlStr =
	        "SELECT
	            pe_lKeyID,pe_strCell,pe_strTitle,pe_strFName,pe_strLName
	         FROM ngo_donors
	         WHERE NOT pe_bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }



	  public function getSetting(){
	 $sqlStr =
	        "SELECT
	            *
	         FROM ngo_sms_settings
	         WHERE setting_id=1;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }


	 
 public function getNames($email_address){
	 $sqlStr =
	        "SELECT
	            pe_strTitle,pe_strFName,pe_strLName
	         FROM ngo_donors
	         WHERE NOT pe_bRetired AND pe_strEmail=$email_address;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

 public function saveSettings(){
 		$data=array(
			'url'=>$this->input->post('url', TRUE),
			'user_name'=>$this->input->post('user_name', TRUE),
			'password'=>$this->input->post('password', TRUE)			
			);
			$id=1;
		$this->db->where('setting_id', $id);
		$this->db->update('ngo_sms_settings', $data);
		return true;

  }

}
?>