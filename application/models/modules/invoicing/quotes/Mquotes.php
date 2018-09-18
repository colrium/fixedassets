<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mquotes extends CI_Model{

	function __construct(){
		parent::__construct();
	}



	function getquotes($criteria = 'all', $criteriadata=''){
		$sqlStr = "SELECT * FROM invoicing_quotes WHERE 1";
		
		if ($criteria == 'status') {
			$sqlStr .= "  AND quote_status_id = ".prepsqlstringvar($criteriadata)." ";
		}
		if ($criteria == 'client') {
			$sqlStr .= " AND client_id = ".prepsqlstringvar($client_id)." ";
		}
		if ($criteria == 'recent') {
			$sqlStr .= " LIMIT 0,10 ";
		}

		$query = $this->db->query($sqlStr);
		return $query->result();
	}


    public function getstatustotals(){
        $sqlStr = "SELECT 	
					`invoicing_quote_statuses`.`status_id`,
					`invoicing_quote_statuses`.`status_name`,
					`invoicing_quote_statuses`.`status_icon`,
					`invoicing_quote_statuses`.`status_color`,
					(CASE `invoicing_quote_statuses`.`status_id` 
						WHEN 1
							THEN (
								SELECT IFNULL(SUM(`invoicing_quote_amounts`.`quote_total`), '0.00') 
								FROM `invoicing_quotes` AS `invoicing_quotes`, `invoicing_quote_amounts` AS `invoicing_quote_amounts`  WHERE `invoicing_quotes`.`quote_status_id` = `invoicing_quote_statuses`.`status_id`
								AND `invoicing_quotes`.`quote_id` = `invoicing_quote_amounts`.`quote_id`
							)

							ELSE(
								SELECT IFNULL(SUM(`invoicing_quote_amounts`.`quote_total`), '0.00') 
								FROM `invoicing_quotes` AS `invoicing_quotes`, `invoicing_quote_amounts` AS `invoicing_quote_amounts` WHERE `invoicing_quotes`.`quote_status_id` = `invoicing_quote_statuses`.`status_id`
								AND `invoicing_quotes`.`quote_id` = `invoicing_quote_amounts`.`quote_id`
								) 
					END) AS `total`

					FROM `invoicing_quote_statuses` AS `invoicing_quote_statuses`;";
		$query = $this->db->query($sqlStr);
		return $query->result();
    }
    
    public function delete($quote_id){
        $sqlStr = "DELETE FROM invoicing_quotes WHERE quote_id = ".prepsqlstringvar($quote_id).";";
		$query = $this->db->query($sqlStr);
		return TRUE;
    }


    public function mark_viewed($quote_id){
    	$sqlStr = "UPDATE invoicing_quotes SET quote_status_id = '3' WHERE quote_id = ".prepsqlstringvar($quote_id).";";
		$query = $this->db->query($sqlStr);
		return TRUE;
    }
    
    public function mark_sent($quote_id){
    	$sqlStr = "UPDATE invoicing_quotes SET quote_status_id = '2' WHERE quote_id = ".prepsqlstringvar($quote_id).";";
		$query = $this->db->query($sqlStr);
		return TRUE;
    }



































}
