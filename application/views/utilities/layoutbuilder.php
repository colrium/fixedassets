<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  html_builder
*
* Version: 1.0
*
* Author: Collins Mutugi Riungu
*		  colrium@gmail.com
*         @mutugiriungu
*
* Added Awesomeness: Fridah Gacheri Mugambi
*
* Requirements: PHP5 or above
*
*/

	$layout = '<div class="full-width full-height" id="'.$builderdomid.'">

				</div>';
	$layout .= '<script type="text/javascript">
					$("#'.$builderdomid.'").layoutbuilder();
			   </script>';

	echo $layout;

				





