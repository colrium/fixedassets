<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

function setflashnotifacation($name, $data=array()){
	$CI = & get_instance();
	$typenotifacations = array();
	$existingtypenotifacations = getflashnotifacation($name);
	if (!is_null($existingtypenotifacations)) {
		$typenotifacations = array_merge($typenotifacations, $existingtypenotifacations);
	}
	array_push($typenotifacations, $data);
	
	$CI->session->set_userdata($name, $typenotifacations);
}
function unsetflashnotifacation($name='message'){
	$CI = & get_instance();
	$CI->session->unset_userdata($name);
	delete_cookie($name);
}
function getflashnotifacation($name='message', $autounset=TRUE){
	$CI = & get_instance();
	if ($CI->session->has_userdata($name)) {
		$notifacation = $CI->session->userdata($name);
		
		if ($autounset) {
			unsetflashnotifacation($name);
		}
		return $notifacation;
	}
	else{
		return NULL;
	}
		
}


function getnotifacations($module='system', $notifyentity=FALSE, $notifyentityid=FALSE, $active=FALSE){
	$params = array();
	$params['select']['notifacations'] = array('module', 'description', 'entity', 'record', 'entitysuburl');
	if ($notifyentity != FALSE) {
		$params['where']['equalto']['notifacationentity'] = $notifyentity;
		if ($notifyentityid != FALSE) {
			$params['where']['equalto']['notifyentityid'] = $notifyentityid;
		}
	}
	if ($active) {
		$currenttimestamp = date('Y-m-d H:i:s');
		$nexttimestamp = nextdate($currenttimestamp, 'days', 7);
		$params['where']['equalto']['notifacationseen'] = 0;
		$params['where']['between']['notifydate'] = array($currenttimestamp, $nexttimestamp);
	}
	else{		
		$currenttimestamp = date('Y-m-d H:i:s');
		$nexttimestamp = nextdate($currenttimestamp, 'days', 7);
		$params['where']['equalto']['notifacationseen'] = 1;
		$params['where']['between']['notifydate'] = array($currenttimestamp, $nexttimestamp);
	}
	if ($module != FALSE) {
		$params['where']['equalto']['notifacations'] = array('module'=>$module);
	}

	$notifacations = dbtablerecords('notifacations_notifylist', $params, FALSE);

	if ($notifacations == FALSE) {
		$notifacations = array();
	}

	foreach($notifacations as $key => $value) {
        $imageurl = site_url('files/Files/outputmainimage/'.$value->entity.'/'.$value->record);
       
        $notifacations[$key]->image = $imageurl;
	}

	
	return 	$notifacations;
}




function getnotifacation($recId){
	$params = array();
	$params['select']['notifacations'] = array('module', 'description', 'entity', 'record', 'entitysuburl');

	$details = dbtablerecord($recId, 'notifacations_notifylist', TRUE, $params);
	if ($details==FALSE) {
		$details = array();
	}

	return 	$details;
}


function addnotifacation($data=array()){
	$savearr = array();
	$notifacationid = 0;
	if (is_array($data)) {
		$savearr['isreminder'] = array_key_exists('isreminder', $data) ? ($data['isreminder']? 1 : 0) : 0;
		$savearr['title'] = array_key_exists('title', $data) ? $data['title']:'No Title';
		$savearr['description'] = array_key_exists('description', $data) ? $data['description']:'No Description';
		$savearr['entity'] = array_key_exists('entity', $data) ? $data['entity']:'users';
		$savearr['record'] = array_key_exists('record', $data) ? $data['record']:'0';		
		$savearr['module'] = dbtablemodule($savearr['entity']);
		$savearr['entitysuburl'] = array_key_exists('entitysuburl', $data) ? $data['entitysuburl']:'';
		$savearr['date'] = array_key_exists('date', $data) ? $data['date']:date('Y-m-d H:i:s');
		$savearr['recurring'] = array_key_exists('recurring', $data) ? ($data['recurring']? 1 : 0) : 0;

		$notifacationid = addupdatedbtablerecord('notifacations', $savearr, 0, FALSE, FALSE);
		
		if ($notifacationid > 0) {
			$notifylists = array();
			$notifyentity = array_key_exists('notifyentity', $data) ? $data['notifyentity'] : 'users';
			$notifylist = array_key_exists('notifylist', $data) ? $data['notifylist'] : array(USERID);
			if (!is_array($notifylist)) {
				$notifylist = strtolower($notifylist);
				if ($notifylist == 'all') {
					$notifylist = array();
					$records = dbtablerecords($notifyentity);
					$pkcolumninitialName = dbtablepkcolumn($notifyentity)->initialName;
					if (is_array($records)) {
						foreach ($records as $record) {
							array_push($notifylist, $record->$pkcolumninitialName);
						}
					}
				}
				else{
					$notifylist = array();
				}
					
			}
			if (is_array($notifylist)) {
				foreach ($notifylist as $nlkey => $nlvalue) {
					$notifyarr = array();
					$notifyarr['notifacation'] = $notifacationid;
					$notifyarr['notifacationentity'] = $notifyentity;
					$notifyarr['notifyentityid'] = $nlvalue;
					$notifyarr['notifydate'] = $savearr['date'];
					array_push($notifylists, $notifyarr);
				}
			}

			if (sizeof($notifylists)>0) {
				foreach ($notifylists as $notifylistdata) {
					$notifylistid = addupdatedbtablerecord('notifacations_notifylist', $notifylistdata, 0, FALSE, FALSE);
				}
			}
				
			if ($savearr['recurring']) {
				$recurrencedata = array_key_exists('recurrence', $data) ? $data['recurrence'] : array();
				$recurcount = array_key_exists('count', $recurrencedata) ? $recurrencedata['count'] : 1;
				$recurfrequency = array_key_exists('frequency', $recurrencedata) ? $recurrencedata['frequency'] : 'weekly';
				$recurfrequencydef = array_key_exists('frequencydef', $recurrencedata) ? $recurrencedata['frequencydef'] : array();

				$nextnotifydate = $savearr['date'];

				if ($recurcount > 0) {
					for ($i = 0; $i < $recurcount; $i++) {	
						if ($recurfrequency == 'weekly') {
							$nextnotifydate = nextdate($nextnotifydate, 'weeks', 1);
						}
						if ($recurfrequency == 'monthly') {
							$nextnotifydate = nextdate($nextnotifydate, 'months', 1);
						}
						if ($recurfrequency == 'yearly') {
							$nextnotifydate = nextdate($nextnotifydate, 'years', 1);
						}


						foreach ($notifylists as $notifylistdata) {
							$newnotifylistdata = $notifylistdata;
							$newnotifylistdata['notifydate'] = $nextnotifydate;
							$notifylistid = addupdatedbtablerecord('notifacations_notifylist', $newnotifylistdata, 0, FALSE, FALSE); 
						}

						

					}
				}
			}
		}
			

	}
	return $notifacationid;

}

function togglenotifacations($module=FALSE){


}

function generatenotifacations($module = FALSE, $notifyentity=FALSE, $notifyentityid=FALSE){
	$currentnotifacations = getnotifacations($module, $notifyentity, $notifyentityid, TRUE);
	$returndata = '';
	foreach ($currentnotifacations as $notifacation) {
		$returndata .= generatenotifacation($notifacation->id);
	}
	return $returndata;
}

function generatenotifacation($recId){
	$details = getnotifacation($recId);
	$returndata = '';
	if ($details != FALSE) {
		$imagedetails = dbattachmentimages($details->entity, $details->record, TRUE);
		$iconurl = base_url('catalog/system/imageplaceholder.svg');
		if ($imagedetails != FALSE) {
			$iconurl = site_url('uploads/Uploads/downloadattachment/'.$imagedetails->attId);
		}

		$returndata .= '<script>
							$.fn.desktopnotify({
								title : "'.$details->notifacation.'",
								text : "'.$details->description.'",
								icon:"'.$iconurl.'"
							});
						</script>';
	}

	return $returndata;
}






