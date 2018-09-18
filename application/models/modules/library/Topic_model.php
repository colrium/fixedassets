<?php
/**
 * Created by PhpStorm.
 * User: thadaninilesh
 * Date: 22/6/15
 * Time: 12:33 PM
 */
	class topics_model extends  CI_Model {

		public function __construct() {
			$this -> load -> database();

		}

		function get_topic($branches = null){
			$this->db->select('topic_id, topic_name');

			if($branches != NULL){
				$this->db->where('branch_id', $branches);
			}

			$query = $this->db->get('topic');

			$topic = array();

			if($query->result()){
				foreach ($query->result() as $topics) {
					$topic[$topics->topic_id] = $topics->topic_name;
				}
				return $topic;
			}else{
				return FALSE;
			}
		}

	}