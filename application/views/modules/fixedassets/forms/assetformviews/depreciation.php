<?php
$layout = mdldivstrt('col s9 rounded-5px step-up-max', 'depreciationtab');
	$layout .= mdldivstrt('row');

		$layout .= materializetablestart('', maticon('trending_down', 'spaced-text').' Depreciation');

			$layout .= tablerowstart();
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("deprMethod", ($recId == '0' ? set_value('deprMethod') : (set_value('deprMethod')!=''? set_value('deprMethod') : $details->deprMethod)), 'fixedassets_assetlist'), 'class="inputcell"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("dtePutIntoService", ($recId == '0' ? set_value('dtePutIntoService') : (set_value('dtePutIntoService')!=''? set_value('dtePutIntoService') : $details->dtePutIntoService))), 'class="inputcell"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("totalCost", ($recId == '0' ? set_value('totalCost') : (set_value('totalCost')!=''? set_value('totalCost') : $details->totalCost))), 'class="inputcell"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("salvageVal", ($recId == '0' ? set_value('salvageVal') : (set_value('salvageVal')!=''? set_value('salvageVal') : $details->salvageVal))), 'class="inputcell"');
			$layout .= tablerowend();

			$layout .= tablerowstart();
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("assetLYears", ($recId == '0' ? set_value('assetLYears') : (set_value('assetLYears')!=''? set_value('assetLYears') : $details->assetLYears))), 'class="inputcell"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("percdepPA", ($recId == '0' ? set_value('percdepPA') : (set_value('percdepPA')!=''? set_value('percdepPA') : $details->percdepPA))), 'class="inputcell"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("bizUse", ($recId == '0' ? set_value('bizUse') : (set_value('bizUse')!=''? set_value('bizUse') : $details->bizUse))), 'class="inputcell"');
				$layout .= tablerowcell('', 'class="inputcell"');
			$layout .= tablerowend();


			$layout .= tablerowstart();
				$layout .= tablerowcell('', 'class="inputcell" id="yearsprojection" colspan="2"');
				$layout .= tablerowcell('', 'class="inputcell" id="yearsprojection" colspan="2"');
			$layout .= tablerowend();


		$layout .= materializetableend();


	$layout .= mdldivend();



	$layout .= mdldivstrt('row');
		$layout .= materializetablestart('', maticon('remove_circle', 'spaced-text').' Disposal');

			$layout .= tablerowstart();
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("disposalMethod", ($recId == '0' ? set_value('disposalMethod') : (set_value('disposalMethod')!=''? set_value('disposalMethod') : $details->disposalMethod))), 'class="inputcell"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("dteDisposed", ($recId == '0' ? set_value('dteDisposed') : (set_value('dteDisposed')!=''? set_value('dteDisposed') : $details->dteDisposed))), 'class="inputcell"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("disposalBookValue", ($recId == '0' ? set_value('disposalBookValue') : (set_value('disposalBookValue')!=''? set_value('disposalBookValue') : $details->disposalBookValue))), 'class="inputcell"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("disposalLossProfit", ($recId == '0' ? set_value('disposalLossProfit') : (set_value('disposalLossProfit')!=''? set_value('disposalLossProfit') : $details->disposalLossProfit))), 'class="inputcell"');
			$layout .= tablerowend();

			$layout .= tablerowstart();
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("disposeReason", ($recId == '0' ? set_value('disposeReason') : (set_value('disposeReason')!=''? set_value('disposeReason') : $details->disposeReason))), 'class="inputcell" colspan="4"');
			$layout .= tablerowend();

			$layout .= tablerowstart();
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("dteSold", ($recId == '0' ? set_value('dteSold') : (set_value('dteSold')!=''? set_value('dteSold') : $details->dteSold))), 'class="inputcell"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("soldTo", ($recId == '0' ? set_value('soldTo') : (set_value('soldTo')!=''? set_value('soldTo') : $details->soldTo))), 'class="inputcell" colspan="2"');
				$layout .= tablerowcell($this->formfieldinput->generateFieldInput("askingPrice", ($recId == '0' ? set_value('askingPrice') : (set_value('askingPrice')!=''? set_value('askingPrice') : $details->askingPrice))), 'class="inputcell"');		
			$layout .= tablerowend();



		$layout .= materializetableend();


	$layout .= mdldivend();


$layout .= mdldivend();




















echo $layout;

?>

