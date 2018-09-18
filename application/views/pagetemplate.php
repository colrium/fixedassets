	<?php
		
		$this->load->view('preloaders');
		$this->load->view('navviews/navbar');
		$this->load->view('navviews/notifacations');
				if (isloggedin(FALSE)){
					$this->load->view('navigation');
					$this->load->view('references/jsreference');
				}

				$displaypage = '';
				if (isset($page)) {
					$displaypage = $page;
				}
				if ($displaypage == 'errorpage') {
					if (!is_null($mainTemplate)){
						if (is_array($mainTemplate)){
							foreach ($mainTemplate as $singleTemplate){
								$this->load->view($singleTemplate);
							}
						}
						else {
							$this->load->view($mainTemplate);																	
						}
					}
				}
				else{   
				?>
					<div class="data-card content-page">
						<div class="cardheader">                        
													 <?php
													 $logo = dbattachmentimages('systemlogo', 1, TRUE);
													 $homebreadcrumb = breadcrumb('<i class="material-icons spaced-text">apps</i>', 'Dashboard/modules', 'class="white black-text avatar-char onviewanimated breadcrumb waves-effect waves-light"');
														if ($logo != FALSE) {
															$homebreadcrumb = breadcrumb('<img src="'.site_url('files/Files/outputmainimage/systemlogo/1').'" class="responsive-img"/>', 'Dashboard/modules', 'class="btn-circle breadcrumb onviewanimated waves-effect waves-dark"');
														}
													$breadcrumbslayout = '<div class="col s12">';
														 if (isloggedin(FALSE)) {
															 $breadcrumbslayout = '<div class="col s12"> '.$homebreadcrumb;
														 }
														
														if (isset($module)) {
															$modules = $this->config->item('fortmodules');
															$modulesicons = $this->config->item('fortmodulesicons');
															$modulesanchorprefixes = $this->config->item('modulesanchorprefixes');
															$modulescolorclasses = $this->config->item('modulescolorclasses');
															$moduledashchips = array();
															foreach ($modules as $modulekey => $modulevalue) {
																$moduledashchips[$modulekey] = breadcrumb('<i class="material-icons chipicon '.$modulescolorclasses[$modulekey].' inverse-text">'.$modulesicons[$modulekey].'</i><span class="'.moduletextcolorclass($modulekey).'">'.$modules[$modulekey].'</span>', $modulesanchorprefixes[$modulekey].'Dashboard', 'class="breadcrumb onviewanimated waves-effect waves-dark"');
															}
															if (array_key_exists($module, $moduledashchips)) {
																$breadcrumbslayout .= $moduledashchips[$module];
															}
														 
														}
														$breadcrumbslayout .= $pageTitle.'</div>';
														echo $breadcrumbslayout;
														if (isset($actionbuttons)) {
															echo $actionbuttons;
														}
													?>
												</div>
													<div class="cardbody">

														<?php  
																	 if (!is_null($mainTemplate)){
																		 if (is_array($mainTemplate)){
																				foreach ($mainTemplate as $singleTemplate){
																					 $this->load->view($singleTemplate);

																				}
																		 }else {
																				$this->load->view($mainTemplate);
																				
																		 }
																	}
																	
															?>

													</div>
													

												</div>

												

										 </div>


							<?php

						 }

						 ?>
						
						 
		 <?php 
		 if (isloggedin(FALSE)){
				if (isset($module)) {
					if (array_key_exists($module, $this->config->item('fortmodules'))) {						
						echo '<script type="text/javascript" src="'.CENUM_ASSETS_DIR.'modules/'.$module.'/script.js"></script>';
					}
				}

				$this->load->view('forms/modals/importmodal');
				$this->load->view('forms/modals/makercheckermodal');
				$this->load->view('forms/modals/addremindermodal');
				if(isdebugger(FALSE)){
					$this->load->view('utilities/restoredbmodal');
				}

				if (isset($module) && $module=='invoicing') {
					$this->load->view(INVOICING_PREFIX.'forms/modals/defineinvoice');
					$this->load->view(INVOICING_PREFIX.'forms/modals/definequote');
				}

				if (isset($module) && $module=='events') {
					$this->load->view(EVENTS_PREFIX.'forms/modals/fcaddeventmodal');
				}
				
				$this->load->view('forms/modals/backupdbmodal');

		}

	



