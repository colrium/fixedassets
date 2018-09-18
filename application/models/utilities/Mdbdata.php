<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdbdata extends CI_Model{

	function __construct(){
		parent::__construct();		     
	}


	public function dbtablerecord($recId, $table, $fkvalues=TRUE, $params=array()){
		$tablefields = $this->tablefields($table);
		$selectSQL = '';

		$returnData = array();
		$headersNames = new stdClass;
		$tablePKColumn = '';
		$joins = array();


		if (array_key_exists('select', $params)) {
			if (is_array($params['select']) && sizeof($params['select']) > 0) {
				$lastselectindex = sizeof($params['select'])-1;
				$selectindex = 0;
				foreach ($params['select'] as $selectkey => $selectvalue) {
						if ($selectkey == 'sum' || $selectkey == 'count') {
							if (is_array($selectvalue)) {
								$scindex = 0;
								foreach ($selectvalue as $sckey => $scvalue) {
									$selectSQL .= strtoupper($selectkey).'('.$sckey.'.'.$scvalue.') AS '.$sckey;
									if ($scindex < (sizeof($scvalue)-1)) {
										$selectSQL .= ', ';
									}
									
									$scindex++;
								}
							}
						}
						else{
							if (is_array($selectvalue)) {
								$selectvaluecursor = 0;
								$selectvaluelastcursor = sizeof($selectvalue)-1;
								foreach ($selectvalue as $selectvaluekey => $selectvaluevalue) {
									$selectSQL .= $selectkey.'.'.$selectvaluevalue.' AS '.$selectvaluevalue;
									if ($selectvaluecursor < $selectvaluelastcursor) {
										$selectSQL .= ', ';
									}
									$selectvaluecursor++;
								}
							}
							else{
								$selectSQL .= $selectkey.'.'.$selectvalue.' AS '.$selectvalue;
							}
							
						}
						if ($selectindex < $lastselectindex) {
							$selectSQL .= ', ';
							
						}
					
					$selectindex++;
				}
			}
			else{
				$selectSQL .= $params['select'];
			}
		}

		if (array_key_exists('joins', $params)) {
			if (is_array($params['joins'])) {
				$joins = array_merge($joins, $params['joins']);
			}
		}

		if(is_array($tablefields) && sizeof($tablefields) > 0 ){
			$iteratingindex = 0;
			$finalarrindex = sizeof($tablefields)-1;
			$selectSQL = trim($selectSQL);
			if (strlen($selectSQL) > 0) {
				$selectSQL .= ', ';
			}
			
			$fktables = array();
			$tablePKfield = '';
			foreach ($tablefields as $key => $value) {
				$fieldinitialName = $value->initialName;
				$headersNames->$fieldinitialName = $value->setName;

				if ($value->isPK) {
					$tablePKfield = $fieldinitialName;
				}

				$haspriveledge = haspriveledge($value->parentTable, $value->module, FALSE);
					if ($value->isFK == '1') {
						if ($fkvalues) {
							if ($value->tableFKname != $table) {
								if (array_key_exists($value->tableFKname, $joins)) {
									if (!array_key_exists($value->initialName, $joins[$value->tableFKname])) {
										$joins[$value->tableFKname][$value->initialName] = $value->fkTableRecPK;
									}
								}
								else{
									$joins[$value->tableFKname][$value->initialName] = $value->fkTableRecPK;
								}
							}
								

							$fkTableRecNames = explode(',', $value->fkTableRecName);
							$fkTableRecNameSQL = '';
							foreach ($fkTableRecNames as $fkTableRecNamekey => $fkTableRecNamevalue) {
								$fkTableRecNameSQL .= ''.$value->tableFKname.'.'.$fkTableRecNamevalue;
								if ($fkTableRecNamekey < (sizeof($fkTableRecNames)-1)) {
									$fkTableRecNameSQL .= ', ';
								}
							}

							$selectSQL .= "CONCAT_WS(' ', $fkTableRecNameSQL) AS ".$value->initialName;
						}
						else{
							$selectSQL .= 'IFNULL('.$value->parentTable.'.'.$value->initialName.', "") AS '.$value->initialName;
						}
						
					}
					else{						
						if ($value->dataType == 'date') {
							$selectSQL .= "IF(".$value->parentTable.".".$value->initialName." IS NULL, '', (CASE  ".$value->parentTable.".".$value->initialName." WHEN '0000-00-00' THEN '' ELSE ".$value->parentTable.".".$value->initialName." END))  AS ".$value->initialName;
						}
						else{
							$selectSQL .= 'IFNULL('.$value->parentTable.'.'.$value->initialName.', "") AS '.$value->initialName;
						}
					}

					if($iteratingindex < $finalarrindex){
						$selectSQL .= ', ';
					}
				


				$iteratingindex++;
			}
			$tableSQL = ''.$table.' ';

			if (sizeof($joins) > 0) {
				$tablejoinSQL = ' ';
				foreach ($joins as $joinkey => $joinvalue) {
					$tablejoinSQL .= ' LEFT JOIN '.$joinkey;

					if (sizeof($joinvalue)>0) {
						$tablejoinSQL .= ' ON ';
						$joinvaluelastindex = sizeof($joinvalue)-1;
						$joinvalueindex = 0;
						foreach ($joinvalue as $onkey => $onvalue) {
							$tablejoinSQL .= ' '.$table.'.'.$onkey.' = '.$joinkey.'.'.$onvalue;
							if ($joinvalueindex < $joinvaluelastindex) {
								$tablejoinSQL .= ' OR ';
							}

							$joinvalueindex++;
						}
					}
					
				}

				
				$tableSQL .= ' '.$tablejoinSQL;
			}

			$sqlStr ="SELECT $selectSQL FROM $tableSQL WHERE 1 AND ".$table.".".$tablePKfield." = ".prepsqlstringvar($recId).";";

			$query = $this->db->query($sqlStr);
			$dbresults = $query->result();
								

			if (sizeof($dbresults) > 0) {				
				return $dbresults[0];		
			}
			else{
				return FALSE;			
			}
				
		}
		else{
			return FALSE;
		}

	}












	public function dbtablerecords($table, $params=array(), $includeheaders=FALSE, $fkvalues=TRUE, $onlyvisiblecolumns=FALSE, $onlyappcolumns=FALSE){

		$tablefields = $this->tablefields($table);
		if ($onlyvisiblecolumns) {
			$onlyappcolumns=FALSE;
			$tablefields = $this->tablefields($table, 'isDashShown', 1);
		}
		if ($onlyappcolumns) {
			$tablefields = $this->tablefields($table, 'isAppData', 1);
		}
		
		$selectSQL = '';
		$returnData = array();
		$headersNames = new stdClass;
		$joins = array();
		$datapriveledges = $this->ion_auth->datapriveledges(USERID, FALSE);

		$sqlStr = "";

		if (array_key_exists('select', $params)) {
			if (is_array($params['select'])) {
				$lastselectindex = sizeof($params['select'])-1;
				$selectindex = 0;
				foreach ($params['select'] as $selectkey => $selectvalue) {
						if ($selectkey == 'sum' || $selectkey == 'count') {
							if (is_array($selectvalue)) {
								$scindex = 0;
								foreach ($selectvalue as $sckey => $scvalue) {
									$selectSQL .= strtoupper($selectkey).'('.$sckey.'.'.$scvalue.') AS '.$scvalue.'_'.strtolower($selectkey);
									if ($scindex < (sizeof($selectvalue)-1)) {
										$selectSQL .= ', ';
									}
									
									$scindex++;
								}
							}
							else{
								$selectSQL .= strtoupper($selectkey).'('.$table.'.'.$selectvalue.') AS '.$selectvalue.'_'.strtolower($selectkey);
							}
						}
						else{
							if (is_array($selectvalue)) {
								$selectvaluecursor = 0;
								$selectvaluelastcursor = sizeof($selectvalue)-1;
								foreach ($selectvalue as $selectvaluekey => $selectvaluevalue) {
									$selectSQL .= $selectkey.'.'.$selectvaluevalue.' AS '.$selectvaluevalue;
									if ($selectvaluecursor < $selectvaluelastcursor) {
										$selectSQL .= ', ';
									}
									$selectvaluecursor++;
								}
							}
							else{
								$selectSQL .= $selectkey.'.'.$selectvalue.' AS '.$selectvalue;
							}
							
						}
						if ($selectindex < $lastselectindex) {
							$selectSQL .= ', ';
							
						}
					
					$selectindex++;
				}
			}
			else{
				$selectSQL .= $params['select'];
			}
		}

		if (array_key_exists('joins', $params)) {
			if (is_array($params['joins'])) {
				$joins = array_merge($joins, $params['joins']);
			}
		}

		if(is_array($tablefields) && sizeof($tablefields) > 0 ){
			$iteratingindex = 0;
			$finalarrindex = sizeof($tablefields)-1;
			$selectSQL = trim($selectSQL);
			if (strlen($selectSQL) > 0) {
				$selectSQL .= ', ';
			}
			
			$fktables = array();
			$tablePKfield = '';
			foreach ($tablefields as $key => $value) {				
				$fieldinitialName = $value->initialName;
				$headersNames->$fieldinitialName = $value->setName;

				if ($value->isPK) {
					$tablePKfield = $fieldinitialName;
				}

				$haspriveledge = haspriveledge($value->parentTable, $value->module, FALSE);
					if ($value->isFK == '1') {
						if ($fkvalues) {
							if ($value->tableFKname != $table) {
								if (array_key_exists($value->tableFKname, $joins)) {
									if (!array_key_exists($value->initialName, $joins[$value->tableFKname])) {
										$joins[$value->tableFKname][$value->initialName] = $value->fkTableRecPK;
									}
								}
								else{
									$joins[$value->tableFKname][$value->initialName] = $value->fkTableRecPK;
								}
							}
								

							$fkTableRecNames = explode(',', $value->fkTableRecName);
							$fkTableRecNameSQL = '';
							foreach ($fkTableRecNames as $fkTableRecNamekey => $fkTableRecNamevalue) {
								$fkTableRecNameSQL .= ''.$value->tableFKname.'.'.$fkTableRecNamevalue;
								if ($fkTableRecNamekey < (sizeof($fkTableRecNames)-1)) {
									$fkTableRecNameSQL .= ', ';
								}
							}

							$selectSQL .= "CONCAT_WS(' ', $fkTableRecNameSQL) AS ".$value->initialName;
						}
						else{
							$selectSQL .= 'IFNULL('.$value->parentTable.'.'.$value->initialName.', "") AS '.$value->initialName ;
						}
						
					}
					else{						
						if ($value->dataType == 'date') {
							$selectSQL .= "IF(".$value->parentTable.".".$value->initialName." IS NULL, '', (CASE  ".$value->parentTable.".".$value->initialName." WHEN '0000-00-00' THEN '' ELSE ".$value->parentTable.".".$value->initialName." END))  AS ".$value->initialName;
						}
						else{
							$selectSQL .= 'IFNULL('.$value->parentTable.'.'.$value->initialName.', "") AS '.$value->initialName ;
						}
					}

					if($iteratingindex < $finalarrindex){
						$selectSQL .= ', ';
					}
				


				$iteratingindex++;
			}
			$tableSQL = ''.$table.' ';

			if (sizeof($joins) > 0) {
				$tablejoinSQL = ' ';
				foreach ($joins as $joinkey => $joinvalue) {
					$tablejoinSQL .= ' LEFT JOIN '.$joinkey;

					if (sizeof($joinvalue)>0) {
						$tablejoinSQL .= ' ON ';
						$joinvaluelastindex = sizeof($joinvalue)-1;
						$joinvalueindex = 0;
						foreach ($joinvalue as $onkey => $onvalue) {
							$tablejoinSQL .= ' '.$table.'.'.$onkey.' = '.$joinkey.'.'.$onvalue;
							if ($joinvalueindex < $joinvaluelastindex) {
								$tablejoinSQL .= ' OR ';
							}

							$joinvalueindex++;
						}
					}
					
				}

				
				$tableSQL .= ' '.$tablejoinSQL;
			}


			$sqlStr ="SELECT $selectSQL FROM $tableSQL ";
			$whereExtraSql = " WHERE 1 ";
			$orderbyExtraSql = " ";

			foreach ($datapriveledges['allowed'] as $allowedprivkey => $allowedprivvalue) {
				if (array_key_exists($allowedprivkey, $joins)) {									
						foreach ($allowedprivvalue as $allowedprivvaluekey => $allowedprivvaluevalue) {
							$whereinstr = '';
							foreach ($allowedprivvaluevalue as $allowedprivvaluevaluekey => $allowedprivvaluevaluevalue) {
								$whereinstr .= prepsqlstringvar($allowedprivvaluevaluevalue);
								if ($allowedprivvaluevaluekey < (sizeof($allowedprivvaluevalue)-1)) {
									$whereinstr .= ', ';
								}
							}
							if (strlen($whereinstr)>0) {
								$whereExtraSql .= " AND ".$allowedprivkey.".".$allowedprivvaluekey." IN (".$whereinstr.") ";
							}
							
						}
				}
				else if ($allowedprivkey == $table) {
					foreach ($allowedprivvalue as $allowedprivvaluekey => $allowedprivvaluevalue) {
						$whereinstr = '';
						foreach ($allowedprivvaluevalue as $allowedprivvaluevaluekey => $allowedprivvaluevaluevalue) {
							$whereinstr .= prepsqlstringvar($allowedprivvaluevaluevalue);
							if ($allowedprivvaluevaluekey < (sizeof($allowedprivvaluevalue)-1)) {
								$whereinstr .= ', ';
							}
						}
						if (strlen($whereinstr)>0) {
							$whereExtraSql .= " AND ".$allowedprivkey.".".$allowedprivvaluekey." IN (".$whereinstr.") ";
						}
						
					}
				}
			}

			foreach ($datapriveledges['forbidden'] as $forbiddenprivkey => $forbiddenprivvalue) {
				if (array_key_exists($forbiddenprivkey, $joins)) {									
						foreach ($forbiddenprivvalue as $forbiddenprivvaluekey => $forbiddenprivvaluevalue) {
							$whereinstr = '';
							foreach ($forbiddenprivvaluevalue as $forbiddenprivvaluevaluekey => $forbiddenprivvaluevaluevalue) {
								$whereinstr .= prepsqlstringvar($forbiddenprivvaluevaluevalue);
								if ($forbiddenprivvaluevaluekey < (sizeof($forbiddenprivvaluevalue)-1)) {
									$whereinstr .= ', ';
								}
							}
							$whereExtraSql .= " AND ".$forbiddenprivkey.".".$forbiddenprivvaluekey." NOT IN (".$whereinstr.") ";
						}
				}
				else if ($forbiddenprivkey == $table) {
					foreach ($forbiddenprivvalue as $forbiddenprivvaluekey => $forbiddenprivvaluevalue) {
						$whereinstr = '';
						foreach ($forbiddenprivvaluevalue as $forbiddenprivvaluevaluekey => $forbiddenprivvaluevaluevalue) {
							$whereinstr .= prepsqlstringvar($forbiddenprivvaluevaluevalue);
							if ($forbiddenprivvaluevaluekey < (sizeof($forbiddenprivvaluevalue)-1)) {
								$whereinstr .= ', ';
							}
						}
						$whereExtraSql .= " AND ".$forbiddenprivkey.".".$forbiddenprivvaluekey." NOT IN (".$whereinstr.") ";
					}
				}
			}

			if (is_array($params) && sizeof($params) > 0) {
				
				if (array_key_exists('where', $params)) {
															
					if (is_array($params['where'])) {
						$wherearray = $params['where'];
						if (array_key_exists('equalto', $wherearray)) {
							if (is_array($wherearray['equalto'])) {
								foreach ($wherearray['equalto'] as $key => $value) {
									if (is_array($value) && sizeof($value)>0) {
										if (isassociativearray($value)) {
											foreach ($value as $valuekey => $valuevalue) {
												$whereExtraSql .= " AND ".$key.".".$valuekey." = ".prepsqlstringvar($valuevalue)." ";
											}
										}
										else{
											$whereExtraSql .= " AND ".$table.".".$key." IN (";
												foreach ($value as $valuekey => $valuevalue) {
													$whereExtraSql .= prepsqlstringvar($valuevalue);
													if ($valuekey < (sizeof($value)-1)) {
														$whereExtraSql .= ", ";
													}
												}
											$whereExtraSql .= ") ";
										}
									}
									else{
										$whereExtraSql .= " AND ".$table.".".$key." = ".prepsqlstringvar($value)." ";
									}
									
								}
							}
							else if (strlen($wherearray['equalto']) > 0) {
								$whereExtraSql .= " ".$wherearray['equalto']." ";
							}
							
						}
						if (array_key_exists('notequalto', $wherearray)) {
							if (is_array($wherearray['notequalto'])) {
								foreach ($wherearray['notequalto'] as $key => $value) {
									if (is_array($value)) {
										foreach ($value as $valuekey => $valuevalue) {
											$whereExtraSql .= " AND ".$key.".".$valuekey." != ".prepsqlstringvar($valuevalue)." ";
										}
									}
									else{
										$whereExtraSql .= " AND ".$table.".".$key." != ".prepsqlstringvar($value)." ";
									}
								}
							}
							else if (strlen($wherearray['notequalto']) > 0) {
								$whereExtraSql .= " ".$wherearray['notequalto']." ";
							}
							
						}

						if (array_key_exists('like', $wherearray)) {
							if (is_array($wherearray['like']) && sizeof($wherearray['like']) > 0) {
								$whereExtraSql .= " AND ";
								$likesindex = 0;
								if (isassociativearray($wherearray['like'])) {
									$likeloopstarted = FALSE;
									foreach ($wherearray['like'] as $searchkey => $searchvalue) {
										if ($likeloopstarted) {
											$whereExtraSql .= " OR ";
										}
										else{
											$likeloopstarted = TRUE;
										}
										$whereExtraSql .= $searchkey." LIKE ".prepsqlstringvar('%'.$searchvalue.'%', "'");
									}
								}
								else{
									foreach ($tablefields as $field) {
										$fieldname = $table.".".$field->initialName;
										if ($field->isFK) {
											$fieldnamearr = explode(',', $field->fkTableRecName);
											$fieldname = '';
											foreach ($fieldnamearr as $fieldnamearrkey => $fieldnamearrval) {
												$fieldname .= ''.$field->tableFKname.'.'.$fieldnamearrval;
												if ($fieldnamearrkey < (sizeof($fieldnamearr)-1)) {
													$fieldname .= ', ';
												}
											}
											$fieldname = "CONCAT_WS(' ', $fieldname)";
										}
										foreach ($wherearray['like'] as $key => $value) {
												if ($likesindex > 0) {
													$whereExtraSql .= " OR ";
												}
												$whereExtraSql .= $fieldname." LIKE ".prepsqlstringvar('%'.$value.'%', "'");
										}
										$likesindex++;
									}
								}

									
										
							}
							else if (strlen($wherearray['like']) > 0) {
								$whereExtraSql .= " ".$wherearray['like']." ";
							}								
						}

						if (array_key_exists('lessthan', $wherearray)) {
							if (is_array($wherearray['lessthan'])) {
								foreach ($wherearray['lessthan'] as $key => $value) {
									$whereExtraSql .= " AND ".$table.".".$key." < ".prepsqlstringvar($value)." ";
								}
							}
							else if (strlen($wherearray['lessthan']) > 0) {
								$whereExtraSql .= " ".$wherearray['lessthan']." ";
							}
							
						}
						if (array_key_exists('morethan', $wherearray)) {
							if (is_array($wherearray['morethan'])) {
								foreach ($wherearray['morethan'] as $key => $value) {
									$whereExtraSql .= " AND ".$table.".".$key." > ".prepsqlstringvar($value)." ";
								}
							}
							else if (strlen($wherearray['morethan']) > 0) {
								$whereExtraSql .= " ".$wherearray['morethan']." ";
							}
								
						}
						if (array_key_exists('between', $wherearray)) {
							if (is_array($wherearray['between'])) {
								foreach ($wherearray['between'] as $key => $value) {
									if (is_array($value)) {
										if (sizeof($value) == 2) {
											$whereExtraSql .= " AND ".$table.".".$key." BETWEEN ".prepsqlstringvar($value[0])." AND ".prepsqlstringvar($value[1])." ";
										}
									}
									
								}
							}
							else if (strlen($wherearray['between']) > 0) {
								$whereExtraSql .= " ".$wherearray['between']." ";
							}
								
						}
					}
					else{
						if (strlen($params['where']) > 0) {
							$whereExtraSql = "WHERE 1 AND ".$params['where'];
						}
					}

					
				}


				


				

			}
			else{
				$sqlStr = "SELECT $selectSQL FROM $tableSQL";
			}
			$sqlStr .= $whereExtraSql;

			
			if (array_key_exists('groupby', $params)) {
				if (is_array($params['groupby']) && sizeof($params['groupby']) > 0) {
					$sqlStr .= ' GROUP BY ';
					if (isassociativearray($params['groupby'])) {
						$lastgrpbyindex = sizeof($params['groupby'])-1;
						$grpbyindex = 0;

						foreach ($params['groupby'] as $groupbykey => $groupbyvalue) {
							$sqlStr .= $groupbykey.".".$groupbyvalue;
							if ($grpbyindex < $lastgrpbyindex) {
								$sqlStr .= ", ";
							}

							$grpbyindex++;
						}
					}
					else{
						$sqlStr .= ' '.implode(', ', $params['groupby']);
					}
					
				}				
			}
			else{
				if (strlen($tablePKfield) > 0) {
					$sqlStr .= ' GROUP BY '.$table.'.'.$tablePKfield;
				}
			}
			
			if (array_key_exists('orderby', $params)) {						
						if (is_array($params['orderby'])) {
							$orderbyExtraSql = " ORDER BY ";
							if (isassociativearray($params['orderby'])) {
								$orderbylastindex = sizeof($params['orderby'])-1;
								$orderbycursor = 0;
								foreach ($params['orderby'] as $orderkey => $ordervalue) {
									if (is_array($ordervalue)) {
										$ordervaluelastindex = sizeof($ordervalue)-1;
										for ($i=0; $i <= $ordervaluelastindex; $i++) { 
											$orderbyExtraSql .= $orderkey.'.'.$ordervalue[$i];
											if ($i < $ordervaluelastindex) {
												$orderbyExtraSql .= ',';
											}
										}
									}
									else{
										$orderbyExtraSql .= $orderkey.'.'.$ordervalue;
									}
									if ($orderbycursor < $orderbylastindex) {
										$orderbyExtraSql .= ',';
									}
									
									$orderbycursor++;  
								}
							}
							else{
								$orderbyExtraSql .= implode(',', $params['orderby']);
							}
							
						}	
						else{
							$orderbyExtraSql = " ORDER BY ";
							$orderbyExtraSql .= $params['orderby'];
						}

					$sqlStr .= " ".$orderbyExtraSql;
			}



			$sqlStr .= ";";

			$query = $this->db->query($sqlStr);
			$dbresults = $query->result();
								

			if (sizeof($dbresults) > 0) {
				if ($includeheaders) {
					if (sizeof($headersNames) > 0) {
						array_unshift($dbresults, $headersNames);
					}
				}
				return $dbresults;		
			}
			else{
				if ($includeheaders) {
					return array($headersNames);
				}
				else{
					return FALSE;
				}
				
			}
				
		}
		else{
			return FALSE;
		}
	}

	
	public function dbtablerecordscount($table, $params){
		$tablefields = $this->tablefields($table);
		$datapriveledges = $this->ion_auth->datapriveledges(USERID, FALSE);
		$tablejoinSQL = ' ';
		$whereExtraSql = " WHERE 1 ";
		$joins = array();

		foreach ($tablefields as $key => $value) {
			$fieldinitialName = $value->initialName;
				if ($value->isFK == '1') {
					if (array_key_exists($value->tableFKname, $datapriveledges['allowed']) || array_key_exists($value->tableFKname, $datapriveledges['forbidden'])) {
						if ($value->tableFKname != $table) {
							if (array_key_exists($value->tableFKname, $joins)) {
								if (!array_key_exists($value->initialName, $joins[$value->tableFKname])) {
									$joins[$value->tableFKname][$value->initialName] = $value->fkTableRecPK;
								}
							}
							else{
								$joins[$value->tableFKname][$value->initialName] = $value->fkTableRecPK;
							}

						}
					}						
				}
		}

		if (is_array($params)) {
			if (array_key_exists('joins', $params)) {
				if (is_array($params['joins'])) {
					$joins = array_merge($joins, $params['joins']);
				}
			}
			foreach ($params as $key => $value) {
				if ($key == 'where') {
					foreach ($value as $wherekey => $wherevalue) {
						if ($wherekey == 'equalto') {
							if (is_array($wherevalue)) {
								foreach ($wherevalue as $wherevaluekey => $wherevaluevalue) {
									$whereExtraSql .= " AND ".$wherevaluekey." = ".prepsqlstringvar($wherevaluevalue);
								}
							}
							else{
								$whereExtraSql .= $wherevalue;
							}
								
						}

						if ($wherekey == 'notequalto') {
							if (is_array($wherevalue)) {
								foreach ($wherevalue as $wherevaluekey => $wherevaluevalue) {
									$whereExtraSql .= " AND ".$wherevaluekey." != ".prepsqlstringvar($wherevaluevalue);
								}
							}
							else{
								$whereExtraSql .= $wherevalue;
							}
								
						}

						if ($wherekey == 'like') {
							if (is_array($wherevalue)) {
								foreach ($wherevalue as $wherevaluekey => $wherevaluevalue) {
									$whereExtraSql .= " OR ".$wherevaluekey." LIKE ".prepsqlstringvar('%'.$wherevaluevalue.'%');
								}
							}
							else{
								$whereExtraSql .= $wherevalue;
							}
								
						}

						if ($wherekey == 'lessthan') {
							if (is_array($wherevalue)) {
								foreach ($wherevalue as $wherevaluekey => $wherevaluevalue) {
									$whereExtraSql .= " AND ".$wherevaluekey." < ".prepsqlstringvar($wherevaluevalue);
								}
							}
							else{
								$whereExtraSql .= $wherevalue;
							}
								
						}
					}
				}
						

			}
		}
		else{
			$whereExtraSql = $params;
		}


		if (sizeof($joins) > 0) {				
				foreach ($joins as $joinkey => $joinvalue) {
					$tablejoinSQL .= ' LEFT JOIN '.$joinkey;

					if (sizeof($joinvalue)>0) {
						$tablejoinSQL .= ' ON ';
						$joinvaluelastindex = sizeof($joinvalue)-1;
						$joinvalueindex = 0;
						foreach ($joinvalue as $onkey => $onvalue) {
							$tablejoinSQL .= ' '.$table.'.'.$onkey.' = '.$joinkey.'.'.$onvalue;
							if ($joinvalueindex < $joinvaluelastindex) {
								$tablejoinSQL .= ' OR ';
							}

							$joinvalueindex++;
						}
					}
					
				}
		}

		foreach ($datapriveledges['allowed'] as $allowedprivkey => $allowedprivvalue) {
				if (array_key_exists($allowedprivkey, $joins)) {									
						foreach ($allowedprivvalue as $allowedprivvaluekey => $allowedprivvaluevalue) {
							$whereinstr = '';
							foreach ($allowedprivvaluevalue as $allowedprivvaluevaluekey => $allowedprivvaluevaluevalue) {
								$whereinstr .= prepsqlstringvar($allowedprivvaluevaluevalue);
								if ($allowedprivvaluevaluekey < (sizeof($allowedprivvaluevalue)-1)) {
									$whereinstr .= ', ';
								}
							}
							$whereExtraSql .= " AND ".$allowedprivkey.".".$allowedprivvaluekey." IN (".$whereinstr.") ";
						}
				}
				else if ($allowedprivkey == $table) {
					foreach ($allowedprivvalue as $allowedprivvaluekey => $allowedprivvaluevalue) {
						$whereinstr = '';
						foreach ($allowedprivvaluevalue as $allowedprivvaluevaluekey => $allowedprivvaluevaluevalue) {
							$whereinstr .= prepsqlstringvar($allowedprivvaluevaluevalue);
							if ($allowedprivvaluevaluekey < (sizeof($allowedprivvaluevalue)-1)) {
								$whereinstr .= ', ';
							}
						}
						$whereExtraSql .= " AND ".$allowedprivkey.".".$allowedprivvaluekey." IN (".$whereinstr.") ";
					}
				}
		}

		foreach ($datapriveledges['forbidden'] as $forbiddenprivkey => $forbiddenprivvalue) {
				if (array_key_exists($forbiddenprivkey, $joins)) {									
						foreach ($forbiddenprivvalue as $forbiddenprivvaluekey => $forbiddenprivvaluevalue) {
							$whereinstr = '';
							foreach ($forbiddenprivvaluevalue as $forbiddenprivvaluevaluekey => $forbiddenprivvaluevaluevalue) {
								$whereinstr .= prepsqlstringvar($forbiddenprivvaluevaluevalue);
								if ($forbiddenprivvaluevaluekey < (sizeof($forbiddenprivvaluevalue)-1)) {
									$whereinstr .= ', ';
								}
							}
							$whereExtraSql .= " AND ".$forbiddenprivkey.".".$forbiddenprivvaluekey." NOT IN (".$whereinstr.") ";
						}
				}
				else if ($forbiddenprivkey == $table) {
					foreach ($forbiddenprivvalue as $forbiddenprivvaluekey => $forbiddenprivvaluevalue) {
						$whereinstr = '';
						foreach ($forbiddenprivvaluevalue as $forbiddenprivvaluevaluekey => $forbiddenprivvaluevaluevalue) {
							$whereinstr .= prepsqlstringvar($forbiddenprivvaluevaluevalue);
							if ($forbiddenprivvaluevaluekey < (sizeof($forbiddenprivvaluevalue)-1)) {
								$whereinstr .= ', ';
							}
						}
						$whereExtraSql .= " AND ".$forbiddenprivkey.".".$forbiddenprivvaluekey." NOT IN (".$whereinstr.") ";
					}
				}
		}
			
		$sqlStr ="SELECT COUNT(*) AS total FROM $table ".$tablejoinSQL." ".$whereExtraSql.";";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			return  $results[0]->total;
		}
		else{
			return FALSE;
		}
	}

	public function dbmoduletables($module){
		$sqlStr ="SELECT parentTable, parentTableName, parentTableIcon, initialName AS PKinitialName, setName AS PKsetName  FROM field_names WHERE module=".prepsqlstringvar($module)." AND isPK='1';";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			return  $results;
		}
		else{
			return FALSE;
		}
	}

	public function dbmoduletablename($table){
		$sqlStr ="SELECT DISTINCT parentTable, parentTableName FROM field_names WHERE parentTable = ".prepsqlstringvar($table).";";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			return  $results[0]->parentTableName;
		}
		else{
			return FALSE;
		}
	}

	public function tablefields($table, $filtercolumn=FALSE, $filtervalue=FALSE){
		$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($table);
		if ($filtercolumn !=FALSE) {
			if ($filtervalue != FALSE) {
				$sqlStr .= ' AND '.$filtercolumn.'='.prepsqlstringvar($filtervalue);
			}
		}
		$sqlStr .= ' ORDER BY fieldId ASC;';
		
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			return  $results;
		}
		else{
			return FALSE;
		}
	}

	public function dbfieldsetname($table, $fieldname){
		$sqlStr ="SELECT setName FROM field_names WHERE parentTable = ".prepsqlstringvar($table)." AND initialName = ".prepsqlstringvar($fieldname).";";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			return  $results[0]->setName;
		}
		else{
			return '';
		}
	}

	public function dbtablemodule($table){
		$sqlStr ="SELECT module FROM field_names WHERE parentTable = ".prepsqlstringvar($table).";";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			return  $results[0]->module;
		}
		else{
			return '';
		}
	}

	public function dbmodulefields($module){
		$sqlStr ="SELECT * FROM field_names WHERE module = ".prepsqlstringvar($module).";";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			return  $results;
		}
		else{
			return FALSE;
		}
	}

	

	public function addupdatedbtablerecord($table, $data, $recId){
		$tablefields = array();
		$tablePKColumn = FALSE;
		$pkinitialname = '';
		if (!$this->db->table_exists($table)) {
			show_error('No table found with the name ::'.$table, 500);
			return FALSE;
		}
		else{
			foreach ($this->tablefields($table) as $fieldkey => $fieldvalue) {
				array_push($tablefields, $fieldvalue->initialName);
				if (boolval($fieldvalue->isPK)) {
					$tablePKColumn = $fieldvalue;
					$pkinitialname = $fieldvalue->initialName;
				}
			}
			$actionuser = 0;
			if (isloggedin(FALSE)) {
				if (null !== USERID) {
					$actionuser = USERID;
				}
				else{
					$user = $this->ion_auth->user()->row();
					$actionuser = $user->id;
				}
				
			}
			

			$sqlExtra = '';
			$last_insert_guid = genrandomstrid($tablePKColumn->dataLength);
			
			if ($recId=='0') {				
				if (array_key_exists($pkinitialname, $data)) {
					$insert_guid = trim($data[$pkinitialname]);
					if (strlen($insert_guid) == $tablePKColumn->dataLength) {
						$last_insert_guid = $insert_guid;						
					}
				}
				$data[$pkinitialname] = $last_insert_guid;

			}
			


				
			
			
			$cleaneddata = array();
			foreach ($data as $key => $value) {
				if (in_array($key, $tablefields)) {
					$cleaneddata[$key] = $value;
				}
			}
			$datacursor = 0;
			$datasize = sizeof($cleaneddata);
			$lastdatacursor = $datasize - 1;

			foreach ($cleaneddata as $key => $value) {
				if (!is_array($value)) {
					$sqlExtra .= $key." = ".prepsqlstringvar($value);
					if ($datacursor < $lastdatacursor) {
						$sqlExtra .= ", ";
					}						
				}
					
				$datacursor++;
			}

			if ($recId=='0') {
				if ($tablePKColumn != FALSE) {
					$sqlStr ="INSERT INTO $table SET $sqlExtra;";
					$query = $this->db->query($sqlStr);
					if ($query) {
						$recordId = $data[$tablePKColumn->initialName];
					}
					else{
						$recordId = addupdatedbtablerecord($table, $data, $recId);
					}
					
				}
				else{
					show_error('No PK Field found for table ::'.$table, 500);
					return FALSE;
				}
			}
			else{
				if ($tablePKColumn != FALSE) {
					$sqlStr ="UPDATE $table SET $sqlExtra WHERE ".$tablePKColumn->initialName." = ".prepsqlstringvar($recId).";";
					$query = $this->db->query($sqlStr);
					$recordId = $recId;
				}
				else{
					show_error('No PK Field found for table ::'.$table, 500);
					return FALSE;
				}
				
			}
			return $recordId;
		}
			
	}

	


	public function deletedbtablerecords($table, $filters, $permanent=FALSE){
		$tablePKColumn = $this->dbtablepkcolumn($table);
		$pkinitialname = $tablePKColumn->initialName;
		$deletedrecords = array();
		$params = array();
		$params['where']['equalto'] = array();

		$sqlStr = "DELETE FROM ".prepsqlstringvar($table, '`')." WHERE 1 ";
		foreach ($filters as $key => $value) {
			if ($permanent==FALSE) {
				$params['where']['equalto'][$key] = $value;				
			}
			$sqlStr .= " AND ".prepsqlstringvar($key, '`')." = ".prepsqlstringvar($value);

		}
		if ($permanent==FALSE) {
			$records = dbtablerecords($table, $params, FALSE);
			foreach ($records as $record) {
				array_push($deletedrecords, $record);
			}
		}

		$query = $this->db->query($sqlStr);


		if ($permanent==FALSE) {
			$module = $this->dbtablemodule($table);

			foreach ($deletedrecords as $key => $value) {
				$valuearray = objecttoarrayrecursivecast($value);
				$data = array();
				$data['module'] = $module;
				$data['entity'] = $table;
				$data['data'] = json_encode($valuearray);
				$data['timestamp'] = date('Y-m-d H:i:s');
				$data['user'] = USERID;
				$this->addupdatedbtablerecord('recyclebin', $data, '0',FALSE);
			}
		}
			
		return TRUE;
			
	}

	public function dbaddattachmentlog($data, $savefiletodb=FALSE){
		$this->load->helper('file');
		$recordId = 0;
		$sqlExtra = '';
		$datacursor = 0;
		if ($savefiletodb) {
			if (array_key_exists('file_dir', $data)) {
				$filedata = read_file($data['file_dir']);
				$data['file']  = base64_encode($filedata);
				if (file_exists($data['file_dir'])) {
					unlink($data['file_dir']);
				}
			}
		}
		else{
			if (array_key_exists('file_dir', $data)) {
				$data['file']  = $data['file_dir'];
			}
		}
			
		$datasize = sizeof($data);
		$lastdatacursor = $datasize - 1;

		if ($savefiletodb) {
			$file = addslashes($data['file']);
			$data['file'] = $file;
		}

		$recordId = $this->addupdatedbtablerecord('attachments', $data, '0');
		return $recordId;
				
	}


	public function dbtablepkcolumn($table){
		$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($table)." AND isPK = '1';";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			return  $results[0];
		}
		else{
			return FALSE;
		}
	}

	public function dbtabledependantfields($table){
		$sqlStr ="SELECT * FROM field_names WHERE isFK = '1' AND tableFKname = ".prepsqlstringvar($table).";";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			return  $results;
		}
		else{
			return FALSE;
		}
	}

	public function dbresettabledependantfields($table, $recId){
		$dependantfields = $this->dbtabledependantfields($table);
		
		if (is_array($dependantfields) && sizeof($dependantfields) > 0) {
			foreach ($dependantfields as $dependantfield) {				
				$sqlStr ="UPDATE ".$dependantfield->parentTable." SET ".$dependantfield->initialName." = '0' WHERE ".$dependantfield->initialName." = '".$recId."';";
				$query = $this->db->query($sqlStr);
				$results = $query->result();
			}
		}
		
		return TRUE;
	}

	public function emptydbtable($table){
		if (!$this->db->table_exists($table)) {
			return FALSE;
		}
		else{
			$sqlStr ="TRUNCATE TABLE ".$table.";";
			if ($this->db->query($sqlStr)) {
				return  TRUE;
			}
			else{
				return FALSE;
			}
		}
	}

	public function emptymoduledb($module){
		$tables = $this->dbmoduletables($module);
		if ($tables != FALSE) {
			foreach ($tables as $table) {
				$emptied = $this->emptydbtable($table->parentTable);
				$emptied = $this->deletedbtablerecords('actions_log', array('entity' => $table->parentTable), TRUE);
				$emptied = $this->deletedbtablerecords('attachments', array('entity' => $table->parentTable), TRUE);
				$emptied = $this->emptydbtable('employeelist');
			}
		}

		return  TRUE;
	}



	public function dbfkrecordexists($table, $fieldname, $value, $create){
		$sqlStr ="SELECT * FROM field_names WHERE parentTable = ".prepsqlstringvar($table)." AND initialName = ".prepsqlstringvar($fieldname).";";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		$returnData = 0;
		if (sizeof($results)>0) {
			$field = $results[0];
			$fktable = $field->tableFKname;
			$pkcolumn = $field->fkTableRecPK;
			$sqlExtra = '';
			$fkTableRecNames = explode(',', $field->fkTableRecName);
			$fkTableRecNameSQL = '';
			foreach ($fkTableRecNames as $fkTableRecNamekey => $fkTableRecNamevalue) {
				$fkTableRecNameSQL .= ''.$field->tableFKname.'.'.$fkTableRecNamevalue;
					if ($fkTableRecNamekey < (sizeof($fkTableRecNames)-1)) {
						$fkTableRecNameSQL .= ', ';
					}
			}

			
			$sqlStr ="SELECT * FROM $fktable WHERE CONCAT_WS(' ', $fkTableRecNameSQL) = ".prepsqlstringvar($value).";";
			$query = $this->db->query($sqlStr);
			$fkresults = $query->result();
			if (sizeof($fkresults) > 0) {
				$fkresult = $fkresults[0];
				$returnData = $fkresult->$pkcolumn;
			}
			else{
				if ($create) {
					$valuetoarr = explode(' ', $value);
					if (sizeof($valuetoarr) > sizeof($fkTableRecNames)) {
						$lastdatacursor = sizeof($fkTableRecNames)-1;
						$valuelastdatacursor = sizeof($valuetoarr)-1;
						$lastvaluestr = $valuetoarr[$lastdatacursor];
						for ($i= ($lastdatacursor+1); $i <= $valuelastdatacursor; $i++) { 
							$lastvaluestr .= ' '.$valuetoarr[$i];
						}
						$valuetoarr[$lastdatacursor] = $lastvaluestr;

					}
					else if (sizeof($valuetoarr) < sizeof($fkTableRecNames)) {
						for ($i=sizeof($valuetoarr); $i < sizeof($fkTableRecNames); $i++) { 
							$valuetoarr[$i] = '';
						}
					}
					

					$sqlStr ="INSERT INTO $fktable SET ";
					$savedata = array();
					foreach ($fkTableRecNames as $columnkey => $columnval) {
						$savedata[$columnval] = $valuetoarr[$columnkey];
					}
					$returnData = $this->addupdatedbtablerecord($fktable, $savedata, '0');
				}
			}
		}
		return $returnData;

	}





	public function updateinputfields($module){
		$isDis = $this->input->post('isDis');
		$setName = $this->input->post('setName');
		$fieldIcon = $this->input->post('fieldIcon');
		$isDashShown = $this->input->post('isDashShown');
		$isUnique = $this->input->post('isUnique');
		$isRequired = $this->input->post('isRequired');
		$makercheckered = $this->input->post('makercheckered');

		foreach ($this->dbmodulefields($module) as $field) {
			$recId = $field->fieldId;
			isset($isDashShown[$recId])? ($shown =$isDashShown[$recId]) : ($shown =0);
			isset($setName[$recId])? ($nameset =$setName[$recId]) : ($nameset = $field->setName);
			isset($fieldIcon[$recId])? ($icon =$fieldIcon[$recId]) : ($icon = $field->fieldIcon);
			isset($isDis[$recId])? ($disabled = $isDis[$recId]) : ($disabled =0);
			isset($isUnique[$recId])? ($unique =$isUnique[$recId]) : ($unique =0);
			isset($isRequired[$recId])? ($required =$isRequired[$recId]) : ($required = 0);
			isset($makercheckered[$recId])? ($makerchecker =$makercheckered[$recId]) : ($makerchecker =0);

			$sqlStr ="UPDATE field_names SET isDis = '$disabled', setName = '$nameset', isDashShown = '$shown', isUnique = '$unique', isFormReq = '$required', fieldIcon = ".prepsqlstringvar($icon).", makercheckered = '$makerchecker' WHERE fieldId = '$recId';";
			$query = $this->db->query($sqlStr);

		}


		
		return true;
	}

	public function getmysqlglobalvariable($variable='max_allowed_packet'){
		$sqlStr ="SELECT @@global.".$variable.";";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		return $results;
	}

	public function setmysqlglobalvariable($variable, $value){
		$sqlStr ="SET @@global.".$variable."=".$value.";";
		$query = $this->db->query($sqlStr);		
		return $query;
	}

	public function recyclebinrestore($recId){
		$sqlStr ="SELECT * FROM recyclebin WHERE id = ".prepsqlstringvar($recId).";";
			$query = $this->db->query($sqlStr);
			$results = $query->result();
			if (sizeof($results) > 0) {
				$result = $results[0];
				$dataobj = json_decode($result->data);
				$table = $result->entity;
				$data = objecttoarrayrecursivecast($dataobj);
				$tablePKcol = $this->dbtablepkcolumn($table);
				$tablePKcolinitialName = $tablePKcol->initialName;

				$exists = $this->dbtablerecord($data[$tablePKcolinitialName], $table);

				
				$setSql = '';
				if ($exists == FALSE) {
					$setSql .= $tablePKcolinitialName.' = '.prepsqlstringvar($data[$tablePKcolinitialName]).', ';
				}

				$lastdataindex = sizeof($data)-1;
				$dataindex = 0;

				foreach ($data as $key => $value) {
					if ($key != $tablePKcolinitialName) {
						$setSql .= $key.' = '.prepsqlstringvar($value);
						if ($dataindex < $lastdataindex) {
							$setSql .= ', ';
						}
					}
					$dataindex++;						
				}
				if (strlen($setSql) > 0) {
					$restoresqlStr = "INSERT INTO $table SET ".$setSql.";";
					$restorequery = $this->db->query($restoresqlStr);
					if ($restorequery) {
						$delrestoresqlStr = "DELETE FROM recyclebin WHERE id=".prepsqlstringvar($recId).";";
						$delrestorequery = $this->db->query($delrestoresqlStr);
					}

					return $restorequery;
				}
					

				
				return FALSE;




			}
	}




	public function dbrefreshfieldnames($fields){
		$this->emptydbtable('field_names');
		$this->db->insert_batch('field_names', $fields);
		return TRUE;
	}

	public function dbaddentityfield($data){
		$typeSqlStr = "VARCHAR(255)";
		$defaultvalSqlStr = "DEFAULT ''";

		if ($data['dataType'] == "varchar" || $data['dataType'] == "int") {
			$typeSqlStr = $data['dataType'].'('.$data['dataLength'].')';
		}

		$sqlStr ="ALTER TABLE ".prepsqlstringvar($data['parentTable'], '`')." ADD ".prepsqlstringvar($data['initialName'], '`')." ".$typeSqlStr." NOT NULL ".$defaultvalSqlStr.";";

		if ($query) {
			$sqlStrfieldnames ="INSERT INTO field_names SET ";
			$currindex = 0;
			$lastindex = sizeof($data)-1;

			foreach ($data as $key => $value) {
				$sqlStrfieldnames .= prepsqlstringvar($key, '`')." = ".prepsqlstringvar($value);
				if ($currindex < $lastindex) {
					$sqlStrfieldnames .=", ";
				}
				$currindex++;
			}
			return $sqlStrfieldnames;
		}
		
	}








}