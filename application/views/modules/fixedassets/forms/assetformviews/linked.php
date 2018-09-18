<?php
$fields = dbtablefields('fixedassets_assetlist');
$displayedfields = array();
foreach ($fields as $field) {
	if ($field->isDashShown) {
		array_push($displayedfields, $field);
	}
}	


echo mdldivstrt('col s9 rounded-5px step-up-max', 'linkedtab');
	echo mdldivstrt('row');

		echo materializetablestart('', maticon('device_hub', 'spaced-text upside-down').' Parent Asset with this item as a child');
			echo tableheadstart();
				echo tablerowstart();
					echo mdltablecell(mdlinputtxt('', 'parent-search', maticon('search', 'spaced-text').' '.$this->fieldnames->getFieldName('assetCode'), false, '', 'parent-search').breaker().' <a href="#" class="btn-flat disabled " id="add-parent-btn">'.maticon('add', 'spaced-text').' Add</a>', 'class="inputcell" colspan="'.sizeof($displayedfields).'"');
				echo tablerowend();

				echo tablerowstart();
					foreach ($displayedfields as $tablefield) {
						echo tablerowcell($tablefield->setName);
					}
					
				echo tablerowend();
			echo tableheadend();


			echo tablebodystart('id="parent-link-tble-body"');
				
				

			echo tablebodyend();


		echo materializetableend();

	echo mdldivend();








	echo mdldivstrt('row');

		echo materializetablestart('', maticon('device_hub', 'spaced-text').' Children Assets with this item as the Parent');
			echo tableheadstart();

				echo tablerowstart();
					echo mdltablecell(mdlinputtxt('', 'child-search', maticon('search', 'spaced-text').' '.$this->fieldnames->getFieldName('assetCode'), false, '', 'child-search').breaker().' <a href="#" class="btn-flat disabled" id="add-child-btn">'.maticon('add', 'spaced-text').' Add</a>', 'class="inputcell" colspan="'.sizeof($displayedfields).'"');
				echo tablerowend();

				echo tablerowstart();
					foreach ($displayedfields as $tablefield) {
						echo tablerowcell($tablefield->setName);
					}
					
				echo tablerowend();
			echo tableheadend();


			echo tablebodystart('id="child-link-tble-body"');
				
				

			echo tablebodyend();


		echo materializetableend();

	echo mdldivend();


echo mdldivend();

?>
