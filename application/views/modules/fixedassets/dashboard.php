<?php
$upreferences = json_encode($preferences);
echo mdldivstrt('row paddless');
	echo mdldivstrt('col l3 m4 s12 paddless step-up-3');
			echo mdldivstrt('page-heading loadcontext');
				echo '<span>No Selection</span>';
			echo mdldivend();

			echo mdldivstrt('page-heading');
				 echo '<a class="dropdown-button btn white waves-effect waves-dark full-width accent-text" href="#" id="viewcriteriabtn" data-constrainwidth="true" data-activates="viewcriteriadrpdwn">Criteria</a>';
				 echo mdldivstrt('dropdown-content collection', 'viewcriteriadrpdwn');

						$userprefsobjarr = get_object_vars($preferences);
						$userdefaultcriteria ='none';
						if (array_key_exists('defaultcriteria', $userprefsobjarr)) {
							$userdefaultcriteria = $preferences->defaultcriteria;
						}

						echo anchor('api/Api/getrecordscount?entity=fixedassets_assetlist&filter=isDisposed&not=1', maticon('folder_open', 'spaced-text').' None', 'class="collection-item left-align grey-text datacriteria" datadom="#criteriadatadom" data-criteria="none" data-criteriacontext="none" data-criterianame="No Criteria"  data-criteriaid="none" data-criteriapk="none" data-criteriaicon="list" '.($userdefaultcriteria=='none'? ' data-autoload="true"':''));
						
						foreach ($criterias as $criteria) {
							if (array_key_exists($criteria->tableFKname, $entitiesnames)) {
								echo anchor('api/Api/getrecords?entity='.$criteria->tableFKname.'&select=count&column=fixedassets_assetlist:assetID&join=fixedassets_assetlist&on='.$criteria->fkTableRecPK.':'.$criteria->initialName.'&keys=1', maticon($entitiesicons[$criteria->tableFKname], 'spaced-text').' '.$entitiesnames[$criteria->tableFKname], 'class="collection-item left-align grey-text datacriteria" datadom="#criteriadatadom" data-criteria="'.$criteria->initialName.'" data-criteriacontext="'.$criteria->tableFKname.'" data-criterianame="'.$entitiesnames[$criteria->tableFKname].'"  data-criteriaid="'.$criteria->fkTableRecName.'" data-criteriapk="'.$criteria->fkTableRecPK.'" data-criteriaicon="'.$entitiesicons[$criteria->tableFKname].'" '.($criteria->tableFKname==$userdefaultcriteria? ' data-autoload="true"':''));
							}
							else{
								echo anchor('api/Api/getrecords?entity='.$criteria->tableFKname.'&select=count&column=fixedassets_assetlist:assetID&join=fixedassets_assetlist&on='.$criteria->fkTableRecPK.':'.$criteria->initialName.'&keys=1', maticon($criteria->parentTableIcon, 'spaced-text').' '.$criteria->setName, 'class="collection-item left-align grey-text datacriteria" datadom="#criteriadatadom" data-criteria="'.$criteria->initialName.'" data-criteriacontext="'.$criteria->tableFKname.'" data-criterianame="'.$criteria->setName.'" data-criteriaid="'.$criteria->fkTableRecName.'" data-criteriapk="'.$criteria->fkTableRecPK.'"  data-criteriaicon="'.$criteria->parentTableIcon.'" '.($criteria->tableFKname==$userdefaultcriteria? ' data-autoload="true"':''));
							}
							
						}

				 echo mdldivend();

			echo mdldivend();

			echo mdldivstrt('col s12 paddless dash-window', 'criteriadatadom');
				
			echo mdldivend();

	echo mdldivend();


	echo mdldivstrt('col l9 m8 s12  paddless step-up-max marginless dash-window rounded-5px grey lighten-3', 'assetList');
			echo headerTxt(4, maticon('folder', 'xl-text').breaker().' Select load criteria', 'class="full-width v-centered center-align grey-text"');
	echo mdldivend();


	echo mdldivend();
echo mdldivend();


if (haspriveledge('add', 'fixedassets')) {
	echo mdldivstrt('fixed-action-btn');
		echo anchor(FIXEDASSETS_PREFIX.'forms/Formhandler/saveUpdateAsset/0', maticon('add'), 'class="btn-floating waves-effect waves-dark accent rippled-ring"');
	echo mdldivend();
}


$this->load->view(FIXEDASSETS_PREFIX.'forms/modals/checkoutmodal');
$this->load->view(FIXEDASSETS_PREFIX.'forms/modals/checkinmodal');
$this->load->view(FIXEDASSETS_PREFIX.'forms/modals/copymovemodal');
$this->load->view(FIXEDASSETS_PREFIX.'forms/modals/disposemodal');

?>
<script type="text/javascript">

			








	function openassetmodal(modal, assetid, assettag){
		if (modal=='dispose') {
			var formaction = "<?php echo site_url('modules/fixedassets/forms/Formhandler/dispose');?>/"+assetid;
			$('#disposeform').attr('action', formaction);
			$('#disposalmodalTitle').text("You are about to dispose Asset # "+assettag);
			$("#disposalModal").openModal();
		}
		else if (modal=='movecopy'){
			var formaction = $.fn.site_url('modules/fixedassetsforms/Formhandler/movecopy/'+assetid);
			$('#movecpyform').attr('action', formaction);
			$('#movecpymodalTitle').text("Move/Copy Asset # "+assettag);
			$("#movecpyModal").openModal();
		}
		else if (modal=='checkout'){
			var formaction = $.fn.site_url('modules/fixedassetsforms/Formhandler/checkout/'+assetid);
			$('#checkoutform').attr('action', formaction);
			$('#checkoutmodalTitle').text("Checkout Asset # "+assettag);
			$("#checkoutModal").openModal();
		}
		else if (modal=='checkin'){
			var formaction = $.fn.site_url('modules/fixedassetsforms/Formhandler/checkin/'+assetid);
			$('#checkinform').attr('action', formaction);
			$('#checkinmodalTitle').text("Checkin Asset # "+assettag);
			$("#checkinModal").openModal();
		}
	}
	
</script>






