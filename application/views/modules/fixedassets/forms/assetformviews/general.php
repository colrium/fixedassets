<?php

echo mdldivstrt('col s9 rounded-5px data-card step-up-max', 'generaltab');
	echo mdldivstrt('cardheader fullheader primarydark');
		echo headertxt('2', maticon('star', 'spaced-text').' General', 'class="full-width center-align inverse-text"');
		echo button('class="action onviewanimated large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));
	echo mdldivend();

	echo mdldivstrt('cardbody white dash-window mdscrollbar');
		echo mdldivstrt('col s6');
			echo materializetablestart('', maticon('star', 'spaced-text').' Details');




				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("assetCode", ($recId == '0' ? set_value('assetCode') : (set_value('assetCode')!=''? set_value('assetCode') : $details->assetCode))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("rfidTag", ($recId == '0' ? set_value('rfidTag') : (set_value('rfidTag')!=''? set_value('rfidTag') : $details->rfidTag))), 'class="inputcell"');		
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("assetItem", ($recId == '0' ? set_value('assetItem') : (set_value('assetItem')!=''? set_value('assetItem') : $details->assetItem))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("assetDesc", ($recId == '0' ? set_value('assetDesc') : (set_value('assetDesc')!=''? set_value('assetDesc') : $details->assetDesc))), 'class="inputcell"');	
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assetCat", ($recId == '0' ? set_value('assetCat') : (set_value('assetCat')!=''? set_value('assetCat') : $details->assetCat))), 'colspan="2" class="inputcell"');		
				echo tablerowend();
				


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assetPrimLoc", ($recId == '0' ? set_value('assetPrimLoc') : (set_value('assetPrimLoc')!=''? set_value('assetPrimLoc') : $details->assetPrimLoc))), 'class="inputcell" colspan="2"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell(mdldivstrt('full-width', 'seldepartments').' '.mdldivend(), 'class="inputcell" colspan="2"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("assetTerLoc", ($recId == '0' ? set_value('assetTerLoc') : (set_value('assetTerLoc')!=''? set_value('assetTerLoc') : $details->assetTerLoc))), 'class="inputcell" colspan="2"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assetSctn", ($recId == '0' ? set_value('assetSctn') : (set_value('assetSctn')!=''? set_value('assetSctn') : $details->assetSctn))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assignedTo", ($recId == '0' ? set_value('assignedTo') : (set_value('assignedTo')!=''? set_value('assignedTo') : $details->assignedTo))), 'class="inputcell"');		
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("quantity", ($recId == '0' ? set_value('quantity') : (set_value('quantity')!=''? set_value('quantity') : $details->quantity))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assetStatus", ($recId == '0' ? set_value('assetStatus') : (set_value('assetStatus')!=''? set_value('assetStatus') : $details->assetStatus))), 'class="inputcell"');					
				echo tablerowend();

				

			echo materializetableend();
		echo mdldivend();



		//other table

		echo mdldivstrt('col s6');
			echo materializetablestart('', maticon('attach_money', 'spaced-text').' Purchase Info');


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("lpoNumber", ($recId == '0' ? set_value('lpoNumber') : (set_value('lpoNumber')!=''? set_value('lpoNumber') : $details->lpoNumber))), 'class="inputcell" colspan="2"');	
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("dtePurchased", ($recId == '0' ? set_value('dtePurchased') : (set_value('dtePurchased')!=''? set_value('dtePurchased') : $details->dtePurchased))), 'class="inputcell" colspan="2"');	
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assetDealer", ($recId == '0' ? set_value('assetDealer') : (set_value('assetDealer')!=''? set_value('assetDealer') : $details->assetDealer))), 'class="inputcell" colspan="2"');
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("assetCost", ($recId == '0' ? (set_value('assetCost')!= ''? set_value('assetCost') : '0') : (set_value('assetCost')!=''? set_value('assetCost') : $details->assetCost))), 'class="inputcell" colspan="2"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("assetCTax1", ($recId == '0' ? (set_value('assetCTax1')!= ''? set_value('assetCTax1') : '0') : (set_value('assetCTax1')!=''? set_value('assetCTax1') : $details->assetCTax1))), 'class="inputcell" colspan="2"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("assetCTax2", ($recId == '0' ? (set_value('assetCTax2')!= ''? set_value('assetCTax2') : '0') : (set_value('assetCTax2')!=''? set_value('assetCTax2') : $details->assetCTax2))), 'class="inputcell" colspan="2"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("totalCost", ($recId == '0' ? (set_value('totalCost')!= ''? set_value('totalCost') : '0') : (set_value('totalCost')!=''? set_value('totalCost') : $details->totalCost))), 'class="inputcell" colspan="2"');
				echo tablerowend();



				echo tablerowstart();				
					echo tablerowcell($this->layoutgen->headerText(4, maticon('info_outline', 'spaced-text').' Others'), 'class="inputcell" colspan="2"');				
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assetMnfctr", ($recId == '0' ? set_value('assetMnfctr') : (set_value('assetMnfctr')!=''? set_value('assetMnfctr') : $details->assetMnfctr))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assetBrand", ($recId == '0' ? set_value('assetBrand') : (set_value('assetBrand')!=''? set_value('assetBrand') : $details->assetBrand))), 'class="inputcell"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assetModel", ($recId == '0' ? set_value('assetModel') : (set_value('assetModel')!=''? set_value('assetModel') : $details->assetModel))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateSingleSelect("assetCondition", ($recId == '0' ? set_value('assetCondition') : (set_value('assetCondition')!=''? set_value('assetCondition') : $details->assetCondition))), 'class="inputcell"');
				echo tablerowend();


				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("serialNum", ($recId == '0' ? set_value('serialNum') : (set_value('serialNum')!=''? set_value('serialNum') : $details->serialNum))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("acCode", ($recId == '0' ? set_value('acCode') : (set_value('acCode')!=''? set_value('acCode') : $details->acCode))), 'class="inputcell"');
				echo tablerowend();

				echo tablerowstart();
					echo tablerowcell($this->formfieldinput->generateFieldInput("assetValue", ($recId == '0' ? set_value('assetValue') : (set_value('assetValue')!=''? set_value('assetValue') : $details->assetValue))), 'class="inputcell"');
					echo tablerowcell($this->formfieldinput->generateFieldInput("replCost", ($recId == '0' ? set_value('replCost') : (set_value('replCost')!=''? set_value('replCost') : $details->replCost))), 'class="inputcell"');
				echo tablerowend();

			echo materializetableend();
		echo mdldivend();

	
		
	echo mdldivend();
echo mdldivend();


?>

