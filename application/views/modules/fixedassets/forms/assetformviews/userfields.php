<?php

echo mdldivstrt('col s9 rounded-5px data-card step-up-max', 'userfieldstab');
	echo mdldivstrt('cardheader fullheader primarydark');
		echo headertxt('2', maticon('local_library', 'spaced-text').' User Fields', 'class="full-width center-align inverse-text"');
		echo button('class="action onviewanimated large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));
	echo mdldivend();

	echo mdldivstrt('cardbody white dash-window mdscrollbar');
		echo mdldivstrt('col s12');
			echo materializetablestart('', maticon('local_library', 'spaced-text').' User Fields');


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField1", ($recId == '0'  ? set_value('userField1') : (set_value('userField1')!=''? set_value('userField1') : $details->userField1))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField2", ($recId == '0'  ? set_value('userField2') : (set_value('userField2')!=''? set_value('userField2') : $details->userField2))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField3", ($recId == '0'  ? set_value('userField3') : (set_value('userField3')!=''? set_value('userField3') : $details->userField3))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField4", ($recId == '0'  ? set_value('userField4') : (set_value('userField4')!=''? set_value('userField4') : $details->userField4))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();					
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField5", ($recId == '0'  ? set_value('userField5') : (set_value('userField5')!=''? set_value('userField5') : $details->userField2))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField6", ($recId == '0'  ? set_value('userField6') : (set_value('userField6')!=''? set_value('userField6') : $details->userField6))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField7", ($recId == '0'  ? set_value('userField7') : (set_value('userField7')!=''? set_value('userField7') : $details->userField1))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField8", ($recId == '0'  ? set_value('userField8') : (set_value('userField8')!=''? set_value('userField8') : $details->userField8))), 'class="inputcell"');		
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField9", ($recId == '0'  ? set_value('userField9') : (set_value('userField9')!=''? set_value('userField9') : $details->userField9))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField10", ($recId == '0'  ? set_value('userField10') : (set_value('userField10')!=''? set_value('userField10') : $details->userField10))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField11", ($recId == '0'  ? set_value('userField11') : (set_value('userField11')!=''? set_value('userField11') : $details->userField11))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField12", ($recId == '0'  ? set_value('userField12') : (set_value('userField12')!=''? set_value('userField12') : $details->userField12))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField13", ($recId == '0'  ? set_value('userField13') : (set_value('userField13')!=''? set_value('userField13') : $details->userField13))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField14", ($recId == '0'  ? set_value('userField14') : (set_value('userField14')!=''? set_value('userField14') : $details->userField14))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userField15", ($recId == '0'  ? set_value('userField15') : (set_value('userField15')!=''? set_value('userField15') : $details->userField15))), 'class="inputcell"');
					echo tablerowcell();			
				echo tablerowend();



				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userDateField1", ($recId == '0'  ? set_value('userDateField1') : (set_value('userDateField1')!=''? set_value('userDateField1') : $details->userDateField1))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userDateField2", ($recId == '0'  ? set_value('userDateField2') : (set_value('userDateField2')!=''? set_value('userDateField2') : $details->userField2))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userDateField3", ($recId == '0'  ? set_value('userDateField3') : (set_value('userDateField3')!=''? set_value('userDateField3') : $details->userDateField3))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userDateField4", ($recId == '0'  ? set_value('userDateField4') : (set_value('userDateField4')!=''? set_value('userDateField4') : $details->userDateField4))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userDateField5", ($recId == '0'  ? set_value('userDateField5') : (set_value('userDateField5')!=''? set_value('userDateField5') : $details->userDateField5))), 'class="inputcell" colspan="2"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userIntField1", ($recId == '0'  ? set_value('userIntField1') : (set_value('userIntField1')!=''? set_value('userIntField1') : $details->userIntField1))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userIntField2", ($recId == '0'  ? set_value('userIntField2') : (set_value('userIntField2')!=''? set_value('userIntField2') : $details->userIntField2))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("userIntField3", ($recId == '0'  ? set_value('userIntField3') : (set_value('userIntField3')!=''? set_value('userIntField3') : $details->userIntField3))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("userIntField4", ($recId == '0'  ? set_value('userIntField4') : (set_value('userIntField4')!=''? set_value('userIntField4') : $details->userIntField4))), 'class="inputcell"');		
				echo tablerowend();







			echo materializetableend();
		echo mdldivend();

	
		
	echo mdldivend();
echo mdldivend();


?>

