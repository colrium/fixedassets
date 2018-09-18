<?php
class Mreports extends CI_Model{

	function __construct(){
	    parent::__construct();     
	}


public function generateincomereport($strtDte='', $endDte='', $include = ''){
	$sqlStrExtra = ' ';
	if ($strtDte=='' && $endDte=='') {
		$sqlStrExtra .= ' ';		
	}
	else if ($strtDte!='' && $endDte==''){
		$sqlStrExtra .= " AND  `insurance_payments`.`paymentDate` >= '$strtDte' ";
	}
	else if ($strtDte=='' && $endDte!=''){
		$sqlStrExtra .= " AND  `insurance_payments`.`paymentDate` <= '$endDte' ";
	}
	else if ($strtDte!='' && $endDte!=''){
		$sqlStrExtra .= " AND  (`insurance_payments`.`paymentDate` BETWEEN '$strtDte' AND '$endDte') ";
	}

	if ($include = 'individuals') {
		$sqlStrExtra .= " AND  `insurance_clients`.`isclientBiz` = '0' ";
	}
	else if ($include = 'companies') {
		$sqlStrExtra .= " AND  `insurance_clients`.`isclientBiz` = '0' ";
	}

	$sqlStr ="SELECT 
				`insurance_payments`.`paymentAmount` AS `paymentAmount`,
				`insurance_payments`.`paymentDate` AS `paymentDate`,
				`insurance_payments`.`paymentClient` AS `paymentClient`,
				`insurance_payments`.`paymentMode` AS `paymentMode`,
				`insurance_clients`.`clientName` AS `clientName`,
				`insurance_clients`.`isclientBiz` AS `isclientBiz`,
				`insurance_clients`.`clientCurrency` AS `clientCurrency`,
				`insurance_covers`.`coverName` AS `coverName`,
				`insurance_covers`.`customcommission` AS `customcommission`,
				`insurance_paymentmodes`.`modeName` AS `modeName`,
				`insurance_currencies`.`currencySymbol` AS `currencySymbol`
			 FROM 
			 `insurance_payments` AS  `insurance_payments`,
			 `insurance_clients` AS  `insurance_clients`,
			 `insurance_covers` AS  `insurance_covers`,
			 `insurance_paymentmodes` AS  `insurance_paymentmodes`,
			 `insurance_currencies` AS  `insurance_currencies`

			 WHERE 

			 NOT `insurance_payments`.`bRetired` 
			 AND `insurance_clients`.`clientId` = `insurance_payments`.`paymentClient` 
			 AND `insurance_covers`.`coverId` = `insurance_payments`.`paymentCover`
			 AND `insurance_paymentmodes`.`modeId` = `insurance_payments`.`paymentMode`
			 AND `insurance_currencies`.`currencyId` = `insurance_clients`.`clientCurrency`

			 	$sqlStrExtra

			 ORDER BY paymentDate DESC;";

	$query = $this->db->query($sqlStr);
	$results = $query->result();
	$table = '<table class="mdl-data-table mdl-js-data-table displaytable">
				<thead>				      	              	
				<tr class="teal">
					<td class="mdl-data-table__cell--non-numeric"> Cover</td>
					<td class="mdl-data-table__cell--non-numeric"> Amount Paid</td>
					<td class="mdl-data-table__cell--non-numeric"> Date Paid</td>
					<td class="mdl-data-table__cell--non-numeric"> Percentage Commision</td>
					<td class="mdl-data-table__cell--non-numeric"> Commision</td>
					<td class="mdl-data-table__cell--non-numeric"> Paid via</td>
				</tr>
				</thead>
				<tbody>';
	$totalCommision = 0;
	$totalPaid = 0;
	if (sizeof($results) > 0) {
		foreach ($results as $row) {
			$commision = $row->customcommission / 100 * $row->paymentAmount;
			$totalCommision = $totalCommision + $commision;
			$totalPaid = $totalPaid+$row->paymentAmount;
			$table .= 	'<tr>
							<td class="mdl-data-table__cell--non-numeric">'.$row->coverName.'</td>
							<td class="mdl-data-table__cell--non-numeric">'.$row->paymentAmount.'</td>
							<td class="mdl-data-table__cell--non-numeric">'.$row->paymentDate.'</td>
							<td class="mdl-data-table__cell--non-numeric">'.$row->customcommission.'</td>
							<td class="mdl-data-table__cell--non-numeric">'.$commision.'</td>
							<td class="mdl-data-table__cell--non-numeric">'.$row->modeName.'</td>
						</tr>';
		}
		$table .= 	'<tr class="grey lighten-3">
							<td class="mdl-data-table__cell--non-numeric"><b>Totals </b></td>
							<td class="mdl-data-table__cell--non-numeric"><b>'.$totalPaid.'</b></td>
							<td class="mdl-data-table__cell--non-numeric grey-text">Not Applicable</td>
							<td class="mdl-data-table__cell--non-numeric grey-text">Not Applicable</td>
							<td class="mdl-data-table__cell--non-numeric"><b>'.$totalCommision.'</b></td>
							<td class="mdl-data-table__cell--non-numeric grey-text">Not Applicable</td>
						</tr>';
		
	}			
	else{
		$table .= 	'<tr class="grey lighten-3">
							<td class="mdl-data-table__cell--non-numeric grey-text" colspan="6" style="text-decoration:italic; text-align:center;">No Data</td>							
					</tr>';
	}	
	$table .=  '</tbody></table>';

	return $table;

}


public function generatedefaultedreport(){
	$table = '<table class="mdl-data-table mdl-js-data-table displaytable">
				<thead>				      	              	
				<tr class="teal">
					<td class="mdl-data-table__cell--non-numeric"> Cover</td>
					<td class="mdl-data-table__cell--non-numeric"> Cover Client</td>
					<td class="mdl-data-table__cell--non-numeric"> Last Date Paid</td>
					<td class="mdl-data-table__cell--non-numeric"> Total Defaults </td>
					<td class="mdl-data-table__cell--non-numeric"> Expected Amount</td>
					<td class="mdl-data-table__cell--non-numeric"> Paid Amount</td>
					<td class="mdl-data-table__cell--non-numeric"> Unpaid Amount</td>
				</tr>
				</thead>
				<tbody>';

	$table .= 	'<tr class="grey lighten-3">
					<td class="mdl-data-table__cell--non-numeric grey-text" colspan="7" style="text-transform: italic; text-align:center;">'.maticon('folder_open', 'medium').'<br> No Data</td>							
				</tr>';

	$table .=  '</tbody></table>';

	return $table;

}

public function generatepopulapoliciesreport(){
	$table = '<table class="mdl-data-table mdl-js-data-table displaytable">
				<thead>				      	              	
				<tr class="teal">
					<td class="mdl-data-table__cell--non-numeric"> Policy</td>
					<td class="mdl-data-table__cell--non-numeric"> Default Insurer</td>
					<td class="mdl-data-table__cell--non-numeric"> Default Commission</td>
					<td class="mdl-data-table__cell--non-numeric"> Total Covers</td>
				</tr>
				</thead>
				<tbody>';

	$table .= 	'<tr class="grey lighten-3">
					<td class="mdl-data-table__cell--non-numeric grey-text" colspan="4" style="text-transform: italic; text-align:center;">'.maticon('folder_open', 'medium').'<br> No Data</td>							
				</tr>';

	$table .=  '</tbody></table>';

	return $table;

}











































}