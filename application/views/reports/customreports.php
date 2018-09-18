<?php
$userdateformat = userpreferences($module, 'dateformat');



$layout = mdldivstrt('row');
  $layout .= mdldivstrt('col s12 paddless rounded-5px step-up-max dash-window');
    $layout .= '<script type="text/javascript">
                  $(function(){
                    "use strict";

                    
                    var dtfactory = function($, DataTable) {
                        $.extend(true, DataTable.defaults, {
                          drawCallback: function(settings){
                            $(".'.$table.'record").contexted({
                              title : false,
                              menuoptions : [
                                              {
                                                text: "Edit",
                                                icon: "edit",
                                                callback: function(element, contexttype, contextname, contextid){
                                                  var pageurl = "'.site_url('reports/Reports/addeditreport').'"+"/"+contextid;
                                                  $.fn.loadpage(pageurl, ".pagebody", true);
                                                }
                                              },
                                              {
                                                text: "Generate",
                                                icon: "equalizer",
                                                callback: function(element, contexttype, contextname, contextid){
                                                  var pageurl = "'.site_url('reports/Reports/generatereport').'"+"/"+contextid;
                                                  $.fn.loadpage(pageurl, ".pagebody", true);
                                                }
                                              }, 
                                              {
                                                text: "Delete",
                                                icon: "delete",
                                                colorclass: "red-text",
                                                callback: function(element, contexttype, contextname, contextid){
                                                  $.fn.confirmdelete("'.$table.'", contextid, contextname, element);
                                                }
                                              }
                                            ]
                            });
                                         
                          }

                        });

                        $(".'.$table.'record").ajaxed({
                            doubleclick: false,
                            progressbar: "circular"
                        });

                      };

                        //simply initialise as normal, stopping multiple evaluation
                        dtfactory($, $.fn.dataTable);
                      });

                </script>';
    $layout .= datatable_open('class="highlight"', $table);
        $layout .= tableheadstart();//table header columns
          $layout .= headerrowstart();
            foreach ($fields as $field) {            
              if ($field->isDashShown) {
                $layout .= tablerowcell(humanize($field->setName));
              }         
            }
          $layout .= headerrowend();
        $layout .= tableheadend();//head end

        $layout .= tablebodystart();//body start
          if ($reports != FALSE) {
            foreach ($reports as $index => $record) {
              $layout .= tablerowstart('class="'.$table.'record" href="'.site_url(TRACKER_PREFIX.'records/View/'.$table.'/'.$record->id).'" id="'.$table.$record->id.'" contexttype="'.$table.'record" contextdataid="'.$record->id.'" contextname="'.$record->name.'" datadom="#npnpreviewpane"');
                foreach ($fields as $field) {
                  if ($field->isDashShown) {
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
