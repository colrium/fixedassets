<?php
/**
 * Created by PhpStorm.
 * User: thadaninilesh
 * Date: 21/6/15
 * Time: 10:43 PM
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Book_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
		$this->load->helper('form');
	}

	public function get_branch(){
		$query = "SELECT * FROM branch";
		$branch = $this->db->query($query);
		if($branch){
			return $branch;
		}
	}

	public function get_topic(){
		$query = "SELECT * FROM topic";
		$branch = $this->db->query($query);
		if($branch){
			return $branch;
		}
	}
	public function get_author(){
		$query = "SELECT * FROM author";
		$branch = $this->db->query($query);
		if($branch){
			return $branch;
		}
	}

	public function getTopic($id){
		$query = "SELECT * FROM topic WHERE branch_id='$id'";
		$topic = $this->db->query($query);
		//echo $this->db->last_query();
		if($topic){
			foreach($topic->result_array() as $top){
				extract($top);
				echo "<option value='".$topic_id."'>".$topic_name."</option>";
			}
		}
	}

	public function getAuthor($data){
		$query = "SELECT * FROM author WHERE topic_id='$data'";
		$author = $this->db->query($query);
		if($author){
			foreach($author->result_array() as $auth){
				extract($auth);
				echo "<option value='".$author_id."'>".$author_name."</option>";
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function get_publication(){
		$query = "SELECT * FROM publication";
		$publication = $this->db->query($query);
		if($publication)
			return $publication;
	}

	/**
	 * @return mixed
	 */
	public function fetch_last_id(){
		$lastid = "SELECT book_id, book_name FROM book ORDER BY bk_id DESC LIMIT 1";
		$last_id = $this->db->query($lastid);
		return $last_id;
	}

	public function fetch_last_id_novel(){
		$lastid = "SELECT novel_id, novel_name FROM novel ORDER BY id DESC LIMIT 1";
		$last_id = $this->db->query($lastid);
		return $last_id;
	}

	public function fetch_last_id_magazine(){
		$lastid = "SELECT magazine_id, magazine_name FROM magazine ORDER BY id DESC LIMIT 1";
		$last_id = $this->db->query($lastid);
		return $last_id;
	}

	/**
	 * @param $bookdata
	 * @return bool|string
	 */
	public function add_book($bookdata){
		extract($bookdata);
		if(($qtype!=null) && ($qtitle!=null) && ($qbranch!=null) && ($qtopic!=null) && ($qauthor!=null) && ($qcost!=null) && ($qpublication!=null) && ($qdate!=null)){
			$exists = $this->db->query("SELECT copy FROM book WHERE book_name='$qtitle' AND branch_id='$qbranch' AND topic_id='$qtopic' AND author_id='$qauthor' AND publication_id='$qpublication'");
			$copy=0;
			$qcopy=0;
			/*while($data = mysql_fetch_array($exists)){
				$copy = $data['copy'];
			}*/
			foreach ($exists->result() as $row){
				$copy = $row->copy;
			}
			if($copy<10)
				$qcopy = "0".$copy;
			else
				$qcopy = $copy + 1;

			if($copy==0){
				$copy = 1;
				$qcopy = "0".$copy;
				$bookid = "$qbranch"."$qtopic"."$qauthor"."$qcopy";
				$query = "INSERT INTO book(branch_id, topic_id, author_id, book_id, publication_id, copy, book_name, book_type, cost, purchase_date) VALUES (?,?,?,?,?,?,?,?,?,?)";
				$addbook = $this->db->query($query, array($qbranch, $qtopic, $qauthor, $bookid, $qpublication, $copy, $qtitle, $qtype, $qcost, $qdate));
				if($addbook)
					return "Book <b>".$qtitle."</b> was <b>added</b> in the database with book id <b>".$bookid."</b> ".$qcopy." copies exists";
				else
					return FALSE;
			}
			else{
				$qcopy = $copy + 1;
				$copyid = $qcopy;
				if($qcopy<10)
					$copyid = "0".$qcopy;
				$bookid = "$qbranch"."$qtopic"."$qauthor"."$copyid";
				//$sql = "UPDATE book SET book_name='$qtitle', branch_id='$qbranch', topic_id='$qtopic', author_id='$qauthor', copy='$qcopy', book_id='$bookid'";
				$sql = "INSERT INTO book(branch_id, topic_id, author_id, book_id, publication_id, copy, book_name, book_type, cost, purchase_date) VALUES (?,?,?,?,?,?,?,?,?,?)";
				$addbook = $this->db->query($sql, array($qbranch, $qtopic, $qauthor, $bookid, $qpublication, $qcopy, $qtitle, $qtype, $qcost, $qdate));
				//echo $this->db->last_query();
				if($addbook)
					return "Book <b>".$qtitle."</b> already <b>existed</b> and hence one more copy with book id <b>".$bookid."</b> is added and now <b>".$qcopy." copies exists.";
				else
					return FALSE;
			}
		}
	}

	/**
	 * @param $branchdata
	 * @return bool|string
	 */
	public function addBranch($branchdata){
		extract($branchdata);
		$lastid = $this->db->query("SELECT b_id FROM branch ORDER BY b_id DESC LIMIT 1");
		$id=0;
		$qid=0;
		/*while($data = mysql_fetch_array($lastid)){
			$id = $data['b_id'];
		}*/
		foreach ($lastid->result() as $row){
			$copy = $row['copy'];
		}
		if($id<9){
			$id=$id+1;
			$qid="0".$id;
		}
		else{
			$qid=$id+1;
		}
		$sql = "INSERT INTO branch(branch_id,branch_name) VALUES (?,?)";
		$addbranch = $this->db->query($sql, array($qid,$qbranch));
		if($addbranch){
			return "Branch <b>".$qbranch."</b> is added successfully with id <b>".$qid."</b>";
		}
		else
			return FALSE;
	}

	/**
	 * @param $topicdata
	 * @return bool|string
	 */
	public function addTopic($topicdata){
		extract($topicdata);
		$lastid = $this->db->query("SELECT topic_id FROM topic WHERE branch_id='$qbranch'");
		$id = $lastid->num_rows();
		$qid=0;

		$id = intval($id);
		echo $id;
		if($id<9){
			$id=$id+1;
			$qid="0".$id;
		}
		else{
			$qid=$id+1;
		}
		$sql = "INSERT INTO topic(branch_id,topic_id,topic_name) VALUES (?,?,?)";
		$addtopic = $this->db->query($sql, array($qbranch,$qid,$qtopic));
		if($addtopic){
			return "Topic <b>".$qtopic."</b> is added successfully with id <b>".$qid."</b>";
		}
		else
			return FALSE;
	}

	/**
	 * @param $authordata
	 * @return bool|string
	 */
	public function addAuthor($authordata){
		extract($authordata);
		$lastid = $this->db->query("SELECT author_id FROM author WHERE branch_id='$qbranch' AND topic_id='$qtopic'");
		$id = $lastid->num_rows();
		$qid=0;

		$id = intval($id);
		echo $id;
		if($id<9){
			$id=$id+1;
			$qid="000".$id;
		}
		else if($id<99){
			$qid=$id+1;
			$qid="00".$qid;
		}
		else if($id<999){
			$qid=$id+1;
			$qid="0".$qid;
		}
		else if($id<9999){
			$qid=$qid+1;
		}
		$sql = "INSERT INTO author(branch_id,topic_id,author_id,author_name) VALUES (?,?,?,?)";
		$addauthor = $this->db->query($sql, array($qbranch,$qtopic,$qid,$qauthor));
		if($addauthor){
			return "Author <b>".$qauthor."</b> is added successfully with id <b>".$qid."</b>";
		}
		else
			return FALSE;
	}

	/**
	 * @param $publicationdata
	 * @return bool|string
	 */
	public function addPublication($publicationdata){
		extract($publicationdata);
		$sql = "INSERT INTO publication(publication_name) VALUES (?)";
		$addpublication = $this->db->query($sql, array($qpublication));
		if($addpublication){
			return "Publication <b>".$qpublication."</b> is added successfully.";
		}
		else
			return FALSE;
	}

	public function add_novel($noveldata){
		extract($noveldata);
		if(($qtype!=null) && ($qtitle!=null) && ($qauthor!=null) && ($qcost!=null) && ($qpublication!=null) && ($qdate!=null)){
			$lastid = "SELECT novel_id FROM novel ORDER BY id DESC LIMIT 1";
			$last = $this->db->query($lastid);
			$novel_id = 0;
			/*while($data = mysql_fetch_array($last)){
				$novel_id = (int)$data['novel_id'];
			}*/
			$novel_id = $this->db->insert_id();
			$novel_id = (int)$novel_id + 1;
			if($novel_id<=1){
				$novel_id = "1000".$novel_id;
			}

		$query = "INSERT INTO novel(author_id, novel_id, publication_id, novel_name, book_type, cost, purchase_date) VALUES (?,?,?,?,?,?,?)";
		$addbook = $this->db->query($query, array($qauthor, $novel_id, $qpublication, $qtitle, $qtype, $qcost, $qdate));
		if($addbook)
			return "Novel <b>".$qtitle."</b> was <b>added</b> in the database with novel id <b>".$novel_id."</b> ";
		else
			return FALSE;
		}
	}

	public function add_magazine($magazinedata){
		extract($magazinedata);
		if(($qtype!=null) && ($qtitle!=null) && ($qauthor!=null) && ($qcost!=null) && ($qpublication!=null) && ($qdate!=null)){
			$lastid = "SELECT magazine_id FROM magazine ORDER BY id DESC LIMIT 1";
			$last = $this->db->query($lastid);
			$magazine_id = 0;
			/*while($data = mysql_fetch_array($last)){
				$magazine_id = (int)$data['magazine_id'];
			}*/
			$magazine_id = $this->db->insert_id();
			$magazine_id = (int)$magazine_id + 1;
			if($magazine_id<=1){
				$magazine_id = "2000".$magazine_id;
			}

			$query = "INSERT INTO magazine(author_id, magazine_id, publication_id, magazine_name, book_type, cost, purchase_date) VALUES (?,?,?,?,?,?,?)";
			$addbook = $this->db->query($query, array($qauthor, $magazine_id, $qpublication, $qtitle, $qtype, $qcost, $qdate));
			if($addbook)
				return "Magazine <b>".$qtitle."</b> was <b>added</b> in the database with magazine id <b>".$magazine_id."</b> ";
			else
				return FALSE;
		}

	}

}