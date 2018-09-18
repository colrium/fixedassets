<?php
class Muploads extends CI_Model{

	function __construct(){
	      parent::__construct();
	     
	}

	public function addassetimage($recId='', $imagename='', $extension='', $dir=''){
		if ($recId!='' && $imagename!='' && $extension!='' && $dir!='') {
			$userId = USERID;
			$sqlStr ="INSERT INTO  attachments 
						SET 
						record 	= '$recId',
						isimage 	= '1',
						name 	= '$imagename',
						extension = '$extension',
						file_dir = '$dir',
						`date` = NOW(),
						added_by = '$userId';";
		 	$query = $this->db->query($sqlStr);
			return $this->db->insert_id();
		}

		else{
			return false;
		}
			
	}



	
	

	public function loadentityattachments($entitytype, $recId){
		$sqlStr ="SELECT * FROM attachments WHERE entity='$entitytype' AND record='$recId' AND NOT isimage;";
		$query = $this->db->query($sqlStr);
		return $query->result();
	}

	public function loadentityimages($entitytype, $recId){
		$sqlStr ="SELECT * FROM attachments WHERE entity='$entitytype' AND record='$recId' AND isimage;";
		$query = $this->db->query($sqlStr);
		return $query->result();
	}

	public function loadtest(){
		$sqlStr ="SELECT * FROM test WHERE id = '1';";
		$query = $this->db->query($sqlStr);
		return $query->result();
	}

	public function loadentitymainimage($entitytype, $recId){
		$sqlStr ="SELECT * FROM attachments WHERE entity='$entitytype' AND record='$recId' AND isimage AND ismainimage LIMIT 0,1;";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		$foundimage = FALSE;
		if (sizeof($results)>0) {
			$foundimage = $results[0];
		}
		return $foundimage;
	}

	public function deleteattachment($attId){
		$sqlStr ="DELETE FROM attachments  WHERE attId='$attId';";
    	$query = $this->db->query($sqlStr);
		return true;
    }

    public function unsetmainimages($entitytype, $recId){
    	$sqlStr ="UPDATE attachments SET ismainimage ='0' WHERE entity='$entitytype' AND record='$recId';";
    	$query = $this->db->query($sqlStr);
		return true;
    }

    public function setmainimage($imageid){ 
    	$sqlStr ="SELECT * FROM attachments WHERE attId='$imageid' LIMIT 0,1;";
		$query = $this->db->query($sqlStr);
		$results = $query->result();
		if (sizeof($results) > 0) {
			$entity = $results[0]->entity;
			$record = $results[0]->record;
			$unsetmainimages = $this->unsetmainimages($entity, $record);
		}
		
        $sqlStr ="UPDATE attachments SET ismainimage = '1' WHERE attId='$imageid';";
    	$query = $this->db->query($sqlStr);

		return true;
    }




























}