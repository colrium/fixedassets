<?php
class Mdatabase extends CI_Model{

	function __construct(){
	      parent::__construct();

	}



	public function emptyDatabase(){
		$truncatetables = array('fixedassets_assetlist', 'fixedassets_secondaryloc', 'fixedassets_categories', 'fixedassets_assetactions', 'employeelist', 'fixedassets_statuses', 'fixedassets_brands', 'fixedassets_models', 'fixedassets_reports', 'fixedassets_report_fields', 'fixedassets_manufacturers', 'fixedassets_dealers', 'fixedassets_conditions', 'fixedassets_linkedassets');
		foreach ($truncatetables as $key => $value) {
			$sqlStr ="TRUNCATE TABLE $value;";
			$query = $this->db->query($sqlStr);
			$sqlStr ="DELETE FROM actions_log WHERE entity = 'fixedassets_assetlist';";
			$query = $this->db->query($sqlStr);
		}

		$sqlStr ="DELETE FROM fixedassets_primaryloc WHERE NOT primisProtected;";
		$query = $this->db->query($sqlStr);
		$sqlStr ="DELETE FROM attachments WHERE entity = 'fixedassets_assetlist';";
		$query = $this->db->query($sqlStr);


	return true;


	}





	public function backupdatabase($module){
		// Load the DB utility class
		$this->load->dbutil();
		$moduletables  = array();
		$tables = dbmoduletables($module);
		foreach ($tables as $table) {
			array_push($moduletables, $table->parentTable);
		}
		print_r($moduletables);

		if ($filetype=='txt') {
			$filename = $filename;
			//backup preferences
			$prefs = array(
			        'tables'        => $moduletables,
			        'ignore'        => array(),
			        'format'        => $filetype,
			        'filename'      => $filename,
			        'add_drop'      => TRUE,
			        'add_insert'    => TRUE,
			        'newline'       => "\n"
			);
		}
		else if ($filetype=='zip') {
			$filename = $filename;
			//backup preferences
			$prefs = array(
			        'tables'        => $moduletables,
			        'ignore'        => array(),
			        'format'        => $filetype,
			        'filename'      => $filename,
			        'newline'       => "\n"
			);
		}
		else{
			$filename = $filename;
			$prefs = array(
			        'tables'        => $moduletables,
			        'ignore'        => array(),
			        'format'        => $filetype,
			        'filename'      => $filename,
			        'newline'       => "\n"
			);
		}

		
		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup($prefs);
		return $backup;

	}


	public function restoredbfromsqlfile($restorefile){
		$filedir = SQL_RESTORES_DIR.''.$restorefile;
		$isi_file = file_get_contents($filedir);
		$string_query = rtrim($isi_file, "\n;" );
		$array_query = explode(";", $string_query);
		foreach($array_query as $query) {
		    $this->db->query($query);
		}
		return true;

	}

	public function optimizedb(){
		$this->load->dbutil();
		$result = $this->dbutil->optimize_database();

		if ($result !== FALSE){
		        return true;
		}
		else{
			return false;
		}
	}











}