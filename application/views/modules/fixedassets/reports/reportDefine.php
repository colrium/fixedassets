<?php
	if ($report=='depreciation') {
		$dispform = form_open(FIXEDASSETS_PREFIX.'reports/Reports/genDepreciationRep/');
			$dispform .= mdldivstrt('row');
				$dispform .= mdldivstrt('col s12 padded');
			    	$dispform .= materializetablestart('class="highlight"', 'Depreciation Report Variables');
			    		$dispform .= headerrowstart();
							$dispform .= tablerowcell(materializeinputdate(date('Y-m-d'), 'dateEnd', 'For Up to the Date', false, '', 'dateEnd'), 'class="inputcell"');
						$dispform .= headerrowend();


						$dispform .= tablerowstart();
							$dispform .= tablerowcell(chosenselect('sortcriteria', array('none'=>'None', 'category'=>$this->fieldnames->getFieldName('assetCat'), 'location' => $this->fieldnames->getFieldName('assetPrimLoc'), 'department' =>$this->fieldnames->getFieldName('assetSecLoc')), 'none', 'Data Sort Criteria', 'sortcriteria'), 'class="inputcell"');
						$dispform .= tablerowstart();


						$dispform .= tablerowstart();
							$dispform .= tablerowcell(materializechkbox('1',  'Include Items with Cost of '.monetaryformat(0).' ? ', 'zerocost', 'zerocost', '', false), 'class="inputcell"');
						$dispform .= tablerowstart();


						$dispform .= tablerowstart();
							$dispform .= tablerowcell(materializechkbox('1',  'Include Fully Depreciated Items? ', 'fullydepreciated', 'fullydepreciated', '', false), 'class="inputcell"');
						$dispform .= tablerowstart();

						$dispform .= tablerowstart();
							$dispform .= tablerowcell(materializechkbox('1',  'Include Disposed Items? ', 'disposeditems', 'disposeditems', '', false), 'class="inputcell"');
						$dispform .= tablerowstart();


						$dispform .= tablerowstart();
							$dispform .= tablerowcell(mdlsubmitbtn('equalizer', 'Generate'), 'class="padded inputcell"');
						$dispform .= tablerowstart();


					$dispform .= materializetableend();
				$dispform .= mdldivend();
			$dispform .= mdldivend();
		$dispform .= form_close();

		echo $dispform;
	}

 
elseif ($report=='betweenDates') {
		$this->load->view(FIXEDASSETS_PREFIX.'forms/reports/repBtnDates');
}

elseif ($report=='purchases') {
		$this->load->view(FIXEDASSETS_PREFIX.'forms/reports/purchases');
}

elseif ($report=='assetsGroupBy') {
		$dispform = form_open(FIXEDASSETS_PREFIX.'reports/Reports/genassetsGroupByRep/');
		$dispform .='<table class="mdl-data-table mdl-js-data-table" id="depTable">';
		$dispform .=	'<tr>
							<td colspan="2" class="mdl-data-table__cell--non-numeric"><h3 class="white-text">Assets Grouped By Report</h3></td>

						</tr>';

		
		$dispform .=	'<tr>
							<td class="mdl-data-table__cell--non-numeric centertxt">Select Criteria</td>
							<td class="mdl-data-table__cell--non-numeric centertxt">
								<select name="criteria" class="chosen" style="width:100%;">
									<option value="category">Group By Category<option>
									<option value="department">Group By Department<option>
									<option value="location">Group By Location<option>

								</select>

							</td>

						</tr>';


		$dispform .=	'<tr>
							<td class="mdl-data-table__cell--non-numeric centertxt" colspan="2"><input type="submit" class="btn btn-success" value="Generate"></td>

						</tr>';








		$dispform .='</table></form>';


		echo $dispform;
	}

















?>