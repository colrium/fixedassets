<?php
  $details = array();
  if(isset($module)){
    echo genexcelimportmodal($module);
  }
  else{
    echo genexcelimportmodal('system');
  }

