<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


echo form_open('preferences/System/inputpreferences/'.$module, 'class="row paddless"');
	echo  mdldivstrt('col l2 m4 s12 step-up-2 fixed');
		echo  mdldivstrt('page-heading');
			echo  spanned(maticon('build', 'spaced-text').' Entities');
		echo  mdldivend();

		echo mdldivstrt('col s12 dash-window paddless');
			echo  '<ul class="tabs transparent vertical">';
				foreach ($tables as $table) {
					echo  '<li class="tab waves-effect"><a href="#'.$table->parentTable.'">'.maticon($table->parentTableIcon, 'spaced-text').' '.$table->parentTableName.'</a></li>';
				}
			echo  '</ul>';
		echo  mdldivend();			
	echo  mdldivend();

	echo  mdldivstrt('col l10 m8 s12 rounded-5px data-card step-up-max');
		echo  mdldivstrt('cardheader fullheader primarydark');
			echo  headerTxt('2', maticon('folder_open', 'spaced-text').' Fields Preferences', 'class="full-width center-align inverse-text"');			
			echo button('class="action large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));
			echo anchor('preferences/System/addinputfield/'.$module, maticon('add', 'spaced-text'), 'class="action waves-effect waves-dark grey lighten-4 primary-text"');
		echo  mdldivend();
			
		echo  mdldivstrt('cardbody white');
			foreach ($tables as $table) {
				echo  mdldivstrt('row', $table->parentTable);
					echo mdldivstrt('row padded');
						echo  headerTxt('1', maticon($table->parentTableIcon, 'spaced-text').' '.$table->parentTableName, 'class="full-width center-align grey-text"');
					echo  mdldivend();
					$tablefields = dbtablefields($table->parentTable);
					foreach ($tablefields as $field) {
						echo mdldivstrt('row padded hoverablebg rounded-3px');
							echo mdldivstrt('col l6 m12 s12');
								echo materializeinputtxt($field->setName, 'setName['.$field->fieldId.']', 'Set Name', false, '', 'setName'.$field->fieldId);
							echo  mdldivend();

							echo mdldivstrt('col l6 m12 s12');
								echo materializeinputtxt($field->fieldIcon, 'fieldIcon['.$field->fieldId.']', 'Icon', false, 'iconpicker', 'fieldIcon'.$field->fieldId);
							echo  mdldivend();

							echo mdldivstrt('col s2');
								echo materializeswitch('1', '',  'Visible', 'isDashShown['.$field->fieldId.']', 'dash'.$field->fieldId, ($field->isDashShown == '1' ? true : false));
							echo  mdldivend();


							echo mdldivstrt('col s2');
								echo materializechkbox('1', 'Required', 'isRequired['.$field->fieldId.']', 'required'.$field->fieldId, '', ($field->isFormReq == '1' ? true : false));
							echo  mdldivend();


							echo mdldivstrt('col s2');
								echo materializechkbox('1', 'Unique', 'isUnique['.$field->fieldId.']', 'unique'.$field->fieldId, '', ($field->isUnique == '1' ? true : false));
							echo  mdldivend();

							echo mdldivstrt('col s3');
								echo materializechkbox('1', 'Disabled', 'isDis['.$field->fieldId.']', 'dis'.$field->fieldId, '', ($field->isDis == '1' ? true : false));
							echo  mdldivend();


							echo mdldivstrt('col s3');
								echo materializechkbox('1', 'MakerCheckered', 'makercheckered['.$field->fieldId.']', 'makercheckered'.$field->fieldId, '', ($field->makercheckered == '1' ? true : false));
							echo  mdldivend();	

						echo  mdldivend();
					}
				echo  mdldivend();
			}
		echo  mdldivend();
		echo mdldivstrt('fixed-action-btn');
			echo anchor('preferences/System/addinputfield/'.$module, maticon('add', 'spaced-text'), 'class="btn-floating waves-effect waves-dark accent rippled-ring"');
		echo mdldivend();
	echo  mdldivend();
		
echo  form_close();


?>
