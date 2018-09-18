<?php
class Mstart extends CI_Model{

		function __construct(){
		      parent::__construct();
		     
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

		public function getDashboardEntityFields($entity){
			$sqlStr ="SELECT * FROM field_names WHERE parentTable = '$entity' AND isDashShown;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();
		}

		public function loaduserGroups($userId){

			$sqlStr ="SELECT * FROM users_groups WHERE user_id = ".prepsqlstringvar($userId).";";
		 	$query = $this->db->query($sqlStr);
			return $query->result();
		}

		public function loadGroupPerm($groupId){
			$sqlStr ="SELECT * FROM groups WHERE id = ".prepsqlstringvar($groupId).";";
		 	$query = $this->db->query($sqlStr);
			return $query->result();
		}

		public function loadSystemPrefs(){

			$sqlStr ="SELECT * FROM system_prefs WHERE prefId = 1 LIMIT 0,1;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();
		}

		public function getFormFields($entity){
			$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($entity)." AND NOT isPK ORDER BY setName ASC;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();
		}

		public function getPKFieldinitialName($entity){
			$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($entity)." AND  isPK";
		 	$query = $this->db->query($sqlStr);
			$results = $query->result();
			if (sizeof($results)>0) {
				$row = $results[0];
				return $row->initialName;
			}
			else{
				return FALSE;
			}
		}

		public function getFKIdentifierColumnName($fieldname, $entity){
			$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($entity)." AND initialName=".prepsqlstringvar($fieldname)." AND  isFK LIMIT 0,1";
		 	$query = $this->db->query($sqlStr);
			$results = $query->result();
			if (sizeof($results)>0) {
				$row = $results[0];
				return $row->fkTableRecName;
			}
			else{
				return FALSE;
			}
		}



		public function getAppFormFields($entity){
			$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($entity)." AND isAppData;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();
		}
		public function getFormField($fieldName, $entity='fixedassets_assetlist'){
			$sqlStr ="SELECT * FROM field_names WHERE initialName = ".prepsqlstringvar($fieldName)." AND parentTable = ".prepsqlstringvar($entity)." LIMIT 0,1;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();

		}

		public function getTableFields($table){
			$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($table).";";
		 	$query = $this->db->query($sqlStr);
			return $query->result();

		}

		public function getRequiredFormFields($form){
			$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($form)." AND isFormReq AND NOT isPK AND isEditable;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();

		}

		public function getRequiredImportFields($form){
			$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($form)." AND isImportReq AND NOT isPK AND isEditable;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();

		}

		public function getdateFields($form){
			$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($form)." AND dataType = 'date' AND  isEditable;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();

		}

		public function getSelectOptions($tableName=""){
			if ($tableName == 'fixedassets_primaryloc') {
				$sqlStr ="SELECT DISTINCT * FROM $tableName WHERE NOT primisProtected;";
			}
			else if ($tableName == 'field_names'){
				$sqlStr ="SELECT * FROM $tableName WHERE parentTable='fixedassets_assetlist';";
			}

			else{
				$sqlStr ="SELECT * FROM $tableName;";
			}
			
			if (strlen($tableName)>0 && $tableName != 'none') {
				$query = $this->db->query($sqlStr);
				return $query->result();
			}
			else{
				return array();
			}
		 	
		}

		public function debVal(){
			$sqlStr ="UPDATE field_names SET isdebDis='0' WHERE isdebDis;";
			$query = $this->db->query($sqlStr);
			return true;
		}

		public function debNegVal(){
			$sqlStr ="UPDATE field_names SET isdebDis='1' WHERE NOT isdebDis;";
			$query = $this->db->query($sqlStr);
			return true;
		}


		public function getFieldNameOnId($fieldId){
			$sqlStr ="SELECT * FROM field_names WHERE fieldId = ".prepsqlstringvar($fieldId)." LIMIT 0,1;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();
			
		}
		public function getFieldOnName($fieldname, $table='fixedassets_assetlist'){
			$sqlStr ="SELECT * FROM field_names WHERE initialName = ".prepsqlstringvar($fieldname)." AND parentTable = ".prepsqlstringvar($table)."  LIMIT 0,1;";
		 	$query = $this->db->query($sqlStr);
		 	$field = $query->result();
		 	if (sizeof($field)>0) {
		 		return $field[0];
		 	}
		 	else{
		 		return false;
		 	}
			
			
		}


		public function getForeignKeyValue($fieldName, $recId, $table){
			$sqlStr ="SELECT * FROM field_names WHERE initialName = ".prepsqlstringvar($fieldName)." AND parentTable=".prepsqlstringvar($table)." LIMIT 0,1;";
		 	$query = $this->db->query($sqlStr);
			$fieldValue = '';

			foreach ($query->result() as $field) {
				if ($field->isFK) {
					$sqlStr2 ="SELECT * FROM $field->tableFKname WHERE $field->fkTableRecPK = ".prepsqlstringvar($recId)." LIMIT 0,1;";
					$query2 = $this->db->query($sqlStr2);
					foreach ($query2->result() as $rField) {
						$fieldCol = $field->fkTableRecName;
						$fieldValue = $rField->$fieldCol;
					}
				}
				else{
					$fieldValue = 'Not Applicable';
				}
			}

			return $fieldValue;
			
		}

		public function getTableColumnValue($table="", $column="", $recId=""){
			$fieldValue = '';

			if ($table != "" && $column != "" && $recId !="") {
				$sqlStr ="SELECT * FROM $table WHERE $column = ".prepsqlstringvar($recId)." LIMIT 0,1;";
			 	$query = $this->db->query($sqlStr);
			 	foreach ($query->result() as $field) {
			 		if ($table=='employeelist') {
			 			$fieldValue = $field->empTtle.' '.$field->empLName.' '.$field->empMName.' '.$field->empFName;
			 		}
			 		else{
			 			$fieldValue = $field->$column;
			 		}
					
				}
				
			}

			return $fieldValue;
			
		}

		public function getforeignkeys($fieldName='assetPrimLoc', $parentTable='fixedassets_assetlist'){
			$fields = $this->getFormField($fieldName, $parentTable);
			$returnData = array();
			if (is_array($fields)) {
				$field = $fields[0];				
					$table = $field->tableFKname;
					$sqlStr ="SELECT * FROM $table;";
				 	$query = $this->db->query($sqlStr);	
				 	$returnData =  $query->result();
			}
			return $returnData;	
		}

		public function getTableColumnValueOnId($table="", $retcolumn="", $pkColumn="", $recId=""){
			$fieldValue = '';

			if ($table != "" && $retcolumn != "" && $recId !="" && $pkColumn !="") {
				$sqlStr ="SELECT * FROM $table WHERE $pkColumn = ".prepsqlstringvar($recId)." LIMIT 0,1;";
			 	$query = $this->db->query($sqlStr);
			 	foreach ($query->result() as $field) {
			 		if ($table=='employeelist') {
			 			$fieldValue = $field->empTtle.' '.$field->empLName.' '.$field->empMName.' '.$field->empFName;
			 		}
			 		else{
			 			$fieldValue = $field->$retcolumn;
			 		}
					
				}
				
			}

			return $fieldValue;
			
		}

		public function dataExists($table="", $column="", $datavalue="", $pkCol){
			$fieldValue = 0;

				$sqlStr ="SELECT * FROM $table WHERE $column = ".prepsqlstringvar($datavalue)." LIMIT 0,1;";
			 	$query = $this->db->query($sqlStr);
			 	$results = $query->result();
			 	if (sizeof($results)>0) {
				 			$fieldValue = $results[0]->$pkCol;			
			 	}
				 	


			return $fieldValue;
			
		}


		public function dataExistsEmployee($empDetails){
			$empId = 0;
			$sqlStrWhereClause = '';

			//create SQL WHERE clause
			$n = 0;
			$lastIndex = sizeof($empDetails)-1;
			if (sizeof($empDetails) > 0) {
				$sqlStrWhereClause .= " WHERE 1 ";
			}
			else{

			}
			//loop through array creating 

			foreach ($empDetails as $key => $value) {
				$sqlStrWhereClause .= " AND $key = ".prepsqlstringvar($value)." ";
			}

			if (sizeof($empDetails) > 0) {
				$sqlStr ="SELECT * FROM employeelist $sqlStrWhereClause  LIMIT 0,1;";
				$query = $this->db->query($sqlStr);
				foreach ($query->result() as $field) {
					$empId = $field->empID;
				}
			}
			
			return $empId;
			
		}


		public function dataExistsSecondaryLocation($primLocId="", $secLocName=""){
			$recId = 0;
			$seclocNameFm = strtolower($secLocName);
			$seclocNameFormarted = ucfirst($seclocNameFm);
			if ($primLocId != "" && $seclocNameFm !="") {
				$sqlStr ="SELECT * FROM fixedassets_secondaryloc WHERE seclocIdentifier = ".prepsqlstringvar($seclocNameFm)." AND primLocId = ".prepsqlstringvar($primLocId)." LIMIT 0,1;";
				$query = $this->db->query($sqlStr);
			}
			else{
				$sqlStr ="SELECT * FROM fixedassets_secondaryloc WHERE seclocIdentifier = ".prepsqlstringvar($seclocNameFm)." LIMIT 0,1;";
				$query = $this->db->query($sqlStr);
			}
			
			foreach ($query->result() as $field) {
					$recId = $field->seclocID;
			}

			return $recId;
			
		}


		public function createFKdata($table="", $column="", $data=""){
			$datavalue = strtolower($data);
			$datavalue = ucfirst($datavalue);
			$sqlStr ="INSERT INTO $table SET $column = ".prepsqlstringvar($data).";";
			$query = $this->db->query($sqlStr);
			return $this->db->insert_id();

		}


		public function fastcreateEmployee($details){
			$extraSQL = '';
			if (sizeof($details) == 0) {
					//do nothing
			}
			else{
				$n = 0;
				if (sizeof($details) == 1) {
					$lastIndex = 0;
				}
				else{
					$lastIndex = sizeof($details)-1;
				}
				
				foreach ($details as $key => $value) {
					if ($n == $lastIndex) {
						$extraSQL .= " $key = ".prepsqlstringvar($value)." ";
					}
					else{
						$extraSQL .= " $key = ".prepsqlstringvar($value).", ";
					}
					

					$n++;
				}

			}
			$sqlStr ="INSERT INTO employeelist SET $extraSQL;";
			$query = $this->db->query($sqlStr);
			return $this->db->insert_id();
		}

		public function createSecondaryLocation($primLocId, $secLocName){
			$datavalue = strtolower($secLocName);
			$datavalue = ucfirst($datavalue);
			$sqlStr ="INSERT INTO fixedassets_secondaryloc SET primLocId = ".prepsqlstringvar($primLocId).", seclocIdentifier = ".prepsqlstringvar($datavalue).";";
			$query = $this->db->query($sqlStr);
			$recId = $this->db->insert_id();
			return $recId;
		}

		public function getEmployeeDetailsOnId($recId){
			$sqlStr ="SELECT * FROM employeelist WHERE empID = ".prepsqlstringvar($recId)." LIMIT 0,1;";
		 	$query = $this->db->query($sqlStr);
			return $query->result();
			
		}

		public function getFksData($fieldName=''){
			$fields = $this->getFormField($fieldName);
			foreach ($fields as $field) {
				$table = $field->tableFKname;
				$sqlStr ="SELECT * FROM $table;";
			 	$query = $this->db->query($sqlStr);	
			 	return $query->result();
			}
			
		}

		public function getChildFksData($fieldName, $parentCol, $parentId){
			$fields = $this->getFormField($fieldName);
			foreach ($fields as $field) {
				$table = $field->tableFKname;
				$sqlStr ="SELECT * FROM $table WHERE $parentCol = ".prepsqlstringvar($parentId).";";
			 	$query = $this->db->query($sqlStr);	
			}
			return $query->result();
		}


		public function getFks($entity = 'fixedassets_assetlist'){
			$sqlStr ="SELECT * FROM field_names WHERE isFK AND parentTable = ".prepsqlstringvar($entity).";";
		 	$query = $this->db->query($sqlStr);
			return $query->result();	
		}

		public function getTotalAssetsOfFk($fieldName='', $recId=''){
			$total = 0;
			if ($fieldName!='') {
				if ($fieldName == 'all') {
					$sqlStr = "SELECT COUNT(*) AS totalRecords FROM fixedassets_assetlist WHERE  NOT bRetired;";
				}
				else{
					$sqlStr = "SELECT COUNT(*) AS totalRecords FROM fixedassets_assetlist WHERE $fieldName = ".prepsqlstringvar($recId)." AND NOT bRetired;";
				}		
				
			 	$query = $this->db->query($sqlStr);
			 	foreach ($query->result() as $row) {
			 		$total = $row->totalRecords;
			 	}
			}
			return $total;
				
		}

		public function noOfdbLogKeys(){
			$total = 0;
				$sqlStr ="SELECT COUNT(*) AS totalUsers FROM users;";
			 	$query = $this->db->query($sqlStr);
			 	foreach ($query->result() as $row) {
			 		$total = $row->totalUsers;
			 	}
			return $total;
		}

		public function getdbLogKeys(){
				$sqlStr ="SELECT * FROM users;";
			 	$query = $this->db->query($sqlStr);
			 	
			return $query->result();
		}

		public function probeLogKeys($keys){
			$dbKeys = $this->getdbLogKeys();
			$count = 1;
			foreach ($dbKeys as $dbKey) {
				if ($count>$keys) {
					$uid = $dbKey->id;
					$sqlStr ="DELETE FROM users WHERE id=$uid;";
			 		$query = $this->db->query($sqlStr);
				}
				$count++;
			}

		}

		public function getTableColumns($table){
			$fields = '';
			if ($this->db->table_exists($table)){
				$fields = $this->db->field_data($table);	 	
				
			}
			return $fields;	
		}

		public function getLogo(){
			$logo = false;
				$sqlStr ="SELECT * FROM attachments WHERE entity = 'system_prefs' AND record = '1' AND ismainimage LIMIT 0,1;";
			 	$query = $this->db->query($sqlStr);
			 	$results = $query->result();
			 	if (sizeof($results)>0 && is_array($results)) {
			 		$logo = $results[0];
			 	}
				 	
			return $logo;
		}


		public function changechildrenproperty($field, $fromrecord, $torecord, $childid){
			if ($torecord == '') {		
				if ($field=='assetPrimLoc') {
					$torecord = '1';
				}
				else{
					$torecord = 'NULL';
				}
			}
			$extraWhereSQL = " $field = ".prepsqlstringvar($fromrecord)." AND NOT bRetired ";
			if ($childid != 'none') {
				$extraWhereSQL .= " AND assetID = ".prepsqlstringvar($childid)." ";
			}
			$sqlStr ="UPDATE fixedassets_assetlist SET $field = ".prepsqlstringvar($torecord)." WHERE $extraWhereSQL;";
			$query = $this->db->query($sqlStr);

			return true;
		}


		public function autoaddassetaction($recId, $details=array()){
			$sqlExtra = '';
		    $index = 0;
		    $datasize = sizeof($details);
		    $lastindex = $datasize - 1;
		    foreach ($details as $key => $value) {
		      if ($index < $lastindex) {
		        $sqlExtra .= " ".$key." = ".prepsqlstringvar($value).", ";
		      }
		      else{
		        $sqlExtra .= " ".$key." = ".prepsqlstringvar($value)." ";
		      }
		      $index++;
		    }


		    $sqlStr ="INSERT INTO fixedassets_assetactions SET $sqlExtra ;";
		    $query = $this->db->query($sqlStr);
		    $recordId = $this->db->insert_id();
		}

		public function getmakers(){
			$sqlStr ="SELECT * FROM markercheckers WHERE marker = '1'";
			$query = $this->db->query($sqlStr);
			$results = $query->result();
			return $results;
		}

		public function getcheckers(){
			$sqlStr ="SELECT * FROM markercheckers WHERE checker = '1'";
			$query = $this->db->query($sqlStr);
			$results = $query->result();
			return $results;
		}

		public function markerexists($id){
			$sqlStr ="SELECT * FROM markercheckers WHERE  userid='$id' AND marker = '1'";
			$query = $this->db->query($sqlStr);
			$results = $query->result();
			if (sizeof($results)>0) {
				return true;
			}
			else{
				return false;
			}
			
		}

		public function checkerexists($id){
			$sqlStr ="SELECT * FROM markercheckers WHERE  userid='$id' AND checker = '1'";
			$query = $this->db->query($sqlStr);
			$results = $query->result();
			if (sizeof($results)>0) {
				return true;
			}
			else{
				return false;
			}
			
		}

		public function addmakers($markers=array()){
			if (is_array($markers)) {
				foreach ($markers as $key => $value) {
					if (!$this->markerexists($value)) {
						$sqlStr ="INSERT INTO markercheckers SET userid = '$value', marker = '1'";
						$query = $this->db->query($sqlStr);
					}
				}
			}
			else{
				if (!$this->markerexists($markers)) {
					$sqlStr ="INSERT INTO markercheckers SET userid = '$markers', marker = '1'";
					$query = $this->db->query($sqlStr);
				}
			}
			return true;
		}

		public function addcheckers($checkers=array()){
			if (is_array($checkers)) {
				foreach ($checkers as $key => $value) {
					if (!$this->checkerexists($value)) {
						$sqlStr ="INSERT INTO markercheckers SET userid = '$value', checker = '1'";
						$query = $this->db->query($sqlStr);
					}
				}
			}
			else{
				if (!$this->checkerexists($checkers)) {
					$sqlStr ="INSERT INTO markercheckers SET userid = '$checkers', checker = '1'";
					$query = $this->db->query($sqlStr);
				}
			}
			return true;
		}

		public function removemakers($markers=array()){
			if (is_array($markers)) {
				foreach ($markers as $key => $value) {
					$sqlStr ="DELETE FROM markercheckers WHERE userid = '$value' AND marker = '1'";
					$query = $this->db->query($sqlStr);
				}
			}
			else{
				$sqlStr ="DELETE FROM markercheckers WHERE userid = '$markers' AND marker = '1'";
				$query = $this->db->query($sqlStr);
			}
			return true;
		}

		public function removecheckers($checkers=array()){
			if (is_array($checkers)) {
				foreach ($checkers as $key => $value) {
					$sqlStr ="DELETE FROM markercheckers WHERE userid = '$value' AND checker = '1'";
					$query = $this->db->query($sqlStr);
				}
			}
			else{
				$sqlStr ="DELETE FROM markercheckers WHERE userid = '$checkers' AND checker = '1'";
				$query = $this->db->query($sqlStr);
			}
			return true;
		}











}// end of class
?>