<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

	class fee_model extends CI_Model {
		public function __construct() {
			parent:: __construct();
			$this->load->helper('form');
		}


		public function checkFee($id){
			extract($id);
			$sql = "SELECT amount FROM fee WHERE member_id='$member_id'";
			$query = $this->db->query($sql);
			if($query->num_rows()>0){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}

		public function newMembers(){
			$sql = "SELECT m.member_id,m.first_name,m.middle_name,m.last_name,m.date_of_joining FROM member m INNER JOIN fee f ON m.member_id != f.member_id WHERE m.status='1'";
			$query = $this->db->query($sql);
			if($query->num_rows()>0){
				foreach($query->result_array() as $top){
				extract($top);
				echo "<option value='".$member_id."'>".$first_name."</option>";
			}
			}
			else{
				echo "<option disabled>No new Member :(</option>";
			}
		}

		public function expiredFeeMembers(){
			$sql = "SELECT m.member_id,m.first_name, m.middle_name, m.last_name, f.start_date, f.end_date FROM member m INNER JOIN fee f ON m.member_id = f.member_id WHERE f.end_date <= CURDATE() AND m.status='1'";
			$query = $this->db->query($sql);
			if($query->num_rows()>0){
				foreach($query->result_array() as $top){
				extract($top);
				echo "<option value='".$member_id."'>".$first_name."</option>";
			}
			}
			else{
				echo "<option disabled>No pending fees due</option>";
			}
		}

		public function updateFee($feeData){
			extract($feeData);
			$sql = "INSERT INTO fee_history SELECT id,member_id,amount,start_date,end_date,period,booklet,receipt FROM fee WHERE member_id='$memberId' AND history!='1'";
			$query = $this->db->query($sql);
			if($query){
				$sql = "UPDATE fee SET history='1' WHERE member_id='$memberId'";
				$query = $this->db->query($sql);
				if($query){
					$sql = "INSERT INTO fee(member_id,amount,start_date,end_date,period,booklet,receipt) VALUES(?,?,?,?,?,?,?)";
					$query = $this->db->query($sql,array($memberId,$amount,$date,date('y-m-d',strtotime("+".$period." months -1 day",strtotime($date))),$period,$booklet,$receipt));
					//echo $this->db->last_query();
					if($query){
						return "success";
					}
					else{
						return "failure";
					}
					
				}
				else{
					return "failure";
				}
			}
			else{
				return "failure";
			}

		}

		public function viewActiveFee(){
			$sql = "SELECT m.member_id, m.first_name, m.last_name, m.contact_1, m.email, f.start_date, f.end_date, f.amount FROM member m INNER JOIN fee f on m.member_id=f.member_id WHERE end_date>=CURDATE() AND m.status='1'";
			$query = $this->db->query($sql);
			if($query->num_rows()>0){
				return $query;
			}
			else{
				return "No records found";
			}
		}

		public function viewDeadFee(){
			$sql = "SELECT m.member_id, m.first_name, m.last_name, m.contact_1, m.email, f.start_date, f.end_date, f.amount FROM member m INNER JOIN fee_history f on m.member_id=f.member_id WHERE end_date<CURDATE() AND m.status='1'";
			$query = $this->db->query($sql);
			if($query->num_rows()>0){
				return $query;
			}
			else{
				return "No records found";
			}
		}
	}
