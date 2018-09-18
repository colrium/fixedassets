	<?php
  if(!defined('BASEPATH')) exit('Hacking Attempt : Get Out of the system ..!');
   
   class Loginmodel extends CI_Model{

 	public function login_valid($username,$password)
 	{          // database loaded in autoload liabrary
 				$pword = md5($password);
 			$q = $this->db->where(['username'=>$username,'password'=>$pword]) ->get('users');

 				if ( $q->num_rows()  ) {    // this check row should greter than 1
 					return $q->row()->id;
 				}else{
 					return FALSE;
 				}
 	     }



 }


?>