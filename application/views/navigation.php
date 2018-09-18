<?php 
/*---------------------------------------------------------------------
echo mdlulstart('class="drawer" id="app-main-drawer"');
	echo mdllistart();
		echo mdldivstrt('drawer-header');
		
			if ($this->session->userdata('user_image')) {
				echo mdllink('href"#"', img(site_url('files/Files/outputmainimage/users/'.USERID), 'class="circle translucent"'));
			}
			else{
				echo maticon('person', 'circle xl-text inverse-text');
			}
			echo mdllink('href"#"', spanned(humanize(USERLNAME).' '.humanize(USERFNAME), 'class="name inverse-text"'));
			echo mdllink('href"#"', spanned(USEREMAIL, 'class="email inverse-text"'));
			echo img(site_url('files/Files/mdbg'), 'class="background"');
			
		echo mdldivend();
	echo mdlliend();
echo mdlulend();
---------------------------------------------------------------------*/
echo mdldivstrt('offcanvas-nav');
		echo mdldivstrt('nav-body');
			  if (isloggedin(FALSE)){
					echo mdldivstrt('inner full-width full-height');                        
							echo mdldivstrt('col s12');//tabs
								$this->load->view('navviews/nav-menu');
								
							echo mdldivend();//tabs
					echo mdldivend();
					
			  }
		echo mdldivend();

echo mdldivend();



	


   
	
?>

	