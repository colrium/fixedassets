<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


echo mdldivstrt('row');
	echo mdldivstrt('col l3 m4 s12 paddless step-up-2 paddless');
		echo mdldivstrt('page-heading');
			echo headerTxt(4, maticon('build', 'spaced-text').' Table Preferences', 'class="inverse-text"');
		echo mdldivend();
		echo mdldivstrt('col s12 dash-window paddless marginless');
		echo '<ul class="tabs transparent vertical marginless">';
			foreach ($tables as $table) {
				echo '<li class="tab"><a href="#'.$table->parentTable.'">'.maticon($table->parentTableIcon, 'spaced-text').' '.$table->parentTableName.'</a></li>';
			}							
		echo '</ul>';
		echo mdldivend();
	echo mdldivend();

	echo mdldivstrt('col l9 m8 s12 rounded-5px data-card step-up-max');
		echo mdldivstrt('cardheader fullheader primarydark');
			echo headertxt('2', maticon('settings', 'spaced-text').' Tables Preferences', 'class="full-width center-align inverse-text"');
			echo button('class="action large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));
		echo mdldivend();

		echo mdldivstrt('cardbody white dash-window');
			echo mdldivstrt('row');
				echo mdldivstrt('col s12');
					echo form_open('preferences/System/tablepreferences/'.$module);
						echo mdldivstrt('row');							

							foreach ($tables as $table) {
								$tablefields = dbtablefields($table->parentTable);
								echo mdldivstrt('col s12', $table->parentTable);
									echo materializetablestart('', maticon($table->parentTableIcon, 'spaced-text').' '.$table->parentTableName);
		                                echo tableheadstart();
		                                    echo tablerowstart();
		                                        echo tablerowcell('Table Name', 'class="inputcell"');
		                                        echo tablerowcell('Table Icon', 'class="inputcell" colspan="2"');
		                                    echo tablerowend();
		                                echo tableheadend();

		                                echo tablebodystart();
		                                        echo tablerowstart();
		                                            echo tablerowcell(materializeinputtxt($table->parentTableName, 'parentTableName['.$table->parentTable.']', 'Name', false, '', 'name_'.$table->parentTable), 'class="inputcell"');
		                                            echo tablerowcell(materializeinputtxt($table->parentTableIcon, 'parentTableIcon['.$table->parentTable.']', 'Icon', false, 'iconpicker', 'icon_'.$table->parentTable), 'class="inputcell" colspan="2"');
		                                        echo tablerowend();

		                                echo tablebodyend();

		                            echo materializetableend();
								echo mdldivend();
							}
						echo mdldivend();
					echo form_close();
				echo mdldivend();
			echo mdldivend();
		echo mdldivend();
		
	echo mdldivend();

echo mdldivend();
?>
