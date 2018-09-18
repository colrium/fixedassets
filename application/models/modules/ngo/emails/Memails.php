<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Memails extends CI_Model{

 public function __construct()
        {
                parent::__construct();
        }

	 public function getEmails(){
	 $sqlStr =
	        "SELECT
	            pe_lKeyID,pe_strEmail,pe_strTitle,pe_strFName,pe_strLName
	         FROM ngo_donors
	         WHERE NOT pe_bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function getPersonEmails($id){
	 $sqlStr =
	        "SELECT
	            pe_lKeyID,pe_strEmail,pe_strTitle,pe_strFName,pe_strLName
	         FROM ngo_donors
	         WHERE NOT pe_bRetired AND pe_lKeyID=".strPrepStr($id).";";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function getGroups(){
	 $sqlStr =
	        "SELECT *    FROM ngo_groups_parent;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function getGroupsChildren($groupId){
	 $sqlStr =
	        "SELECT *    FROM ngo_groups_child WHERE gc_lGroupID=".strPrepStr($groupId).";";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function getTemplates(){
	 $sqlStr ="SELECT * FROM ngo_email_templates;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }


	 public function getTemplatesViaId($template_id){
	 	$sqlStr ="SELECT * FROM ngo_email_templates WHERE template_id=".strPrepStr($template_id).";";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function getThankyouTemplate(){
	 	$sqlStr ="SELECT message FROM ngo_email_templates WHERE template_id=1;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }
	 public function getRemindTemplate(){
	 	$sqlStr ="SELECT message FROM ngo_email_templates WHERE template_id=2;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }
	 
 public function getNames($email_address){
	 $sqlStr =
	        "SELECT
	            pe_strTitle,pe_strFName,pe_strLName
	         FROM ngo_donors
	         WHERE NOT pe_bRetired AND pe_strEmail=".strPrepStr($email_address).";";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }
 public function getDetails($lFID){
 	$sqlStr =
	        "SELECT
	            pe_lKeyID,pe_strEmail,pe_strTitle,pe_strFName,pe_strLName
	         FROM ngo_donors
	         WHERE pe_lKeyID = ".strPrepStr($lFID).";";
	      $query = $this->db->query($sqlStr);
	 return $query->result();


 }

 public function getDetailsFromEmail($emailAddr){
 	$sqlStr =
	        "SELECT
	            pe_lKeyID,pe_strEmail,pe_strTitle,pe_strFName,pe_strLName
	         FROM ngo_donors
	         WHERE pe_strEmail = ".strPrepStr($emailAddr).";";
	      $query = $this->db->query($sqlStr);
	 return $query->result();


 }

 //Outgoing email settings
	public function getOutgoingSettings(){
 	$sqlStr =
	        "SELECT * FROM ngo_outgoing_mail_settings;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

 	}


 //Incoming email settings
 public function getIncomingSettings(){
 	$sqlStr =
	        "SELECT * FROM ngo_incoming_mail_settings;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

  }
  public function saveIncomingSettings(){
 	$data=array(
			'email_address'=>$this->input->post('email_address', TRUE),
			'password'=>$this->input->post('password', TRUE),
			'host'=>$this->input->post('host', TRUE),
			'port'=>$this->input->post('port', TRUE),
			'service_flag'=>$this->input->post('service_flag', TRUE)
			);
			$id=1;
		$this->db->where('setting_id', $id);
		$this->db->update('incoming_mail_settings', $data);
		

		return true;

  }

  public function saveSentEmail($insertData){
 	$this->db->insert('sentemails', $insertData);
    return true;

  }
  

  public function checkSave($i, $login){
  	$sqlStr =
	        "SELECT * FROM ngo_emails WHERE email_no=".strPrepStr()."$i AND forAccount=".strPrepStr($login).";";
	      $query = $this->db->query($sqlStr);
	     $numRows = $query->num_rows();
	     if ($numRows>=1){
	    	 return true;	
	    }
	    else{
	    	return false;
	    }
	   }

  public function saveNewEmail($data=array()){
  	
    $this->db->insert('ngo_emails', $data);
    return true;
    

  }

  public function markRead($emailNo, $ac){
  	$sqlStr ="UPDATE ngo_emails SET isRead=1 WHERE forAccount=".strPrepStr($ac)." AND email_no=".strPrepStr($emailNo).";";
  	$query = $this->db->query($sqlStr);
 
      return true;
  }

  public function getSavedEmails($user_id, $login){
  	$sqlStr ="SELECT * FROM ngo_emails WHERE user_id=".strPrepStr($user_id)." AND forAccount=".strPrepStr($login)." AND NOT bRetired ORDER BY email_no ASC;";
	$query = $this->db->query($sqlStr);
    return ($query->result());
  }

  public function getSentEmails(){
  	$sqlStr ="SELECT 
				`ngo_sentemails`.`id` AS id,
				`ngo_sentemails`.`toAddress` AS toAddress,
				`ngo_sentemails`.`emailSubject` AS emailSubject,
				`ngo_sentemails`.`body` AS body,
				`ngo_sentemails`.`fromAddress` AS fromAddress,
				`ngo_sentemails`.`sentOn` AS sentOn,
				`ngo_sentemails`.`sentBy` AS sentBy,
				`users`.`last_name` AS userLName,
				`users`.`first_name` AS userFName


				FROM 
					`ngo_sentemails` AS `ngo_sentemails`,
					`users` AS `users`

				WHERE 
				 	`users`.`id` = `ngo_sentemails`.`sentBy`

				ORDER BY `ngo_sentemails`.`id` DESC;";
	$query = $this->db->query($sqlStr);
    return ($query->result());
  }

  public function getSentEmail($id){
  	$sqlStr ="SELECT 
				`ngo_sentemails`.`id` AS id,
				`ngo_sentemails`.`toAddress` AS toAddress,
				`ngo_sentemails`.`emailSubject` AS emailSubject,
				`ngo_sentemails`.`body` AS body,
				`ngo_sentemails`.`fromAddress` AS fromAddress,
				`ngo_sentemails`.`sentOn` AS sentOn,
				`ngo_sentemails`.`sentBy` AS sentBy,
				`users`.`last_name` AS userLName,
				`users`.`first_name` AS userFName


				FROM 
					`ngo_sentemails` AS `ngo_sentemails`,
					`users` AS `users`

				WHERE 
				 	`users`.`id` = `sentemails`.`sentBy`
				AND 
					`ngo_sentemails`.`id` = ".strPrepStr($id)."

				ORDER BY `ngo_sentemails`.`id` DESC;";
	$query = $this->db->query($sqlStr);
    return ($query->result());
  }


 public function getSavedEmail($id){
  	$sqlStr ="SELECT * FROM ngo_emails WHERE id=".strPrepStr($id).";";
	$query = $this->db->query($sqlStr);
    return ($query->result());
  }
 public function getSavedEmailBody($user_id, $login, $email_no){
 	$sqlStr ="SELECT * FROM ngo_emails WHERE user_id=".strPrepStr($user_id)." AND forAccount=".strPrepStr($login)." AND email_no=".strPrepStr($email_no)." AND NOT bRetired ORDER BY email_no DESC;";
	$query = $this->db->query($sqlStr);
    return ($query->result());


	 	
	 }

	public function SaveEmailBody($body, $login, $email_no){

	$sqlStr ="UPDATE  ngo_emails SET body=".strPrepStr($body)." WHERE forAccount=".strPrepStr($login)." AND email_no=".strPrepStr($email_no).";";
	$query = $this->db->query($sqlStr);
    return true;


	}
  public function autoresponder(){
  	$sqlStr ="SELECT * FROM ngo_email_autoresponder;";
	$query = $this->db->query($sqlStr);
    return ($query->result());
  }

  public function updateautoresponder(){
  	$data=array(
			'subject'=>$this->input->post('subject', TRUE),
			'message'=>$this->input->post('message', TRUE)			
			);
			$id=1;
		$this->db->where('id', $id);
		$this->db->update('ngo_email_autoresponder', $data);

		return true;
  }

  public function getTotSavedEmails($user_id){
  	$sqlStr ="SELECT COUNT(*) AS lNumRecs FROM ngo_emails WHERE user_id=".strPrepStr($user_id)." AND NOT bRetired;";
	$query = $this->db->query($sqlStr);
      $row = $query->row();
      return((integer)$row->lNumRecs);
  }
  public function saveOutgoingSettings(){
 		$data=array(
			'smtp_user'=>$this->input->post('smtp_user', TRUE),
			'smtp_pass'=>$this->input->post('smtp_pass', TRUE),
			'smtp_host'=>$this->input->post('smtp_host', TRUE),
			'smtp_port'=>$this->input->post('smtp_port', TRUE),
			'body_image'=>$this->input->post('body_image', TRUE),
			'footer_image'=>$this->input->post('footer_image', TRUE),
			'header_image'=>$this->input->post('header_image', TRUE),
			'signature'=>$this->input->post('signature', TRUE)
			
			);
			$id=1;
		$this->db->where('setting_id', $id);
		$this->db->update('ngo_outgoing_mail_settings', $data);

		return true;

  }
}
