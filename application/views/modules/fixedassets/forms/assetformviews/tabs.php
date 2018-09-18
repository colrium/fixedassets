<?php

$layout = 	'<div class="col s3 paddless  step-up-2 ">
				<div class="page-heading truncate">
					'.($recId != '0'  ? ' <span>'.$details->assetCode.' '.$details->assetItem.'</span>' : ' <span>'.maticon('add_circle', 'spaced-text').' New Record</span>').'
				</div>
				<ul class="tabs transparent vertical dash-window mdscrollbar">
				  <li class="tab"><a href="#generaltab" class="active">'.maticon('star', 'spaced-text').' General</a></li>
				  <li class="tab"><a href="#additionaltab" >'.maticon('star_half', 'spaced-text').' Additional</a></li>
				  <li class="tab"><a href="#userfieldstab" >'.maticon('local_library', 'spaced-text').' UserFields</a></li>
				  '.($recId != '0' ? '<li class="tab"><a href="#notebooktab" >'.maticon('book', 'spaced-text').' Notebook</a></li>':'').'
				  '.($recId != '0' ? '<li class="tab"><a href="#picturetab" >'.maticon('camera_alt', 'spaced-text').' Item picture</a></li>':'').'
				  '.($recId != '0' ? '<li class="tab"><a href="#attachmentstab" >'.maticon('attachment', 'spaced-text').' Attachments</a></li>':'').'
				  '.($recId != '0' ? '<li class="tab"><a href="#linkedtab" >'.maticon('phonelink', 'spaced-text').' Linked Assets</a></li>':'').'
				  <li class="tab"><a href="#depreciationtab" >'.maticon('trending_down', 'spaced-text').' Depreciation</a></li>
				</ul>
			  </div>';




echo $layout;