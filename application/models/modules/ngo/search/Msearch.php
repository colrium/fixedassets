<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM!
//
// copyright (c) 2013 by  Collins Riungu
// Nairobi Kenya
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//



---------------------------------------------------------------------*/

//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class Msearch extends CI_Model{

 

   function __construct() {

 		parent::__construct();
 		
   }


		public function showTables(){
			
		

		$sqlStr = "show tables";
		$query = $this->db->query($sqlStr);
		return ($query->result());


		}

		public function showColumns($table){
		$sqlStr = "show columns in $table";	
		$query = $this->db->query($sqlStr);
		return ($query->result());
		}

		public function searchTable($keyword, $table, $column){
		$sqlStr = "SELECT * FROM $table WHERE $column LIKE '%$keyword%'";
    	$query = $this->db->query($sqlStr);	
    	return ($query->result());



		}

    	



}


   ?>