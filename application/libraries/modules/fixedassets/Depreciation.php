<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/
class Depreciation {
	public $roundmonths, $roundyears, $realtime, $svconflicts, $fiscalyearstart;

	public function __construct(){
		$this->roundmonths = FALSE;
		$this->roundyears = FALSE;
		$this->realtime = FALSE;
		$this->svconflicts = 'largerofslordb';
	}


	public function __get($var){
	    return get_instance()->$var;
	}


	public function depreciationdata($recId, $datatype, $lastdate=FALSE, $depreciationvars=FALSE){
		if ($depreciationvars==FALSE) {
			$depreciationvars = $this->deprecreciationvars($recId);
		}

		$method = $depreciationvars['method'];

		$data = FALSE; 
		if ($method == 1) {
			$data = $this->straightlinedata($recId, $datatype, $lastdate, $depreciationvars);
		}
		else if ($method == 2){
			$data = $this->decliningbalancedata($recId, $datatype, $lastdate, $depreciationvars);
		}
		else if ($method == 3){
			$data = $this->decliningbalancedata($recId, $datatype, $lastdate, $depreciationvars);
		}
		else if ($method == 4){
			$data = $this->decliningbalancedata($recId, $datatype, $lastdate, $depreciationvars);
		}
		else{
			
		}
		
		return $data;
	}

	 

	public function deprecreciationvars($recId){	
		$depreciationdata = array();
		$cost = 0.00;
		$recordmethod = FALSE;
		$groupmethod = FALSE;	
		$date = FALSE;
		$recordlife = FALSE;
		$grouppercentage = FALSE;
		$recordpercentage = FALSE;
		$recordsalvagevalue = 0.00;
		$recorduse = FALSE;
		$grouplife = FALSE;

		$life = 1;
		$percentage = 100;
		$method = 1;

		$assetdetails = dbtablerecord($recId, 'fixedassets_assetlist', FALSE);

		if ($assetdetails != FALSE) {
			$recorduse = $assetdetails->bizUse;
			$recordsalvagevalue = $assetdetails->salvageVal;
			$computedtotalcost = $assetdetails->assetCost + $assetdetails->assetCTax1 + $assetdetails->assetCTax2;
			$cost = $computedtotalcost;
			if (is_validdate($assetdetails->dtePurchased)) {
				$date = $assetdetails->dtePurchased;
			}

			if (is_validdate($assetdetails->dtePutIntoService)) {
				$date = $assetdetails->dtePutIntoService;
			}
			
			if ($assetdetails->totalCost > 0 && $assetdetails->totalCost != $computedtotalcost) {
				$cost = $assetdetails->totalCost;
			}

			if (intval($assetdetails->deprMethod) > 0 && intval($assetdetails->deprMethod) < 5) {
				$recordmethod = $assetdetails->deprMethod;
			}
			if (intval($assetdetails->assetLYears) > 0) {
				$recordlife = $assetdetails->assetLYears;
			}

			if (intval($assetdetails->percdepPA) > 0) {
				$recordpercentage = $assetdetails->percdepPA;
			}

			$assetGroupdetails = dbtablerecord($assetdetails->assetCat, 'fixedassets_categories', FALSE);

			if ($assetGroupdetails != FALSE) {
				if (intval($assetGroupdetails->catDepMethod) > 0 && intval($assetGroupdetails->catDepMethod) < 5) {
					$groupmethod = $assetGroupdetails->catDepMethod;
				}
				if (intval($assetGroupdetails->catLifeInYears) > 0) {
					$grouplife = $assetGroupdetails->catLifeInYears;
				}
				if (intval($assetGroupdetails->catdeppercpa) > 0) {
					$grouppercentage = $assetGroupdetails->catdeppercpa;
				}	
			}
		}

		if (!$date) {
			$date = date('Y-m-d');
		}
		if (!$groupmethod) {
			if ($recordmethod) {
				$method = $recordmethod;
			}
		}
		else{
			if (!$recordmethod) {
				$method = $groupmethod;
			}
			else{
				$method = $recordmethod;
			}
		}
		if (!$grouplife) {
			if ($recordlife) {
				$life = $recordlife;
			}
		}
		else{
			if (!$recordlife) {
				$life = $grouplife;
			}
			else{
				$life = $recordlife;
			}
		}

		if (!$grouppercentage) {
			if (!$recordpercentage) {
				$percentage = 100/$life;
			}
			else{
				$percentage = $recordpercentage;
			}
		}
		else{
			if (!$recordpercentage) {
				$percentage = $grouppercentage;
			}
			else{
				$percentage = $recordpercentage;
			}
		}

		$depreciationdata['method'] = $method;
		$depreciationdata['life'] = $life;
		$depreciationdata['percentage'] = $percentage;
		$depreciationdata['cost'] = $cost;
		$depreciationdata['date'] = $date;
		$depreciationdata['use'] = $recorduse;
		$depreciationdata['salvagevalue'] = $recordsalvagevalue;
		

		return $depreciationdata;	
	}





	public function straightlinedata($recId, $datatype='monthsdata', $lastdate=FALSE, $depreciationvars=FALSE){
		$cost = $depreciationvars['cost'];
		$life = $depreciationvars['life'];
		$salvagevalue = $depreciationvars['salvagevalue'];
		$percentage = $depreciationvars['percentage'];
		$use = $depreciationvars['use'];
		$startdate = $depreciationvars['date'];

		
		$amountperyear = $cost*($percentage/100);

		$amountperday = $amountperyear/365;
		$percentageperday = $percentage/365;

		$accumulated = 0;

		$lastaccumulatedvalue = $cost-$salvagevalue;




		$depreciationstartdate = $startdate;
		$depreciationstartdateobj = date_create($depreciationstartdate);

		$totalmonths = $life*12;
		$totalyears = $life;

		if ($this->roundmonths) {
			$day = intval(date_format($depreciationstartdateobj, 'd'));
			$month = intval(date_format($depreciationstartdateobj, 'm'));
			$year = intval(date_format($depreciationstartdateobj, 'Y'));

			$startmonthlastday = cal_days_in_month(CAL_GREGORIAN, $month, $year);

			if ($day >= 15) {
				$depreciationstartdate = $year.'-'.$month.'-'.$startmonthlastday;
			}
			else if ($day < 15){
				$depreciationstartdate = $year.'-'.$month.'-1';
			}
			
			
		}
		if ($this->roundyears) {
			$startmonth = intval(date_format($depreciationstartdateobj, 'm'));
			$startyear = intval(date_format($depreciationstartdateobj, 'Y'));
			if ($startmonth >= 6) {
				$depreciationstartdate =  $startyear.'-12-31';
			}
			elseif ($startmonth < 6) {
				$depreciationstartdate =  ($startyear-1).'-12-31';
			}				
		}

		$depreciationstartdateobj = date_create($depreciationstartdate);

		if ($datatype=='monthsdata') {			

			$monthsdata = array();
			

			for ($i=0; $i < intval($totalmonths); $i++) {
					$monthdata = array();

					$depstartdate = date_create($depreciationstartdate);
					$dependdate = date_create(nextdate($depreciationstartdate, 'months', 1));

					$datedifference = date_diff($depstartdate, $dependdate);
					$noofdaysdifference = $datedifference->format('%a');


					$monthdata['days'] = $noofdaysdifference;
					$monthdata['from'] = date_format($depstartdate, 'Y-m-d');
					$monthdata['to'] = date_format($dependdate, 'Y-m-d');

					$depreciation = $noofdaysdifference*$amountperday;
					
					$invalidaccumulated = $accumulated + $depreciation;

					if ($invalidaccumulated > $lastaccumulatedvalue) {
						$depreciation = $cost - $accumulated;
						$accumulated = $lastaccumulatedvalue;
					}
					else{
						$accumulated = $invalidaccumulated;
					}

					$bookvalue = $cost-$accumulated;

					$accumulated = round($accumulated, 2);					
					$depreciation = round($depreciation, 2);
					$bookvalue = round($bookvalue, 2);
					


					
					$monthdata['depreciation'] = $depreciation;
					$monthdata['accumulated'] = $accumulated;
					$monthdata['bookvalue'] = $bookvalue;
					$monthdata['period'] = $i;

					array_push($monthsdata, $monthdata);
					$depreciationstartdate = date_format($dependdate, 'Y-m-d');					
				}
			return $monthsdata;
		}//end of monthly table
		else if($datatype == 'yearsdata') {
			$yearsdata = array();
			

			for ($k=0; $k < $totalyears; $k++) {
				$yeardata = array();

				$depstartdate = date_create($depreciationstartdate);
				$dependdate = date_create(nextdate($depreciationstartdate, 'years', 1));

			

				$datedifference = date_diff($depstartdate, $dependdate);
				$noofdaysdifference = $datedifference->format('%a');
				$noofdaysdifference = $noofdaysdifference;


				$yeardata['days'] = $noofdaysdifference;
				$yeardata['from'] = date_format($depstartdate, 'Y-m-d');
				$yeardata['to'] = date_format($dependdate, 'Y-m-d');

				$depreciation = $noofdaysdifference*$amountperday;
					
					$invalidaccumulated = $accumulated + $depreciation;

					if ($invalidaccumulated > $lastaccumulatedvalue) {
						$depreciation = $cost - $accumulated;
						$accumulated = $lastaccumulatedvalue;
					}
					else{
						$accumulated = $invalidaccumulated;
					}

					$bookvalue = $cost-$accumulated;

					$accumulated = round($accumulated, 2);					
					$depreciation = round($depreciation, 2);
					$bookvalue = round($bookvalue, 2);
					


					
					$yeardata['depreciation'] = $depreciation;
					$yeardata['accumulated'] = $accumulated;
					$yeardata['bookvalue'] = $bookvalue;
					$yeardata['period'] = $k;


				array_push($yearsdata, $yeardata);
				$depreciationstartdate = date_format($dependdate, 'Y-m-d');
			}

			return $yearsdata;
		}
		else if ($datatype=='datedata') {
			if ($lastdate==FALSE) {
				$lastdate = date('Y-m-d');
			}
			
			if (!is_validdate($lastdate)) {
				$lastdate = date('Y-m-d');
			}
				$datedata = array();
				$depstartdate = date_create($depreciationstartdate);
				$dependdate = date_create($lastdate);
				
				$datedifference = date_diff($depstartdate, $dependdate);
				$noofdaysdifference = $datedifference->format('%a');
				$noofdaysdifference = $noofdaysdifference;


				$depreciation = $noofdaysdifference * $amountperday;
				$fullydepreciated = FALSE;
				if ($depreciation >= $lastaccumulatedvalue) {
					$depreciation = $lastaccumulatedvalue;
					$fullydepreciated = TRUE;
				}

				$accumulated = $depreciation;
				$bookvalue = $cost-$accumulated;
				$accumulated = round($accumulated, 2);					
				$depreciation = round($depreciation, 2);
				$bookvalue = round($bookvalue, 2);
					

				$datedata['days'] = $noofdaysdifference;
				$datedata['from'] = date_format($depstartdate, 'Y-m-d');
				$datedata['to'] = date_format($dependdate, 'Y-m-d');
				$datedata['depreciation'] = $depreciation;
				$datedata['accumulated'] = $accumulated;
				$datedata['bookvalue'] = $bookvalue;
				$datedata['cost'] = $cost;
				$datedata['fullydepreciated'] = $fullydepreciated;
				

				return $datedata;
		}		

		return FALSE;	
	}





	public function decliningbalancedata($recId, $datatype='monthsdata', $lastdate=FALSE, $depreciationvars=FALSE){
		$cost = $depreciationvars['cost'];
		$life = $depreciationvars['life'];
		$salvagevalue = $depreciationvars['salvagevalue'];
		$percentage = $depreciationvars['percentage'];
		$use = $depreciationvars['use'];
		$startdate = $depreciationvars['date'];

		
		$amountperyear = $cost*($percentage/100);
		
		$amountperday = $amountperyear/365;
		$percentageperday = round(($percentage/365), 2);

		$accumulated = 0;

		$lastaccumulatedvalue = $cost-$salvagevalue;

		$bookvalue = $cost;


		$depreciationstartdate = $startdate;


		$totalmonths = $life*12;
		$totalyears = $life;

		if ($this->roundmonths) {
			$day = intval(date_format($depreciationstartdateobj, 'd'));
			$month = intval(date_format($depreciationstartdateobj, 'm'));
			$year = intval(date_format($depreciationstartdateobj, 'Y'));

			$startmonthlastday = cal_days_in_month(CAL_GREGORIAN, $month, $year);

			if ($day >= 15) {
				$depreciationstartdate = $year.'-'.$month.'-'.$startmonthlastday;
			}
			else if ($day < 15){
				$depreciationstartdate = $year.'-'.$month.'-1';
			}
			
			
		}
		if ($this->roundyears) {
			$startmonth = intval(date_format($depreciationstartdateobj, 'm'));
			$startyear = intval(date_format($depreciationstartdateobj, 'Y'));
			if ($startmonth >= 6) {
				$depreciationstartdate =  $startyear.'-12-31';
			}
			elseif ($startmonth < 6) {
				$depreciationstartdate =  ($startyear-1).'-12-31';
			}				
		}

		$depreciationstartdateobj = date_create($depreciationstartdate);

		if ($datatype=='monthsdata') {			

			$monthsdata = array();

			
			for ($i=0; $i < intval($totalmonths); $i++) {
					$monthdata = array();

					$depstartdate = date_create($depreciationstartdate);
					$dependdate = date_create(nextdate($depreciationstartdate, 'months', 1));

					$datedifference = date_diff($depstartdate, $dependdate);
					$noofdaysdifference = $datedifference->format('%a');
					

					$perioddepreciation = 0;
					$periodbookvalue = $bookvalue;
					for ($j=0; $j <= $noofdaysdifference; $j++) { 
						$perioddepreciation = $perioddepreciation + (($percentageperday/100)*$bookvalue);
						$periodbookvalue = $periodbookvalue - $perioddepreciation;
					}

					$depreciation = $perioddepreciation;


					
					$invalidaccumulated = $accumulated + $depreciation;

					if ($invalidaccumulated > $lastaccumulatedvalue) {
						$depreciation = $cost - $accumulated;
						$accumulated = $lastaccumulatedvalue;
					}
					else{
						$accumulated = $invalidaccumulated;
					}

					$bookvalue = $cost-$accumulated;

					$accumulated = round($accumulated, 2);					
					$depreciation = round($depreciation, 2);
					$bookvalue = round($bookvalue, 2);
					


					$monthdata['days'] = $noofdaysdifference;
					$monthdata['from'] = date_format($depstartdate, 'Y-m-d');
					$monthdata['to'] = date_format($dependdate, 'Y-m-d');
					$monthdata['depreciation'] = $depreciation;
					$monthdata['accumulated'] = $accumulated;
					$monthdata['bookvalue'] = $bookvalue;
					$monthdata['period'] = $i;

					array_push($monthsdata, $monthdata);
					$depreciationstartdate = date_format($dependdate, 'Y-m-d');					
				}
			return $monthsdata;
		}//end of monthly table
		else if($datatype == 'yearsdata') {
			$yearsdata = array();
			$period = 0;

			while (++$period) {
				$yeardata = array();

				$depstartdate = date_create($depreciationstartdate);
				$dependdate = date_create(nextdate($depreciationstartdate, 'years', 1));
				$datedifference = date_diff($dependdate, $depstartdate);
				$noofdaysdifference = $datedifference->format('%a');


				$perioddepreciation = 0;
				$periodbookvalue = $bookvalue;
				for ($j=0; $j <= $noofdaysdifference; $j++) { 
					$perioddepreciation = $perioddepreciation + (($percentageperday/100)*$bookvalue);
					$periodbookvalue = $periodbookvalue - $perioddepreciation;
				}

					$depreciation = $perioddepreciation;
					
					$invalidaccumulated = $accumulated + $depreciation;

					if ($invalidaccumulated > $lastaccumulatedvalue) {
						
						$accumulated = $lastaccumulatedvalue;
					}
					else{
						$accumulated = $invalidaccumulated;
					}
					$bookvalue = $cost - $accumulated;
					$accumulated = round($accumulated, 2);					
					$depreciation = round($depreciation, 2);
					$bookvalue = round($bookvalue, 2);
					


					$yeardata['days'] = $noofdaysdifference;
					$yeardata['from'] = date_format($depstartdate, 'Y-m-d');
					$yeardata['to'] = date_format($dependdate, 'Y-m-d');
					$yeardata['depreciation'] = $depreciation;
					$yeardata['accumulated'] = $accumulated;
					$yeardata['bookvalue'] = $bookvalue;
					$yeardata['period'] = $period;


				array_push($yearsdata, $yeardata);
				$depreciationstartdate = date_format($dependdate, 'Y-m-d');

				if ($accumulated == $lastaccumulatedvalue) {						
					break;
				}

			}



			return $yearsdata;
		}
		else if ($datatype=='datedata') {
			if ($lastdate==FALSE) {
				$lastdate = date('Y-m-d');
			}
			
			if (!is_validdate($lastdate)) {
				$lastdate = date('Y-m-d');
			}
				$datedata = array();
				$depstartdate = date_create($depreciationstartdate);
				$dependdate = date_create($lastdate);
				
				$datedifference = date_diff($depstartdate, $dependdate);
				$noofdaysdifference = $datedifference->format('%a');
				$noofdaysdifference = $noofdaysdifference;


				$perioddepreciation = 0;
				$periodbookvalue = $bookvalue;

					for ($j=0; $j <= $noofdaysdifference; $j++) { 
						$perioddepreciation = $perioddepreciation + (($percentageperday/100)*$bookvalue);
						$periodbookvalue = $periodbookvalue - $perioddepreciation;
					}

					$depreciation = $perioddepreciation;

				$fullydepreciated = FALSE;
				if ($depreciation >= $lastaccumulatedvalue) {
					$depreciation = $lastaccumulatedvalue;
					$fullydepreciated = TRUE;
				}

				$accumulated = $depreciation;
				$bookvalue = $cost-$accumulated;
				$accumulated = round($accumulated, 2);					
				$depreciation = round($depreciation, 2);
				$bookvalue = round($bookvalue, 2);
					

				$datedata['days'] = $noofdaysdifference;
				$datedata['from'] = date_format($depstartdate, 'Y-m-d');
				$datedata['to'] = date_format($dependdate, 'Y-m-d');
				$datedata['depreciation'] = $depreciation;
				$datedata['accumulated'] = $accumulated;
				$datedata['bookvalue'] = $bookvalue;
				$datedata['cost'] = $cost;
				$datedata['fullydepreciated'] = $fullydepreciated;
				

				return $datedata;
		}		

		return FALSE;	
	}





	public function doubledecliningbalancedata($recId, $datatype='monthsdata', $lastdate=FALSE, $depreciationvars=FALSE){
		$cost = $depreciationvars['cost'];
		$life = $depreciationvars['life'];
		$salvagevalue = $depreciationvars['salvagevalue'];
		$percentage = $depreciationvars['percentage'];
		$use = $depreciationvars['use'];
		$startdate = $depreciationvars['date'];

		
		$amountperyear = $cost*($percentage/100);
		
		$amountperday = $amountperyear/365;
		$percentageperday = round(($percentage/365), 2);

		$accumulated = 0;

		$lastaccumulatedvalue = $cost-$salvagevalue;

		$bookvalue = $cost;


		$depreciationstartdate = $startdate;


		$totalmonths = $life*12;
		$totalyears = $life;

		if ($this->roundmonths) {
			$day = intval(date_format($depreciationstartdateobj, 'd'));
			$month = intval(date_format($depreciationstartdateobj, 'm'));
			$year = intval(date_format($depreciationstartdateobj, 'Y'));

			$startmonthlastday = cal_days_in_month(CAL_GREGORIAN, $month, $year);

			if ($day >= 15) {
				$depreciationstartdate = $year.'-'.$month.'-'.$startmonthlastday;
			}
			else if ($day < 15){
				$depreciationstartdate = $year.'-'.$month.'-1';
			}
			
			
		}
		if ($this->roundyears) {
			$startmonth = intval(date_format($depreciationstartdateobj, 'm'));
			$startyear = intval(date_format($depreciationstartdateobj, 'Y'));
			if ($startmonth >= 6) {
				$depreciationstartdate =  $startyear.'-12-31';
			}
			elseif ($startmonth < 6) {
				$depreciationstartdate =  ($startyear-1).'-12-31';
			}				
		}

		$depreciationstartdateobj = date_create($depreciationstartdate);

		if ($datatype=='monthsdata') {			

			$monthsdata = array();

			
			for ($i=0; $i < intval($totalmonths); $i++) {
					$monthdata = array();

					$depstartdate = date_create($depreciationstartdate);
					$dependdate = date_create(nextdate($depreciationstartdate, 'months', 1));

					$datedifference = date_diff($depstartdate, $dependdate);
					$noofdaysdifference = $datedifference->format('%a');
					

					$perioddepreciation = 0;
					$periodbookvalue = $bookvalue;
					for ($j=0; $j <= $noofdaysdifference; $j++) { 
						$perioddepreciation = $perioddepreciation + (($percentageperday/100)*$bookvalue);
						$periodbookvalue = $periodbookvalue - $perioddepreciation;
					}

					$depreciation = $perioddepreciation;


					
					$invalidaccumulated = $accumulated + $depreciation;

					if ($invalidaccumulated > $lastaccumulatedvalue) {
						$depreciation = $cost - $accumulated;
						$accumulated = $lastaccumulatedvalue;
					}
					else{
						$accumulated = $invalidaccumulated;
					}

					$bookvalue = $cost-$accumulated;

					$accumulated = round($accumulated, 2);					
					$depreciation = round($depreciation, 2);
					$bookvalue = round($bookvalue, 2);
					


					$monthdata['days'] = $noofdaysdifference;
					$monthdata['from'] = date_format($depstartdate, 'Y-m-d');
					$monthdata['to'] = date_format($dependdate, 'Y-m-d');
					$monthdata['depreciation'] = $depreciation;
					$monthdata['accumulated'] = $accumulated;
					$monthdata['bookvalue'] = $bookvalue;
					$monthdata['period'] = $i;

					array_push($monthsdata, $monthdata);
					$depreciationstartdate = date_format($dependdate, 'Y-m-d');					
				}
			return $monthsdata;
		}//end of monthly table
		else if($datatype == 'yearsdata') {
			$yearsdata = array();
			$period = 0;

			while (++$period) {
				$yeardata = array();

				$depstartdate = date_create($depreciationstartdate);
				$dependdate = date_create(nextdate($depreciationstartdate, 'years', 1));

			

				$datedifference = date_diff($dependdate, $depstartdate);
				$noofdaysdifference = $datedifference->format('%a');
				$noofdaysdifference = $noofdaysdifference;

				$perioddepreciation = 0;
				$periodbookvalue = $bookvalue;
				for ($j=0; $j <= $noofdaysdifference; $j++) { 
					$perioddepreciation = $perioddepreciation + (($percentageperday/100)*$bookvalue);
					$periodbookvalue = $periodbookvalue - $perioddepreciation;
				}

					$depreciation = $perioddepreciation;
					
					$invalidaccumulated = $accumulated + $depreciation;

					if ($invalidaccumulated > $lastaccumulatedvalue) {
						
						$accumulated = $lastaccumulatedvalue;
					}
					else{
						$accumulated = $invalidaccumulated;
					}
					$bookvalue = $cost - $accumulated;
					$accumulated = round($accumulated, 2);					
					$depreciation = round($depreciation, 2);
					$bookvalue = round($bookvalue, 2);
					


					$yeardata['days'] = $noofdaysdifference;
					$yeardata['from'] = date_format($depstartdate, 'Y-m-d');
					$yeardata['to'] = date_format($dependdate, 'Y-m-d');
					$yeardata['depreciation'] = $depreciation;
					$yeardata['accumulated'] = $accumulated;
					$yeardata['bookvalue'] = $bookvalue;
					$yeardata['period'] = $period;


				array_push($yearsdata, $yeardata);
				$depreciationstartdate = date_format($dependdate, 'Y-m-d');

				if ($accumulated == $lastaccumulatedvalue) {						
					break;
				}

			}



			return $yearsdata;
		}
		else if ($datatype=='datedata') {
			if ($lastdate==FALSE) {
				$lastdate = date('Y-m-d');
			}
			
			if (!is_validdate($lastdate)) {
				$lastdate = date('Y-m-d');
			}
				$datedata = array();
				$depstartdate = date_create($depreciationstartdate);
				$dependdate = date_create($lastdate);
				
				$datedifference = date_diff($depstartdate, $dependdate);
				$noofdaysdifference = $datedifference->format('%a');
				$noofdaysdifference = $noofdaysdifference;


				$perioddepreciation = 0;
				$periodbookvalue = $bookvalue;

					for ($j=0; $j <= $noofdaysdifference; $j++) { 
						$perioddepreciation = $perioddepreciation + (($percentageperday/100)*$bookvalue);
						$periodbookvalue = $periodbookvalue - $perioddepreciation;
					}

					$depreciation = $perioddepreciation;

				$fullydepreciated = FALSE;
				if ($depreciation >= $lastaccumulatedvalue) {
					$depreciation = $lastaccumulatedvalue;
					$fullydepreciated = TRUE;
				}

				$accumulated = $depreciation;
				$bookvalue = $cost-$accumulated;
				$accumulated = round($accumulated, 2);					
				$depreciation = round($depreciation, 2);
				$bookvalue = round($bookvalue, 2);
					

				$datedata['days'] = $noofdaysdifference;
				$datedata['from'] = date_format($depstartdate, 'Y-m-d');
				$datedata['to'] = date_format($dependdate, 'Y-m-d');
				$datedata['depreciation'] = $depreciation;
				$datedata['accumulated'] = $accumulated;
				$datedata['bookvalue'] = $bookvalue;
				$datedata['cost'] = $cost;
				$datedata['fullydepreciated'] = $fullydepreciated;
				

				return $datedata;
		}		

		return FALSE;	
	}




















































	public function straightLineDepreciation($dataType, $years, $buyingPrice, $serviceDte, $salvageVal, $percUsage, $upToDate){
		$percentageDepPYear = (100/$years);
	    $percentageDepPDay = $percentageDepPYear/365;
	    $amountPerDay = ($buyingPrice - $salvageVal) * ($percentageDepPDay/100);
		

			   if ($dataType=="monthlytable") {
			   			  //initialize variables
					      $startingMdate = $serviceDte;
					      $noOfMonths = $years*12;
					      $monthlyBkValue = $buyingPrice ;
					      $totalMonthDepreciation = 0;
					      $depreciation = 0;
					      $i=0;
					      $s = 0;
					      //start table
					      $returnData  = '<table class="striped highlight">';
					      $returnData .= '<tr class="'.getcolorclass(9).' '.getcolorclass(5).'">
					                          <td colspan="4">Monthly Depreciation</td>
					                      </tr>
					                      <tr>
					                          <td><b>Date Ending</b></td>
					                          <td><b>Depreciation</b></td>
					                          <td><b>Total Depreciation</b></td>
					                          <td><b>Book Value</b></td>
					                      </tr>';
					          	  //start calculation
							      for ($i>0; $i <= ($noOfMonths-1) ; $i++) { 
							      	if ($i == ($noOfMonths-1)) {
							      		$onemonthOn 				= 		date('Y-m-d', strtotime(date('Y-m-d', strtotime($startingMdate))." + 1 month"));
							      	}
							      	else{
							      		$onemonthOn 				= 		date('Y-m-d', strtotime(date('Y-m-d', strtotime($startingMdate))." + 1 month"));
							      	}
							                
							        $startDte 					= 		date_create($startingMdate);
							        $endDte 					= 		date_create($onemonthOn);
							        $intervalMonth 				= 		date_diff($startDte, $endDte);
							        $month_datediff 			= 		$intervalMonth->format('%R%a');
							        $depreciation 				= 		((($percentageDepPDay/100)*($buyingPrice-$salvageVal))*$month_datediff)*($percUsage/100);
							        $totalMonthDepreciation 	= 		$totalMonthDepreciation+($depreciation);
							        $bookValue 					= 		$buyingPrice - $totalMonthDepreciation;
							       	if ($bookValue < 0) {
							       		$totalMonthDepreciation = $totalMonthDepreciation+$bookValue;
							       		$depreciation = $depreciation+$bookValue;
							       		$bookValue = 0;
							       	}
							        $returnData 				.=  '<tr>
							                                          <td>'.$this->datalib->userdateformat($onemonthOn).'</td>
							                                          <td>'.monetaryformat(number_format((float)$depreciation, 2, '.', '')).'</td>
							                                          <td>'.monetaryformat(number_format((float)$totalMonthDepreciation, 2, '.', '')).'</td>
							                                          <td>'.monetaryformat(number_format((float)$bookValue, 2, '.', '')).'</td>
							                                      </tr>';
							        if ($i<($noOfMonths-1)){
							        	
							        		$startingMdate = date('Y-m-d', strtotime($onemonthOn)); 
							        	
							             
							        }


							        
							      }

					      $returnData .= '</table>';
			   }

			   //yearly table
			   elseif ($dataType=="yearlytable") {
			   			  
					      $percentageDepPYear 	= 	(100/$years);
					      $percentageDepPDay 	= 	$percentageDepPYear/365;
					      $amountPerDay 		= 	($buyingPrice - $salvageVal)* ($percentageDepPDay/100);
					      $startingYdte 		=	 $serviceDte;
					      
					      
					      
					      $s = 0;
					      
					      $returnData 		= 	'<table class="striped highlight">';
					      $returnData 		.=  '<tr class="'.getcolorclass(9).' '.getcolorclass(5).'">
					                               	<td colspan="4">Annual Depreciation</td>
					                             </tr>
					                             <tr class="'.getcolorclass(9).' '.getcolorclass(5).'">
					                                 <td><b>Date Ending</b></td>
					                                 <td><b>Depreciation</b></td>
					                                 <td><b>Total Depreciation</b></td>
					                                 <td><b>Book Value</b></td>
					                             </tr>';

					      $totalannualDepreciation = 0;
					      $annualBkValue = $buyingPrice;
					      $annualdepreciation = 0;

					      for ($s>0; $s <=($years-1) ; $s++) { 
					      		if ($s == ($years-1)) {
							      		$oneYearOn 				= 		date('Y-m-d', strtotime(date('Y-m-d', strtotime($startingYdte))." + 1 year"));
							      	}
							      	else{
							      		$oneYearOn 				= 		date('Y-m-d', strtotime(date('Y-m-d', strtotime($startingYdte))." + 1 year"));
							      	}
	      
						        $yearstart 						= 			date_create($startingYdte);
						        $yearend 						= 			date_create($oneYearOn);
						        $interval2 						= 			date_diff($yearstart, $yearend);
						        $form_datediff2 				= 			$interval2->format('%R%a');
						        $annualdepreciation 			= 			((($percentageDepPDay/100)*($buyingPrice-$salvageVal))*$form_datediff2)*($percUsage/100);
						        $totalannualDepreciation 		= 			$totalannualDepreciation+$annualdepreciation;
						        $annualBkValue 					= 			$buyingPrice - $totalannualDepreciation;
						        if ($annualBkValue < 0) {
							       		$totalannualDepreciation = $totalannualDepreciation+$annualBkValue;
							       		$annualdepreciation = $annualdepreciation+$annualBkValue;
							       		$annualBkValue = 0;
							       	}

						        $returnData 	.=  '<tr>
						                                <td>'.$this->datalib->userdateformat($oneYearOn).'</td>
						                                <td>'.monetaryformat(number_format((float)$annualdepreciation, 2, '.', '')).'</td>
						                                <td>'.monetaryformat(number_format((float)$totalannualDepreciation, 2, '.', '')).'</td>
						                                <td>'.monetaryformat(number_format((float)$annualBkValue, 2, '.', '')).'</td>
						                            </tr>';
						          if ($s<($years-1)) {
						            $startingYdte = date('Y-m-d', strtotime($oneYearOn));
						          }
					        
					      }

					      $returnData .= '</table>';
			   }


			   elseif ($dataType=="value") {
			   			$percentageDepPYear 	= 	(100/$years);
					   	$percentageDepPDay 	= 	$percentageDepPYear/365;
					    $amountPerDay 		= 	($buyingPrice - $salvageVal)* ($percentageDepPDay/100);

					    if ($upToDate=="") {
					    	$today 		= 	date_create(date('Y-m-d'));
					    }
					    else{
					    	$today 		= 	date_create($upToDate);
					    }
					    $dteStart 	= 	date_create($serviceDte);
						
						$intervaldays = date_diff($dteStart, $today);
						$noOfDays = $intervaldays->format('%R%a');
						$totalDepreciation 	= $amountPerDay * $noOfDays;
						$currentValue = $buyingPrice - $totalDepreciation;
						if ($currentValue < 0) {
							$currentValue = 0;
						}
						$returnData = monetaryformat(number_format((float)$currentValue, 2, '.', ''));
					    
			   }

			   elseif ($dataType=="accumulated") {
			   			$percentageDepPYear 	= 	(100/$years);
					   	$percentageDepPDay 	= 	$percentageDepPYear/365;
					    $amountPerDay 		= 	($buyingPrice - $salvageVal)* ($percentageDepPDay/100);

					    if ($upToDate=="") {
					    	$today 		= 	date_create(date('Y-m-d'));
					    }
					    else{
					    	$today 		= 	date_create($upToDate);
					    }
					    $dteStart 	= 	date_create($serviceDte);
						
						$intervaldays = date_diff($dteStart, $today);
						$noOfDays = $intervaldays->format('%R%a');
						$totalDepreciation 	= $amountPerDay * $noOfDays;
						$currentValue = $buyingPrice - $totalDepreciation;
						if ($totalDepreciation > $buyingPrice) {
							$totalDepreciation = $buyingPrice;
						}
						$returnData = monetaryformat(number_format((float)$totalDepreciation, 2, '.', ''));
					    
			   }

			   else{
			   	$returnData = 0;
			   }

		return $returnData;
	   
	}

	public function percentagePerAnnumDepreciation($dataType, $years, $buyingPrice, $serviceDte, $salvageVal, $percUsage){
	   
	   
	}

	public function decliningBalanceDepreciation($dataType, $years, $buyingPrice, $serviceDte, $salvageVal, $percUsage){
	   
	   
	}

	public function sumOfYearsDepreciation($dataType, $years, $buyingPrice, $serviceDte, $salvageVal, $percUsage){
	   
	   
	}
}