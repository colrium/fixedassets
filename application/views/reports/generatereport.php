<?php
$userdateformat = userpreferences($module, 'dateformat');



$layout = mdldivstrt('row');
  $layout .= mdldivstrt('col s12 paddless rounded-5px step-up-max dash-window');
    
    $layout .= datatable_open('class="highlight"', $table);
        $layout .= tableheadstart();//table header columns
          $layout .= headerrowstart();
            foreach ($reportentityfields as $field) {            
              if (in_array($field->initialName, $reportfields)) {
                $layout .= tablerowcell(humanize($field->setName));
              }         
            }
          $layout .= headerrowend();
        $layout .= tableheadend();//head end

        $layout .= tablebodystart();//body start
          if (is_array($payload)) {
            foreach ($payload as $index => $record) {
              $layout .= tablerowstart();
                foreach ($reportentityfields as $field) {
                  if (in_array($field->initialName, $reportfields)) {
                    $initialName = $field->initialName;
                    $content = '';
                    $cellclasses = '';
                    //Format Display Data
                    if ($field->dataType == 'date' || $field->dataType == 'datetime') {
                      if ($record->$initialName != '') {
                        $content = date($userdateformat, strtotime($record->$initialName));
                      }                  
                    }
                    else if ($field->dataType == 'boolean') {
                      if ($record->$initialName == '1') {
                        $content = 'check';
                        $cellclasses .= 'material-icons accent-text';
                      }
                    }
                    else{
                      $content = $record->$initialName;
                    }
                    $layout .= tablerowcell($content, ($cellclasses!=''? 'class="'.$cellclasses.'"' : ''));
                  }
                }
              $layout .= tablerowend();
            }
          }
            

        $layout .= tablebodyend();//body End
    $layout .= datatable_close();//data table end
  $layout .= mdldivend();
$layout .= mdldivend();




echo $layout;
?>
