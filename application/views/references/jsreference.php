<?php
	


?>
<script type="text/javascript">

		
		

	function confirmEmptyDatabase(entity){
		var notytext = '<i class="material-icons medium white-text">delete_sweep</i><br>Are you sure you want to empty your database. Please note that all data will be delete and this action is irreversible.';
		var n = noty({
													layout: 'center',
													theme: 'customnoty',
													type: 'error',
													timeout: 3000,
													text: notytext, 
													modal:true,                 
													animation: {
															open  : 'animated bounceInDown',
															close : 'animated bounceOutDown',
															easing: 'swing', // easing
															speed: 1000 // opening & closing animation speed
													},
													buttons: [
														{
															addClass: 'waves-effect waves-teal btn-flat white teal-text left', 
															text: '<i class="material-icons normal-text">delete_sweep</i> Yes', 
															onClick: function($noty) {
																$noty.close();
																var url = "<?php echo site_url('utilities/Database/emptyDatabase'); ?>/"+entity;
																$(location).attr('href',url);                                
															}
														},
														{
															addClass: 'waves-effect waves-red btn-flat white red-text right', 
															text: '<i class="material-icons normal-text">cancel</i>  Cancel', 
															onClick: function($noty) {
																$noty.close();                                
															}
														}
													]
											});


	}

	function confirmOptimizeDatabase(){
		var notytext = '<i class="material-icons medium white-text">memory</i><br>Your database is about to be optimized. Click <i>proceed</i> to execute optimization.';
		var n = noty({
													layout: 'center',
													theme: 'customnoty',
													type: 'error',
													timeout: 3000,
													text: notytext, 
													modal:true,                 
													animation: {
															open  : 'animated bounceInDown',
															close : 'animated bounceOutDown',
															easing: 'swing', // easing
															speed: 1000 // opening & closing animation speed
													},
													buttons: [
														{addClass: 'waves-effect waves-teal btn-flat white teal-text left', text: '<i class="material-icons normal-text">memory</i> Proceed', onClick: function($noty) {
															$noty.close();
															var url = "<?php echo site_url('utilities/Database/optimizedb'); ?>";
															$(location).attr('href',url);
																
															}
														},
														{addClass: 'waves-effect waves-red btn-flat white red-text right', text: '<i class="material-icons normal-text">cancel</i>  Cancel', onClick: function($noty) {
																$noty.close();
																
															}
														}
													]
											});


	}




	</script>

	<?php
		if (haspriveledge('delete', 'fixedassets')) {
	?>
	<script>
		function confirmDeleteItem(type, entity, recordname, recordid){

		var n = noty({
													layout: 'center',
													theme: 'customnoty', 
													type: 'error',
													timeout: 5000,
													modal:true, 
													text: '<i class="material-icons medium white-text">delete</i><br> Are you sure you want to delete '+type+' : '+recordname+'<br>',                     
													animation: {
															open  : 'animated bounceInDown',
															close : 'animated bounceOutDown',
															easing: 'swing', // easing
															speed: 1000 // opening & closing animation speed
													},
													buttons: [
														{addClass: 'btn-flat white teal-text', text: 'Delete', onClick: function($noty) {
															$noty.close();
															var loadurl = "<?php echo site_url('utilities/Database/deleterecord'); ?>/"+entity+"/"+recordid;
																$.fn.loadpage(loadurl, '.pagebody', true);
																
															}
														},
														{addClass: 'btn-flat white red-text spacer', text: 'Cancel', onClick: function($noty) {
																$noty.close();
																
															}
														}
													]
											});


	}
	function confirmpermDeleteItem(type, entity, recordname, recordid){

		var n = noty({
													layout: 'center',
													theme: 'customnoty', 
													type: 'error',
													timeout: 5000,
													modal:true, 
													text: '<i class="material-icons medium white-text">delete</i><br> Are you sure you want to permanently delete '+type+' : '+recordname+'<br>',                     
													animation: {
															open  : 'animated bounceInDown',
															close : 'animated bounceOutDown',
															easing: 'swing', // easing
															speed: 1000 // opening & closing animation speed
													},
													buttons: [
														{addClass: 'btn-flat white teal-text', text: 'Delete', onClick: function($noty) {
															$noty.close();
															var loadurl = "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/FormHandler/deletesecondaryrecord'); ?>/"+entity+"/"+recordid;
																$.fn.loadpage(loadurl, '.pagebody', true);
																
															}
														},
														{addClass: 'btn-flat white red-text spacer', text: 'Cancel', onClick: function($noty) {
																$noty.close();
																
															}
														}
													]
											});


	}

	</script>
<?php
		}
		else{
?>
<script>
		function confirmDeleteItem(type, entity, recordname, recordid){

		var n = noty({
													layout: 'center',
													theme: 'customnoty', 
													type: 'error',
													timeout: 5000,
													modal:true, 
													text: '<i class="material-icons medium white-text">block</i><br>Sorry! you dont have delete priveledges to delete '+recordname+'<br>',                     
													animation: {
															open  : 'animated bounceInDown',
															close : 'animated bounceOutDown',
															easing: 'swing', // easing
															speed: 1000 // opening & closing animation speed
													},
													buttons: [                            
														{addClass: 'btn white red-text spacer', text: 'Close', onClick: function($noty) {
																$noty.close();
																
															}
														}
													]
											});


	}


	</script>


<?php
		}
	?>

	<script type="text/javascript">
		
		 $(function() {
			
			$.fn.initplugins();
			Materialize.updateTextFields();
		});
			 
		

		function openMakercheckerModal(fieldId, fieldName){
			$("#mc-modal-header").html("<i class=\"material-icons spaced-text\">lock_outline</i> "+fieldName+" Maker-Checker Validation");
			$("#mc-fieldId").val(fieldId);
			$('#maker-cherker-modal').openModal();
		}


		window.document.title = "<?php $module = (isset($module)) ? $module : 'system'; echo $title.' - '.modulename($module); ?>";

 
				

				
				
				
				

			

		 
				
			
		 

				



		


	</script>