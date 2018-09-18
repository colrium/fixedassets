<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



echo form_open('preferences/System/addinputfield/'.$module, 'class="row"');
	echo mdldivstrt('col l3 m4 s12 paddless step-up-2');
		echo mdldivstrt('col s12 page-heading');
			echo spanned(maticon($moduleicon, 'spaced-text').' '.$modulename, 'class="inverse-text"');
		echo mdldivend();

		echo mdldivstrt('col s12 dash-window grey lighten-4', 'contextentities');
			$entityindex = 0;
			foreach ($entities as $key => $entity) {
				echo mdldivstrt('col s12');
					echo materializeradio($key, $entity, 'entity', 'entity-'.$key, '', $entityindex > 0? false : true);			
				echo mdldivend();
				$entityindex++;
			}				
		echo mdldivend();
	echo mdldivend();

	echo mdldivstrt('col l9 m8 s12 rounded-5px data-card step-up-max');
		echo mdldivstrt('cardheader fullheader primarydark');
			echo headertxt('2', maticon('add', 'spaced-text').' Add Data Field', 'class="full-width center-align inverse-text"');			
			echo button('class="action large waves-effect waves-dark accent inverse-text onviewanimated bouncein" type="submit" id="formsubmitbtn"', maticon('save', 'spaced-text'));
		echo mdldivend();

		echo mdldivstrt('cardbody white dash-window');
			echo mdldivstrt('row');
				echo mdldivstrt('col s12 padded');
					echo materializeinputicontxt('', 'fieldname', 'Name', 'text_fields', FALSE, '', 'fieldname', TRUE);
				echo mdldivend();

				echo mdldivstrt('col s12 padded');
					$fieldtypes = array('varchar'=>'Short Text', 'text'=>'Long Text', 'int'=>'Number', 'decimal'=>'Decimal', 'date'=>'Date', 'time'=>'Time', 'datetime'=>'Date & Time', 'boolean'=>'Conditional', 'fk'=>'Foreign Entity Value');
					echo materializeiconselect('fieldtype', $fieldtypes, 'varchar', 'Field Data Type', 'extension', 'fieldtype', FALSE, FALSE, TRUE);
				echo mdldivend();

				echo mdldivstrt('col s12 padded', 'foreignentitydom');					
					echo materializeiconselect('fieldforeignentity', $entities, '', 'Foreign Value Entity', 'folder', 'fieldforeignentity', FALSE, TRUE, FALSE);
				echo mdldivend();

				echo mdldivstrt('col s12 padded', 'datalengthdom');
					echo materializeinputicondecimal('11', 'fielddatalength', 'Data Size', 'linear_scale', FALSE, '', 'fielddatalength', FALSE);
				echo mdldivend();

				echo mdldivstrt('col s12 padded');
					echo materializeinputicontxt('', 'fielddefaultvalue', 'Default Value', 'fiber_manual_record', FALSE, '', 'fielddefaultvalue', FALSE);
				echo mdldivend();
			echo mdldivend();
		echo mdldivend();
		
	echo mdldivend();

echo form_close();
echo '<script type="text/javascript">
		$(function(){
			$("#foreignentitydom").velocity({duration: 2000, scaleY:0, easing: "easeOutCubic"}, {dispaly:"none"});
			var entities = '.json_encode($entities).';
			$("#fieldtype").change(function(e){
				e.preventDefault();
				var fieldtypeval = $(this).val();
				if(fieldtypeval=="fk"){
					$("#datalengthdom").velocity({scaleY:"0", ease: "slideOutUp", duration: 300},{display:"none"});
					$("#foreignentitydom").velocity({scaleY:1, duration: 300, ease: "tada"},{display:"inline-block"});
				}
				else if(fieldtypeval=="boolean" || fieldtypeval=="date" || fieldtypeval=="time" || fieldtypeval=="datetime"){
					$("#datalengthdom").velocity({scale:0, ease: "slideOutUp", duration: 300},{display:"none", duration: 300});
					$("#foreignentitydom").velocity({duration: 2000, scaleY:0, easing: "easeOutCubic"}, {dispaly:"none"});
				}
				else{
					$("#datalengthdom").velocity({scaleY:1, duration: 300, ease: "tada"},{display:"inline-block"});
					$("#foreignentitydom").velocity({duration: 300, scaleY:0, easing: "easeOutCubic"});
				}
				console.log("entities", entities.ngo_vol_reg);
			});
		});
	</script>';
?>

