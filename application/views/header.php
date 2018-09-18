<!DOCTYPE html>
<html lang="en">
<head>  
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Site Title -->
		<title><?php $module = (isset($module)) ? $module : 'system'; echo $title.' - '.modulename($module); ?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Equus ERP, An ERP By Fort Technologies.">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		
		<!-- TODO add manifest here -->
		<link rel="manifest" href="<?php echo base_url('manifest.json');?>">
		<!-- Add to home screen for Safari on iOS -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-title" content="Weather PWA">
		<link rel="apple-touch-icon" href="images/icons/icon-152x152.png">
		<meta name="msapplication-TileImage" content="images/icons/icon-144x144.png">
		<meta name="msapplication-TileColor" content="#2F3BA2">
		<!-- Favicon Icon -->
		<link rel="shortcut icon" href="<?php echo site_url('files/Files/outputmainimage/systemlogo/1'); ?>" >


		<?php
					echo definecolorstyle();
					echo definejsvars();
		?>
		

		<!-- Stylesheets --> 
		<link href="<?php echo CENUM_ASSETS_DIR;?>materialize/css/materialize.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo CENUM_ASSETS_DIR;?>datatables/datatables.css" type="text/css"/>
		<link href="<?php echo CENUM_CSS_DIR;?>utilities.css" rel="stylesheet">
		<link href="<?php echo CENUM_ASSETS_DIR;?>filechooser/css/jquery.fileuploader.css" rel="stylesheet">
		<link href="<?php echo CENUM_ASSETS_DIR;?>datepicker/datepicker.css" rel="stylesheet">

		<link href="<?php echo CENUM_ASSETS_DIR;?>materialiconpicker/css/style.css" rel="stylesheet">
		<link href="<?php echo CENUM_ASSETS_DIR;?>timepicker/timepicker.css" rel="stylesheet">
		<link href="<?php echo CENUM_ASSETS_DIR;?>timedropper/css/timedropper.css" rel="stylesheet">
		<link href="<?php echo CENUM_ASSETS_DIR;?>fullcalendar/css/theme.css" rel="stylesheet">

		<!-- Javascript -->
		<!-- JQUERY -->     
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>jquery/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>jquery/jquery-ui/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>jquery/jquery.easing.1.3.js"></script>

		<!-- Define site and base urls  after jquery before loading scripts -->
		<script type="text/javascript">
			$.fn.extend ({
				site_url: function(suburl = false){
						var siteurl = "<?php echo site_url(); ?>";
						if (suburl != false) {
							siteurl = siteurl+"/"+suburl;
						}
						return siteurl;
				},
				base_url: function(suburl = false){
						var baseurl = "<?php echo base_url(); ?>";
						if (suburl != false) {
							baseurl = baseurl+suburl;
						}
						return baseurl;
				}
			});
		</script>

		<!-- Velocity -->
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>velocity/velocity.min.js"></script>

		<!-- Hammer -->
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>hammer/hammer.min.js"></script>

		<!-- Materialize -->
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>materialize/js/materialize.js"></script>	 
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>materialize/js/materialize.js"></script>
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>materialize/js/contexted.js"></script>
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>materialize/js/colorpicker.js"></script>



		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>datatables/datatables.min.js"></script>
		
		
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>noty/packaged/jquery.noty.packaged.js"></script>

		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>filechooser/js/filepicker.js"></script>
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>datepicker/datepicker.js"></script>
		

		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>materialiconpicker/js/materialiconpicker.js"></script>

		


		

		<!-- System and Modules scripts -->
		<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR; ?>modules/system/script.js"></script>


</head>
<body class="grey lighten-2 questrial modalcontainer ">
	<div class="ribbon delauneybg"> </div>
	

