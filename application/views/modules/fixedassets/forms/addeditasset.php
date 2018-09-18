<?php

echo mdldivstrt('row paddless', 'formCont');

		echo form_open(FIXEDASSETS_PREFIX.'forms/Formhandler/saveUpdateAsset/'.$recId);
				$this->load->view(FIXEDASSETS_PREFIX.'forms/assetformviews/tabs');
						$this->load->view(FIXEDASSETS_PREFIX.'forms/assetformviews/general');
						$this->load->view(FIXEDASSETS_PREFIX.'forms/assetformviews/additional');
						if ($recId != '0') {
							$this->load->view(FIXEDASSETS_PREFIX.'forms/assetformviews/notebook');
							$this->load->view(FIXEDASSETS_PREFIX.'forms/assetformviews/picture');
							$this->load->view(FIXEDASSETS_PREFIX.'forms/assetformviews/attachments');
							$this->load->view(FIXEDASSETS_PREFIX.'forms/assetformviews/linked');
						}
						
						$this->load->view(FIXEDASSETS_PREFIX.'forms/assetformviews/userfields');						
						$this->load->view(FIXEDASSETS_PREFIX.'forms/assetformviews/depreciation');


		echo form_close();        
	
echo mdldivend();
$this->load->view(FIXEDASSETS_PREFIX.'forms/modals/notebookitemmodal');
?>

												
<script>
	$(document).ready(function() {
		var recId = "<?php echo $recId; ?>";
		addCosts();
		getDepreciation();
		$('#assetCost').change(function(){
			addCosts();
		});

		$('#assetCTax1').change(function(){
			addCosts();
		});
		$('#assetCTax2').change(function(){
			addCosts();
		});

		$('#dtePurchased').change(function(){
			var dtepicked = $(this).val();
			$('#dtePutIntoService').val(dtepicked);
		});

		function addCosts(){
			var baseCost = parseInt($('#assetCost').val());
			var tax1 = parseInt($('#assetCTax1').val());
			var tax2 = parseInt($('#assetCTax2').val());
			var totalC = baseCost+tax1+tax2;
			$('#totalCost').val(parseInt(totalC));										
		}

		var selectedprimloc = $('#assetPrimLoc').val();
		$.ajax({
				url: "<?php echo site_url(FIXEDASSETS_PREFIX.'Dashboard/ajaxsecondarylocationsselect');?>" + "/" +selectedprimloc,
				dataType: "html",
					success: function(html){																									             
						$("#seldepartments").html(html);
					}
		});

		$('#assetPrimLoc').change(function(){
			var rec = $(this).val();
				$.ajax({
				url: "<?php echo site_url(FIXEDASSETS_PREFIX.'Dashboard/ajaxsecondarylocationsselect');?>" + "/" +rec,
				dataType: "html",
					success: function(html){																									             
						$("#seldepartments").html(html);
					}
				});
		});

		$('#dtePutIntoService').change(function(){
			getDepreciation();															
		});
		$('#dtePutIntoService').change(function(){
			getDepreciation();															
		});
		$('#salvageVal').change(function(){
			getDepreciation();															
		});
		$('#deprMethod').change(function(){
			getDepreciation();															
		});

		function getDepreciation(){
			var years = parseInt($('#assetLYears').val());
			var buyPrice = parseInt($('#depCost').val());
			var dateStart = $('#dtePutIntoService').val();
			var salVal = parseInt($('#salvageVal').val());
			var depMethod = $('#deprMethod').val();
			var percU = parseInt($('#bizUse').val());
			if (years > 0) {
				if (buyPrice > 0) {
					if (percU > 0 ) {
																	
						$.ajax({
						url: "<?php echo site_url(FIXEDASSETS_PREFIX.'Dashboard/echocalculateAnnualDepreciation');?>" + "/" +years+"/"+buyPrice+"/"+dateStart+"/"+salVal+"/"+depMethod+"/"+percU,																
						dataType: "html",
						success: function(html){																												             
							$("#annualdepdataTble").html(html);
								$.ajax({
									url: "<?php echo site_url(FIXEDASSETS_PREFIX.'Dashboard/echocalculateMonthlyDepreciation');?>" + "/" +years+"/"+buyPrice+"/"+dateStart+"/"+salVal+"/"+depMethod+"/"+percU,																
									dataType: "html",
									success: function(html){
																																 
										$("#monthlydepdataTble").html(html);
									}
								});
							}
						});
																	

					}
					else {
						$('#bizUse').focus();
					}

					}

					else {
						$(".mdl-tabs__tab").removeClass('is-active');
						$("a[href='#general']").addClass('is-active');
						$("#general").addClass('is-active');
						$('#assetCost').focus();
					}

					}
					else {
						$('#assetLYears').focus();
					}
		}

		$.ajax({
				url: "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/getlinkchildren/'.$recId.'/ajax');?>",
				dataType: "html",
					success: function(html){
						if (html == 'none') {

						}
						else{
							$("#child-link-tble-body").append(html);
						}																									             
						
					}
		});

		$.ajax({
				url: "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/getlinkparent/'.$recId.'/ajax');?>",
				dataType: "html",
					success: function(html){																									             
						if (html == 'none') {

						}
						else{
							$("#parent-link-tble-body").append(html);
						}
					}
		});


		



		

		$('#add-parent-btn').click(function(){
			var searchparentasset = $('#parent-search').val();
			if (searchparentasset.length > 0) {
				$.ajax({
						url: "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/linkedrecordadd/parent');?>/"+searchparentasset+"/"+recId,
						dataType: "html",
							success: function(html){																									             
								var errorTxt;																									             
								if (html == 'none' || html == 'exists' || html == 'error') {
									if (html == 'none') {
										errorTxt = "<?php echo maticonjs('search', 'medium'); ?></br> <h4 class=\"white-text\">Sorry!!</h4> <small>"+searchparentasset+" was not found!!</small>";
									}
									else if (html == 'exists'){
										errorTxt = "<?php echo maticonjs('content_copy', 'medium'); ?></br> <h4 class=\"white-text\">Sorry!!</h4> <small>"+searchparentasset+" Parent Link for this record already exists!!</small>";
									}
									else if (html == 'error'){
										errorTxt = "<?php echo maticonjs('save', 'medium'); ?></br> <h4 class=\"white-text\">Sorry!!</h4>  <small>"+searchparentasset+" Parent Link Add error!!</small>";
									}
									
										var n = noty({
											text        : errorTxt,
											type        :'error',
											layout: 'bottomRight',
											closeWith   : ['click'],
											theme       : 'customnoty',                
											animation   : {
												open  : 'animated bounceInRight',
												close : 'animated bounceOutRight',
												easing: 'swing',
												speed : 1000
											}
										});
								}
								else{
									$("#parent-link-tble-body").append(html);
								}
							}
				});
			}
		});

		
		$('#add-child-btn').click(function(){
			var searchchildasset = $('#child-search').val();
			if (searchchildasset.length > 0) {
				$.ajax({
						url: "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/linkedrecordadd/child');?>/"+searchchildasset+"/"+recId,
						dataType: "html",
							success: function(html){
								var errorTxt;																									             
								if (html == 'none' || html == 'exists' || html == 'error') {
									if (html == 'none') {
										errorTxt = "<?php echo maticonjs('search', 'medium'); ?></br> <h4 class=\"white-text\">Sorry!!</h4> <small>"+searchchildasset+" was not found!!</small>";
									}
									else if (html == 'exists'){
										errorTxt = "<?php echo maticonjs('content_copy', 'medium'); ?></br> <h4 class=\"white-text\">Sorry!!</h4> <small>"+searchchildasset+" child Link for this record already exists!!</small>";
									}
									else if (html == 'error'){
										errorTxt = "<?php echo maticonjs('save', 'medium'); ?></br> <h4 class=\"white-text\">Sorry!!</h4> <small>"+searchchildasset+" Child Link Add error!!</small>";
									}
									
										var n = noty({
											text        : errorTxt,
											type        :'error',
											layout: 'bottomRight',
											closeWith   : ['click'],
											theme       : 'customnoty',                
											animation   : {
												open  : 'animated bounceInRight',
												close : 'animated bounceOutRight',
												easing: 'swing',
												speed : 1000
											}
										});
								}
								else{
									$("#child-link-tble-body").append(html);
								}
							}
				});
			}
		});




		$('#parent-search').keyup(function(){
			var parentsearchval = $(this).val();
			if (parentsearchval.length > 0) {
				$('#add-parent-btn').removeClass("disabled");

			}
			else{
				$('#add-parent-btn').addClass('disabled', true);
			}
		});

		$('#child-search').keyup(function(){
			var parentsearchval = $(this).val();
			if (parentsearchval.length > 0) {
				$('#add-child-btn').removeClass("disabled");

			}
			else{
				$('#add-child-btn').addClass('disabled', true);
			}
		});


		$(document).bind("ajaxComplete", function(){
			$('a[href=#]').click(function(e){
				e.preventDefault();
			});

			$('.remove-parent-link').each(function(){
				$(this).click(function(){
					var linkId = $(this).attr("linkid");
					var parentrow = $(this).parent('td').parent('tr');
					$.ajax({
						url: "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/removelink');?>/"+linkId,
						dataType: "html",
							success: function(html){
								if (html=='1') {
									parentrow.remove();
								}
								else{

								}
								
							}
					});														
				});
			});

			$('.remove-child-link').each(function(){
				$(this).click(function(){
					var linkId = $(this).attr("linkid");
					var parentrow = $(this).parent('td').parent('tr');
					$.ajax({
						url: "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/removelink');?>/"+linkId,
						dataType: "html",
							success: function(html){
								if (html=='1') {
									parentrow.remove();
								}
								else{

								}
								
							}
					});														
				});
			});


			$('#remove-all-parent').click(function(){
				$('.remove-parent-link').each(function(){
					var linkId = $(this).attr("linkid");
					var parentrow = $(this).parent('td').parent('tr');

					$.ajax({
						url: "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/removelink');?>/"+linkId,
						dataType: "html",
							success: function(html){
								if (html=='1') {
									
									parentrow.remove();
									
								}
								else{

								}
								
							}
					});

				});
																		
			});

			$('#remove-all-child').click(function(){
				
																		
			});

		});	


	});
	

														
</script>