<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>colorpicker/js/prism.js"></script>
<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>colorpicker/js/materialize-colorpicker.js"></script>
<link rel="stylesheet" href="<?php echo CENUM_ASSETS_DIR;?>colorpicker/css/materialize-colorpicker.css">
<link rel="stylesheet" href="<?php echo CENUM_ASSETS_DIR;?>colorpicker/css/prism.css">
<?php
$allcolors = allcolorclasses();
$layout = form_open('preferences/System/colorscheme');

	$layout .= mdldivstrt('row white rounded-6px padded');
		//primary color
		$layout .= mdldivstrt('col s12');
			$layout .=  mdldivstrt('row');
				$layout .= mdldivstrt('col s12');
					$layout .= headertxt(3, maticon('color_lens', 'spaced-text').' System Color Scheme');
				$layout .= mdldivend();
			$layout .= mdldivend();

			$layout .=  mdldivstrt('row');
				$layout .= mdldivstrt('col s12 padded ');
					$layout .= '<hr class="style3"/>';
				$layout .= mdldivend();
			$layout .= mdldivend();
		$layout .= mdldivend();
		$layout .= breaker(2);


		$layout .= mdldivstrt('col s8 offset offset-s2');
			$layout .=  materializecolorpicker(getcolorclass(0), 'primary_color_class', 'Primary Color', 'primary_color_class', 'colordatatype="name"');
		$layout .= mdldivend();
		$layout .= breaker(2);



		//primary color dark
		$layout .= mdldivstrt('col s8 offset offset-s2');
			$layout .= materializecolorpicker(getcolorclass(1), 'primary_dark_color_class', 'Primary Dark Color', 'primary_dark_color_class', 'colordatatype="name"');
		$layout .= mdldivend();
		$layout .= breaker(2);


		//Accent color
		$layout .= mdldivstrt('col s8 offset offset-s2');
			$layout .= materializecolorpicker(getcolorclass(2), 'accent_color_class', 'Accent Color', 'accent_color_class', 'colordatatype="name"');
		$layout .= mdldivend();
		$layout .= breaker(2);


		//highlight color
		$layout .= mdldivstrt('col s8 offset offset-s2');
			$layout .= materializecolorpicker(getcolorclass(3), 'highlight_color_class', 'Highlight Color', 'highlight_color_class', 'colordatatype="name"');
		$layout .= mdldivend();
		$layout .= breaker(2);




		//Submit Button color
		$layout .= mdldivstrt('col s8 offset offset-s2');
			$layout .= materializecolorpicker(getcolorclass(6), 'submit_btn_color_class', 'Submit Button Color', 'submit_btn_color_class', 'colordatatype="name"');
		$layout .= mdldivend();
		$layout .= breaker(2);



		//Action Button color
		$layout .= mdldivstrt('col s8 offset offset-s2');
			$layout .= materializecolorpicker(getcolorclass(7), 'action_btn_color_class', 'Action Button Color', 'action_btn_color_class', 'colordatatype="name"');
		$layout .= mdldivend();
		$layout .= breaker(2);

		//Link Text color
		$currentLinkTxtcolor = str_replace('-text', '', str_replace(' text-', ' ', getcolorclass(8)));
		$layout .= mdldivstrt('col s8 offset offset-s2');
			$layout .= materializecolorpicker($currentLinkTxtcolor, 'link_text_color_class', 'Link text Color', 'link_text_color_class', 'colordatatype="name"');
		$layout .= mdldivend();
		$layout .= breaker(2);




		//Table header color
		$layout .= mdldivstrt('col s8 offset offset-s2');
			$layout .= materializecolorpicker(getcolorclass(9), 'table_head_bg_color_class', 'Data Tables Header Row Color', 'table_head_bg_color_class', 'colordatatype="name"');
		$layout .= mdldivend();
		$layout .= breaker(2);


		


		//Table header color
		$layout .= mdldivstrt('col s8 offset offset-s2');
			$layout .= mdlsubmitbtn('save', 'Save Changes');
			
		$layout .= mdldivend();
		$layout .= breaker(2);
		
	$layout .= mdldivend();

$layout .= form_close();
echo $layout;





?>

