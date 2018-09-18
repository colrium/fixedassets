<!DOCTYPE HTML>
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member_model extends CI_Model {

    public function __construct() {
        parent:: __construct();
        $this->load->helper('form');
    }

    public function add_member($add_member) {
        extract($add_member);
		if(($qfirst_name!=null) && ($qmiddle_name!=null) && ($qlast_name!=null) && ($qemail!=null) &&($qcontact_1) && ($qgender!=null) && ($qdate_of_birth!=null) && ($qaddress_building!=null) && ($qaddress_street!=null) && ($qaddress_city!=null) && ($qaddress_state!=null) && ($qaddress_pin!=null) && ($qyear_of_passing!=null) && ($qtype!=null)){
			$add = "INSERT into member(first_name, middle_name, last_name, date_of_birth, email, contact_1, contact_2, address_building, address_street, address_city, address_state, address_pin, type, college, company, course, current_year, gender, blood_group, university, year_of_passing, designation, domain_of_work, status, branch) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$addmember = $this->db->query($add, array($qfirst_name, $qmiddle_name, $qlast_name, $qdate_of_birth, $qemail, $qcontact_1, $qcontact_2, $qaddress_building, $qaddress_street, $qaddress_city, $qaddress_state, $qaddress_pin, $qtype, $qcollege, $qcompany, $qcourse, $qcurrent_year, $qgender, $qblood_group, $quniversity, $qyear_of_passing, $qdesignation, $qdomain_of_work, '0', $qbranch));
			$insert_id = $this->db->insert_id();
		}
		if($addmember){
			return $insert_id;
		}
		else{
			return FALSE;
		}
    }

	public function fetch_last_id(){
		$lastid = "SELECT member_id, first_name, last_name FROM member ORDER BY member_id DESC LIMIT 1";
		$last_id = $this->db->query($lastid);
		return $last_id;
	}

    public function view_member(){
        $data = "SELECT member_id, first_name, middle_name, last_name, contact_1, contact_2, email, address_building, address_street, address_city, address_pin, blood_group, type, status FROM member WHERE status='1'";
        $viewdata = $this->db->query($data);
        return $viewdata;
     }

    public function display_member($id){
        $edit = "SELECT * FROM member WHERE member_id = '$id'";
        $edituser = $this->db->query($edit);
        return $edituser;
    }

    public function update_member($update_member){
        extract($update_member);
        $sql =  "UPDATE member SET first_name='$wfirst_name',middle_name='$wmiddle_name',last_name='$wlast_name',date_of_birth='$wdate_of_birth',email='$wemail',contact_1='$wcontact_1',contact_2='$wcontact_2',address_building='$waddress_building', address_street='$waddress_street', address_city='$waddress_city', address_state='$waddress_state', address_pin='$waddress_pin', college='$wcollege', company='$wcompany', course='$wcourse',current_year='$wcurrent_year', gender='$wgender', blood_group='$wblood_group', university='$wuniversity', year_of_passing='$wyear_of_passing', designation='$wdesignation', domain_of_work='$wdomain_of_work', status='$wstatus', branch='$wbranch', type='$wtype' WHERE member_id='$wmember_id'";
       $update = $this->db->query($sql);
		if($update){
			return TRUE;
		}else{
			return FALSE;
		}
    }

	public function college(){
		$query = "SELECT * FROM college";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function branch(){
		$query = "SELECT * FROM branch";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function university(){
		$query = "SELECT * FROM university";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function bloodGroup(){
		$query = "SELECT * FROM bloodgroup";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function state(){
		$query = "SELECT * FROM state";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function status(){
		$query = "SELECT * FROM status";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function viewMemberDetails($memberId){
		extract($memberId);
		$sql = "SELECT m.member_id, m.first_name, m.middle_name, m.last_name, m.date_of_joining, m.gender, m.status, d.amount, d.date, d.booklet, d.receipt FROM member m INNER JOIN deposit d ON d.member_id = m.member_id WHERE m.member_id='$member_id'";
		$details = $this->db->query($sql);
		foreach ($details->result() as $row){
			//temporary check to see if member details are retrieved from db
			$name = $row->first_name;
		}
		if(isset($name) && $name!=''){
			return $details;
		}else{
			return FALSE;
		}
	}

	public function deleteMember($memberId){
		extract($memberId);
		$sql = "UPDATE member SET status='0' WHERE member_id='$member_id'";
		$delete = $this->db->query($sql);
		$sql = "UPDATE deposit SET returned='1',return_date=CURDATE() WHERE member_id='$member_id'";
		$deleteDeposit = $this->db->query($sql);
		if($delete && $deleteDeposit){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function addDeposit($depositDetails){
		extract($depositDetails);
		$sql = "INSERT INTO deposit(member_id,date,amount,booklet,receipt) VALUES(?,?,?,?,?)";
		$query = $this->db->query($sql,array($member_id,$date,$amount,$booklet,$receipt));
		$sql = "UPDATE member SET status='1' WHERE member_id='$member_id'";
		$mem = $this->db->query($sql);
		if($query && $mem){
			return TRUE;
		}
		else
			return FALSE;
	}
}