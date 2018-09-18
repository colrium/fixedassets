<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mexpenses extends CI_Model{

 public function __construct()
        {
                parent::__construct();
        }



public function loadExpense($id){
	$sqlStr =
	        "SELECT				
					`ngo_expenses`.`id` AS `id`,
					`ngo_expenses`.`amount` AS `amount`,
					`ngo_expenses`.`expense_date` AS `expense_date`,
					`ngo_expenses`.`expense_account` AS `expense_account`,
					`ngo_expenses`.`expense_type` AS `expense_type`,
					`ngo_expenses`.`created_on` AS `created_on`,
					`ngo_expenses`.`expenseNote` AS `expenseNote`,
					`ngo_lists_generic`.`lgen_strListItem` AS `exptype`,
					`ngo_gifts_accounts`.`ga_strAccount` AS `expaccount`,
					`users`.`last_name` AS `userLastName`,
					`users`.`first_name` AS `userFirstname`
					
									
				FROM
					`ngo_expenses` AS `ngo_expenses`,
					`ngo_lists_generic` AS `ngo_lists_generic`,
					`ngo_gifts_accounts` AS `ngo_gifts_accounts`,
					`users` AS `users`

                                       
									
				WHERE
					`ngo_expenses`.`expense_account` = `ngo_gifts_accounts`.`ga_lKeyID`
                    AND `ngo_expenses`.`created_by` = `users`.`id`
                    AND  `ngo_expenses`.`expense_type` = `ngo_lists_generic`.`lgen_lKeyID`
					AND NOT `ngo_expenses`.`bRetired` 
	         		AND `ngo_expenses`.`id`=$id;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();


}

public function loadExpenses(){
	$sqlStr =
	        "SELECT				
					`ngo_expenses`.`id` AS `id`,
					`ngo_expenses`.`amount` AS `amount`,
					`ngo_expenses`.`expense_date` AS `expense_date`,
					`ngo_expenses`.`expense_account` AS `expense_account`,
					`ngo_expenses`.`expense_type` AS `expense_type`,
					`ngo_expenses`.`created_on` AS `created_on`,
					`ngo_expenses`.`expenseNote` AS `expenseNote`,
					`ngo_lists_generic`.`lgen_strListItem` AS `exptype`,
					`ngo_gifts_accounts`.`ga_strAccount` AS `expaccount`,
					`users`.`last_name` AS `userLastName`,
					`users`.`first_name` AS `userFirstname`
					
									
				FROM
					`ngo_expenses` AS `ngo_expenses`,
					`ngo_lists_generic` AS `ngo_lists_generic`,
					`ngo_gifts_accounts` AS `ngo_gifts_accounts`,
					`users` AS `users`

                                       
									
				WHERE
					`ngo_expenses`.`expense_account` = `ngo_gifts_accounts`.`ga_lKeyID`
                    AND `ngo_expenses`.`created_by` = `users`.`id`
                    AND  `ngo_expenses`.`expense_type` = `ngo_lists_generic`.`lgen_lKeyID`
					AND NOT `ngo_expenses`.`bRetired`;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();


}



public function loadAccounts(){
	$sqlStr =
	        "SELECT
	            *
	         FROM ngo_gifts_accounts
	         WHERE NOT ga_bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	
}


public function loadTypes(){
	$sqlStr =
	        "SELECT
	            *
	         FROM ngo_lists_generic
	         WHERE NOT lgen_bRetired
	         AND lgen_enumListType='campaignExpense';";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
	
}


public function saveExpense($id){
	$glUserID = USERID;

   $amount = $this->input->post('amount', TRUE);
   $expense_date = $this->input->post('expense_date', TRUE);
   $expense_account = $this->input->post('expense_account', TRUE);
   $expense_type = $this->input->post('expense_type', TRUE);
   $expenseNote = $this->input->post('expenseNote', TRUE);

if($id==0){
$sqlStr =
	        "INSERT INTO
	            ngo_expenses

	         SET 
	         amount = ".$this->db->escape($amount).",
	         expense_date =".$this->db->escape($expense_date).",
	         expense_account = ".$this->db->escape($expense_account).",
	         expense_type = ".$this->db->escape($expense_type).",
	         created_by='$glUserID',
	         expenseNote=".$this->db->escape($expenseNote).",
	         created_on = CURDATE();";

$this->db->query($sqlStr);
      return($this->db->insert_id());


}

else{
 $sqlStr =
	        "UPDATE
	            ngo_expenses

	         SET 
	         amount = ".$this->db->escape($amount).",
	         expense_date =".$this->db->escape($expense_date).",
	         expense_account = ".$this->db->escape($expense_account).",
	         expense_type = ".$this->db->escape($expense_type).",
	         created_by='$glUserID',
	         expenseNote=".$this->db->escape($expenseNote).",
	         WHERE id=$id;";
$this->db->query($sqlStr);
      return($id);

}



}



public function deleteExpense($id){
	 $sqlStr =
	        "UPDATE
	            ngo_expenses

	         SET 
	         bRetired=1
	         WHERE id=$id;";
$this->db->query($sqlStr);
return true;

}






















 }
 ?>