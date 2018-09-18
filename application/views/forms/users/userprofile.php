<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/
	if ($mainimage != false) {
		$userimage = '<img src="'.site_url('files/Files/outputmainimage/users/'.USERID).'" class="semi-large-image circle framed-image-6px materialboxed"/>';
	}
	else{
		$userimage = maticon('person', 'medium black-text');
	}

	
echo mdldivstrt('row paddless');
	echo mdldivstrt('col l3 s12');

	echo mdldivend();

	echo mdldivstrt('col l9 s12 white step-up-max');
		echo mdldivstrt('col s12 padded');
			echo form_open('users/User/profile');

				echo materializetablestart('', maticon('person_outline', 'spaced-text').' Profile');

					
					echo tablerowstart();
						echo mdltablecell(centereddom($userimage.' '.headertxt('3', humanize(USERLNAME).' '.humanize(USERFNAME), 'class="grey-text text-darken-3" full-width center-align')), 'class="inputcell" colspan="2"');
					echo tablerowend();



					echo tablerowstart();
						echo mdltablecell(imageuploader('profimage', 'profimage', 'users', $recId), 'class="inputcell" colspan="2"');					
					echo tablerowend();

					echo tablerowstart();
						echo mdltablecellstrt('class="inputcell" colspan="2"');
							//user images
							if ($images != false) {
								echo mdldivstrt('row');
									echo mdldivstrt('col l12 m12 s12');
										foreach ($images as $image) {
											echo mdldivstrt('col l2 m2 s4');
												echo '<center>';

													echo '<img src="'.site_url('files/Files/outputimage/'.$image->attId).'" class="circle large"/>';
												
													echo breaker();
													if ($image->ismainimage != '1') {
														echo anchor('uploads/Uploads/setmainimage/'.$image->attId, maticon('photo_filter', 'spaced-text'), 'class="teal-text"');
													}
													echo '<span class="spacer_x3"></span>';
													echo anchor('uploads/Uploads/deleteattachment/'.$image->attId, maticon('delete', 'spaced-text'), 'class="red-text"');
													
													
												echo '</center>';
											echo mdldivend();
										}
									echo mdldivend();
								echo mdldivend();
							}
							else{
								echo headertxt('2', maticon('folder_open', 'normal-text').'<br> No Images uploaded.', 'class="grey-text full-width center-align"');
							} 						

						echo mdltablecellend();
					echo tablerowend();


					echo tablerowstart();
							echo mdltablecell(mdlinputtxt($details->username, 'username', boldtxt(maticon('block','normal-text').' Username', 'class="grey-text"'), true), 'class="inputcell" colspan="2"');
					echo mdlrowend();

					echo tablerowstart();
							echo mdltablecell(mdlinputtxt((set_value('email')!=''? set_value('email') : $details->email), 'email', maticon('email','normal-text').' Email Address'), 'class="inputcell" colspan="2"');
					echo mdlrowend();

					echo tablerowstart();
							echo mdltablecell(mdlinputtxt((set_value('first_name')!=''? set_value('first_name') : $details->first_name), 'first_name', maticon('text_fields','normal-text').' First Name'), 'class="inputcell" colspan="2"');
					echo mdlrowend();

					echo tablerowstart();
							echo mdltablecell(mdlinputtxt((set_value('last_name')!=''? set_value('last_name') : $details->last_name), 'last_name', maticon('text_fields','normal-text').' Last Name'), 'class="inputcell" colspan="2"');
					echo mdlrowend();

					echo tablerowstart();
							echo mdltablecell(mdlinputtxt((set_value('phone')!=''? set_value('phone') : $details->phone), 'phone', maticon('phone','normal-text').' Phone'), 'class="inputcell" colspan="2"');
					echo mdlrowend();


					echo tablerowstart();
						echo mdltablecell(mdlsubmitbtn('save', 'Save Changes'), 'colspan="2" class="inputcell"');
					echo tablerowend();

				echo materializetableend();

			echo form_close();

		echo mdldivend();

	echo mdldivend();
echo mdldivend();