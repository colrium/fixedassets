<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Minvoices extends CI_Model{

	function __construct(){
		parent::__construct();
	}





	function getinvoices($criteria = 'all', $criteriadata=''){
		$sqlStr = "SELECT * FROM invoicing_invoices WHERE 1";
		
		if ($criteria == 'status') {
			$sqlStr .= "  AND invoice_status_id = ".prepsqlstringvar($criteriadata)." ";
		}
		if ($criteria == 'client') {
			$sqlStr .= " AND client_id = ".prepsqlstringvar($criteriadata)." ";
		}
		
		$sqlStr .= " ORDER BY invoice_date_created DESC";

		if ($criteria == 'recent') {
			$sqlStr .= " LIMIT 0,10 ";
		}

		$query = $this->db->query($sqlStr);
		return $query->result();
	}

	public function getoverdueinvoices($criteria = 'all', $criteriadata=''){
		$sqlStr = "SELECT * FROM invoicing_invoices WHERE 1";
		
		$sqlStr .= " AND invoice_status_id NOT IN (1,4) AND DATEDIFF(NOW(), invoice_date_due) > 0";
		if ($criteria == 'client') {
			$sqlStr .= " AND client_id = ".prepsqlstringvar($criteriadata)." ";
		}
		
		$sqlStr .= "  ORDER BY invoice_date_created DESC";

		if ($criteria == 'recent') {
			$sqlStr .= " LIMIT 0,10 ";
		}
	
		$query = $this->db->query($sqlStr);
		return $query->result();
	}

	public function invoicesoverview($criteria = 'status', $criteriadata=''){
		$sqlStr = "SELECT * FROM invoicing_invoice_amounts WHERE invoice_id = ".prepsqlstringvar($invoice_id).";";
		$query = $this->db->query($sqlStr);
		return $query->result();
	}

	public function getstatuses(){
		$sqlStr = "SELECT * FROM invoicing_invoice_statuses;";
		$query = $this->db->query($sqlStr);
		return $query->result();
	}

	public function getstatustotals(){
        $sqlStr = "SELECT 	
					`invoicing_invoice_statuses`.`status_id`,
					`invoicing_invoice_statuses`.`status_name`,
					`invoicing_invoice_statuses`.`status_icon`,
					`invoicing_invoice_statuses`.`status_color`,
					(CASE `invoicing_invoice_statuses`.`status_id` 
						WHEN 4 
							THEN (
									SELECT SUM(`invoicing_invoice_amounts`.`invoice_paid`) 
									FROM `invoicing_invoice_amounts` AS `invoicing_invoice_amounts`, `invoicing_invoices` AS `invoicing_invoices` WHERE `invoicing_invoices`.`invoice_status_id` = `invoicing_invoice_statuses`.`status_id`
								) 
						ELSE (
								SELECT IFNULL(SUM(`invoicing_invoice_amounts`.`invoice_balance`), '0.00') 
								FROM `invoicing_invoice_amounts` AS `invoicing_invoice_amounts`, `invoicing_invoices` AS `invoicing_invoices` 
								WHERE `invoicing_invoice_amounts`.`invoice_id` = `invoicing_invoices`.`invoice_id` 
								AND `invoicing_invoices`.`invoice_status_id` = `invoicing_invoice_statuses`.`status_id`
							) 
					END) AS `total`

					FROM `invoicing_invoice_statuses` AS `invoicing_invoice_statuses`;";
		$query = $this->db->query($sqlStr);
		return $query->result();
    }


    public function getinvoiceamounts($invoice_id){
    	$sqlStr = "SELECT * FROM invoicing_invoice_amounts WHERE invoice_id = ".prepsqlstringvar($invoice_id).";";
		$query = $this->db->query($sqlStr);
		return $query->result();
    }

    public function delete($invoice_id){
        $sqlStr = "DELETE FROM invoicing_invoices WHERE invoice_id = ".prepsqlstringvar($invoice_id).";";
		$query = $this->db->query($sqlStr);
		return TRUE;
    }

    public function mark_viewed($invoice_id){
    	$sqlStr = "UPDATE invoicing_invoices SET invoice_status_id = '3' WHERE invoice_id = ".prepsqlstringvar($invoice_id).";";
		$query = $this->db->query($sqlStr);
		return TRUE;
    }
    
    public function mark_sent($invoice_id){
    	$sqlStr = "UPDATE invoicing_invoices SET invoice_status_id = '2' WHERE invoice_id = ".prepsqlstringvar($invoice_id).";";
		$query = $this->db->query($sqlStr);
		return TRUE;
    }

































}
