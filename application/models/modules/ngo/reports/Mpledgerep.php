<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mpledgerep extends CI_Model{
 
 public function __construct()
        {
                parent::__construct();
        }

       public function getGroups(){

       	$sqlStr = "SELECT *	FROM ngo_groups_parent";
			$query = $this->db->query($sqlStr);
	 		return $query->result();



       }

       public function getPipeline($group, $year){
       	
		$sqlStr = "SELECT				
					`ngo_fin_proj_data`.`id` AS `data_id`,
					`ngo_fin_proj_data`.`biz_pple_id` AS `biz_pple_id`,
					`ngo_fin_proj_data`.`objective` AS `objective`,
					`ngo_fin_proj_data`.`total_asked_amount` AS `total_asked_amount`,
					`ngo_fin_proj_data`.`lead_person` AS `lead_person`,
					`ngo_fin_proj_data`.`country_focus` AS `country_focus`,
					`ngo_fin_proj_data`.`restriction` AS `restriction`,
					`ngo_fin_proj_data`.`start_year` AS `start_year`,
					`ngo_fin_proj_data`.`status` AS `status`,
					`ngo_fin_proj_data`.`amount_planned` AS `amount_planned`,
					`ngo_fin_proj_data`.`success_perc` AS `success_perc`,
					`ngo_fin_proj_data`.`years` AS `years`,
					Sum(`ngo_gifts`.`gi_curAmnt`) AS `total_fulfilment`,
					year(`ngo_gifts`.`gi_dteDonation`) AS `for_year`,
					`ngo_groups_parent`.`gp_strGroupName` AS `group`,
					`ngo_donors`.`pe_strLName` AS `last_name`,
					`ngo_donors`.`pe_strFName` AS `first_name`,
					`ngo_donors`.`pe_strTitle` AS `Title`


					
									
				FROM
					`ngo_fin_proj_data` AS `ngo_fin_proj_data`,
					`ngo_gifts` AS `ngo_gifts`,
					`ngo_groups_parent` AS `ngo_groups_parent`,
					`ngo_groups_child` AS `ngo_groups_child`,
					`ngo_donors` AS `ngo_donors`
                                       
									
				WHERE
					
					
					 `ngo_groups_child`.`gc_lGroupID` = $group
                    AND `ngo_groups_parent`.`gp_lKeyID` = `ngo_groups_child`.`gc_lGroupID`
                    AND  `ngo_groups_child`.`gc_lForeignID`= `ngo_donors`.`pe_lKeyID`
                 	AND `ngo_gifts`.`gi_lForeignID` = `ngo_fin_proj_data`.`biz_pple_id`
                 	AND `ngo_fin_proj_data`.`start_year`=$year
					AND `ngo_fin_proj_data`.`start_year`=year(`ngo_gifts`.`gi_dteDonation`)
					AND NOT `ngo_gifts`.`gi_bRetired`  
					
					AND `ngo_donors`.`pe_lKeyID`= `ngo_fin_proj_data`.`biz_pple_id`
					
					 
				GROUP BY  `ngo_donors`.`pe_lKeyID` 
				";
			$query = $this->db->query($sqlStr);
	 		return $query->result();





       }

       public function getPipelineTotals($group, $year){
       	
		$sqlStr = "SELECT				
					
					Sum(`ngo_gifts`.`gi_curAmnt`) AS `total`
					

					
									
				FROM
					`ngo_fin_proj_data` AS `ngo_fin_proj_data`,
					`ngo_gifts` AS `ngo_gifts`,
					`ngo_groups_parent` AS `ngo_groups_parent`,
					`ngo_groups_child` AS `ngo_groups_child`,
					`docs_images` AS `docs_images`,
					`ngo_donors` AS `ngo_donors`
                                       
									
				WHERE
					
					
					 `ngo_groups_child`.`gc_lGroupID` = $group
                    AND `ngo_groups_parent`.`gp_lKeyID` = `ngo_groups_child`.`gc_lGroupID`
                    AND  `ngo_groups_child`.`gc_lForeignID`= `ngo_donors`.`pe_lKeyID` = `ngo_gifts`.`gi_lForeignID` = `ngo_fin_proj_data`.`biz_pple_id`
                 	AND `ngo_fin_proj_data`.`start_year`=$year
					AND `ngo_fin_proj_data`.`start_year`=year(`ngo_gifts`.`gi_dteDonation`)
					AND NOT `ngo_gifts`.`gi_bRetired`  
					
					AND `ngo_donors`.`pe_lKeyID`= `ngo_fin_proj_data`.`biz_pple_id`
					
					 
				GROUP BY  `ngo_groups_parent`.`gp_lKeyID` 
				";
			$query = $this->db->query($sqlStr);
	 		return $query->result();





       }

       public function getAllPledges(){
       		$sqlStr = "SELECT				
					`ngo_gifts_pledges`.`gp_lKeyID` AS `pledge_id`,
					`ngo_gifts_pledges`.`gp_lForeignID` AS `pledge_people_id`,
					`ngo_gifts_pledges`.`gp_curCommitment` AS `pledge_commitment`,
					`ngo_gifts_pledges`.`gp_lNumCommit` AS `commitment_no`,
					`ngo_gifts_pledges`.`gp_enumFreq` AS `frequency`,
					`ngo_gifts_pledges`.`gp_dteStart` AS `start_date`,
					Sum(`ngo_gifts`.`gi_curAmnt`) AS `total_fulfilment`,
					`ngo_donors`.`pe_strFName` AS `first_name`,
					`ngo_donors`.`pe_strTitle` AS `salutation`,
					`ngo_donors`.`pe_strEmail` AS `email`,

					`ngo_donors`.`pe_strLName` AS `last_name`

					
									
				FROM
					`ngo_gifts_pledges` AS `ngo_gifts_pledges`,
					`ngo_gifts` AS `ngo_gifts`,
					`ngo_donors` AS `ngo_donors`
                                       
									
				WHERE
					
					 `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_donors`.`pe_lKeyID` 
					AND `ngo_gifts`.`gi_lForeignID` = `ngo_donors`.`pe_lKeyID` 
					AND NOT `ngo_gifts`.`gi_bRetired`  
					AND (TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)<`ngo_gifts_pledges`.`gp_lNumCommit` 
					 
				GROUP BY  `ngo_gifts_pledges`.`gp_lForeignID`";
			$query = $this->db->query($sqlStr);
	 		return $query->result();

       }

        public function getPledges($group, $category){
			$sqlStr = "SELECT				
					`ngo_gifts_pledges`.`gp_lKeyID` AS `pledge_id`,
					`ngo_gifts_pledges`.`gp_lForeignID` AS `pledge_people_id`,
					`ngo_gifts_pledges`.`gp_curCommitment` AS `pledge_commitment`,
					`ngo_gifts_pledges`.`gp_lNumCommit` AS `commitment_no`,
					`ngo_gifts_pledges`.`gp_enumFreq` AS `frequency`,
					`ngo_gifts_pledges`.`gp_dteStart` AS `start_date`,
					((TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)*`ngo_gifts_pledges`.`gp_curCommitment`) AS expected_amount,
					(TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1) AS Months_passed,
					Sum(`ngo_gifts`.`gi_curAmnt`) AS `total_fulfilment`,
					`ngo_donors`.`pe_strFName` AS `first_name`,
					`ngo_donors`.`pe_strTitle` AS `salutation`,
					`ngo_donors`.`pe_strEmail` AS `email`,
					`ngo_groups_child`.`gc_lKeyID` AS `group`,
					`ngo_donors`.`pe_strLName` AS `last_name`

					
									
				FROM
					`ngo_gifts_pledges` AS `ngo_gifts_pledges`,
					`ngo_gifts` AS `ngo_gifts`,
					`ngo_groups_child` AS `ngo_groups_child`,
					`ngo_donors` AS `ngo_donors`
                                       
									
				WHERE
					
					 `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_donors`.`pe_lKeyID` 
                    AND `ngo_groups_child`.`gc_lGroupID` = $group
                    AND `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_groups_child`.`gc_lForeignID`
					AND `ngo_gifts`.`gi_lForeignID` = `ngo_donors`.`pe_lKeyID` 
					AND `ngo_gifts`.`gi_lPledgeID` = `ngo_gifts_pledges`.`gp_lKeyID` 
					AND `ngo_gifts_pledges`.`gp_enumFreq` = '$category'
					AND NOT `ngo_gifts`.`gi_bRetired`  
					AND (TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)<`ngo_gifts_pledges`.`gp_lNumCommit` 
					 
				GROUP BY  `ngo_gifts_pledges`.`gp_lForeignID` 
				HAVING Sum(`ngo_gifts`.`gi_curAmnt`) < ((TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)*`ngo_gifts_pledges`.`gp_curCommitment`)";
			$query = $this->db->query($sqlStr);
	 		return $query->result();


		}

		public function getDuePledges($group, $category){
			$sqlStr = "SELECT				
					`ngo_gifts_pledges`.`gp_lKeyID` AS `pledge_id`,
					`ngo_gifts_pledges`.`gp_lForeignID` AS `pledge_people_id`,
					`ngo_gifts_pledges`.`gp_curCommitment` AS `pledge_commitment`,
					`ngo_gifts_pledges`.`gp_lNumCommit` AS `commitment_no`,
					`ngo_gifts_pledges`.`gp_enumFreq` AS `frequency`,
					`ngo_gifts_pledges`.`gp_dteStart` AS `start_date`,

					`ngo_donors`.`pe_strFName` AS `first_name`,
					`ngo_donors`.`pe_strTitle` AS `salutation`,
					`ngo_donors`.`pe_strEmail` AS `email`,
					`ngo_groups_child`.`gc_lKeyID` AS `group`,
					`ngo_donors`.`pe_strLName` AS `last_name`

					
									
				FROM
					`ngo_gifts_pledges` AS `ngo_gifts_pledges`,
					`ngo_gifts` AS `ngo_gifts`,
					`ngo_groups_child` AS `ngo_groups_child`,
					`ngo_donors` AS `ngo_donors`
                                       
									
				WHERE
					
					 `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_donors`.`pe_lKeyID` 
                    AND `ngo_groups_child`.`gc_lGroupID` = $group
                    AND `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_groups_child`.`gc_lForeignID`
					AND `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_donors`.`pe_lKeyID` 
					AND `ngo_gifts_pledges`.`gp_enumFreq` = '$category'
					AND (TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)<`ngo_gifts_pledges`.`gp_lNumCommit` 
					 
				GROUP BY  `ngo_gifts_pledges`.`gp_lForeignID` ";
			$query = $this->db->query($sqlStr);
	 		return $query->result();




		}

		public function getHonoredPledges($group, $month, $year, $category){
			$sqlStr ="SELECT				
					`ngo_gifts_pledges`.`gp_lKeyID` AS `pledge_id`,
					`ngo_gifts_pledges`.`gp_lForeignID` AS `pledge_people_id`,
					`ngo_gifts_pledges`.`gp_curCommitment` AS `pledge_commitment`,
					`ngo_gifts_pledges`.`gp_lNumCommit` AS `commitment_no`,
					`ngo_gifts_pledges`.`gp_enumFreq` AS `frequency`,
					`ngo_gifts_pledges`.`gp_dteStart` AS `start_date`,
					((TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)*`ngo_gifts_pledges`.`gp_curCommitment`) AS expected_amount,
					(TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1) AS Months_passed,
					Sum(`ngo_gifts`.`gi_curAmnt`) AS `total_fulfilment`,
					`ngo_donors`.`pe_strFName` AS `first_name`,
					`ngo_donors`.`pe_strTitle` AS `salutation`,
					`ngo_donors`.`pe_strEmail` AS `email`,
					`ngo_groups_child`.`gc_lKeyID` AS `group`,
					`ngo_donors`.`pe_strLName` AS `last_name`,
					`ngo_gifts`.`gi_dteDonation` AS `date_honored`,
					month(`ngo_gifts`.`gi_dteDonation`) AS `for_month`,
					year(`ngo_gifts`.`gi_dteDonation`) AS `for_year`
					
									
				FROM
					`ngo_gifts_pledges` AS `ngo_gifts_pledges`,
					`ngo_gifts` AS `ngo_gifts`,
					`ngo_groups_child` AS `ngo_groups_child`,
					`ngo_donors` AS `ngo_donors`
                                       
									
				WHERE
					
					 `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_donors`.`pe_lKeyID` 
                    AND `ngo_groups_child`.`gc_lGroupID` = $group
                    AND `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_groups_child`.`gc_lForeignID`
					AND `ngo_gifts`.`gi_lForeignID` = `ngo_donors`.`pe_lKeyID` 
					AND month(`ngo_gifts`.`gi_dteDonation`)=$month
					AND year(`ngo_gifts`.`gi_dteDonation`)=$year
					AND `ngo_gifts_pledges`.`gp_enumFreq` = '$category'
					AND `ngo_gifts`.`gi_lPledgeID` = `ngo_gifts_pledges`.`gp_lKeyID` 
					AND NOT `ngo_gifts`.`gi_bRetired`  
					AND (TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)<`ngo_gifts_pledges`.`gp_lNumCommit` 
					 
				GROUP BY  `ngo_gifts_pledges`.`gp_lForeignID`, month(`ngo_gifts`.`gi_dteDonation`) 
				HAVING Sum(`ngo_gifts`.`gi_curAmnt`) >= `ngo_gifts_pledges`.`gp_curCommitment`";
			$query = $this->db->query($sqlStr);
	 		return $query->result();


		}
		public function markAck($giftId){
			$glUserID = USERID;
			$sqlStr="UPDATE gifts SET gi_bAck=1, gi_dteAck=NOW(), gi_lAckByID=$glUserID
			WHERE gi_lKeyID=$giftId;";
			$query = $this->db->query($sqlStr);
	 		return true;
			
		}




		public function getHonoredPledgesRecipients($group, $month, $year){
			$sqlStr ="SELECT				
					`ngo_gifts_pledges`.`gp_lKeyID` AS `pledge_id`,
					`ngo_gifts_pledges`.`gp_lForeignID` AS `pledge_people_id`,
					`ngo_gifts_pledges`.`gp_curCommitment` AS `pledge_commitment`,
					`ngo_gifts_pledges`.`gp_lNumCommit` AS `commitment_no`,
					`ngo_gifts`.`gi_lKeyID` AS `gi_lKeyID`,
					`ngo_gifts_pledges`.`gp_enumFreq` AS `frequency`,
					`ngo_gifts_pledges`.`gp_dteStart` AS `start_date`,
					((TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)*`ngo_gifts_pledges`.`gp_curCommitment`) AS expected_amount,
					(TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1) AS Months_passed,
					Sum(`ngo_gifts`.`gi_curAmnt`) AS `total_fulfilment`,
					`ngo_donors`.`pe_strFName` AS `first_name`,
					`ngo_donors`.`pe_strTitle` AS `salutation`,
					`ngo_donors`.`pe_strEmail` AS `email`,
					`ngo_groups_child`.`gc_lKeyID` AS `group`,
					`ngo_donors`.`pe_strLName` AS `last_name`,
					`ngo_gifts`.`gi_dteDonation` AS `date_honored`,
					month(`ngo_gifts`.`gi_dteDonation`) AS `for_month`,
					year(`ngo_gifts`.`gi_dteDonation`) AS `for_year`
					
									
				FROM
					`ngo_gifts_pledges` AS `ngo_gifts_pledges`,
					`ngo_gifts` AS `ngo_gifts`,
					`ngo_groups_child` AS `ngo_groups_child`,
					`ngo_donors` AS `ngo_donors`
                                       
									
				WHERE
					
					 `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_donors`.`pe_lKeyID` 
                    AND `ngo_groups_child`.`gc_lGroupID` = $group
                    AND `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_groups_child`.`gc_lForeignID`
					AND `ngo_gifts`.`gi_lForeignID` = `ngo_donors`.`pe_lKeyID` 
					AND month(`ngo_gifts`.`gi_dteDonation`)=$month
					AND year(`ngo_gifts`.`gi_dteDonation`)=$year
					AND `ngo_gifts`.`gi_bAck`=0
					AND `ngo_gifts`.`gi_lPledgeID` = `ngo_gifts_pledges`.`gp_lKeyID` 
					AND NOT `ngo_gifts`.`gi_bRetired`  
					AND (TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)<`ngo_gifts_pledges`.`gp_lNumCommit` 
					 
				GROUP BY  `ngo_gifts_pledges`.`gp_lForeignID`, month(`ngo_gifts`.`gi_dteDonation`) 
				HAVING Sum(`ngo_gifts`.`gi_curAmnt`) >= `ngo_gifts_pledges`.`gp_curCommitment`";
			$query = $this->db->query($sqlStr);
	 		return $query->result();


		}

		public function getPledges2(){
			 $group = $this->input->post('group', TRUE);
			$sqlStr = "SELECT				
					`ngo_gifts_pledges`.`gp_lKeyID` AS `pledge_id`,
					`ngo_gifts_pledges`.`gp_lForeignID` AS `pledge_people_id`,
					`ngo_gifts_pledges`.`gp_curCommitment` AS `pledge_commitment`,
					`ngo_gifts_pledges`.`gp_lNumCommit` AS `commitment_no`,
					`ngo_gifts_pledges`.`gp_enumFreq` AS `frequency`,
					`ngo_gifts_pledges`.`gp_dteStart` AS `start_date`,
					((TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)*`ngo_gifts_pledges`.`gp_curCommitment`) AS expected_amount,
					(TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1) AS Months_passed,
					Sum(`ngo_gifts`.`gi_curAmnt`) AS `total_fulfilment`,
					`ngo_donors`.`pe_strFName` AS `first_name`,
					`ngo_donors`.`pe_strTitle` AS `salutation`,
					`ngo_donors`.`pe_strEmail` AS `email`,
					`ngo_groups_child`.`gc_lKeyID` AS `group`,
					`ngo_donors`.`pe_strLName` AS `last_name`

					
									
				FROM
					`ngo_gifts_pledges` AS `ngo_gifts_pledges`,
					`ngo_gifts` AS `ngo_gifts`,
					`ngo_groups_child` AS `ngo_groups_child`,
					`ngo_donors` AS `ngo_donors`
                                       
									
				WHERE
					
					 `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_donors`.`pe_lKeyID` 
                                         AND `ngo_groups_child`.`gc_lGroupID` = $group
                                        AND `ngo_gifts_pledges`.`gp_lForeignID` = `ngo_groups_child`.`gc_lForeignID`
					AND `ngo_gifts`.`gi_lForeignID` = `ngo_donors`.`pe_lKeyID` 
					AND `ngo_gifts`.`gi_lPledgeID` = `ngo_gifts_pledges`.`gp_lKeyID` 
					AND NOT `ngo_gifts`.`gi_bRetired`  
					AND (TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)<`ngo_gifts_pledges`.`gp_lNumCommit` 
					 
				GROUP BY  `ngo_gifts_pledges`.`gp_lForeignID` 
				HAVING Sum(`ngo_gifts`.`gi_curAmnt`) < ((TIMESTAMPDIFF(MONTH, `ngo_gifts_pledges`.`gp_dteStart`, CURDATE())+1)*`ngo_gifts_pledges`.`gp_curCommitment`)";
			$query = $this->db->query($sqlStr);
	 		return $query->result();


		}


		public function getFulfillments($lPledgeID){
			
			$sqlStr =
          "SELECT gi_lKeyID, gi_lForeignID,
             gi_dteDonation,
             gi_curAmnt, gi_strCheckNum,
             pe_lKeyID, pe_bBiz, pe_strFName, pe_strLName,
             gi_lACOID, aco_strFlag, aco_strCurrencySymbol, aco_strName
           FROM ngo_gifts
            INNER JOIN ngo_donors    ON pe_lKeyID  = gi_lForeignID
            INNER JOIN ngo_admin_aco       ON gi_lACOID  = aco_lKeyID
           WHERE gi_lPledgeID=$lPledgeID
              AND NOT gi_bRetired ";
       $query = $this->db->query($sqlStr);
	   return $query->result();

			
		}
		








}



?>