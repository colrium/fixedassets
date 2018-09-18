<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
// author: Mutugi Riungu
---------------------------------------------------------------------*/


class Uploads extends CI_Controller{
    public $uploaddata;
    public $params;
    function __construct(){
        parent::__construct();
        $this->load->library('uploader');
        $this->load->model('uploads/muploads', 'clsUpld');
        $this->load->helper('file');
        $returnarray = array();
        $returnmsg = '';
        $this->uploaddata =array();
        $this->params = array(
                                'limit' => 10, //Maximum Limit of files. {null, Number}
                                'maxSize' => 10000, //Maximum Size of files {null, Number(in MB's)}
                                'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                                'required' => true, //Minimum one file is required for upload {Boolean}
                                'uploadDir' => CSV_IMPORTS_DIR, //Upload directory {String}
                                'entity' => 'imports',
                                'record' => '0',
                                'isimage' => FALSE,
                                'ismainimage' => FALSE,
                                'databaselog' => TRUE,
                                'filelocation' => 'filesystem',
                                'title' => array('name'), //New file name {null, String, Array} *please read documentation in README.md
                                'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                                'replace' => true, //Replace the file if it already exists  {Boolean}
                                'perms' => null, //Uploaded file permisions {null, Number}
                                'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
                                'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
                                'onSuccess' =>  null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
                                'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
                                'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
                                'onRemove' => null //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                            );
                
    }
    
    public function downloadattachment($id){
        dbattachmentfile($id);        
    }

    public function attachmentstream($id){
        dbattachmentfilestream($id);        
    }

    public function iterate($files, $metas){
        echo 'success <br/> data:';
        print_r($metas);
    }


    public function uploadimportfile($inputname){
        $this->params['extensions'] =  array('csv', 'xls', 'xlsx');
        $this->params['uploadDir'] =  CSV_IMPORTS_DIR;
        $this->params['entity'] =  'imports';
        $this->params['maxSize'] =  50000;
        $this->params['filelocation'] = 'filesystem';

        $this->uploaddata = $this->uploader->upload($_FILES[$inputname], $this->params);

        if($this->uploaddata['isComplete'] && $this->uploaddata['hasErrors'] != 1){                
                $files = $this->uploaddata['data'];
                $returnarray['erroroccured'] = "0";
                $returnarray['message'] = "Upload successful";
                $returnarray['filesdata'] = $files['metas'][0]['name'];
                $returnarray['filesdetails'] = $files['metas'][0];
                echo json_encode($returnarray);
            
        }
        if($this->uploaddata['hasErrors']){
                $errors = $this->uploaddata['errors'];
                $files = $this->uploaddata['data'];
                $returnarray['erroroccured'] = "1";
                foreach ($errors as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $key1 => $value1) {
                            $returnmsg .= $value1.'<br>';
                        }
                    }
                     
                }
                $returnarray['message'] = $returnmsg;
                $returnarray['filesdata'] = null;
                $returnarray['filesdetails'] = null;  
                echo json_encode($returnarray);
        }

         $this->uploaddata = $this->uploader->upload($_FILES[$inputname], $this->params);

       

    }

    public function uploadsqldbrestorefile(){
        $this->params['extensions'] =  ['sql'];
        $this->params['uploadDir'] =  SQL_RESTORES_DIR;
        $this->params['entity'] =  'dbrestorations';
        $this->params['maxSize'] =  50000;
        $this->uploaddata = $this->uploader->upload($_FILES['restoresqlfile'], $this->params);
    }


 
    public function uploadattachments($inputname, $recId, $entitytype='fixedassets_assetlist', $isimage='0', $ismainimage='0'){
        $entity = $entitytype;
        $module = dbtablemodule($entity);
        $targetdirectory = ATTACHMENTS_DIR.'/'.$module.'/'.$entity.'/'.$recId;
        if ($isimage == '0') {
            $targetdirectory .= '/attachments/';
        }
        else{
            $targetdirectory .= '/images/';
        }

        $direxists = createdirectory($targetdirectory);
        
        $this->params['uploadDir'] = $targetdirectory;
        
        if ($isimage != '0') {
            $this->params['isimage'] = TRUE;             
            $this->params['extensions'] = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'ico', 'svg', 'bmp'];
            if ($ismainimage != '0') {
               $this->params['ismainimage'] = TRUE; 
            }
        }
        

        $this->params['entity'] =  $entitytype;
        $this->params['record'] =  $recId;

        $this->uploaddata = $this->uploader->upload($_FILES[$inputname], $this->params);

        if($this->uploaddata['isComplete'] && $this->uploaddata['hasErrors'] != 1){                
                $files = $this->uploaddata['data'];
                $returnarray['erroroccured'] = "0";
                $returnarray['message'] = "Upload successful";
                $returnarray['filesdata'] = $files['metas'][0]['name'];
                $returnarray['filesdetails'] = $files['metas'][0]; 
                $details = $returnarray['filesdetails'];
                if (array_key_exists('databaseid', $details)) {
                    if ($details['databaseid'] != '0' && $ismainimage != '0') {
                        $this->setmainimage($details['databaseid'], FALSE);
                    }
                }
                
                echo json_encode($returnarray);
            
        }
        if($this->uploaddata['hasErrors']){
                $errors = $this->uploaddata['errors'];
                $files = $this->uploaddata['data'];
                $returnarray['erroroccured'] = "1";
                $returnmsg = '';
                foreach ($errors as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $key1 => $value1) {
                            $returnmsg .= $value1.'<br>';
                        }
                    }                     
                }
                $returnarray['message'] = $returnmsg;
                $returnarray['filesdata'] = null;
                $returnarray['filesdetails'] = null;  
                echo json_encode($returnarray);
        }
    }

   




    public function setmainimage($imageid, $redirect=TRUE){
        $table = 'attachments';
        $refererpage = reffererpage();
        $requestingUrl = 'Dashboard';
        if ($refererpage != '') {
            $requestingUrl = $refererpage;
        }
        $contextimage = dbtablerecord($imageid, $table, FALSE);

        if (is_object($contextimage)) {
            $unsetmainimages = dbunsetmainimages($contextimage->entity, $contextimage->record);
            if (dbsetmainimage($imageid)) {
                setflashnotifacation('message', array('icon'=>'photo_filter', 'alert'=>'Main image set successfully'));
                if ($redirect == TRUE) {
                    preredirect($requestingUrl);
                } 
                
            }
            else{
                setflashnotifacation('error', array('icon'=>'error', 'alert'=>'Main image not set'));
                if ($redirect == TRUE) {
                    preredirect($requestingUrl);
                }
            }
        }
        else{            
            if ($redirect == TRUE) {
                setflashnotifacation('error', array('icon'=>'folder_open', 'alert'=>'Attachment Does not exist'));
                preredirect($requestingUrl);
            }
        }

        



            
    }



    public function removefiles($file_dir=''){
        if (!empty($file_dir)) {
            if(file_exists($file_dir)){
                unlink($file_dir);
            }
        }
        else{
            if(isset($_POST['file'])){
                $file = './catalog/uploads/' . $_POST['file'];
                if(file_exists($file)){
                    unlink($file);
                }
            }
        }
            
    }

    public function deleteattachment($attId){
        $refererpage = reffererpage();
        $requestingUrl = 'Dashboard';
        if ($refererpage != '') {
            $requestingUrl = $refererpage;
        }

        if ($this->clsUpld->deleteattachment($attId)) {
            setflashnotifacation('message', maticon('delete', 'medium').' <br> Attachment deleted successfully'); 
            preredirect($requestingUrl);  
        }
        else{
            setflashnotifacation('error', maticon('block', 'medium').' <br> Attachment delete error'); 
            preredirect($requestingUrl);  
        }

    }

    public function ajaxremoveattachment($attId){
        if ($this->clsUpld->deleteattachment($attId)) {
            echo "1";  
        }
        else{
            echo "0";  
        }

    }

}






