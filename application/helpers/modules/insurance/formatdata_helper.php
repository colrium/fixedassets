<?php

define('CLIENT_ADDEDIT_FORM',  site_url(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/client'));
define('POLICY_ADDEDIT_FORM',  site_url(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/policy'));
define('INSURER_ADDEDIT_FORM',  site_url(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/insurer'));
define('COVER_ADDEDIT_FORM',  site_url(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/cover'));
define('CLAIM_ADDEDIT_FORM',  site_url(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/claim'));
define('PAYMENT_ADDEDIT_FORM',  site_url(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/payment'));
define('CURRENCY_ADDEDIT_FORM',  site_url(INSURANCE_PREFIX.'others/Currencies/addEdit'));
define('LOGIN_FORM',  site_url('Login/login'));
define('CLIENT_VIEW',  site_url(INSURANCE_PREFIX.'clients/Clients/view'));
define('POLICY_VIEW',  site_url(INSURANCE_PREFIX.'policies/Policies/view'));
define('INSURER_VIEW',  site_url(INSURANCE_PREFIX.'insurers/Insurers/view'));
define('PAYMENT_VIEW',  site_url(INSURANCE_PREFIX.'payments/Payments/view'));
define('CURRENCY_VIEW',  site_url(INSURANCE_PREFIX.'others/Currencies/view'));
define('CALENDAR_VIEW',  site_url(INSURANCE_PREFIX.'calendar/Calendar/viewday'));
define('CLIENT_DELETE',  site_url(INSURANCE_PREFIX.'functions/Functions/delete/client'));
define('POLICY_DELETE',  site_url(INSURANCE_PREFIX.'functions/Functions/delete/policy'));
define('INSURER_DELETE',  site_url(INSURANCE_PREFIX.'functions/Functions/delete/insurer'));
define('PAYMENT_DELETE',  site_url(INSURANCE_PREFIX.'functions/Functions/delete/payment'));
define('CURRENCY_DELETE',  site_url(INSURANCE_PREFIX.'functions/Functions/delete/currency'));
define('CALENDAR_DELETE',  site_url(INSURANCE_PREFIX.'functions/Functions/delete/calendar'));

function tableDataCell($fieldName, $entity, $value, $class="", $id=""){
 	$CI = & get_instance();
  	$CI->load->model('mstart', 'clsStrt');
  	$CI->load->library('datalib');
    $fieldDetails = $CI->clsStrt->getFormField($fieldName, $entity);
    $field = $fieldDetails[0];
    $cellValue = '';
    $cell = '';
    
    if ($field->isPK && $value > 0) {
      if ($entity=='insurance_clients') {
        $links = anchor(INSURANCE_PREFIX.'records/Records/view/client/'.$value, maticon('launch', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/client/'.$value, maticon('edit', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor('clients/Clients/delete/'.$value, maticon('delete', 'tiny red-text'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"');
      } 
      else if ($entity=='insurance_insurers'){
        $links = anchor(INSURANCE_PREFIX.'records/Records/view/insurer/'.$value, maticon('launch', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/insurer/'.$value, maticon('edit', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor('insurers/Insurers/delete/'.$value, maticon('delete', 'tiny red-text'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"');
      }
      else if ($entity=='insurance_policies'){
        $links = anchor(INSURANCE_PREFIX.'records/Records/view/policy/'.$value, maticon('launch', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').''.spacer(2).' '.anchor(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/policy/'.$value, maticon('edit', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor('policies/Policies/delete/'.$value, maticon('delete', 'tiny red-text'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"');
      }
      else if ($entity=='insurance_covers'){
        $links = anchor(INSURANCE_PREFIX.'records/Records/view/cover/'.$value, maticon('launch', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/cover/'.$value, maticon('edit', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor('', maticon('delete', 'tiny red-text'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"');
      }
      else if ($entity=='insurance_payments'){
        $links = anchor(INSURANCE_PREFIX.'records/Records/view/payment/'.$value, maticon('launch', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/payment/'.$value, maticon('edit', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor('', maticon('delete', 'tiny red-text'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"');
      }
      else if ($entity=='insurance_claims'){
        $links = anchor(INSURANCE_PREFIX.'records/Records/view/claim/'.$value, maticon('launch', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor(INSURANCE_PREFIX.'forms/Formhandler/saveUpdate/claim/'.$value, maticon('edit', 'tiny'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"').' '.spacer(2).' '.anchor('', maticon('delete', 'tiny red-text'), 'class="mdl-button mdl-js-button mdl-button--icon waves-effect waves-dark"');
      }  
      else{
        $links = '<i class="grey-text">Not Applicable</i>';
      }   
      
      $cellValue = $links;
      $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
    }
    else if ($field->isFK && $value > 0) {
      $value = $CI->datalib->getForeignKeyValue($fieldName, $value, $entity);
      $cellValue = $value;
      $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
    }
    else{
      if ($field->dataType == 'boolean') {
        if ($value=='1') {
          $cellValue = 'Yes';
        }
        else{
          $cellValue = 'No';
        }

        $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }
      else if($field->dataType == 'text'){
        $cellValue = nl2br_except_pre($value);
        $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }
      else if($field->dataType == 'varchar'){
        $cellValue = humanize($value);
        $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }
      else if($field->dataType == 'int' || $field->dataType == 'decimal'){
        $cellValue = $value;
        $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }
      else if($field->dataType == 'date' || $field->dataType == 'datetime'){
        if ($value !='' && $value != NULL && $value != '0000-00-00 00:00:00') {
          $cellValue = cleanDate($value);
        }
        else{
           $cellValue = '<i class="grey-text">Not Applicable</i>';
        }
        
        $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }

      else if($field->dataType == 'rating'){
        $cellValue = mdlrating($value);
        $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }

      else{
        $cellValue = humanize($value);
        $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }
    }

    return $cell;

  }

  function tableHeaderCell($fieldName, $entity, $class="", $id=""){
  	$CI = & get_instance();
  	$CI->load->model('mstart', 'clsStrt');
    $fieldDetails = $CI->clsStrt->getFormField($fieldName, $entity);
    $field = $fieldDetails[0];
    $value = $field->setName;
    $cellValue = humanize($value);
    $cell = '';
      if ($field->isFK) {
          $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      } 
      else{
        if($field->dataType == 'text' || $field->dataType == 'varchar' || $field->dataType == 'date' || $field->dataType == 'datetime'){
        $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }
      
      else if($field->dataType == 'int' || $field->dataType == 'decimal'){
        $cell = '<td class="'.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }
      else{
        $cell = '<td class="mdl-data-table__cell--non-numeric '.($class == '' ? '' : $class).'" '.($id == '' ? '' : 'id="'.$id.'"').'>'.$cellValue.'</td>';
      }
      } 
      
    

    return $cell;

  }

  function cleanDate($date){
    $unixDate = strtotime($date);
    $newDate = unix_to_human($unixDate, TRUE, 'us');
    $cleanedDate = nice_date($newDate, 'd M Y H:i');
    return $cleanedDate;
  }

 function entityTable($entity=""){
    $table = '';
    if ($entity=='client') {
      $table = 'insurance_clients';
    }
    else if ($entity=='insurer') {
      $table = 'insurance_insurers';
    }
    else if ($entity=='policy') {
      $table = 'insurance_policies';
    }
    else if ($entity=='cover') {
      $table = 'insurance_covers';
    }

    else if ($entity=='payment') {
      $table = 'insurance_payments';
    }
    else if ($entity=='claim') {
      $table = 'insurance_claims';
    }
    else if ($entity=='report') {
      $table = 'insurance_reports';
    }
    else if ($entity=='invoice') {
      $table = 'insurance_invoices';
    }


    return $table;
}

function entityPK($entity=""){
    $pk = '';
    if ($entity=='client') {
      $pk = 'clientId';
    }
    else if ($entity=='insurer') {
      $pk = 'insurerId';
    }
    else if ($entity=='policy') {
      $pk = 'policyId';
    }
    else if ($entity=='cover') {
      $pk = 'coverId';
    }

    else if ($entity=='payment') {
      $pk = 'paymentId';
    }
    else if ($entity=='claim') {
      $pk = 'claimId';
    }
    else if ($entity=='report') {
      $pk = 'reportId';
    }
    else if ($entity=='invoice') {
      $pk = 'invoiceId';
    }

    
    return $pk;
}
  

function entityviewpage($entity=""){
    $page = '';
    if ($entity=='client') {
      $page = INSURANCE_PREFIX.'clients/viewrecord';
    }
    else if ($entity=='insurer') {
      $page = INSURANCE_PREFIX.'insurers/viewrecord';
    }
    else if ($entity=='policy') {
      $page = INSURANCE_PREFIX.'policies/viewrecord';
    }
    else if ($entity=='cover') {
      $page = INSURANCE_PREFIX.'covers/viewrecord';
    }

    else if ($entity=='payment') {
      $page = INSURANCE_PREFIX.'payments/viewrecord';
    }
    else if ($entity=='claim') {
      $page = INSURANCE_PREFIX.'claims/viewrecord';
    }
    else if ($entity=='report') {
      $page = INSURANCE_PREFIX.'reports/viewrecord';
    }
    else if ($entity=='invoice') {
      $page = INSURANCE_PREFIX.'invoices/viewrecord';
    }

    
    return $page;
}