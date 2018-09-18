<?php
echo mdldivstrt('col s9 rounded-5px data-card step-up-max', 'picturetab');
	echo mdldivstrt('cardheader fullheader primarydark');
		echo headertxt('2', maticon('camera_alt', 'normal-text').' Images', 'class="full-width center-align inverse-text"');
		echo button('class="action onviewanimated large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));
	echo mdldivend();

	echo mdldivstrt('cardbody white dash-window mdscrollbar');
		echo mdldivstrt('col s12 center-align padded');		
			echo imageuploader('faimage', 'faimage', 'fixedassets_assetlist', $recId);
		echo mdldivend();

		echo mdldivstrt('col s12');
					
						if (sizeof($images)>0 && is_array($images)) {
							echo '<ul class="collection borderless">';
							foreach ($images as $image) {
								echo '<li class="collection-item avatar">';
										echo img(site_url('files/Files/outputimage/'.$image->attId), 'alt="" class="circle grey lighten-2"');
										echo '<span class="title grey-text text-darken-3">'.$image->name.'</span>';
										echo paragraph(maticon('event', 'spaced-text').' '.formatmoduledatetimeformat($image->gmtinsertdate, 'fixedassets').breaker().maticon('data_usage', 'spaced-text').' '.$image->filesize, 'class="grey-text"');
										echo anchor('files/Files/delete/'.$image->attId, maticon('delete', 'spaced-text'), 'class="secondary-content red-text"');
										echo anchor('files/Files/download/'.$image->attId, maticon('cloud_download', 'spaced-text'), 'class="secondary-content grey-text"');
								echo '</li>';
								
							}
							echo '</ul>';
						}
						else{
							echo headertxt('3', maticon('folder_open', 'normal-text').' No Images Yet', 'class="full-width center-align grey-text"');
						}
		echo mdldivend();

	echo mdldivend();
echo mdldivend();

?>

