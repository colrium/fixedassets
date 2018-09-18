<?php
$layout =  mdldivstrt('full-width full-height padded-top padded-bottom');
	if (isloggedin(FALSE)){

				$layout .=  mdldivstrt('row margin-top-x2');
					$layout .=  mdldivstrt('col l12 s12 m12');
					$layout .=  mdldivend();//col l12 s12 m12
				$layout .=  mdldivend();//row


				$layout .=  mdldivstrt('row');
					$layout .=  mdldivstrt('nav-breadcrumb margin-x1 padded', 'nav-breadcrumb');
						 $layout .=  mdldivstrt('row');
							$layout .=  mdldivstrt('col s12');				    	 		
								$layout .=  $pageTitle;
							$layout .=  mdldivend();//col l12 s12 m12
						 $layout .=  mdldivend();//row
						
					$layout .=  mdldivend();//full-width end
				$layout .=  mdldivend();//row

				$layout .=  mdldivstrt('row bottom');
					$layout .=  mdldivstrt('col s6');
						$layout .=  mdlsmalldiv(maticon('help_outline', 'chipicon').' Help', 'class="chip  grey primarydark-text waves-effect waves-dark"');
					$layout .=  mdldivend();//col s6

					$layout .=  mdldivstrt('col s6 right-align');
						$layout .=  mdlsmalldiv(maticon('info_outline', 'chipicon').' About', 'class="chip grey lighten-1 primary-text waves-effect waves-dark"');
					$layout .=  mdldivend();//col s6

					$layout .=  mdldivstrt('col s12');
						$layout .=  smalltxt('Render Time <strong>{elapsed_time}</strong> seconds.', 'class="right grey-text padded"');
						$layout .=  smalltxt($this->verauth->organisation(), 'class="left grey-text text-lighten-1  padded"');
					$layout .=  mdldivend();//col l12 s12 m12
				$layout .=  mdldivend();//row

				
	}
$layout .=  mdldivend();//full-width end
echo $layout;