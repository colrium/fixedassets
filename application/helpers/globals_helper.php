<?php

define('PHP_MIN_DL_VERSION', '5.3.0');

define('CSNG_M_TO_FT', 3.393701);
define('CSNG_KILOS_TO_LBS', 2.20462);
define('CSTR_UNITS_LB',  'lb');
define('CSTR_UNITS_IN',  'in');
define('CSTR_UNITS_KG',  'kg');
define('CSTR_UNITS_CM',  'cm');

define('DL_IMAGEPATH',   base_url('images'));
define('DL_CATALOGPATH', base_url('catalog'));

//directories
define('CENUM_BGIMG_DIR',    base_url().'assets/images/layout/bg/');
define('CENUM_IMG_DIR',    base_url().'assets/images/');
define('CENUM_FONTS_DIR',    base_url().'assets/fonts/');
define('CENUM_LAYOUTIMG_DIR',    base_url().'assets/images/layout/');
define('CENUM_JS_DIR',    base_url().'assets/js/');
define('CENUM_CSS_DIR',    base_url().'assets/css/');
define('CENUM_ASSETS_DIR',    base_url().'assets/');



define('ATTACHMENTS_DIR',    './catalog/attachments');
define('RECS_IMAGES_DIR',    './catalog/attachments/images/');
define('RECS_ATTCHMNTS_DIR',    './catalog/attachments/others/');
define('CSV_IMPORTS_DIR',    './catalog/imports/');
define('BULK_IMPORTS_DIR',    './catalog/attachments/system/imports/');
define('DATAIMPORTSFILES_DIR',    './catalog/imports/');
define('SQL_RESTORES_DIR',    './catalog/dbsqlrestores/');
define('CENUM_LOGO_DIR',    './assets/images/logo/');

	// PDF paper sizes
define('CENUM_PDFPSIZE_LETTER',   'Letter');  
define('CENUM_PDFPSIZE_LEGAL',    'Legal');  
define('CENUM_PDFPSIZE_A3',       'A3');  
define('CENUM_PDFPSIZE_A4',       'A4');  
define('CENUM_PDFPSIZE_A5',       'A5');  


	//-----------------------------
	// image/doc entry types
	//-----------------------------
define('CENUM_IMGDOC_ENTRY_IMAGE',    'image');
define('CENUM_IMGDOC_ENTRY_PDF',      'document');
define('CENUM_IMGDOC_ENTRY_UNKNOWN',  'Unknown');





define('CI_IMGDOC_RESIZE_MAXDIMENSION',  1200);
define('CI_IMGDOC_THUMB_MAXDIMENSION',    120);
define('CSTR_IMAGE_LIBRARY',            'gd2');
define('CI_IMGDOC_MAXUPLOADKB',         100000);   // max image/doc upload size in kb (i.e. 100000 = 100mb)
define('CI_IMPORT_MAXUPLOADKB',         100000);   // max import upload size in kb (i.e. 10000 = 10mb)

define('COVERS_ICON',    'verified_user');
define('CLIENTS_ICON',    'group');
define('INSURERS_ICON',    'business');
define('POLICIES_ICON',    'security');
define('CLAIMS_ICON',    'flag');
define('REPORTS_ICON',    'insert_chart');
define('PAYMENTS_ICON',    'monetization_on');
define('CALENDAR_ICON',    'event');




//barcode types
define('TYPE_CODE_39', 'C39');
define('TYPE_CODE_39_CHECKSUM', 'C39+');
define('TYPE_CODE_39E', 'C39E');
define('TYPE_CODE_39E_CHECKSUM', 'C39E+');
define('TYPE_CODE_93', 'C93');
define('TYPE_STANDARD_2_5', 'S25');
define('TYPE_STANDARD_2_5_CHECKSUM', 'S25+');
define('TYPE_INTERLEAVED_2_5', 'I25');
define('TYPE_INTERLEAVED_2_5_CHECKSUM', 'I25+');
define('TYPE_CODE_128', 'C128');
define('TYPE_CODE_128_A', 'C128A');
define('TYPE_CODE_128_B', 'C128B');
define('TYPE_CODE_128_C', 'C128C');
define('TYPE_EAN_2', 'EAN2');
define('TYPE_EAN_5', 'EAN5');
define('TYPE_EAN_8', 'EAN8');
define('TYPE_EAN_13', 'EAN13');
define('TYPE_UPC_A', 'UPCA');
define('TYPE_UPC_E', 'UPCE');
define('TYPE_MSI', 'MSI');
define('TYPE_MSI_CHECKSUM', 'MSI+');
define('TYPE_POSTNET', 'POSTNET');
define('TYPE_PLANET', 'PLANET');
define('TYPE_RMS4CC', 'RMS4CC');
define('TYPE_KIX', 'KIX');
define('TYPE_IMB', 'IMB');
define('TYPE_CODABAR', 'CODABAR');
define('TYPE_CODE_11', 'CODE11');
define('TYPE_PHARMA_CODE', 'PHARMA');
define('TYPE_PHARMA_CODE_TWO_TRACKS', 'PHARMA2T');















?>
