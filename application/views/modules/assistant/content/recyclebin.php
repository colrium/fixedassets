<?php
$userdateformat = userpreferences('system', 'dateformat');
$layout = mdldivstrt('row');
	$layout .= mdldivstrt('col s12 rounded-5px step-up-3');
		$layout .= '<script type="text/javascript">
        $(function(){
          "use strict";
          var dtfactory = function($, DataTable) {
              $.extend(true, DataTable.defaults, {
                drawCallback: function(settings){
                  $(".recyclebinitem").contexted({
                    title : false,
                    menuoptions : [
                                    {
                                      text: "Restore",
                                      icon: "history",
                                      colorclass: "teal-text",
                                      callback: function(element, contexttype, contextname, contextid){
                                        var pageurl = "'.site_url(ASSISTANT_PREFIX.'content/Recyclebin/restore').'"+"/"+contextid;
                                        $.fn.loadpage(pageurl, ".pagebody", true);
                                      }
                                    },                             
                                    {
                                      text: "Delete Permanently",
                                      icon: "delete_forever",
                                      colorclass: "red-text",
                                      callback: function(element, contexttype, contextname, contextid){
                                      	var pageurl = "'.site_url(ASSISTANT_PREFIX.'content/Recyclebin/deletepermanently').'"+"/"+contextid;
                                        $.fn.loadpage(pageurl, ".pagebody", true);
                                      }
                                    }
                                  ]
                  });
                               
                }

              });
            };

              //simply initialise as normal, stopping multiple evaluation
              dtfactory($, $.fn.dataTable);
            });

      </script>';
      $layout .= datatable_open('class="highlight"', "recyclebinitems");
          $layout .= tableheadstart();//table header columns
            $layout .= headerrowstart();
            	$layout .= tablerowcell(humanize('Name'));
            	$layout .= tablerowcell(humanize('Entity'));
	            foreach ($tablefields as $field) {            
					if ($field->isDashShown) {
						$layout .= tablerowcell(humanize($field->setName));
					}         
				}
            $layout .= headerrowend();
          $layout .= tableheadend();//head end

          $layout .= tablebodystart();//body start
            if (is_array($records) && sizeof($records)>0) {
              foreach ($records as $index => $record) {
                $idcolsarr = explode(',', $record->parentTableIdColumns);
                $recordname = '';
                $recdetailsobj = json_decode($record->data);
                
                foreach ($idcolsarr as $idcolkey => $idcolvalue) {
                  $colname = $idcolvalue;
                  if (strlen($recordname)>0) {
                    $recordname .= ' ';
                  }
                  if (is_object($recdetailsobj)) {
                    if (property_exists($recdetailsobj, $idcolvalue)) {
                      $recordname .= $recdetailsobj->$idcolvalue;
                    }
                  }

                  if (is_array($recdetailsobj)) {
                    if (array_key_exists($idcolvalue, $recdetailsobj)) {
                      $recordname .= $recdetailsobj[$idcolvalue];
                    }
                  }

                  
                  
                }

                $layout .= tablerowstart('class="recyclebinitem" id="recyclebinitem'.$record->id.'" contexttype="recyclebinitem" contextdataid="'.$record->id.'" contextname="'.$record->entity.'"');
                  $layout .= tablerowcell($recordname);
                  $layout .= tablerowcell($record->parentTableName);

                  foreach ($tablefields as $field) {
                    if ($field->isDashShown) {
                      $initialName = $field->initialName;
                      $content = '';
                      //Format Display Data
                      if ($field->dataType == 'date' || $field->dataType == 'datetime') {
                        if ($record->$initialName != '') {
                          $layout .= tablerowcell(date($userdateformat, strtotime($record->$initialName)));
                        }
                        else{
                          $layout .= tablerowcell('');
                        }                  
                      }
                      else if ($field->dataType == 'boolean') {
                        if ($record->$initialName == '1') {
                          $layout .= tablerowcell('check', 'class="material-icons primary-text center-align"');
                        }
                        else{
                          $layout .= tablerowcell('');
                        }
                        
                      }
                      else{
                        $layout .= tablerowcell($record->$initialName);
                      }
                      
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
