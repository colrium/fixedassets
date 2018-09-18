<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM
// copyright (c) 2013  Collins Riungu
//
// author: Mutugi Riungu
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
  ---------------------------------------------------------------------
      $this->load->model('emr/mpercentiles', 'percentiles');
  ---------------------------------------------------------------------

---------------------------------------------------------------------*/


class Mpercentiles extends CI_Model{
   public $pRecord;


   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->pRecord = new stdClass;
   }

   
   
}
