<?php 

  $this->load->view('header');
  echo '<div class="pagebody">';
  $this->load->view('pagetemplate');
  echo '</div>';
  echo '<div class="cd-cover-layer"></div><div class="cd-loading-bar"></div>';
  $this->load->view('footer');
?>


