<?php
echo mdldivstrt('row paddless');
		echo mdldivstrt('col s12 data-card step-up-max');
			echo mdldivstrt('cardheader fullheader primarydark');
				echo headerTxt(2, maticon('apps', 'spaced-text').' APPS', 'class="full-width center-align inverse-text"');
			echo mdldivend();
			echo mdldivstrt('cardbody white dash-window mdscrollbar', 'delauneybg');
				$modulesicons = $this->config->item('fortmodulesicons');
				$modulesanchorprefixes = $this->config->item('modulesanchorprefixes');
				$modulescolors = $this->config->item('modulescolorclasses');
				foreach ($this->config->item('fortmodules') as $key => $value) {
					$textcolor = moduletextcolorclass($key);
					echo anchor($modulesanchorprefixes[$key].'Dashboard', maticon($modulesicons[$key], 'xl-text onviewanimated').' </br>'.$value, 'class="col s6 '.$textcolor.' padded center-align transition-a-2ms margin-top-x1"');
				}
			echo mdldivend();
		echo mdldivend();

echo mdldivend();
?>
