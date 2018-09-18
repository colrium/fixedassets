<?php
/**
 * Created by PhpStorm.
 * User: thadaninilesh
 * Date: 17/2/15
 * Time: 8:14 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Searchdatabase_model extends CI_Model{

    public function __construct() {
        parent:: __construct();
        $this->load->helper('form');
    }

    public function id_member($member){
        extract($member);
        $memberdata = "SELECT m.member_id, m.first_name, m.middle_name, m.last_name, m.date_of_birth, m.email, m.contact_1, m.contact_2, m.address_building, m.address_street, m.address_city, s.state_name, m.address_pin, m.date_of_joining, m.type, co.college_name, m.company, m.course, m.gender, bg.blood_name, u.university_name, m.year_of_passing, m.designation, m.domain_of_work, m.status, b.branch_name FROM member m INNER JOIN state s ON m.address_state = s.state_id INNER JOIN college co ON m.college = co.college_id INNER JOIN branch b ON m.branch = b.b_id INNER JOIN bloodgroup bg ON m.blood_group = bg.blood_id INNER JOIN university u ON m.university = u.university_id WHERE member_id='$qmember_id'";
        $member_data = $this->db->query($memberdata);
        if($member_data -> num_rows() > 0){
            return $member_data;
        }
        else return FALSE;
    }

    public function advance_search($data){
        extract($data);
        $arr = array();
        if($wmember_id != "") $arr[] = "member_id LIKE '$wmember_id'";
        if($wname != "") $arr[] = "first_name LIKE '%$wname%'";
        if($wgender != "") $arr[] = "gender LIKE '$wgender'";
        if($wcontact != "") $arr[] = "contact_1 LIKE '$wcontact'";
        if($wemail != "") $arr[] = "email LIKE '$wemail'";
        if($waddress_city != "") $arr[] = "address_city LIKE '$waddress_city'";
        if($wcollege != "") $arr[] = "college LIKE '%$wcollege%'";
        if($wblood_group != "") $arr[] = "blood_group LIKE '$wblood_group%'";
        if($wstatus != "") $arr[] = "status LIKE '$wstatus'";
        if($wtype != "") $arr[] = "type LIKE '$wtype'";
        if($wbranch != "") $arr[] = "branch LIKE '$wbranch'";
        if($wuniversity != "") $arr[] = "university LIKE '$wuniversity'";
		if($wcurrent_year != "") $arr[] = "current_year LIKE '$wcurrent_year'";

        $str = implode(" AND ", $arr);
		if($str!=NULL){
                    $sql = "Select * from member WHERE {$str}";
                    $results = $this->db->query($sql);
			//echo $this->db->last_query();
                    if($results -> num_rows() > 0){
			return $results;
                    }
                    else {
                        return FALSE;
                    }
		}
		else{
			$results = "Please enter data to search for!";
			return $results;
		}
    }

	public function bookSearch($bookdata){
		extract($bookdata);
		if($qbookid != "") $arr[] = "book_id LIKE '$qbookid%'";
		if($qtitle != "") $arr[] = "book_name LIKE '%$qtitle%'";
		if($qtype != "") $arr[] = "book_type LIKE '$qtype'";
		if($qtopic != "") $arr[] = "topic_id LIKE '$qtopic'";
		if($qauthor != "") $arr[] = "author_id LIKE '$qauthor'";
		if($qtype != "") $arr[] = "book_type LIKE '$qtype'";
		if($qbranch != "") $arr[] = "branch_id LIKE '$qbranch'";
		if($qdate != "") $arr[] = "purchase_date LIKE '%$qdate%'";
		if($qpublication != "") $arr[] = "publication_id LIKE '$qpublication'";

		$str = implode(" AND ", $arr);
		if($str!=NULL){
			$sql = "Select * from book WHERE {$str}";
			$results = $this->db->query($sql);
			//echo $this->db->last_query();
			if($results -> num_rows() > 0){
				return $results;
			}
			else {
				return FALSE;
			}
		}
		else{
			$results = "Please enter data to search for!";
			return $results;
		}
	}

	public function novelSearch($noveldata){
		extract($noveldata);
		if($qbookid != "") $arr[] = "novel_id = '$qbookid%'";
		if($qtitle != "") $arr[] = "novel_name LIKE '%$qtitle%'";
		if($qauthor != "") $arr[] = "author_id LIKE '$qauthor'";
		if($qtype != "") $arr[] = "book_type LIKE '$qtype'";
		if($qdate != "") $arr[] = "purchase_date LIKE '%$qdate%'";
		if($qpublication != "") $arr[] = "publication_id LIKE '$qpublication'";

		$str = implode(" AND ", $arr);
		if($str!=NULL){
			$sql = "Select * from novel WHERE {$str}";
			$results = $this->db->query($sql);
			//echo $this->db->last_query();
			if($results -> num_rows() > 0){
				return $results;
			}
			else {
				return FALSE;
			}
		}
		else{
			$results = "Please enter data to search for!";
			return $results;
		}
	}

	public function magazineSearch($magazinedata){
		extract($magazinedata);
		if($qbookid != "") $arr[] = "magazine_id = '$qbookid%'";
		if($qtitle != "") $arr[] = "magazine_name LIKE '%$qtitle%'";
		if($qauthor != "") $arr[] = "author_id LIKE '$qauthor'";
		if($qtype != "") $arr[] = "book_type LIKE '$qtype'";
		if($qdate != "") $arr[] = "purchase_date LIKE '%$qdate%'";
		if($qpublication != "") $arr[] = "publication_id LIKE '$qpublication'";

		$str = implode(" AND ", $arr);
		if($str!=NULL){
			$sql = "Select * from magazine WHERE {$str}";
			$results = $this->db->query($sql);
			//echo $this->db->last_query();
			if($results -> num_rows() > 0){
				return $results;
			}
			else {
				return FALSE;
			}
		}
		else{
			$results = "Please enter data to search for!";
			return $results;
		}
	}
}