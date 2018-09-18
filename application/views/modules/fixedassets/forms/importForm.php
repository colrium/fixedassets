<?php
$details = array();
if(isset($module)){
  if($module == 'fixedassets'){
    $details['name'] = 'importmodal';
    $details['formurl'] = FIXEDASSETS_PREFIX.'functions/Functions/importCsvForm';
    $details['options'] = array('fixedassets' => 'Fixed Assets');
    $details['title'] = 'Select .CSV file to import below';
    echo importmodal($details);

  }
}
  
