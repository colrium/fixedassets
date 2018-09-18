<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mrecycle extends CI_Model{

   

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();

     
   }



 public function loadBin(){

 	$sqlStr ="	SELECT				
					`ngo_recycle_bin`.`rb_lKeyID` AS `binId`,
					`ngo_recycle_bin`.`rb_lGroupID` AS `binGroup`,
					`ngo_recycle_bin`.`rb_lForeignID` AS `binForeignID`,
					`ngo_recycle_bin`.`rb_enumRecycleType` AS `binType`,
					`ngo_recycle_bin`.`rb_strDescription` AS `binDescription`,
					`ngo_recycle_bin`.`rb_strTable` AS `binParentTable`,
					`ngo_recycle_bin`.`rb_strKeyIDFN` AS `binParentTablePKName`,
					`ngo_recycle_bin`.`rb_strRetireFN` AS `binParentTableRetireColumn`,
					`ngo_recycle_bin`.`rb_lOriginID` AS `binDeletedBy`,
					`ngo_recycle_bin`.`rb_dteOrigin` AS `binDeletedOn`,
					`users`.`last_name` AS `lastName`,
					`users`.`first_name` AS `firstName`				
	FROM
					`ngo_recycle_bin` AS `ngo_recycle_bin`,
					`users` AS `users`
	WHERE	
					`ngo_recycle_bin`.`rb_lOriginID` = `users`.`id`
	ORDER BY 
					`ngo_recycle_bin`.`rb_lKeyID` DESC";
      $query = $this->db->query($sqlStr);
      return $query->result();

 }

 public function restore($id){

 	$sqlStr ="	SELECT				
					`ngo_recycle_bin`.`rb_lKeyID` AS `binId`,
					`ngo_recycle_bin`.`rb_lGroupID` AS `binGroup`,
					`ngo_recycle_bin`.`rb_lForeignID` AS `binForeignID`,
					`ngo_recycle_bin`.`rb_enumRecycleType` AS `binType`,
					`ngo_recycle_bin`.`rb_strDescription` AS `binDescription`,
					`ngo_recycle_bin`.`rb_strTable` AS `binParentTable`,
					`ngo_recycle_bin`.`rb_strKeyIDFN` AS `binParentTablePKName`,
					`ngo_recycle_bin`.`rb_strRetireFN` AS `binParentTableRetireColumn`,
					`ngo_recycle_bin`.`rb_lOriginID` AS `binDeletedBy`,
					`ngo_recycle_bin`.`rb_dteOrigin` AS `binDeletedOn`
			
	FROM
					`ngo_recycle_bin` AS `ngo_recycle_bin`

	WHERE	
					`ngo_recycle_bin`.`rb_lKeyID` = ?";
      $query = $this->db->query($sqlStr, array($id));

    foreach ($query->result() as $record) {
    	$sqlRestore =	"UPDATE ".$record->binParentTable." 
    				SET
    				 ".$record->binParentTableRetireColumn." = 0
    				 WHERE ".$record->binParentTablePKName." = ".$record->binForeignID.";
    				";

    	$this->db->query($sqlRestore);
    	$this->deleteBin($record->binId);
    }

    return true;

 }



 public function deleteBin($id){
 	$sqlStr ="	DELETE FROM	 ngo_recycle_bin 	WHERE	rb_lKeyID = ?";
      
      if ($this->db->query($sqlStr, array($id))){
      	return true;
      }
      else{
      	return false;
      }




 }


















}

?>