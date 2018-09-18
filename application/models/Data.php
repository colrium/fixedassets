<?php
class Data extends CI_Model{

function __construct(){
      parent::__construct();

}


public function loadrecordsfromtable($table, $extraSQL='WHERE NOT bRetired'){
	$sqlStr ="SELECT * FROM $table $extraSQL;";
 	$query = $this->db->query($sqlStr);
 	
	$result = $query->result();
	if (sizeof($result)>0) {
		return $result;
	}
	else{
		return false;
	}
}

public function loadrecordfromtable($table, $pkColumn, $recId){
	$sqlStr ="SELECT * FROM $table WHERE $pkColumn = ".prepsqlstringvar($recId).";";
 	$query = $this->db->query($sqlStr);
	$result = $query->result();
	if (sizeof($result)>0) {
		return $result[0];
	}
	else{
		return false;
	}
}




public function addrecordstotable($table, $data){

}

public function updaterecordsintable($table, $data){

}

public function totalrecordsoftable($table, $extraSQL = ''){
	$sqlStr ="SELECT COUNT(*) As total FROM $table $extraSQL;";
 	$query = $this->db->query($sqlStr);
	$result = $query->result();
	return $result[0]->total;
}

public function searchindb($search_values){
	// Init vars
	$db_name = $this->db->database;
	$table_fields = array();
	$cumulative_results = array();

	// Pull all table columns that have character data types
	$result = $this->db->query("
		SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE
		FROM  `INFORMATION_SCHEMA`.`COLUMNS` 
		WHERE  `TABLE_SCHEMA` =  '{$db_name}'
		AND `DATA_TYPE` IN ('varchar', 'char', 'text')
		")->result_array();
	
	// Build table-keyed columns so we know which to query
	foreach ( $result  as $o ){
		$table_fields[$o['TABLE_NAME']][] = $o['COLUMN_NAME'];			
	}
	
	// Build search query to pull the affected rows
	// Search Each Row for matches
	foreach($table_fields as $table_name => $fields){
		// Clear search array
		$search_array = array();
		
		// Add a search for each search match
		foreach($fields as $field){
			if (is_array($search_values)) {
				foreach($search_values as $value){
					$search_array[] = " `{$field}` LIKE '{$value}' ";
				}
			}
			else{
				$search_array[] = " `{$field}` LIKE '{$search_values}' ";
			}
			
		}
		// Implode $search_array
		$search_string = implode (' OR ', $search_array);
		$query_string = "SELECT * FROM `{$table_name}` WHERE {$search_string}";
		
		$table_results = $this->db->query($query_string)->result_array();		
		$cumulative_results = array_merge($cumulative_results, $table_results);
	}
	
	return $cumulative_results;
}




















































}