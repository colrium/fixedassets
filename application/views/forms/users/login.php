
<?php
echo mdldivstrt('row', 'loginwrapper');
	echo mdldivstrt('col l4 m8 s12 offset-l4 offset-m2 data-card step-up-max');
		echo mdldivstrt('cardheader fullheader primarydark center-align');
			echo img(site_url('files/Files/outputmainimage/systemlogo/1'), 'class="h-centered"');
		echo mdldivend();

		echo mdldivstrt('cardbody white paddless');
			echo form_open('Login/login');
				echo mdldivstrt('row paddless');
					echo mdldivstrt('col s12 margin-top-x3 paddless');
						echo materializeinputicontxt('',  'username', 'Username / Email', 'person');
					echo mdldivend();
				echo mdldivend();


				echo mdldivstrt('row paddless');
					echo mdldivstrt('col s12 paddless');
						echo materializeinputiconpass('',  'password', ' Password', 'vpn_key');
					echo mdldivend();
				echo mdldivend();

				

				echo mdldivstrt('row paddless');
					echo mdldivstrt('col s12 margin-top-x3 paddless');
						echo mdlsubmitbtn('lock_open', 'Login');
					echo mdldivend();
				echo mdldivend();

				echo mdldivstrt('row paddless');
					echo mdldivstrt('col s12 margin-top-x2 center-align');
						echo anchor('Login/forgotpassword', 'Forgot Password?', 'class="grey-text"');
					echo mdldivend();
				echo mdldivend();

			echo form_close();
		echo mdldivend();
		
	echo mdldivend();
	echo mdldivend();
echo mdldivend();
?>


	 
