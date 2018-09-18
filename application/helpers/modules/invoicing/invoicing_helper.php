<?php
	function getpreferences(){
		$CI = & get_instance();
		$CI->model->load('mpreferences', 'clsPrefs');
	}

	function is_open($status){
    	$isopenstatuses = array(2, 3);
    	return in_array($status, $isopenstatuses);
    }

    function guest_visible($status){
    	$isvisiblestatuses = array(2, 3, 4);
    	return in_array($status, $isvisiblestatuses);
    }

    function is_draft($status){
    	return $status == 1;
    }

    function is_sent($status){
        return $status == 1;
    }

    function is_viewed($status){
       return $status == 3;
    }

    function is_paid($status){
        return $status == 4;
    }
    
    function is_overdue($status){
        return $status == 1;
    }


    //invoices functions
    function getinvoiceamounts($recId){
        $CI = & get_instance();
        $CI->load->model(INVOICING_PREFIX.'invoices/minvoices');
        return $CI->minvoices->getinvoiceamounts($recId);
    }

    function getinvoiceamountpaid(){

    }

    function getinvoicebalance($recId){
        $amounts = getinvoiceamounts($recId);
        if (sizeof($amounts) > 0) {
            $recamounts = $amounts[0];
            return $recamounts->invoice_balance;
        }
        else {
            return 0;
        }
    }


