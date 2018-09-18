<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$modules = $this->config->item('fortmodules');
$icons = $this->config->item('fortmodulesicons');
$dbfields = dbtablefields('systempriveledgedefs');
echo mdldivstrt('row');
	echo mdldivstrt('col l3 m4 s12 paddless step-up-2');
		echo mdldivstrt('page-heading');
			echo '<span class="onviewanimated zoomin"> Modules</span>';
		echo mdldivend();
		echo  '<ul class="tabs transparent vertical dash-window">';
			foreach ($modules as $key => $value) {
				echo '<li class="tab"><a href="#'.$key.'prvdgetab" class="active">'.maticon($icons[$key], 'spaced-text').' '.humanize($value).'</a></li>';
			}		
		echo '</ul>';
	echo mdldivend();
	foreach ($modules as $key => $value) {
		echo mdldivstrt('col l9 m8 s12 data-card step-up-max', $key.'prvdgetab');
			echo mdldivstrt('cardheader primarydark fullheader');
					echo headertxt('2', maticon($icons[$key], 'spaced-text').' '.humanize($value), 'class="full-width center-align inverse-text"');
			echo mdldivend();

			echo mdldivstrt('cardbody white paddless dash-window');				
					echo materializetablestart('class="bordered"', maticon($icons[$key], 'spaced-text').' '.humanize($value));
						$params= array();
						$params['where']['equalto'] = array('entity' => $key);
						$priveledges = dbtablerecords('systempriveledgedefs', $params);
						if (!is_array($priveledges)) {
							$priveledges = array();
						}
						echo tableheadstart();
							echo headerrowstart();
							foreach ($dbfields as $dbfield) {
								if ($dbfield->initialName != 'id' && $dbfield->initialName != 'name') {
									echo tablerowcell($dbfield->setName);	
								}
								
							}							
							echo headerrowend();
						echo tableheadend();
						
						echo tablebodystart();
							foreach ($priveledges as $priveledge) {
								echo tablerowstart(($priveledge->type == 'data'? 'class="blue lighten-4 custompriveledge" contexttype="'.$key.'" contextdataid="'.$priveledge->id.'" contextname="'.$priveledge->identityname.'"' : ''));
								foreach ($dbfields as $dbfield) {
									$initialName = $dbfield->initialName;
									if ($initialName == 'id' || $initialName == 'name') {
										//do not display
									}
									else if ($initialName == 'datatable') {
										echo tablerowcell(dbmoduletablename($key));
									}
									else if ($initialName == 'datacolumn') {
										echo tablerowcell(dbfieldsetname($priveledge->datatable, $priveledge->$initialName));
									}
									else if ($initialName == 'includeadmins') {
										if ($priveledge->$initialName == 1) {
											echo tablerowcell('check', 'class="material-icons primary-text"');
										}
										else{
											echo tablerowcell('');
										}
										
									}
									else{
										echo tablerowcell($priveledge->$initialName);
									}
																	
									
								}
								echo tablerowend();
							}
						
						echo tablebodyend();
					echo materializetableend();
					if (isdebugger(FALSE)) {
						echo mdldivstrt('fixed-action-btn');
							echo anchor('preferences/System/addedditpriveledge/'.$key.'/0', maticon('add'), 'class="btn-floating waves-effect waves-dark accent rippled-ring"');
						echo mdldivend();
					}
			echo mdldivend();
		echo mdldivend();
	}		
		
echo mdldivend();
if (isdebugger(FALSE)) {
	echo '<script type="text/javascript">
			$(function(){
				$(".custompriveledge").contexted({
								title : false,
								menuoptions : [
									{
										text: "Edit",
										icon: "edit",
										colorclass: "teal-text",
										callback: function(element, contexttype, contextname, contextid){
											var pageurl = $.fn.site_url("preferences/System/addedditpriveledge/"+contexttype+""+contextid);
											$.fn.loadpage(pageurl, ".pagebody", true);
										}
									},
									{
										text: "Delete",
										icon: "delete",
										colorclass: "red-text",
										callback: function(element, contexttype, contextname, contextid){
											$.fn.confirmdelete("systempriveledgedefs", contextid, contextname, element);
										}
									}
								]
				});
			});
		 </script>';
}
	