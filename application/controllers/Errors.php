<?php 
class Errors extends CI_Controller{
    public function __construct(){
        parent::__construct(); 
    } 

    public function index(){ 
        $this->output->set_status_header('404'); 
        $displayData['title']        = '404 error';
        $displayData['pageTitle']    = ' '.CENUM_CHIP_POINTER.' '.breadcrumb('Page not found');
        $displayData['mainTemplate'] = 'errors/system/errorspage';
        $displayData['page'] = 'errorpage';
        $displayData['errortype'] = '404'; 
        $displayData['nav'] = '';             
        renderpage($displayData);
        
    } 

    public function error404(){ 
        $this->output->set_status_header('404'); 
        $displayData['title']        = '404 error';
        $displayData['pageTitle']    = ' '.CENUM_CHIP_POINTER.' '.CENUM_CHIP_POINTER.' '.breadcrumb('Page not found');
        $displayData['mainTemplate'] = 'errors/system/errorspage';
        $displayData['nav'] = '';
        $displayData['page'] = 'errorpage';
        $displayData['errortype'] = '404';              
        renderpage($displayData);
        
    
    }

    public function record404($recordName){ 
        $this->output->set_status_header('404'); 
        $displayData['title']        = 'Unexisting Record';
        $displayData['pageTitle']    = ' '.CENUM_CHIP_POINTER.' '.breadcrumb('Record not found');
        $displayData['mainTemplate'] = 'errors/system/errorspage';
        $displayData['nav'] = '';
        $displayData['recordName'] = $recordName;
        $displayData['page'] = 'errorpage';
        $displayData['errortype'] = 'rec404';              
        renderpage($displayData);
        
    
    }



    








} 
?>