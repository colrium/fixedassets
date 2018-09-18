<?php

echo mdldivstrt('col s9 rounded-5px data-card step-up-max', 'additionaltab');
	echo mdldivstrt('cardheader fullheader primarydark');
		echo headertxt('2', maticon('star_half', 'spaced-text').' Additional Info', 'class="full-width center-align inverse-text"');
		echo button('class="action onviewanimated large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));
	echo mdldivend();

	echo mdldivstrt('cardbody white dash-window mdscrollbar');
		echo mdldivstrt('col s12');
			echo materializetablestart('', maticon('star_half', 'spaced-text').' Additional Info');
				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("numberMade", ($recId == '0' ? set_value('numberMade') : (set_value('numberMade')!=''? set_value('numberMade') : $details->numberMade))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("color", ($recId == '0' ? set_value('color') : (set_value('color')!=''? set_value('color') : $details->color))), 'class="inputcell"');			
					echo tablerowcell($this->formfieldinput->generateFieldInput("madeOf", ($recId == '0' ? set_value('madeOf') : (set_value('madeOf')!=''? set_value('madeOf') : $details->madeOf))), 'class="inputcell"');	
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("size", ($recId == '0' ? set_value('size') : (set_value('size')!=''? set_value('size') : $details->size))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("shape", ($recId == '0' ? set_value('shape') : (set_value('shape')!=''? set_value('shape') : $details->shape))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("year", ($recId == '0' ? set_value('year') : (set_value('year')!=''? set_value('year') : $details->year))), 'class="inputcell"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateSingleSelect("auditStatus", ($recId == '0' ? set_value('auditStatus') : (set_value('auditStatus')!=''? set_value('auditStatus') : $details->auditStatus))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("lasDteAudit", ($recId == '0' ? set_value('lasDteAudit') : (set_value('lasDteAudit')!=''? set_value('lasDteAudit') : $details->lasDteAudit))), 'class="inputcell"');					
					echo tablerowcell($this->formfieldinput->generateSingleSelect("lastAuditedBy", ($recId == '0' ? set_value('lastAuditedBy') : (set_value('lastAuditedBy')!=''? set_value('lastAuditedBy') : $details->lastAuditedBy))), 'class="inputcell"');
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("insuredBy", ($recId == '0' ? set_value('insuredBy') : (set_value('insuredBy')!=''? set_value('insuredBy') : $details->insuredBy))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("insurePolicy", ($recId == '0' ? set_value('insurePolicy') : (set_value('insurePolicy')!=''? set_value('insurePolicy') : $details->insurePolicy))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("insurancedteExp", ($recId == '0' ? set_value('insurancedteExp') : (set_value('insurancedteExp')!=''? set_value('insurancedteExp') : $details->insurancedteExp))), 'class="inputcell"');
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("leaseBegin", ($recId == '0' ? set_value('leaseBegin') : (set_value('leaseBegin')!=''? set_value('leaseBegin') : $details->leaseBegin))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("leaseEnd", ($recId == '0' ? set_value('leaseEnd') : (set_value('leaseEnd')!=''? set_value('leaseEnd') : $details->leaseEnd))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("leaseDesc", ($recId == '0' ? set_value('leaseDesc') : (set_value('leaseDesc')!=''? set_value('leaseDesc') : $details->leaseDesc))), 'class="inputcell"');
				echo tablerowend();



			echo materializetableend();
		echo mdldivend();
	echo mdldivend();
echo mdldivend();

?>

