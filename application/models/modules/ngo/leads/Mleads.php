<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mleads extends CI_Model{

 public function __construct()
        {
                parent::__construct();
        }

    public function loadAll(){
	 $sqlStr =
	        "SELECT				
					`ngo_leads`.`lead_id` AS `lead_id`,
					`ngo_leads`.`title` AS `title`,
					`ngo_leads`.`first_name` AS `first_name`,
					`ngo_leads`.`last_name` AS `last_name`,
					`ngo_leads`.`middle_name` AS `middle_name`,
					`ngo_leads`.`mobile` AS `mobile`,
					`ngo_leads`.`email` AS `email`,
					`ngo_leads`.`website` AS `website`,
					`ngo_leads`.`gender` AS `gender`,
					`ngo_leads`.`notes` AS `notes`,
					`ngo_leads`.`category` AS `category`,
					`ngo_leads`.`lead_stage` AS `stage`,
					`ngo_leads`.`lead_priority` AS `priority`,
					`ngo_leads`.`lead_group` AS `group`,
					`ngo_leads`.`lead_source` AS `source`,
					`ngo_leads`.`assignedTo` AS `assUser`,
					`ngo_leads`.`dte_created` AS `dte_created`,
					`ngo_leads`.`dte_modified` AS `dte_modified`
									
				FROM
					`ngo_leads` AS `ngo_leads`
					

                                       
									
				WHERE  `ngo_leads`.`bRetired` = ?;";
	      $query = $this->db->query($sqlStr, array(0));
	 return $query->result();
	 }
    

    public function assignedTo(){
	 $sqlStr =
	        "SELECT
	            *
	         FROM users
	         WHERE NOT active;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function loadLeadUser($recId=0){
	 	$sqlStr =
	        "SELECT
	            *
	         FROM users
	         WHERE NOT active AND id=$recId;";
	      $query = $this->db->query($sqlStr);
	 	foreach ($query->result() as $record) {
	      	return $record->username;
	      }
	 }

	 public function leadSource(){
	 $sqlStr =
	        "SELECT
	            *
	         FROM ngo_lead_sources
	         WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function loadLeadSource($recId=0){
	 	$sqlStr =
	        "SELECT *
	         FROM ngo_lead_sources
	         WHERE NOT bRetired AND id=$recId;";
	      $query = $this->db->query($sqlStr);
	 	foreach ($query->result() as $record) {
	      	return $record->source_name;
	      }
	 }

	  public function leadStage(){
	 $sqlStr =
	        "SELECT
	            *
	         FROM ngo_lead_stages
	         WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function leadGroup(){
	 $sqlStr =
	        "SELECT
	            *
	         FROM ngo_leadgroups
	         WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function loadLeadStage($recId=0){
	 	$sqlStr =
	        "SELECT *
	         FROM ngo_lead_stages
	         WHERE NOT bRetired AND id=$recId;";
	      $query = $this->db->query($sqlStr);
	 	foreach ($query->result() as $record) {
	      	return $record->stage_name;
	      }
	 }

	 public function leadPriority(){
	 $sqlStr =
	        "SELECT
	            *
	         FROM ngo_lead_priorities
	         WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	 }

	 public function loadLeadPriority($recId=0){
	 	$sqlStr =
	        "SELECT *
	         FROM ngo_lead_priorities
	         WHERE NOT bRetired AND id=$recId;";
	      $query = $this->db->query($sqlStr);

	      foreach ($query->result() as $record) {
	      	return $record->priority_name;
	      }
	 }

	 public function loadLeadGroup($recId=0){
	 	$sqlStr =
	        "SELECT *
	         FROM ngo_leadgroups
	         WHERE NOT bRetired AND id=$recId;";
	      $query = $this->db->query($sqlStr);

	      foreach ($query->result() as $record) {
	      	return $record->groupName;
	      }
	 }

	 public function saveLead(){
	 	$title = $this->input->post('title', TRUE);
		$first_name = $this->input->post('first_name', TRUE);
		$middle_name = $this->input->post('middle_name', TRUE);
		$last_name = $this->input->post('last_name', TRUE);
		$mobile = $this->input->post('mobile', TRUE);
		$email = $this->input->post('email', TRUE);
		$website = $this->input->post('website', TRUE);
		$gender = $this->input->post('gender', TRUE);
		$notes = $this->input->post('notes', TRUE);
		$assigneTo = $this->input->post('assignedTo', TRUE);
		$lead_source = $this->input->post('lead_source', TRUE);
		$lead_stage = $this->input->post('lead_stage', TRUE);
		$lead_group = $this->input->post('lead_group', TRUE);
		$lead_priority = $this->input->post('lead_priority', TRUE);
		$category = $this->input->post('lead_stage', TRUE);
		$created_by = htmlspecialchars(@$_SESSION[CS_NAMESPACE.'user']->lUserID);
		
	 $sqlStr =
	        "INSERT INTO ngo_leads
	         SET 
	         	title=".$this->db->escape($title).",
	         	first_name=".$this->db->escape($first_name).",
	         	middle_name=".$this->db->escape($middle_name).",
	         	last_name=".$this->db->escape($last_name).",
	         	mobile=".$this->db->escape($mobile).",
	         	email=".$this->db->escape($email).",
	         	website=".$this->db->escape($website).", 
	         	gender=".$this->db->escape($gender).",
	         	notes=".$this->db->escape($notes).",
	         	assignedTo=".$this->db->escape($assigneTo).",
	         	lead_source=".$this->db->escape($lead_source).",
	         	lead_stage =".$this->db->escape($lead_stage).",
	         	lead_group =".$this->db->escape($lead_group).",
	         	lead_priority=".$this->db->escape($lead_priority).",
	         	category=".$this->db->escape($category).",
	         	created_by=".$this->db->escape($created_by).",
	         	dte_created=NOW()
	         ;";
	      $query = $this->db->query($sqlStr);
	 return $this->db->insert_id();
	 }

	 public function updateLead($id){
	 $title = $this->input->post('title', TRUE);
		$first_name = $this->input->post('first_name', TRUE);
		$middle_name = $this->input->post('middle_name', TRUE);
		$last_name = $this->input->post('last_name', TRUE);
		$mobile = $this->input->post('mobile', TRUE);
		$email = $this->input->post('email', TRUE);
		$website = $this->input->post('website', TRUE);
		$gender = $this->input->post('gender', TRUE);
		$notes = $this->input->post('notes', TRUE);
		$assigneTo = $this->input->post('assignedTo', TRUE);
		$lead_source = $this->input->post('lead_source', TRUE);
		$lead_stage = $this->input->post('lead_stage', TRUE);
		$lead_group = $this->input->post('lead_group', TRUE);
		$lead_priority = $this->input->post('lead_priority', TRUE);
		$category = $this->input->post('lead_stage', TRUE);
		$modified_by = htmlspecialchars(@$_SESSION[CS_NAMESPACE.'user']->lUserID);
		
	 $sqlStr =
	        "UPDATE ngo_leads
	         SET 
	         	title=".$this->db->escape($title).",
	         	first_name=".$this->db->escape($first_name).",
	         	middle_name=".$this->db->escape($middle_name).",
	         	last_name=".$this->db->escape($last_name).",
	         	mobile=".$this->db->escape($mobile).",
	         	email=".$this->db->escape($email).",
	         	website=".$this->db->escape($website).", 
	         	gender=".$this->db->escape($gender).",
	         	notes=".$this->db->escape($notes).",
	         	assignedTo=".$this->db->escape($assigneTo).",
	         	lead_source=".$this->db->escape($lead_source).",
	         	lead_stage =".$this->db->escape($lead_stage).",
	         	lead_group =".$this->db->escape($lead_group).",
	         	lead_priority=".$this->db->escape($lead_priority).",
	         	category=".$this->db->escape($category).",
	         	modified_by=".$this->db->escape($modified_by).",
	         	dte_modified=NOW()
	         WHERE lead_id=$id
	         ;";
	      $query = $this->db->query($sqlStr);
	 return true;	




	 }

	 public function loadLead($id){
	 	$sqlStr =
	        "SELECT				
					`ngo_leads`.`lead_id` AS `lead_id`,
					`ngo_leads`.`title` AS `title`,
					`ngo_leads`.`first_name` AS `first_name`,
					`ngo_leads`.`last_name` AS `last_name`,
					`ngo_leads`.`middle_name` AS `middle_name`,
					`ngo_leads`.`mobile` AS `mobile`,
					`ngo_leads`.`lead_stage` AS `stage`,
					`ngo_leads`.`lead_priority` AS `priority`,
					`ngo_leads`.`lead_source` AS `source`,
					`ngo_leads`.`lead_group` AS `group`,
					`ngo_leads`.`assignedTo` AS `assUser`,
					`ngo_leads`.`email` AS `email`,
					`ngo_leads`.`website` AS `website`,
					`ngo_leads`.`gender` AS `gender`,
					`ngo_leads`.`notes` AS `notes`,
					`ngo_leads`.`category` AS `category`,
					`ngo_leads`.`dte_created` AS `dte_created`,
					`ngo_leads`.`dte_modified` AS `dte_modified`

				FROM
					`ngo_leads` AS `ngo_leads`                                     
									
				WHERE `ngo_leads`.`lead_id` = $id LIMIT 0,1;";
	      $query = $this->db->query($sqlStr);
	 	return $query->result();




	 }



	 public function createdBy($id){
	 	$sqlStr =
	        "SELECT				
					`ngo_leads`.`dte_created` AS `dte_created`,
					`users`.`last_name` AS `createdByLname`,
					`users`.`first_name` AS `createdByFname`

				FROM
					`ngo_leads` AS `ngo_leads`,
					`users` AS `users`
		
				WHERE

                 	 `ngo_leads`.`created_by` = `users`.`id`
					AND NOT `ngo_leads`.`bRetired` 
				 AND `ngo_leads`.`lead_id`=$id;";
	      $query = $this->db->query($sqlStr);
	 	return $query->result();
	 }

	 public function modifiedBy($id){
	 	$sqlStr =
	        "SELECT				
					`ngo_leads`.`dte_modified` AS `dte_modified`,
					`users`.`last_name` AS `modifiedByLname`,
					`users`.`first_name` AS `modifiedByFname`

				FROM
					`ngo_leads` AS `ngo_leads`,
					`users` AS `users`

				WHERE

                 	 `ngo_leads`.`created_by` = `users`.`id`
					AND NOT `ngo_leads`.`bRetired` 
				 AND `ngo_leads`.`lead_id`=$id;";
	      $query = $this->db->query($sqlStr);
	 	return $query->result();

	 	
	 }
	public function deleteLead($id){
		$glUserID = USERID;

		$sqlStr =
	        "UPDATE ngo_leads
	         SET 
	         bRetired=1
	         WHERE lead_id=".$this->db->escape($id).";";
	    $query = $this->db->query($sqlStr);
	    $sqlRec =
	        "INSERT INTO ngo_recycle_bin
	         SET 
	         rb_lGroupID=0,
	         rb_lForeignID=".$this->db->escape($id).",
	         rb_enumRecycleType = 'lead',
	         rb_strDescription = 'Retired Lead $id',
	         rb_strTable = 'leads',
	         rb_strKeyIDFN = 'lead_id',
	         rb_strRetireFN = 'bRetired',
	         rb_lOriginID=$glUserID,
	         rb_dteOrigin=NOW();";
	    $this->db->query($sqlRec);
	 	return true;


	}

	public function addActivity($leadID){
		$subject = $this->input->post('subject', TRUE);
		$start_date = $this->input->post('start_date', TRUE);
		$start_time = $this->input->post('start_time', TRUE);
		$end_date = $this->input->post('end_date', TRUE);
		$end_time = $this->input->post('end_time', TRUE);
		$activity = $this->input->post('activity', TRUE);
		$status = $this->input->post('status', TRUE);
		$sqlStr =
	        "INSERT INTO ngo_lead_activities
	         SET 
	         subject='$subject',
	         lead_id= $leadID,
	         start_date= '$start_date',
	         start_time= '$start_time',
	         end_date='$end_date',
	         end_time='$end_time',
	         activity='$activity',
	         status='$status';";

	    $query = $this->db->query($sqlStr);
	 	return true;



	}
	public function loadActivities($id){
		
		$sqlStr = "SELECT * FROM ngo_lead_activities WHERE NOT bRetired AND lead_id=$id;";
		$query = $this->db->query($sqlStr);
	 	return $query->result();


	}

	public function deleteActivity($id){
		$sqlStr = "UPDATE ngo_lead_activities SET bRetired=1 WHERE id=$id;";
		$query = $this->db->query($sqlStr);
	 	return true;

	}

	public function loadActivity($id){
		$sqlStr = "SELECT * FROM ngo_lead_activities WHERE NOT bRetired AND id=$id;";
		$query = $this->db->query($sqlStr);
	 	return $query->result();



	}

	public function insert_csv($data){

		$this->db->insert('lngo_eads', $data);
		return true;
	}

	public function insertTopeople($data){
		$this->db->insert('ngo_donors', $data);
		$peopleID = $this->db->insert_id();
		$data2 = array(
                'pe_lHouseholdID'=>$peopleID
            );
            $this->db->where('pe_lKeyID', $peopleID);
            $this->db->update('ngo_donors', $data2);
		return $peopleID;


	}




}
?>