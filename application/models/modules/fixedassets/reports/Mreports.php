<?php
class Mreports extends CI_Model{

 public function __construct()
        {
                parent::__construct();
        }




public function genDepreciation(){






}



public function genListOfAssets(){

	$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired";
	$query = $this->db->query($sqlStr);
	 return $query->result();




}
public function getmanName($recId=''){
	$sqlStr ="SELECT * FROM fixedassets_manufacturers WHERE manId = '$recId' LIMIT 0,1 ";
	$query = $this->db->query($sqlStr);
	 $manufacturer = '';
	 foreach ($query->result() as $rec) {
	 	$manufacturer = $rec->manName;
	 }
	 return $manufacturer;
}

public function getmodelName($recId=''){
	$sqlStr ="SELECT * FROM fixedassets_models WHERE modelId = '$recId' LIMIT 0,1 ";
	$query = $this->db->query($sqlStr);
	 $model = '';
	 foreach ($query->result() as $rec) {
	 	$model = $rec->modelName;
	 }
	 return $model;
}

public function getstatusName($recId=''){
	$sqlStr ="SELECT * FROM fixedassets_statuses WHERE statusId = '$recId' LIMIT 0,1 ";
	$query = $this->db->query($sqlStr);
	 $status = '';
	 foreach ($query->result() as $rec) {
	 	$status = $rec->statusName;
	 }
	 return $status;
}

public function getlocName($recId=''){
	$sqlStr ="SELECT * FROM fixedassets_primaryloc WHERE primlocID = '$recId' LIMIT 0,1 ";
	$query = $this->db->query($sqlStr);
	 $status = '';
	 foreach ($query->result() as $rec) {
	 	$status = $rec->primlocIdentifier;
	 }
	 return $status;
}

public function getdepName($recId=''){
	$sqlStr ="SELECT * FROM fixedassets_secondaryloc WHERE seclocID = '$recId' LIMIT 0,1 ";
	$query = $this->db->query($sqlStr);
	 $status = '';
	 foreach ($query->result() as $rec) {
	 	$status = $rec->seclocIdentifier;
	 }
	 return $status;
}

public function getcatName($recId=''){
	$sqlStr ="SELECT * FROM fixedassets_categories WHERE catId = '$recId' LIMIT 0,1 ";
	$query = $this->db->query($sqlStr);
	 $status = '';
	 foreach ($query->result() as $rec) {
	 	$status = $rec->catName;
	 }
	 return $status;
}

public function getdealerName($recId=''){
	$sqlStr ="SELECT * FROM fixedassets_dealers WHERE dealerId = '$recId' LIMIT 0,1 ";
	$query = $this->db->query($sqlStr);
	 $status = '';
	 foreach ($query->result() as $rec) {
	 	$status = $rec->dealerName;
	 }
	 return $status;
}


public function getemployee($recId=''){
	$sqlStr ="SELECT * FROM employeelist WHERE empID = '$recId' LIMIT 0,1 ";
	$query = $this->db->query($sqlStr);
	 $status = '';
	 foreach ($query->result() as $rec) {
	 	$status = $rec->empLName;
	 }
	 return $status;
}

public function loadAssets($criteria){
	$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired ORDER BY $criteria ASC;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadcheckedOutAssets($criteria){
	$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired ORDER BY $criteria ASC;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function calculateCurrentValue($years, $buyingPrice, $dtePutIntoService, $upToDate,  $salvageVal, $depMethod, $percUsage){


	if ($depMethod=='1') {
	      
	      $x = $years;
	      $y = $buyingPrice;
	      $percentageDepPYear = (100/$x);
	      $percentageDepPDay = $percentageDepPYear/365;
	      $amountDepPerDay = ($buyingPrice - $salvageVal) * ($percentageDepPDay/100)*($percUsage/100);
	      $startingMdate = $dtePutIntoService;
	      $today = $upToDate;
	      $startDte = date_create($startingMdate);
	      $endDte = date_create($today);
	      $noOfDaysPassed = date_diff($startDte, $endDte);
	      $daysPassed = $noOfDaysPassed->format('%R%a');
	      $totalAccumalatedDep = $amountDepPerDay*$daysPassed;

	      }

	if (isset($totalAccumalatedDep)) {
		return $totalAccumalatedDep;
	}
	else{
		return 0;
	}
}

public function genassetsGroupByRep($sortCriteria){
	if ($sortCriteria=="category") {
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired ORDER BY assetCat ASC;";
	    $query = $this->db->query($sqlStr);
	 return $query->result();  	
	}

	if ($sortCriteria=="department") {
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired ORDER BY assetSecLoc ASC;";
	    $query = $this->db->query($sqlStr);
	 return $query->result();
	}

	if ($sortCriteria=="location"){
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired ORDER BY assetPrimLoc ASC;";
	    $query = $this->db->query($sqlStr);
	 return $query->result();
	}	


}


public function genRepbtnDates($repType, $dteFieldname){
	if ($repType=="assets") {
		$period = $this->input->post('dateSel');
		if ($period=="all") {
			$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired AND $dteFieldname != '0000-00-00' ORDER BY $dteFieldname ASC;";
		}
		elseif ($period=="year") {
			$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired AND year($dteFieldname) = year(CURDATE())  ORDER BY $dteFieldname ASC;";
		}

		elseif ($period=="month") {
			$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired AND year($dteFieldname) = year(CURDATE()) AND month($dteFieldname) = month(CURDATE()) ORDER BY $dteFieldname ASC;";
		}
		elseif ($period=="selDates") {
			$strtDate = $this->input->post('srtDte');
			$endDate = $this->input->post('endDte');
			$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired AND $dteFieldname BETWEEN '$strtDate' AND '$endDate' AND $dteFieldname != '0000-00-00' ORDER BY $dteFieldname ASC;";
		}
			
		    $query = $this->db->query($sqlStr);
		 return $query->result();  	
	}

	else if ($repType=="audit") {
		$period = $this->input->post('dateSel');
		if ($period=="all") {
			$sqlStr ="SELECT * FROM fixedassets_assetactions WHERE  $dteFieldname != '0000-00-00' ORDER BY $dteFieldname ASC;";
		}
		elseif ($period=="year") {
			$sqlStr ="SELECT * FROM fixedassets_assetactions WHERE  year($dteFieldname) = year(CURDATE())  ORDER BY $dteFieldname ASC;";
		}

		elseif ($period=="month") {
			$sqlStr ="SELECT * FROM fixedassets_assetactions WHERE  year($dteFieldname) = year(CURDATE()) AND month($dteFieldname) = month(CURDATE()) ORDER BY $dteFieldname ASC;";
		}
		elseif ($period=="selDates") {
			$strtDate = $this->input->post('srtDte');
			$endDate = $this->input->post('endDte');
			$sqlStr ="SELECT * FROM fixedassets_assetactions WHERE  $dteFieldname BETWEEN '$strtDate' AND '$endDate' AND $dteFieldname != '0000-00-00' ORDER BY $dteFieldname ASC;";
		}
			
		    $query = $this->db->query($sqlStr);
		 return $query->result(); 		
	}



}


public function genrepoPurchases(){

	$period = $this->input->post('dateSel');

	if ($period=="all") {
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired AND dtePurchased != '0000-00-00' ORDER BY dtePurchased ASC;";
	}
	elseif ($period=="year") {
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired AND year(dtePurchased) = year(CURDATE())  ORDER BY dtePurchased ASC;";
	}

	elseif ($period=="month") {
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired AND year(dtePurchased) = year(CURDATE()) AND month($dteFieldAsset) = month(CURDATE()) ORDER BY $dteFieldAsset ASC;";
	}
	elseif ($period=="selDates") {
		$strtDate = $this->input->post('srtDte');
		$endDate = $this->input->post('endDte');
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired AND dtePurchased BETWEEN '$strtDate' AND '$endDate' AND dtePurchased != '0000-00-00' ORDER BY dtePurchased ASC;";
	}

	$query = $this->db->query($sqlStr);
	 return $query->result();



}


public function customReports(){
	$userId = 	USERID;
	$sqlStr =	"SELECT * FROM  fixedassets_reports WHERE reportUser = $userId OR NOT isPrivate;";
	$query = $this->db->query($sqlStr);
	return $query->result();
}


public function getReportFields($repId){

  $sqlStr = "SELECT 
              `field_names`.`initialName` AS `initialName`,
              `field_names`.`setName` AS `setName`,
              `field_names`.`dataType` AS `dataType`,
              `field_names`.`isPK` AS `isPK`,
              `field_names`.`isFK` AS `isFK`,
              `field_names`.`isMonetary` AS `isMonetary`,
              `field_names`.`tableFKname` AS `tableFKname`,
              `field_names`.`fkTableRecPK` AS `fkTableRecPK`,
              `field_names`.`fkTableRecName` AS `fkTableRecName`,
              `fixedassets_report_fields`.`paramData` AS `paramData`,
              `fixedassets_report_fields`.`paramId` AS `paramId`,
              `fixedassets_report_fields`.`includeTotals` AS `includeTotals`,
              `fixedassets_reports_data_params`.`paramName` AS `paramName`,
              `fixedassets_reports_data_params`.`paramSymbol` AS `paramSymbol`
              FROM 
              `field_names` AS `field_names`,
              `fixedassets_report_fields` AS  `fixedassets_report_fields`,
              `fixedassets_reports_data_params` AS  `fixedassets_reports_data_params`
              WHERE 
               `fixedassets_report_fields`.`reportId` = $repId
              AND
                `fixedassets_report_fields`.`fieldId` = `field_names`.`fieldId`
              AND 
                `fixedassets_report_fields`.`paramId` =  `fixedassets_reports_data_params`.`paramId`;";
  $query = $this->db->query($sqlStr);
  return $query->result();
}

public function getReportDetails($repId){

  $sqlStr = "SELECT * FROM fixedassets_reports  WHERE reportId  = $repId;";
  $query = $this->db->query($sqlStr);
  return $query->result();
}

public function generateReportSQL($repId){
  $fields = $this->getReportFields($repId);
  $SQLselectFields = array();
  $SQLselectWhere = '';
  $SQLselectWhereStrt = '';
  $n = 0;
  foreach ($fields as $field) {
  	$SQLselectFields[$n] = $field->initialName;
    if ($field->paramName != 'none' && $field->paramId != '1') {
    	$SQLselectWhereStrt = ' WHERE 1 ';
      if ($field->paramName != 'isSimilarTo') {
      	
        $SQLselectWhere .= ' AND '.$field->initialName.' '.$field->paramSymbol.' "'.$field->paramData.'" ';
      }
      else{

      }
    }
   $n++;
  }
  $SQLstatement = 'SELECT '.implode(',', $SQLselectFields).' FROM fixedassets_assetlist '.$SQLselectWhereStrt.' '.$SQLselectWhere;
  

  
  return $SQLstatement;
}

public function generateCustomReport($repId){

	$sqlStr = $this->generateReportSQL($repId);
	$query = $this->db->query($sqlStr);
  	return $query->result();


}


























 }