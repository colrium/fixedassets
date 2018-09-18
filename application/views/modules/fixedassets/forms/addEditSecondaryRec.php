<?php

$layout = mdldivstrt('row');
	$layout .= mdldivstrt('col s12 data-card step-up-max', 'secondaryrecedit');
		
			$layout .= mdldivstrt('cardheader fullheader primarydark');
				if ($recId=='0') {
			        $layout .= headertxt('2', maticon('add_circle_outline', 'normal-text').' Add to '.$tablename, 'class="full-width center-align inverse-text"');
			    }
			    else{
			        $layout .= headertxt('2', maticon('mode_edit', 'normal-text').' Edit '.$tablename.': '.$recname, 'class="full-width center-align inverse-text"');      	
			    }
			$layout .= mdldivend();

			$layout .= mdldivstrt('cardbody white dash-window mdscrollbar');					
				$layout .= form_open(FIXEDASSETS_PREFIX.'forms/Formhandler/addeditsecondaryrecord/'.$type.'/'.$recId);
					if ($recId != '0') {
						$layout .= mdldivstrt('col s12 padded');
							$layout .= imageuploader('secrecordimg', 'secrecordimg', $table, $recId, 'dragdroperfiler', 'Drag & Drop Image here');
						$layout .= mdldivend();
					}
						

					foreach ($fields as $field) {
						$initialName = $field->initialName;
			          	$value = '';
			          	if ($recId != '0') {
			          		$value = $details->$initialName;
			          	}
				          if (!$field->isPK && ($field->dataLength > 1 || $field->dataType=='text' || $field->dataType=='varchar')) {
					            if ($field->initialName != 'createdBy' && $field->initialName != 'dteCreated' && $field->initialName != 'bRetired') {

					              $layout .= mdldivstrt('col s12 padded');
					          		$layout .= mdldivstrt('col l3 m4 s6');
					          				$layout .= dbfieldsetname($table, $field->initialName);
									$layout .= mdldivend();

									$layout .= mdldivstrt('col l9 m8 s6');
											if ($field->initialName=="catIcon" || $field->initialName=="locIcon") {
												if ($field->initialName=="catIcon" && $value == '') {
													$value = 'star';
												}
												if ($field->initialName=="locIcon" && $value == '') {
													$value = 'place';
												}
												$layout .= materializeiconpicker($value, $field->initialName, $field->initialName);
							                }
							                else{
							                  if ($this->datalib->isFKField($field->initialName, $table)) {							                    
							                    $layout .= $this->formfieldinput->generateSingleSelect($field->initialName, $value, $table);
							                  }
							                  else{
							                    $layout .= $this->formfieldinput->generateFieldInput($field->initialName, $value, $table);
							                  }
							                  
							                }
									$layout .= mdldivend();				                
					              $layout .= mdldivend();
					            }			            
				          }		          
			        }

			        $layout .= mdldivstrt('col s12 padded margin-top-x1', 'none');
			        	if ($recId=='0') {
			        		$layout .= mdlsubmitbtn('save', 'Add New');
			        	}
			        	else{
			        		$layout .= mdlsubmitbtn('save', 'Save  Changes');
			        	}

			        $layout .= mdldivend();
		        $layout .= form_close();

			$layout .= mdldivend();
	$layout .= mdldivend();

$layout .= mdldivend();

echo $layout;


