<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Templateadd extends CI_Model{
 
 public function __construct()
        {
                parent::__construct();
        }


	public function insertTemplate(){
		$data=array(
			'template_name'=>$this->input->post('temp_name', TRUE),
			'subject'=>$this->input->post('subject', TRUE),
			'message'=>$this->input->post('message', TRUE)
			);
		
		$this->db->set($data);
		$this->db->insert('ngo_email_templates');

		return true;
	}

	public function updateTemplate(){

		$data = array(
                'template_name'=>$this->input->post('temp_name', TRUE),
                'subject'=>$this->input->post('subject', TRUE),
				'message'=>$this->input->post('message', TRUE)
            );
            $this->db->where('template_id', $this->input->post('template_id', TRUE));
            $this->db->update('ngo_email_templates', $data);
		return true;
	}

 	public function deleteTemplate($template_id){
			$sqlStr="DELETE FROM ngo_email_templates
			WHERE template_id=".strPrepStr($template_id).";";
			$query = $this->db->query($sqlStr);
	 		return true;
 	}

}
?>