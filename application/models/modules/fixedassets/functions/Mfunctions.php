<?php
class Mfunctions extends CI_Model{

 public function __construct()
        {
                parent::__construct();
        }


public function loadCategories(){
	$sqlStr ="SELECT * FROM fixedassets_categories WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}

public function loadModels(){
	$sqlStr ="SELECT * FROM fixedassets_models WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadBrands(){
	$sqlStr ="SELECT * FROM fixedassets_brands WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadManufacturers(){
	$sqlStr ="SELECT * FROM fixedassets_manufacturers WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadSections(){
	$sqlStr ="SELECT * FROM fixedassets_sections WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadStatuses(){
	$sqlStr ="SELECT * FROM fixedassets_statuses WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadConditions(){
	$sqlStr ="SELECT * FROM fixedassets_conditions WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}


public function loadAssetModel($recId){
	$sqlStr ="SELECT * FROM fixedassets_models WHERE  modelId=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetBrand($recId){
	$sqlStr ="SELECT * FROM fixedassets_brands WHERE brandId=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetManufacturer($recId){
	$sqlStr ="SELECT * FROM fixedassets_manufacturers WHERE manId=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetSection($recId){
	$sqlStr ="SELECT * FROM fixedassets_sections WHERE sectionId=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetStatus($recId){
	$sqlStr ="SELECT * FROM fixedassets_statuses WHERE statusId=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetCategory($recId){
	
	$sqlStr ="SELECT * FROM fixedassets_categories WHERE catId=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetAssignedEmployee($recId){
	$sqlStr ="SELECT * FROM employeelist WHERE empID=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetCondition($recId){
	$sqlStr ="SELECT * FROM fixedassets_conditions WHERE condId=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetWarranty($recId){
	$sqlStr ="SELECT * FROM fixedassets_warranties WHERE warrantyAsset=$recId AND NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetLocation($recId){
	$sqlStr ="SELECT * FROM fixedassets_primaryloc WHERE primlocID=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAssetDepartment($recId){
	$sqlStr ="SELECT * FROM fixedassets_secondaryloc WHERE seclocID=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadfixedassets_assetactions($recId){
	$sqlStr ="SELECT * FROM fixedassets_assetactions WHERE assetId=$recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function ifExists($dbtable, $column, $dataRec){
		if ($dbtable=="employeelist") {	
			if (sizeof($dataRec)==1) {
				$lName = $dataRec[0];
				$sqlStr ="SELECT  * FROM $dbtable WHERE empLName = '$lName';";
			}
			elseif (sizeof($dataRec)==2) {
				$lName=$dataRec[0];
				$fName=$dataRec[1];

				$sqlStr ="SELECT  * FROM $dbtable WHERE (empLName = '$lName' AND empFName = '$fName') OR (empLName = '$fName' AND empFName = '$lName');";
			}
			elseif (sizeof($dataRec)==3) {
				$lName=$dataRec[0];
				$mName=$dataRec[1];
				$lName=$dataRec[2];

				$sqlStr ="SELECT  * FROM $dbtable WHERE (empLName = '$lName' AND empFName = '$fName' AND empMName= '$mName') OR (empLName = '$fName' AND empFName = '$lName' AND empMName='mName');";
			}
			elseif (sizeof($dataRec)==4) {
				$title=$dataRec[0];
				$lName=$dataRec[1];
				$mName=$dataRec[2];
				$fName=$dataRec[3];

				$sqlStr ="SELECT  * FROM $dbtable WHERE (empTtle= '$title' AND empLName = '$lName' AND empFName = '$fName' AND empMName= '$mName') OR (empTtle= '$title' AND empLName = '$fName' AND empFName = '$lName' AND empMName='mName');";
			}
			else{
				$name = "";
				foreach ($dataRec as $key => $value) {
					$name .= ' '.$value;					
				}
				$sqlStr ="SELECT  * FROM $dbtable WHERE empLName = '$name';";
			}


			
		}
		else{
			$sqlStr ="SELECT DISTINCT * FROM $dbtable WHERE $column = '$dataRec';";
		}
		
	
	      $query = $this->db->query($sqlStr);

	 if (sizeof($query->result())>0) {
	 	foreach ($query->result() as $result) {
	 		if ($dbtable=='fixedassets_brands') {
	 			return $result->brandId;
	 		}
	 		elseif ($dbtable=='fixedassets_categories') {
	 			return $result->catId;
	 		}

	 		elseif ($dbtable=='fixedassets_conditions') {
	 			return $result->condId;
	 		}

	 		elseif ($dbtable=='employeelist') {
	 			return $result->empID;
	 		}

	 		elseif ($dbtable=='fixedassets_manufacturers') {
	 			return $result->manId;
	 		}

	 		elseif ($dbtable=='fixedassets_models') {
	 			return $result->modelId;
	 		}

	 		elseif ($dbtable=='fixedassets_sections') {
	 			return $result->sectionId;
	 		}
	 		elseif ($dbtable=='fixedassets_statuses') {
	 			return $result->statusId;
	 		}
	 		elseif ($dbtable=='fixedassets_primaryloc') {
	 			return $result->primlocID;
	 		}
	 		elseif ($dbtable=='fixedassets_secondaryloc') {
	 			return $result->seclocID;
	 		}

	 	}
	 }
	 else{
	 	return 0;
	 }


}


public function ifSecLocExists($dbtable, $column, $dataRec, $parentRecCol, $parentRecId){
	$sqlStr ="SELECT DISTINCT * FROM $dbtable WHERE $column='$dataRec' AND $parentRecCol=$parentRecId;";
	$query = $this->db->query($sqlStr);
	return $query->result();
}


public function createNewsecRecord($dbtable, $column, $dataRec){
	if ($dbtable=="employeelist") {
		if (sizeof($dataRec)==0) {
				
			}	
		elseif (sizeof($dataRec)==1) {
			$lName= $dataRec[0];

			$sqlStr ="INSERT INTO $dbtable SET empLName='$lName';";
		}
		elseif (sizeof($dataRec)==2) {
			$lName= $dataRec[0];
			$fName= $dataRec[1];
			$sqlStr ="INSERT INTO $dbtable SET empFName='$fName', empLName='$lName';";
		}

		elseif (sizeof($dataRec)==3) {
			$lName= $dataRec[0];
			$fName= $dataRec[2];
			$mName= $dataRec[1];
			$sqlStr ="INSERT INTO $dbtable SET empFName='$fName', empLName='$lName', empMName='$mName';";
		}
		elseif (sizeof($dataRec)==4){
			$title = $dataRec[0];
			$lName= $dataRec[1];
			$fName= $dataRec[3];
			$mName= $dataRec[2];
			$sqlStr ="INSERT INTO $dbtable SET empTtle='$title', empFName='$fName', empLName='$lName', empMName='$mName';";
		}
		else{
			$name="";
			foreach ($dataRec as $key => $value) {
				$name .= ' '.$value;
			}
			$sqlStr ="INSERT INTO $dbtable SET empLName='$name';";
		}
	}
	else{
		$sqlStr ="INSERT INTO $dbtable SET $column='$dataRec';";
	}
	
	$query = $this->db->query($sqlStr);
	return $this->db->insert_id();

}

public function createNewseclocRecord($dbtable, $column, $dataRec, $parentRecCol, $parentRecId){
	$sqlStr ="INSERT INTO $dbtable SET $column='$dataRec', $parentRecCol = $parentRecId;";
	$query = $this->db->query($sqlStr);
	return $this->db->insert_id();

}
 public function saveUpdateImportRec($data, $entity){
 		if (sizeof($data)>0) {
 			$this->db->set($data);
			$this->db->insert($entity);
			if ($entity=='fixedassets_assetlist') {
				
			}
 		}
		
		
		return true;
 }

 public function addAssetAction($recId, $actionType, $actionUser){
	$sqlStr ="INSERT INTO  fixedassets_assetactions
	 				SET 
	 				actionType = '$actionType',
	 				assetId = $recId,
	 				actionUser = $actionUser,
	 				actionDate = CURDATE();";
	$query = $this->db->query($sqlStr);
	 return true;

}






public function emptyDatabase(){
	$truncatetables = array('fixedassets_assetlist', 'fixedassets_secondaryloc', 'fixedassets_categories', 'fixedassets_assetactions', 'employeelist', 'fixedassets_statuses', 'fixedassets_brands', 'fixedassets_models', 'fixedassets_reports', 'fixedassets_report_fields', 'fixedassets_manufacturers', 'fixedassets_dealers', 'fixedassets_conditions', 'fixedassets_linkedassets');
	foreach ($truncatetables as $key => $value) {
		$sqlStr ="TRUNCATE TABLE $value;";
		$query = $this->db->query($sqlStr);
	}

	$sqlStr ="DELETE FROM fixedassets_primaryloc WHERE NOT primisProtected;";
	$query = $this->db->query($sqlStr);
	$sqlStr ="DELETE FROM attachments WHERE entitytype = 'fixedassets_assetlist';";
	$query = $this->db->query($sqlStr);
return true;


}




	public function backupdatabase($filetype='txt', $filename='assetsdbbckp'){
		// Load the DB utility class
		$this->load->dbutil();

		if ($filetype=='txt') {
			$filename = $filename.'.sql';
			//backup preferences
			$prefs = array(
			        'tables'        => array(),
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
			        'tables'        => array(),
			        'ignore'        => array(),
			        'format'        => $filetype,
			        'filename'      => $filename,
			        'newline'       => "\n"
			);
		}
		else{
			$filename = $filename;
			$prefs = array(
			        'tables'        => array(),
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






}
?>
