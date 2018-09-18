<?php			
		$layout = 	'			<div id="maker-cherker-modal" class="modal modal-fixed-footer modal-fixed-header">
								  <form id="makercherkerform" method="post" action="#">
								  	<div class="modal-header center-v-align">
								      '.headertxt(4, maticon('lock_outline', 'spaced-text').' Maker-Checker Validation', 'class="full-width center-align '.getcolorclass(5).'" id="mc-modal-header"').'
								    </div>
								    <div class="modal-content pscrollbar center-v-align">								      

								      <div class="row full-width">
								      	<div class="col s12" id="mc-notifacation">
								      		
								      	</div>
								      </div>

								      <div class="row full-width">
								      		<div class="col l6 m6 s12">
								      			'.materializeinputpass('', $name='markerpass', maticon('vpn_key', 'spaced-text').' Marker Password').'
								      		</div>
								      			
								      		<div class="col l6 m6 s12">
								      			'.materializeinputpass('', $name='checkerpass', maticon('vpn_key', 'spaced-text').' Checker Password').'
								      		</div>
								      </div>
								      <div class="row full-width">
								      	<div class="col s12">
								      		'.mdlinputhidden('none', 'mc-fieldId', 'mc-fieldId').'
								      	</div>
								      </div>

								      <div class="row full-width">
								      	<div class="col s12">
								      		'.mdlsubmitbtn('lock_open', 'Validate', 'mc-validatebtn', 'waves-effect waves-dark btn-large blue lighten-1').'
								      	</div>
								      </div>
								    </div>
								    <div class="modal-footer grey lighten-2">
								      <a href="#!" class=" modal-action modal-close waves-effect waves-dark btn-flat red-text">'.maticon('cancel', 'spaced-text').' Dismiss</a>
								    </div>
								    </form>
								</div>';

	echo $layout;

?>

<script type="text/javascript">
	$(function(){
		$("#makercherkerform").submit(function(e){
			e.preventDefault();
			var postdata = $(this).serializeArray();
			var posturl = "<?php echo site_url('users/Users/validatemarkerchecker'); ?>";
			var inputdomid = $("#mc-fieldId").val();
			var inputbtndomid = "#mcmodaltrigger"+inputdomid;
			inputdomid = "#"+inputdomid;

			
			$.ajax({
				url : posturl,
				type: "POST",
				data : postdata,
				dataType : "JSON",
				success:function(data){
						if (data != null) {
							if(data.valstatus==0){
								var n = $("#mc-notifacation").noty({
	                                            text        : data.valmessage,
	                                            type        :'error',
	                                            layout		: "center",
	                                            timeout 	: 5000,
		                                        theme 		: "relax", // or 'relax'
		                                        dismissQueue: true
	                                        });
							}
							else{
								$(inputdomid).prop("readonly", false);
								if ($(inputdomid).parent().hasClass("is-disabled")) {
									$(inputdomid).parent().removeClass("is-disabled");
								}
								$(inputbtndomid).remove();
								$('#maker-cherker-modal').closeModal();	
								var $toastContent = $('<center>'+data.valmessage+'</center>');
								Materialize.toast($toastContent, 5000, 'rounded');

							}
						}




					}
				});
		});
	});



</script>