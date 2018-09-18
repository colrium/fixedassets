<?php
class Mandroid extends CI_Model{

 public function __construct()
        {
                parent::__construct();
        }


public function updateAndroidAsset($assetCode){
	$assetCode  = $_POST['assetCode'];
	$assetItem  = $_POST['assetItem'];
	$assetDesc  = $_POST['assetDesc'];
	$serialNum  = $_POST['serialNum'];
	$assetCondtn  = $_POST['assetCondtn'];
	$assetStatus  = $_POST['assetStatus'];
	$assetCat  = $_POST['assetCat'];
	$assetPrimLoc  = $_POST['assetPrimLoc'];
	$assetSecLoc  = $_POST['assetSecLoc'];
	$assignedTo  = $_POST['assignedTo'];
	$auditStatus  = $_POST['auditStatus'];
	$assetImg  = $_POST['assetImg'];
	$lastAuditedBy  = $_POST['lastAuditedBy'];

	if ($this->ifExists('fixedassets_statuses', 'statusName', $assetStatus)==0) {
 		$assetStatus = $this->createNewsecRecord('fixedassets_statuses', 'statusName', $assetStatus);
	 }
	 else{
	 	$assetStatus = $this->ifExists('fixedassets_statuses', 'statusName', $assetStatus);
	 }

	 if ($this->ifExists('fixedassets_primaryloc', 'primlocIdentifier', $assetPrimLoc)==0) {
 		$assetPrimLoc = $this->createNewsecRecord('primaryloc', 'primlocIdentifier', $assetPrimLoc);
	 }
	 else{
	 	$assetPrimLoc = $this->ifExists('fixedassets_primaryloc', 'primlocIdentifier', $assetPrimLoc);
	 }

	 if ($this->ifExists('fixedassets_conditions', 'condName', $assetCondtn)==0) {
 		$assetCondtn = $this->createNewsecRecord('fixedassets_conditions', 'condName', $assetCondtn);
	 }
	 else{
	 	$assetCondtn = $this->ifExists('fixedassets_conditions', 'condName', $assetCondtn);
	 }

	 if ($this->ifExists('employeelist', 'empLName', $assignedTo)==0) {
 		$assignedTo = $this->createNewsecRecord('employeelist', 'empLName', $assignedTo);
	 }
	 else{
	 	$assignedTo = $this->ifExists('employeelist', 'empLName', $assignedTo);
	 }

	 if ($this->ifExists('fixedassets_categories', 'catName', $assetCat)==0) {
 		$assetCat = $this->createNewsecRecord('fixedassets_categories', 'catName', $assetCat);
	 }
	 else{
	 	$assetCat = $this->ifExists('fixedassets_categories', 'catName', $assetCat);
	 }

	 if ($this->ifSecLocExists('fixedassets_secondaryloc', 'seclocIdentifier', $assetSecLoc, 'primLocId', $assetPrimLoc)==0) {
 		$assetPrimLoc = $this->createNewseclocRecord('fixedassets_secondaryloc', 'seclocIdentifier', $assetSecLoc, 'primLocId', $assetPrimLoc);
	 }
	 else{
	 	$assetPrimLoc = $this->ifSecLocExists('fixedassets_secondaryloc', 'seclocIdentifier', $assetSecLoc, 'primLocId', $assetPrimLoc);
	 }

	 	$sqlStr ="UPDATE  fixedassets_assetlist 
	 				SET 
		 				assetItem 		= '$assetItem',
		 				assetCode 		= '$assetCode',		 				
		 				assetDesc 		= '$assetDesc',
		 				assetCat 		= '$assetCat',
		 				serialNum 		= '$serialNum',
		 				assetPrimLoc 	= '$assetPrimLoc',
		 				assetSecLoc 	= '$assetSecLoc',
		 				assetTerLoc 	= '$assetTerLoc',
		 				assetCondtn 	= '$assetCondtn',
		 				assignedTo 		= '$assignedTo',
		 				assetStatus 	= '$assetStatus',
		 				lasDteAudit 	= CURDATE(),
		 				auditStatus 	= '$auditStatus',
		 				assetImg		= '$assetImg',
		 				lastAuditedBy 	= '$lastAuditedBy'
		 			WHERE assetCode = '$assetCode';";
	 	$query = $this->db->query($sqlStr);
	 	return $this->db->insert_id();


}