<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Mnotifacations extends CI_Model{

   function __construct(){
      parent::__construct();
     
   }


public function assetNotifacations($days, $dteField){
	$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE $dteField <= DATE_ADD(NOW(),INTERVAL $days DAY) AND $dteField >= DATE_ADD(CURDATE(),INTERVAL 0 DAY) AND NOT bRetired AND $dteField !='0000-00-00';";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}















}