<div class="row margin-top-x2 gradientbganim">

	<div class="valign-wrapper" style="height:100%;">
		<div class="col l6 offset-l3 m6 offset-m3 s12 white valign rounded-5px">
			<?php
				$loginLayout = form_open('utilities/Install/installsystem', 'autocomplete="off"');
				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l12 s12 m12 margin-top-x1">';
						$loginLayout .= maticon('settings', getcolorclass(10));
					$loginLayout .='</div>';
				$loginLayout .='</div>';
				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l12 s12 m12 center-align margin-top-x1">';
						$loginLayout .= $this->layoutgen->genLogo().' '.headertxt('3', 'Install System', ' class="grey-text"');
					$loginLayout .='</div>';
				$loginLayout .='</div>';

				$loginLayout .='<div class="row"><div class="col l12 s12 m12 center-align">'.paragraph('Before running the application, please follow the installation instruction provided in the Developer Manual Documentation', 'class="grey-text center-align"').'</div></div>';
				$loginLayout .='<div class="row"><hr class="style14"></div>';

				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l6 offset-l3  s12 m12  margin-top-x2">';
						$loginLayout .= mdlinputtxt('',  'db_host', maticon('important_devices', 'spaced-text').' Database Host', false, '', 'db_host');
					$loginLayout .='</div>';
				$loginLayout .='</div>';

				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l6 offset-l3  s12 m12">';
						$loginLayout .= mdlinputtxt('',  'db_name', maticon('memory', 'spaced-text').' Database Name', false, '', 'db_name');
					$loginLayout .='</div>';
				$loginLayout .='</div>';

				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l6 offset-l3  s12 m12">';
						$loginLayout .= mdlinputtxt('',  'db_user', maticon('perm_identity', 'spaced-text').' Database User', false, '', 'db_user');
					$loginLayout .='</div>';
				$loginLayout .='</div>';


				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l6 offset-l3 m6 s12 m12">';
						$loginLayout .= mdlinputtxt('',  'db_user_password', maticon('vpn_key', 'spaced-text').' Database User Password', false, '', 'db_user_password');
					$loginLayout .='</div>';
				$loginLayout .='</div>';

				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l6 offset-l3  s12 m12">';
						$loginLayout .= mdlinputtxt('',  'sys_superuserpass', maticon('perm_identity', 'spaced-text').' Super User', false, '', 'sys_superuserpass');
					$loginLayout .='</div>';
				$loginLayout .='</div>';


				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l6 offset-l3 m6 s12 m12">';
						$loginLayout .= mdlinputtxt('',  'sys_superuserpass', maticon('vpn_key', 'spaced-text').' Super User Password', false, '', 'sys_superuserpass');
					$loginLayout .='</div>';
				$loginLayout .='</div>';

				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l6 offset-l3 m6 s12 m12">';
						$loginLayout .= mdlinputtxt('',  'sys_name', maticon('work', 'spaced-text').' System Name', false, '', 'sys_name');
					$loginLayout .='</div>';
				$loginLayout .='</div>';


				$loginLayout .='<div class="row">';
					$loginLayout .='<div class="col l6 offset-l3  s12 m12 margin-top-x3 center-align">';
						$loginLayout .= mdlsubmitbtn('settings', 'Install');
					$loginLayout .='</div>';
				$loginLayout .='</div>';

				$loginLayout .= '</form>';
				echo $loginLayout;
			?>
		</div>
	</div>
	
</div>
<script>
$(document).ready(function(){
    particlesbg('particled', 'default');
});
</script>