<?php
/**
 * Created by PhpStorm.
 * User: thadaninilesh
 * Date: 22/6/15
 * Time: 12:27 PM
 */
class branch_model extends  CI_Model {

	public function __construct() {
		$this -> load -> database();

	}

	function get_branch() {
		$this -> db -> select('branch_id, branch_name');
		$query = $this -> db -> get('branch');

		$branch = array();

		if ($query -> result()) {
			foreach ($query->result() as $branches) {
				$branch[$branches -> branch_id] = $branches -> branches_name;
			}
			return $branch;
		} else {
			return FALSE;
		}
	}
}
?>