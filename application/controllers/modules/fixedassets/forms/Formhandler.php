<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formhandler extends CI_Controller {
	public $displayData;
	function __construct(){
		
	  parent::__construct();
	  isloggedin(TRUE);
	  $this->displayData = array();
	  $this->displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
	  $this->displayData['module'] = 'fixedassets';
	  $this->load->model(FIXEDASSETS_PREFIX.'forms/mformhandler', 'clsHndlr');

   }

	public function dispose($recId){
		$dteDisposed = $this->input->post('dteDisposed');
		$disposeReason = $this->input->post('reasonDispose');
		$disposalMethod = $this->input->post('methodDispose');
		$details = dbtablerecord($recId, 'fixedassets_assetlist', FALSE);


		if($details != FALSE){
			$details->isDisposed = 1;
			$details->assetPrimLoc = 2;
			$details->dteDisposed = $dteDisposed;
			$details->disposeReason = $disposeReason;
			$details->disposalMethod = $disposalMethod;
			$detailsarr = objecttoarrayrecursivecast($details);

			$newrecId = addupdatedbtablerecord('fixedassets_assetlist', $detailsarr, $recId, FALSE, FALSE);
					$acionlogdetails['type'] = 'Dispose';
					$acionlogdetails['entity'] = 'fixedassets_assetlist';
					$acionlogdetails['description'] = 'Disposed';
					$acionlogdetails['record'] = $newrecId;
					$acionlogdetails['timestamp'] = date('Y-m-d H:i:s');
					$acionlogdetails['completion_date'] = date('Y-m-d H:i:s');
					$acionlogdetails['initialdata'] = json_encode($details);
					$acionlogdetails['initialdata'] = json_encode($details);
					addupdatedbtablerecord('actions_log', $acionlogdetails, '0', FALSE, FALSE);
			setflashnotifacation('message', array('icon'=>'done', 'alert'=>$details->assetCode.' Disposed'));

		}

		preredirect(FIXEDASSETS_PREFIX.'Dashboard'); 
  
	}


	public function checkout($recId){
		$dtecheckedOut = $this->input->post('dtecheckedOut');
		$dueDteCheckout = $this->input->post('dueDteCheckout');
		$checkoutReason = $this->input->post('checkoutReason');
		$checkedOutTo = $this->input->post('checkedOutTo');
		$details = dbtablerecord($recId, 'fixedassets_assetlist', FALSE);
		$olddata = $details;
		if($details != FALSE){    		
			$details->checkedOut = 1;
			$details->dtecheckedOut = $dtecheckedOut;
			$details->dueDteCheckout = $dueDteCheckout;
			$details->checkoutReason = $checkoutReason;
			$details->checkedOutTo = $checkedOutTo;
			$detailsarr = objecttoarrayrecursivecast($details);
			$newrecId = addupdatedbtablerecord('fixedassets_assetlist', $detailsarr, $recId, FALSE, FALSE);
					$acionlogdetails['type'] = 'Checkout';
					$acionlogdetails['entity'] = 'fixedassets_assetlist';
					$acionlogdetails['description'] = 'Checked Out';
					$acionlogdetails['record'] = $newrecId;
					$acionlogdetails['timestamp'] = date('Y-m-d H:i:s');
					$acionlogdetails['completion_date'] = date('Y-m-d H:i:s');
					$acionlogdetails['initialdata'] = json_encode($details);
					addupdatedbtablerecord('actions_log', $acionlogdetails, '0', FALSE, FALSE);


					$notifacationlogdetails['title'] = 'Due Checkin Date';
					$notifacationlogdetails['description'] = $olddata->assetCode.' is due for checkin on '.$dueDteCheckout;
					$notifacationlogdetails['entity'] = 'fixedassets_assetlist';
					$notifacationlogdetails['module'] = 'fixedassets';
					$notifacationlogdetails['record'] = $recId;
					$notifacationlogdetails['entity'] = 'fixedassets_assetlist';
					$notifacationlogdetails['date'] = $dueDteCheckout;
					$notifacationlogdetails['entitysuburl'] = 'modules/fixedassets/forms/Formhandler/saveUpdateAsset/'.$recId;
					$notId = addupdatedbtablerecord('notifacations', $notifacationlogdetails, '0', FALSE, FALSE);

					$notifacationlistlogdetails['notifacation'] = $notId;
					$notifacationlistlogdetails['notifacationentity'] = 'users';
					$notifacationlistlogdetails['notifyentityid'] = USERID;
					$notifacationlistlogdetails['notifydate'] = $dueDteCheckout;
					$notId = addupdatedbtablerecord('notifacations_notifylist', $notifacationlistlogdetails, '0', FALSE, FALSE);



		}

	  
	  preredirect(FIXEDASSETS_PREFIX.'Dashboard'); 

	}



	public function checkin($recId){
		$dteCheckedin = $this->input->post('dteCheckedin');
		$details = dbtablerecord($recId, 'fixedassets_assetlist', FALSE);
		$olddata = $details;
		if($details != FALSE){
			$details->checkedOut = 0;
			$details->dteCheckedin = $dteCheckedin;
			$details->checkoutReason = '';
			$details->checkedOutTo = 0;

			$detailsarr = objecttoarrayrecursivecast($details);
			$newrecId = addupdatedbtablerecord('fixedassets_assetlist', $detailsarr, $recId, FALSE, FALSE);
					$acionlogdetails['type'] = 'Checkin';
					$acionlogdetails['entity'] = 'fixedassets_assetlist';
					$acionlogdetails['description'] = 'Checked In';
					$acionlogdetails['record'] = $newrecId;
					$acionlogdetails['timestamp'] = date('Y-m-d H:i:s');
					$acionlogdetails['completion_date'] = date('Y-m-d H:i:s');
					$acionlogdetails['initialdata'] = json_encode($details);
					addupdatedbtablerecord('actions_log', $acionlogdetails, '0', FALSE, FALSE);

					$params = array();
					$params['where']['equalto'] = array('entity'=>'fixedassets_assetlist', 'record'=>$recId, 'title'=>'Due Checkin Date', 'date'=>$details->dueDteCheckout);
					$notifacations = dbtablerecords('notifacations', $params, FALSE);
					if ($notifacations != FALSE) {
						foreach ($notifacations as $notifacation) {
							$params = array();
							$params['where']['equalto'] = array('notifacation'=>$notifacation->id);
							$notifylists = dbtablerecords('notifacations_notifylist', $params, FALSE);
							if($notifylists != FALSE){
								foreach ($notifylists as $notifylist) {
									$notifylist->notifacationseen = 1;
									$detailsarr = objecttoarrayrecursivecast($notifylist);
									$newrecId = addupdatedbtablerecord('notifacations_notifylist', $detailsarr, $notifylist->id, FALSE, FALSE);
								}
							}
								
						}
							
					}

				setflashnotifacation('message', array('icon'=>'vertical_align_bottom', 'alert'=>'Record '.$olddata->assetCode.' Checked In'));
				preredirect(FIXEDASSETS_PREFIX.'Dashboard'); 

		}

	}

	public function movecopy($recId){
	  $this->form_validation->set_rules('toprimaryLoc', 'Destination', 'required');
		if ($this->form_validation->run() == FALSE){
		  //set error message
				   
		  $errorMessage = strip_tags(validation_errors());
			setflashnotifacation('error', array('icon'=>'edit', 'alert'=>$errorMessage));
		  preredirect(FIXEDASSETS_PREFIX.'Dashboard');

		}
		//data validated success
		else{
		  $toprimaryLoc = $this->input->post('toprimaryLoc');
		  $tosecondaryLoc = $this->input->post('tosecondaryLoc');
		  if ($tosecondaryLoc == '') {
			$tosecondaryLoc = 0;
		  }

		  $details = dbtablerecord($recId, 'fixedassets_assetlist', FALSE);
		  if ($details != FALSE) {
			$savedata = array('assetPrimLoc'=>$toprimaryLoc, 'assetSecLoc'=>$tosecondaryLoc);
			$newrecId = addupdatedbtablerecord('fixedassets_assetlist', $savedata, $recId, FALSE);
			setflashnotifacation('message', array('icon'=>'compare_arrows', 'alert'=>'Asset '.$recId.' Moved'));
			preredirect(FIXEDASSETS_PREFIX.'Dashboard');
		  }
		  
		}
	}




	public function clonerecord($recId){
	  $details = dbtablerecord($recId, 'fixedassets_assetlist', FALSE);
	  if ($details != FALSE) {
		$clonearr = array();
		$detailsarr =objecttoarrayrecursivecast($details);
		foreach ($detailsarr as $key => $value) {
		  if ($key != 'assetID') {
			$clonearr[$key] = $value;
		  }
		}
		$newrecId = addupdatedbtablerecord('fixedassets_assetlist', $clonearr, '0', FALSE, TRUE);
		setflashnotifacation('message', array('icon'=>'content_copy', 'alert'=>$details->assetID.' Cloned'));
	  }
	  preredirect(FIXEDASSETS_PREFIX.'Dashboard');
	}




public function saveUpdateAsset($recId='0'){
		$table = 'fixedassets_assetlist';
		//set display array
		$this->displayData['recId']        	= $recId;
		$this->displayData['locations']       = dbtablerecords('fixedassets_primaryloc', array(), FALSE, TRUE);
		$this->displayData['categories']      = dbtablerecords('fixedassets_categories', array(), FALSE, TRUE);
		$this->displayData['employees']       = dbtablerecords('employeelist', array(), FALSE, TRUE);
		$this->displayData['sections']        = dbtablerecords('fixedassets_sections', array(), FALSE, TRUE);
		$this->displayData['users']        	= dbtablerecords('users', array(), FALSE, TRUE);		  
		$this->displayData['brands']        	= dbtablerecords('fixedassets_brands', array(), FALSE, TRUE);
		$this->displayData['manufacturers']   = dbtablerecords('fixedassets_manufacturers', array(), FALSE, TRUE);
		$this->displayData['conditions']      = dbtablerecords('fixedassets_conditions', array(), FALSE, TRUE);		
		$this->displayData['mainTemplate'] 	= FIXEDASSETS_PREFIX.'forms/addeditasset';
		
	if ($recId=='0') {
		$this->displayData['attachments']   	= array();
		$this->displayData['notebookItems']   = array();
		$this->displayData['title']        	= 'Add Asset';
		$this->displayData['pageTitle']    	= breadcrumb('Add Asset');
	}
	else{
		$this->displayData['images']        	= $this->datalib->loadentityimages('fixedassets_assetlist', $recId);
		$this->displayData['attachments']   	= $this->datalib->loadentityattachments('fixedassets_assetlist', $recId);
		$notebookparams = array();
		$notebookparams['where']['equalto'] = array('entity' => $table, 'record'=>$recId);
		$this->displayData['notebookItems']   = dbtablerecords('actions_log', $notebookparams, FALSE);
		$details   = dbtablerecord($recId, $table, FALSE);
		$this->displayData['details']        	= $details;
		$this->displayData['title']        	= 'Edit Asset';
		$this->displayData['pageTitle']    	= breadcrumb('Edit Asset');	
	}

	//check if any data has been posted
	$posteduserData = $this->input->post(NULL, FALSE);
	if (sizeof($posteduserData)>0) {
		$newRecId = addupdatedbtablerecord($table, $posteduserData, $recId);
		if (!array_key_exists('strerror', $this->displayData)) {
			setflashnotifacation('message', array('icon'=>'save', 'alert'=>'Record Saved Successfully'));
			//redirect
			preredirect(FIXEDASSETS_PREFIX.'forms/Formhandler/saveUpdateAsset/'.$newRecId);
		}
		else{
			renderpage($this->displayData);
		}
			
	}
	//no data posted
	else{
		renderpage($this->displayData);
		
	}
	

}






public function saveUpdateReport($repId){

	foreach ($this->fieldnames->getRequiredFormFields("fixedassets_reports") as $field) {
		$this->form_validation->set_rules($field->initialName, $field->setName, 'required');
	 }


	if ($repId == 0) {
		if ($this->form_validation->run() == FALSE){
				$errorMessage = maticon('edit', 'white-text').'<br>'.strip_tags(validation_errors());
				$errorMessage = str_replace("\n", "<br>", $errorMessage);
				$this->displayData['strerror']        = $errorMessage;
				$this->displayData['title']        = 'Custom Report';
				$this->displayData['repId']        = $repId;
				$this->displayData['pageTitle']    = ' '.breadcrumb('Create Custom Report');
				$this->displayData['fields']    = $this->formfieldinput->getFormFields("fixedassets_reports");
				$this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/createCustomReport';
				$this->displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
				$this->displayData['module'] = 'fixedassets';
				renderpage($this->displayData);
				

		}
		else{
			$recId = $this->clsHndlr->saveUpdateReport($repId);
			preredirect(FIXEDASSETS_PREFIX.'reports/Createreport/reportDefine/'.$recId);
		}
	}

	else if ($repId !=0){
		if ($this->form_validation->run() == FALSE){
				$errorMessage = maticon('edit', 'white-text').'<br>'.strip_tags(validation_errors());
					$errorMessage = str_replace("\n", "<br>", $errorMessage);
					$this->displayData['strerror']        = $errorMessage;
				$this->displayData['title']        = 'Custom Report';
				$this->displayData['repId']        = $repId;
				$this->displayData['pageTitle']    = ' '.breadcrumb(' Edit Report');
				$this->displayData['fields']    = $this->formfieldinput->getFormFields("fixedassets_reports");
				$this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/createCustomReport';

				renderpage($this->displayData);
				

		}
		else{
			$recId = $this->clsHndlr->saveUpdateReport($repId);
			setflashnotifacation('message', array('icon'=>'save', 'alert'=>'Report Saved Successfully'));
			preredirect(FIXEDASSETS_PREFIX.'reports/Createreport/reportDefine/'.$recId);
		}

	}



}


public function addRemoveReportFields($repId){
	if ($this->clsHndlr->insertRemoveReportField($repId)){
		setflashnotifacation('message', array('icon'=>'save', 'alert'=>'Report Fields Updated Updated'));
		preredirect(FIXEDASSETS_PREFIX.'reports/Createreport/definereportfields/'.$repId);      
	}
	else{

	}

}

public function defineReportFields($repId){
	if($this->clsHndlr->saveUpdateDefinedReportFields($repId)){
		setflashnotifacation('message', array('icon'=>'save', 'alert'=>'Report Created successfully'));
			preredirect(FIXEDASSETS_PREFIX.'reports/Reports/mycustomreports');
	}
	echo $this->clsHndlr->saveUpdateDefinedReportFields($repId);
}

public function saveUpdateProperties($datatype, $recId){
			$this->clsHndlr->saveUpdateProperties($datatype, $recId);
			setflashnotifacation('message', array('icon'=>'save', 'alert'=>'Properties Saved'));
			preredirect(FIXEDASSETS_PREFIX.'Dashboard');


}

public function addeditsecondaryrecord($type="", $recId=""){
	$table = $type;
	$tablename = dbmoduletablename($table);
	$idcolumns = tableidcolumns($table);
	$recname = '';


	$refererpage = reffererpage();

	  if ($refererpage == '') {
		 $refererpage = FIXEDASSETS_PREFIX.'Dashboard';
	  }

	  if ($recId > 0) {
		 if (!dbtablerecordexists($recId, $table)) {
			setflashnotifacation('error', array('icon'=>'link', 'alert'=>'Sorry! Record does not exist'));
			preredirect($refererpage, 'refresh');
		 }
	  }

	$recname = dbtablerecordname($table, $recId);

	$details = dbtablerecord($recId, $table, FALSE);
	//check if any data has been posted
	$postedData = $this->input->post(NULL, FALSE);

	if (sizeof($postedData)>0) {
		if (isset($type) && isset($recId)) {
			$newrecId = addupdatedbtablerecord($table, $postedData, $recId);
				
				if ($newrecId != FALSE) {
					setflashnotifacation('message', array('icon'=>'save', 'alert'=>'Saved in '.$tablename.' successfully'));
					preredirect(FIXEDASSETS_PREFIX.'forms/Formhandler/addeditsecondaryrecord/'.$type.'/'.$newrecId);
				}
				else{
					setflashnotifacation('error', array('icon'=>'edit', 'alert'=>'Save in '.$tablename.' Error'));
					preredirect(FIXEDASSETS_PREFIX.'forms/Formhandler/addeditsecondaryrecord/'.$type.'/'.$newrecId);
				}
			

		}
	}
	else{
		if (isset($type) && isset($recId)) {
			$fields = dbtablefields($table, 'isPK', '0');
			if ($recId=='0') {
				$this->displayData['title']        = 'Add to '.$tablename;
				$this->displayData['pageTitle']    = breadcrumb(' Add to '.$tablename);
			}
			else{
				$this->displayData['title']        = 'Edit in '.$tablename;
				$this->displayData['pageTitle']    = ' '.breadcrumb($recname);
			}
			 
			  $this->displayData['recId']        = $recId;
			  $this->displayData['details']       = $details;
			  $this->displayData['fields']       = $fields;
			  $this->displayData['table']        = $table;
			  $this->displayData['tablename']    = $tablename;
			  $this->displayData['recname']    = $recname;
			  $this->displayData['type']    = $type;	      
			  $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'forms/addEditSecondaryRec';
			  
			  renderpage($this->displayData);
			  
		}
		else{

		}
	}
		


}


	public function deletesecondaryrecord($type="", $recId=""){
		if ($type!="" && $recId!="") {
			if ($type=='fixedassets_assetlist') {
				if ($this->clsHndlr->tempdeleteassetrecord($recId)) {
					//add addaction
					$actionArray = array();
					$actionArray['actionType'] = '15';
					$actionArray['actionAssetId'] = $recId;
					$actionArray['actionUser'] = USERID;
					$actionArray['actionDate'] = date('Y-m-d');
					$this->datalib->autoaddassetaction($recId, $actionArray);
					setflashnotifacation('message', array('icon'=>'delete', 'alert'=>'Record Deleted successfully'));
					preredirect(FIXEDASSETS_PREFIX.'Dashboard');
				}
			}
			else{
				$table = $this->datalib->getFKFieldTable($type);
				$pkColumn = $this->datalib->getPKFieldinitialName($table);
				if ($this->clsHndlr->deletesecondaryrecord($table, $pkColumn, $recId)) {
					$this->datalib->changechildrenproperty($type, $recId, '', 'none');
					setflashnotifacation('message', array('icon'=>'delete', 'alert'=>'Record Deleted successfully'));
					preredirect(FIXEDASSETS_PREFIX.'Dashboard');
				}
			}
				
		}
	}




	public function addeditnotebookitem($recId, $noteId){
		$table = 'actions_log';
		

		$refererpage = reffererpage();
		if ($refererpage == '') {
			$refererpage = FIXEDASSETS_PREFIX.'Dashboard';
		}

		if ($recId > 0) {
			if (!dbtablerecordexists($recId, 'fixedassets_assetlist')) {
				setflashnotifacation('error', array('icon'=>'folder_open', 'alert'=>'Sorry! This record does not exist')); 
				preredirect($refererpage, 'refresh');
			}
		}

		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData)>0) {
			$savearr = $postedData;
			$savearr['entity'] = 'fixedassets_assetlist';
			$savearr['record'] = $recId;
			$savearr['user_generated'] = 1;
		}

		

		if (addupdatedbtablerecord($table, $savearr, 0, FALSE, FALSE)) {
			setflashnotifacation('message', array('icon'=>'save', 'alert'=>'Saved successfully'));
			preredirect($refererpage);
		}
		else{
			setflashnotifacation('error', array('icon'=>'error', 'alert'=>'Save Error'));
			preredirect($refererpage);
		}



	}

	public function deletenotebookitem($recId, $noteId){
		if ($this->clsHndlr->deletenotebookitem($noteId)) {
				setflashnotifacation('message', array('icon'=>'delete', 'alert'=>'Note deleted successfully'));
				preredirect(FIXEDASSETS_PREFIX.'forms/Formhandler/saveUpdateAsset/'.$recId);
		}

	}

	public function unique_check($data, $fieldname){
		if ($this->datalib->dataExists("fixedassets_assetlist", $fieldname, $data, "assetID", false) != '0') {
			$this->form_validation->set_message('unique_check', 'The {field} field must be unique');
			return FALSE;
		}
		return TRUE;		
	}


	public function getlinkchildren($recId, $requester){
		$children = $this->clsHndlr->getlinkchildren($recId);
		$returndata = '';
		$fieldName = '';
		if (sizeof($children) > 0) {
			if ($requester == 'ajax') {
				$tableFields = $this->formfieldinput->getFormFields('fixedassets_assetlist');
						foreach ($children as $child) {
							$returndata .= tablerowstart();
								$returndata .= mdltablecell('<a href="#" class="remove-child-link red-text" linkid="'.$child->linkId.'">'.maticon('delete', 'spaced-text').'</a>', 'class="input-cell"');
								$childdetails = $this->datalib->loadrecordfromtable('fixedassets_assetlist', 'assetID', $child->childId);
								
									foreach ($tableFields as $tableField) {
										
										if ($tableField->isDashShown) {
											$fieldName = $tableField->initialName;
											$fieldValue = $childdetails->$fieldName;
											if ($tableField->isFK) {
												$fkValue = '';
												if ($tableField->initialName!='assignedTo') {
													if ($tableField->dataType=='image') {
														$mainimage=$this->datalib->loadentitymainimage('fixedassets_assetlist', $childdetails->assetID);
														if ($mainimage != false) {
															$imgSrc = base_url().''.$mainimage->file_dir;								            
															$fkValue = img($imgSrc, 'class="responsive-scaled  rounded-5px"');   								            
														}
														else{
															$fkValue = '';
														}
													}
													else{
														$fkValue = $this->fieldnames->getForeignKeyValue($fieldName, $fieldValue);
													}
												}
												else{
													$fkValue = $this->fieldnames->getEmployeeName($fieldValue);
												}
												$returndata .= mdltablecell($fkValue, 'class="input-cell"');
											}
											else{
												$returndata .= mdltablecell($fieldValue, 'class="input-cell"');
											}
											
										}
									}	
							$returndata .= tablerowend();
													
						}

				echo $returndata;
			}
			else{
				$returndata = $children;
				return $returndata;
			}
		}
		else{
			if ($requester == 'ajax') {
				$returndata = 'none';
				echo $returndata;
			}
			else{
				$returndata = FALSE;
				return $returndata;
			}
		}

		
	}

	public function getlinkparent($recId, $requester){
		$parents = $this->clsHndlr->getlinkparent($recId);
		
		$returndata = '';
		$fieldName = '';
		if (sizeof($parents) > 0) {
			if ($requester == 'ajax') {
				$tableFields = $this->formfieldinput->getFormFields('fixedassets_assetlist');

						foreach ($parents as $parent) {
							$returndata .= tablerowstart();
								$returndata .= mdltablecell('<a href="#" class="remove-parent-link red-text" linkid="'.$parent->linkId.'">'.maticon('delete', 'spaced-text').'</a>', 'class="input-cell"');
								$parentdetails = $this->datalib->loadrecordfromtable('assetlist', 'assetID', $parent->parentId);
								
									foreach ($tableFields as $tableField) {
										
										if ($tableField->isDashShown) {
											$fieldName = $tableField->initialName;
											$fieldValue = $parentdetails->$fieldName;
											if ($tableField->isFK) {
												$fkValue = '';
												if ($tableField->initialName!='fixedassets_assignedTo') {
													if ($tableField->dataType=='image') {
														$mainimage=$this->datalib->loadentitymainimage('fixedassets_assetlist', $parentdetails->assetID);
														if ($mainimage != false) {
															$imgSrc = base_url().''.$mainimage->file_dir;								            
															$fkValue = img($imgSrc, 'class="responsive-scaled  rounded-5px"');   								            
														}
														else{
															$fkValue = '';
														}
													}
													else{
														$fkValue = $this->fieldnames->getForeignKeyValue($fieldName, $fieldValue);
													}
												}
												else{
													$fkValue = $this->fieldnames->getEmployeeName($fieldValue);
												}
												$returndata .= mdltablecell($fkValue, 'class="input-cell"');
											}
											else{
												$returndata .= mdltablecell($fieldValue, 'class="input-cell"');
											}
											
										}
									}	
							$returndata .= tablerowend();
													
						}

				echo $returndata;
			}
			else{
				$returndata = $children;
				return $returndata;
			}
		}
		else{
			if ($requester == 'ajax') {
				$returndata = 'none';
				echo $returndata;
			}
			else{
				$returndata = FALSE;
				return $returndata;
			}
		}
	}



	public function linkedrecordadd($type, $assetCode, $recId){
		$assetdetails = $this->datalib->loadrecordfromtable('fixedassets_assetlist', 'assetCode', $assetCode);
		$returndata = '';
		if ($assetdetails != FALSE) {
			if ($this->linkexists($type, $recId, $assetdetails->assetID) != TRUE) {
				$newlinkId = $this->addlink($type, $recId, $assetdetails->assetID);
				if ($newlinkId != FALSE) {
					$tableFields = $this->formfieldinput->getFormFields('fixedassets_assetlist');

					$returndata .= tablerowstart();
						if ($type=='parent') {
							$returndata .= mdltablecell('<a href="#" class="remove-parent-link red-text" linkid="'.$assetdetails->assetID.'">'.maticon('delete', 'spaced-text').'</a>', 'class="input-cell"');
						}
						else if ($type=='child'){
							$returndata .= mdltablecell('<a href="#" class="remove-child-link red-text" linkid="'.$assetdetails->assetID.'">'.maticon('delete', 'spaced-text').'</a>', 'class="input-cell"');
						}
						

						foreach ($tableFields as $tableField) {
							$fieldname = $tableField->initialName;
								if ($tableField->isDashShown) {
									$fieldName = $tableField->initialName;
									$fieldValue = $assetdetails->$fieldName;
									if ($tableField->isFK) {
										$fkValue = '';
										if ($tableField->initialName!='assignedTo') {
											if ($tableField->dataType=='image') {
												$mainimage=$this->datalib->loadentitymainimage('fixedassets_assetlist', $assetdetails->assetID);
													if ($mainimage != false) {
														$imgSrc = base_url().''.$mainimage->file_dir;								            
														$fkValue = img($imgSrc, 'class="responsive-scaled  rounded-5px"');   								            
													}
													else{
														$fkValue = '';
													}
												}
												else{
													$fkValue = $this->fieldnames->getForeignKeyValue($fieldName, $fieldValue);
												}
											}
											else{
												$fkValue = $this->fieldnames->getEmployeeName($fieldValue);
											}
											$returndata .= mdltablecell($fkValue, 'class="input-cell"');
										}
										else{
											if ($tableField->isMonetary ) {
												$fieldValue = monetaryformat($fieldValue);
											}
											if ($tableField->dataType =='date'){
												$fieldValue = $this->datalib->userdateformat($fieldValue);
											}
											$returndata .= mdltablecell($fieldValue, 'class="input-cell"');
										}
													
								}
						}

					$returndata .= tablerowend();
					echo $returndata;
				}
				else{
					echo "error";
				}



					
			}
			else{
				echo "exists";
			}


				
		}
		else{
			$returndata = 'none';

			echo $returndata;
		}
	}



	public function linkexists($linktype, $recId, $linkrecId){
		$linkExists = $this->clsHndlr->linkexists($linktype, $recId, $linkrecId);
		return $linkExists;

	}

	public function addlink($linktype, $recId, $linkrecId){
		$newlinkId = $this->clsHndlr->addlink($linktype, $recId, $linkrecId);
		return $newlinkId;

	}

	public function removelink($linkId){
		$remove = $this->clsHndlr->removelink($linkId);
		if ($remove) {
			echo '1';
		}
		else{
			echo '0';
		}
	}
















}//end of class