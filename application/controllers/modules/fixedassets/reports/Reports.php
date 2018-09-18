<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

  public $displayData;

  function __construct(){
      parent::__construct();
      $this->load->model(FIXEDASSETS_PREFIX.'assets/massets','clsAssets');
      $this->load->model(FIXEDASSETS_PREFIX.'functions/mfunctions','clsFunc');
      $this->load->model(FIXEDASSETS_PREFIX.'reports/mreports','clsRep');
      $this->displayData = array();   
      $this->displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
      $this->displayData['module'] = 'fixedassets';
    }


public function genReport($reportType){
	if ($reportType=='listOfAssets') {
	  $this->displayData['title']        = 'Report';
      $this->displayData['pageTitle']    = ' '.breadcrumb(' List of Assets');
      $dbfields = dbtablefields('fixedassets_assetlist', 'isDashShown', '1');
      $tablefields = array();
      foreach ($dbfields as $dbfield) {
        $tablefields[$dbfield->initialName] = $dbfield->setName;
      }
      $params['where']['notequalto'] = array('assetPrimLoc' => '3', 'assetPrimLoc' => '2');
      $records = dbtablerecords('fixedassets_assetlist', $params=array(), FALSE, TRUE);

      $this->displayData['report'] = generatematerialtable(array('title'=>'List of Assets', 'headers'=>$tablefields, 'rows'=>$records), TRUE, array());
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportView';
      

      renderpage($this->displayData);
      
		
	}

	if ($reportType=='listOfAssetsFinancial') {
	  $this->displayData['title']        = 'Report';
      $repTable = datatable_open("highlight full-width", "reportdatatable");
      $repTable .= '<thead>';
       $repTable .= '<tr>
                        <td>Asset #</td>
                        <td>Item</td>
                        <td>Description</td>
                        <td>Location</td>
                        <td>Date Of Prch</td>
                        <td>Cost</td>
                        <td>Value</td>
                        <td>Acct Code</td>
                        <td>Invoice/PO #</td>
                   </tr>
                   </thead>
                   <tbody';
      foreach ($this->clsRep->genListOfAssets() as $asset) {
           $repTable .= '<tr>
                              <td>'.$asset->assetCode.'</td>
                              <td>'.$asset->assetItem.'</td>
                              <td>'.$asset->assetDesc.'</td>
                              <td>'.$this->fieldnames->getForeignKeyValue('assetPrimLoc', $asset->assetPrimLoc, 'assetlist').'</td>
                              <td>'.$this->datalib->userdateformat($asset->dtePurchased).'</td>
                              <td>'.monetaryformat($asset->totalCost).'</td>
                              <td>'.monetaryformat($asset->assetValue).'</td>
                              <td>'.$asset->acCode.'</td>
                              <td>'.$asset->lpoNumber.'</td>
                        </tr>';
      }

      $repTable .= '</tbody>';
      $repTable .= datatable_close();

      $this->displayData['report'] = $repTable;                         
      $this->displayData['pageTitle']    = breadcrumb('List Of Assets Financial Report');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportView';
      

      renderpage($this->displayData);
      
		
	}

	if ($reportType=='assetsGroupBy') {
	 $this->displayData['title']        = 'Report';
      $this->displayData['pageTitle']    = ' '.breadcrumb(' Asset Group By Report');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportDefine';
      

      $this->displayData['report'] = $reportType;    
      renderpage($this->displayData);
      
		
	}

  if ($reportType=='purchases') {
   $this->displayData['title']        = 'Report';
      $this->displayData['pageTitle']    = ' '.breadcrumb(' Asset Purchases');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportDefine';
      

      $this->displayData['report'] = $reportType;    
      renderpage($this->displayData);
      
    
  }
    
    if ($reportType=='checkedOutAssets') {
      $repTable = datatable_open("highlight full-width", "reportdatatable");
      $repTable .= '<thead>
                    <tr class="'.getcolorclass(9).' '.getcolorclass(5).'">
                        <td colspan="7">Checked Out Assets</td>
                    </tr>';
       $repTable .= '<tr class="'.getcolorclass(9).' '.getcolorclass(5).'">
                        <td>Asset #</td>
                        <td>Item</td>
                        <td>Description</td>
                        <td>Date Checked Out</td>
                        <td>Due Date</td>
                        <td>Checkout Reason</td>
                        <td>Checked Out To</td>
                   </tr>
                   </thead>
                   <tbody';
      foreach ($this->clsRep->genListOfAssets() as $asset) {
           $employee = $this->clsRep->getemployee($asset->checkedOutTo);

           if ($asset->checkedOut == '1') {
             $repTable .= '<tr>
                              <td>'.$asset->assetCode.'</td>
                              <td>'.$asset->assetItem.'</td>
                              <td>'.$asset->assetDesc.'</td>
                              <td>'.$this->datalib->userdateformat($asset->dtecheckedOut).'</td>
                              <td>'.$this->datalib->userdateformat($asset->dueDteCheckout).'</td>
                              <td>'.$asset->checkoutReason.'</td>
                              <td>'.$this->fieldnames->getEmployeeName($asset->assignedTo).'</td>
                        </tr>';
           }
           
      }

      $repTable .= '</tbody>';
      $repTable .= datatable_close();

      $this->displayData['report'] = $repTable; 
    	$this->displayData['title']        = 'Report';
      $this->displayData['pageTitle']    = ' '.breadcrumb(' Checked Out Report');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportView';
      

      renderpage($this->displayData);
      
		
	}

	if ($reportType=='betweenDates') {

	  $this->displayData['title']        = 'Report';
      $this->displayData['pageTitle']    = ' '.breadcrumb(' Between Dates Report');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportDefine';
      $this->displayData['report'] = 'betweenDates';      
      renderpage($this->displayData);
      
		
	}

	if ($reportType=='depreciation') {

	    $this->displayData['title']        = 'Report';
      $this->displayData['pageTitle']    = ' '.breadcrumb(' Depreciation Report');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportDefine';
      $this->displayData['report'] = $reportType;      
      renderpage($this->displayData);
      
		
	}




}

public function genDepreciationRep(){
    $this->load->library(FIXEDASSETS_PREFIX.'depreciation');
    $table = 'fixedassets_assetlist';
    $upToDate = $this->input->post('dateEnd');
    $sortCriteria = $this->input->post('sortcriteria');    
    $zerocost = $this->input->post('zerocost');
    $fullydepreciated = $this->input->post('fullydepreciated');
    $disposeditems = $this->input->post('disposeditems');

    if (!is_validdate($upToDate) || $upToDate == '') {
      $upToDate = date('Y-m-d');
    }
    if ($zerocost=='1') {
      $zerocost = TRUE;
    }
    else{
      $zerocost = FALSE;
    }

    $loadcriteria = 'assetID';
    if ($sortCriteria=='category') {
      $loadcriteria = 'assetCat';
    }
    else if ($sortCriteria=='department') {
      $loadcriteria = 'assetSecLoc';
    }
    else if ($sortCriteria=='location') {
      $loadcriteria = 'assetPrimLoc';
    }

    $nonincludedlocs = array('assetPrimLoc' => '3', 'assetPrimLoc' => '2');
    $params = array();
    $params['where']['notequalto'] = $nonincludedlocs;

    $fields = dbtablefields($table);
    $records = dbtablerecords($table, $params, FALSE, TRUE);
    $datacolumns = array();

    if ($fields != FALSE && is_array($fields) && sizeof($fields) > 0) {
      foreach ($fields as $field) {            
        if ($field->isDashShown) {
          if ($field->isMonetary) {
            $datacolumns[$field->initialName] = array($field->setName, 'monetary');
          }
          else{
            $datacolumns[$field->initialName] = array($field->setName, $field->dataType);
          }
          
        }         
      }
    }
    else{
        $datacolumns['assetCode'] = array($this->fieldnames->getFieldName('assetCode'), 'varchar');
        $datacolumns['assetItem'] = array($this->fieldnames->getFieldName('assetItem'), 'varchar');
    }

    $repTable = mdldivstrt('row padded');

    $datacolumns['depdatacost'] = array('Cost', 'monetary');
    $datacolumns['depdatasalvagevalue'] = array('Salvage Value', 'monetary');
    $datacolumns['depdatastartdate'] = array('Start Date', 'date');
    $datacolumns['depdataaccumulated'] = array('Accumulated Depreciation', 'monetary');
    $datacolumns['depdatavbookvalue'] = array('Book Value', 'monetary');
    if ($fullydepreciated == '1') {
      $datacolumns['depdatastatus'] = array('Status', 'varchar');
    }

    if ($records != FALSE) {

        $repTable .= datatable_open("highlight full-width", $table, 'Depreciation Report');
              $repTable .= tableheadstart();          
                  //table header columns
                  $repTable .= headerrowstart();                               
                      $repTable .= tablerowcell(headerTxt(4, 'Depreciation as of - <b>'.$this->datalib->userdateformat($upToDate).'</b>'), 'colspan="'.sizeof($datacolumns).'" class="inputcell"');                    
                  $repTable .= headerrowend();


                  $repTable .= headerrowstart();
                    foreach ($datacolumns as $datacolumn) {            
                      $repTable .= tablerowcell(humanize($datacolumn[0]));        
                    }
                  $repTable .= headerrowend();

                $repTable .= tableheadend();
                //head end

                

                //body start 
                $repTable .= tablebodystart();



                  foreach ($records as $record) {
                    $recorddepreciationvars = $this->depreciation->deprecreciationvars($record->assetID);
                    $recorddepreciationdata = array();
                    if ($recorddepreciationvars != FALSE) {
                      if (intval($recorddepreciationvars['cost']) > 0) {
                        $recorddepreciationdata = $this->depreciation->depreciationdata($record->assetID, 'datedata', $upToDate);
                      }
                      else{
                        if ($zerocost) {
                          $recorddepreciationdata = $this->depreciation->depreciationdata($record->assetID, 'datedata', $upToDate);
                        }
                      }
                    }

                    if (sizeof($recorddepreciationdata) > 0) {
                        $repTable .= tablerowstart();            
                          foreach ($datacolumns as $columnkey=>$columnvalue) {
                            $celldata = '';
                            if ($columnkey != 'depdatacost' && $columnkey != 'depdatasalvagevalue' && $columnkey != 'depdatastartdate' && $columnkey != 'depdataaccumulated' && $columnkey != 'depdatavbookvalue' && $columnkey != 'depdatastatus') {
                                if ($columnvalue[1] == 'date') {
                                  $celldata = $this->datalib->userdateformat($record->$columnkey);
                                }
                                else if ($columnvalue[1] == 'boolean') {
                                  if ($record->$columnkey == '1') {
                                    $celldata = 'True';
                                  }                                
                                }
                                else if ($columnvalue[1] == 'monetary') {
                                  $celldata = monetaryformat($record->$columnkey);                              
                                }
                                else{
                                  $celldata = $record->$columnkey;
                                }
                            }
                            else{
                                if ($columnkey == 'depdatacost') {
                                   $celldata = monetaryformat($recorddepreciationvars['cost']);
                                }
                                else if ($columnkey == 'depdatasalvagevalue') {
                                   $celldata = monetaryformat($recorddepreciationvars['salvagevalue']);
                                }
                                else if ($columnkey == 'depdatastartdate') {
                                   $celldata = $this->datalib->userdateformat($recorddepreciationdata['from']);
                                }
                                else if ($columnkey == 'depdataaccumulated') {
                                   $celldata = monetaryformat($recorddepreciationdata['accumulated']);
                                }
                                else if ($columnkey == 'depdatavbookvalue') {
                                   $celldata = monetaryformat($recorddepreciationdata['bookvalue']);
                                }
                                else if ($columnkey == 'depdatastatus') {
                                  if ($recorddepreciationdata['fullydepreciated']) {
                                    $celldata = 'Fully Depreciated';
                                  }                                   
                                }
                            }

                            $repTable .= tablerowcell($celldata);
                          }
                        $repTable .= tablerowend();
                    }
                      
                  }




                //body End 
                $repTable .= tablebodyend();
              //data table end
            $repTable .= datatable_close();
    }

    $repTable .= mdldivend();

	    $this->displayData['title']        = 'Report';
      $this->displayData['pageTitle']    = ' '.breadcrumb(' Depreciation Report');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportView';
      
      
      $this->displayData['report'] = $repTable;      
      renderpage($this->displayData);
      


}

public function currentTotalDep($assetId){
  $totalDep = 0;
  foreach ($this->clsAssets->loadAsset($assetId) as $asset) {
    $totalDep = $this->clsRep->calculateCurrentValue($asset->assetLYears, $asset->totalCost, $asset->dtePutIntoService, $upToDate, $asset->salvageVal, $asset->deprMethod, $asset->bizUse);
  }

return $totalDep;
}

public function genassetsGroupByRep(){

$sortCriteria = $this->input->post('criteria');
$repTable = datatable_open("highlight full-width", "reportdatatable");
      $repTable .= '<thead>';
       $repTable .= '<tr>
                        <td>Asset #</td>
                        <td>Item</td>
                        <td>Description</td>
                        <td>Manufacturer</td>
                        <td>Model</td>
                        <td>Serial #</td>
                        <td>Date Of Prch</td>
                        <td>Cost</td>
                        <td>Assigned To</td>
                        <td>Status</td>
                        <td>Location</td>
                        <td>Department</td>
                        <td>Category</td>
                   </tr>
                   </thead>
                   <tbody>';
    foreach ($this->clsRep->genassetsGroupByRep($sortCriteria) as $asset) {

           $repTable .= '<tr>
                              <td>'.$asset->assetCode.'</td>
                              <td>'.$asset->assetItem.'</td>
                              <td>'.$asset->assetDesc.'</td>
                              <td>'.$this->fieldnames->getForeignKeyValue('assetMnfctr', $asset->assetMnfctr, 'fixedassets_assetlist').'</td>
                              <td>'.$this->fieldnames->getForeignKeyValue('assetModel', $asset->assetModel, 'fixedassets_assetlist').'</td>
                              <td>'.$asset->serialNum.'</td>
                              <td>'.$this->datalib->userdateformat($asset->dtePurchased).'</td>
                              <td>'.monetaryformat($asset->totalCost).'</td>
                              <td>'.$this->fieldnames->getEmployeeName($asset->assignedTo).'</td>
                              <td>'.$this->fieldnames->getForeignKeyValue('assetStatus', $asset->assetStatus, 'fixedassets_assetlist').'</td>
                              <td>'.$this->fieldnames->getForeignKeyValue('assetPrimLoc', $asset->assetPrimLoc, 'fixedassets_assetlist').'</td>
                              <td>'.$this->fieldnames->getForeignKeyValue('assetSecLoc', $asset->assetSecLoc, 'fixedassets_assetlist').'</td>
                              <td>'.$this->fieldnames->getForeignKeyValue('assetCat', $asset->assetCat, 'fixedassets_assetlist').'</td>
                        </tr>';
    }
    $repTable .= '</tbody>';
    $repTable .= datatable_close();


      $this->displayData['title']        = 'Report';
      $this->displayData['pageTitle']    =  breadcrumb(' Assets Grouped By '.$sortCriteria);
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportView';
      

      $this->displayData['report'] = $repTable;      
      renderpage($this->displayData);
      



}


public function genrepBtnDates(){
  $repType = $this->input->post('repType');
  if ($repType=="assets") {
    $dteFieldname = $this->input->post('dteFieldAsset');
    if ($dteFieldname != '') {
      $fieldName = dbfieldsetname('fixedassets_assetlist', $dteFieldname);
      $records = $this->clsRep->genRepbtnDates($repType, $dteFieldname);

      $repTable = datatable_open("highlight full-width", "reportdatatable");
           $repTable .= '<thead>
                        <tr>
                            <td>Asset #</td>
                            <td>Item</td>
                            <td>Description</td>
                            <td>'.$fieldName.'</td>
                            <td>Cost</td>
                            <td>Assigned To</td>
                            <td>Location</td>
                            <td>Department</td>
                            <td>Category</td>
                       </tr>
                       </thead>
                       <tbody>';

            if (sizeof($records)>0) {
              foreach ($records as $asset) {

                $repTable .= '<tr>
                                  <td>'.$asset->assetCode.'</td>
                                  <td>'.$asset->assetItem.'</td>
                                  <td>'.$asset->assetDesc.'</td>
                                  <td>'.$asset->$dteFieldname.'</td>
                                  <td>'.monetaryformat($asset->totalCost).'</td>
                                  <td>'.$this->fieldnames->getEmployeeName($asset->assignedTo).'</td>
                                  <td>'.$this->fieldnames->getForeignKeyValue('assetPrimLoc', $asset->assetPrimLoc, 'fixedassets_assetlist').'</td>
                                  <td>'.$this->fieldnames->getForeignKeyValue('assetSecLoc', $asset->assetSecLoc, 'fixedassets_assetlist').'</td>
                                  <td>'.$this->fieldnames->getForeignKeyValue('assetCat', $asset->assetCat, 'fixedassets_assetlist').'</td>
                       </tr>';
              }
            }








          $repTable .= '</tbody>';
          $repTable .= datatable_close();


          $this->displayData['title']        = 'Report';
          $this->displayData['pageTitle']    = ' '.breadcrumb(' Assets Grouped By '.$fieldName);
          $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportView';
          

          $this->displayData['report'] = $repTable;      
          renderpage($this->displayData);
          
    }
    else{
      setflashnotifacation('error', maticon('block', 'medium').'</br>Sorry!! You have to pick an Asset Report Date Field');
      preredirect(FIXEDASSETS_PREFIX.'reports/Reports/genReport/betweenDates');
    }
    
  }
  elseif ($repType=="audit") {
    $dteFieldname = $this->input->post('dteFieldAudit');

    if ($dteFieldname != '') {
      $table = 'actions_log';
      $fields = dbtablefields($table);
      $dataparams = array();
      $dataparams['select'] = array('fixedassets_assetlist'=>array('assetCode', 'assetItem'));
      $dataparams['where']['equalto'] = array('entity'=>'fixedassets_assetlist');
      $dataparams['joins'] = array('fixedassets_assetlist'=>array('record'=>'assetID'));
      $period = $this->input->post('dateSel');



      $records = dbtablerecords($table, $dataparams);


      $repTable = datatable_open("highlight full-width", "reportdatatable");


          $repTable = datatable_open("highlight full-width", "reportdatatable");
          $repTable .= '<thead>';
            $repTable .= tablerowstart();              
              foreach ($fields as $field) {
                if ($field->isPK) {
                  $repTable .= tablerowcell(dbfieldsetname('fixedassets_assetlist', 'assetCode'));
                  $repTable .= tablerowcell(dbfieldsetname('fixedassets_assetlist', 'assetItem'));
                }
                else{
                  if ($field->initialName != 'initialdata' && $field->initialName != 'datachanges' && $field->initialName != 'entity') {
                    $repTable .= tablerowcell($field->setName);
                  }
                  else if ($field->initialName == 'datachanges') {
                    $repTable .= tablerowcell($field->setName);
                  }
                  else{
                    // do nothing
                  }
                  
                }                
              }
            $repTable .= tablerowend();
          $repTable .= '</thead>';
          $repTable .= '<tbody>';
              foreach ($records as $record) {
                $repTable .= tablerowstart();
                  foreach ($fields as $field) {
                    $initialName = $field->initialName;
                    if ($field->isPK) {
                      $repTable .= tablerowcell($record->assetCode);
                      $repTable .= tablerowcell($record->assetItem);
                    }
                    else{
                      if ($field->initialName != 'initialdata' && $field->initialName != 'datachanges' && $field->initialName != 'entity') {
                        $repTable .= tablerowcell($record->$initialName);
                      }
                      else if ($field->initialName == 'datachanges') {
                        $repTable .= tablerowcell($record->$initialName);
                      }
                      else{
                        // do nothing
                      }

                      
                    }
                  }
                $repTable .= tablerowend();
              }
           



          $repTable .= '</tbody>';
          $repTable .= datatable_close();


          $this->displayData['title']        = 'Report';
          $this->displayData['pageTitle']    = breadcrumb('Report Between Dates');
          $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportView';
          

          $this->displayData['report'] = $repTable;      
          renderpage($this->displayData);
          
    }
    else{
      setflashnotifacation('error', maticon('block', 'medium').'</br>Sorry!! You have to pick an Asset Notebook Report Date Field');
      preredirect(FIXEDASSETS_PREFIX.'reports/Reports/genReport/betweenDates');
    }
  }

  



}
 

public function genrepPurchases(){
  $repTable = datatable_open("highlight full-width", "reportdatatable");
      $repTable .= '<thead>';
       $repTable .= '<tr>
                        <td>Asset #</td>
                        <td>Item</td>
                        <td>Description</td>
                        <td>Manufacturer</td>
                        <td>Model</td>
                        <td>Serial #</td>
                        <td>Invoice/PO#</td>
                        <td>Date Purchased</td>
                        <td>Base Cost</td>
                        <td>Tax 1</td>
                        <td>Tax 2</td>
                        <td>Total Cost</td>
                        <td>Dealer</td>
                   </tr>
                   </thead>
                   <tbody>';
    $bCost = 0;
    $cTax1 = 0;
    $cTax2 = 0;
    $tCost = 0;

    $records = $this->clsRep->genrepoPurchases();
    if (sizeof($records)>0) {
      foreach ($records as $asset) {
                $repTable .= '<tr>
                                  <td>'.$asset->assetCode.'</td>
                                  <td>'.$asset->assetItem.'</td>
                                  <td>'.$asset->assetDesc.'</td>
                                  <td>'.$this->fieldnames->getForeignKeyValue('assetMnfctr', $asset->assetMnfctr, 'fixedassets_assetlist').'</td>
                                  <td>'.$this->fieldnames->getForeignKeyValue('assetModel', $asset->assetModel, 'fixedassets_assetlist').'</td>
                                  <td>'.$asset->serialNum.'</td>
                                  <td>'.$asset->lpoNumber.'</td>
                                  <td>'.$this->datalib->userdateformat($asset->dtePurchased).'</td>
                                  <td>'.monetaryformat($asset->assetCost).'</td>
                                  <td>'.monetaryformat($asset->assetCTax1).'</td>
                                  <td>'.monetaryformat($asset->assetCTax2).'</td>
                                  <td>'.monetaryformat($asset->totalCost).'</td>
                                  <td>'.$this->fieldnames->getForeignKeyValue('assetDealer', $asset->assetDealer, 'fixedassets_assetlist').'</td>
                       </tr>';
        $bCost = $bCost + $asset->assetCost;
        $cTax1 = $cTax1 + $asset->assetCTax1;
        $cTax2 = $cTax2 + $asset->assetCTax1;
        $tCost = $tCost + $asset->totalCost;            
      }
      $repTable .= '<tr class="'.getcolorclass(3).' '.getcolorclass(4).'">
                      <td colspan="8" ><b>Totals</b></td>
                      <td><b>'.monetaryformat($bCost).'</b></td>
                      <td><b>'.monetaryformat($cTax1).'</b></td>
                      <td><b>'.monetaryformat($cTax2).'</b></td>
                      <td><b>'.monetaryformat($tCost).'</b></td>
                      <td></td>
                    </tr>';
    }
      

       $repTable .= '</tbody>';
      $repTable .= datatable_close();


      $this->displayData['title']        = 'Report';
      $this->displayData['pageTitle']    = ' '.breadcrumb(' Assets Purchase Report');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportView';
      
      
      $this->displayData['report'] = $repTable;      
      renderpage($this->displayData);
      

}


public function myCustomReports(){
      $this->displayData['title']        = 'Reports';
      $this->displayData['pageTitle']    = ' '.breadcrumb(' Custom Reports');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/myReports';
      
      
      $this->displayData['reports'] = $this->clsRep->customReports();      
      renderpage($this->displayData);
      

}

public function generatereport($repId){
 $rows = $this->clsRep->generateCustomReport($repId);
  $details = $this->clsRep->getReportDetails($repId);
  $fields = $this->clsRep->getReportFields($repId);
  $reportName = '';
  $table = '';

  $table = datatable_open("highlight full-width", "reportdatatable");



  $table .= $this->layoutgen->tableHeaderStart();
     
      $table .= $this->layoutgen->tableNormalRowStart();
      
      foreach ($fields as $field) {
        $table .= $this->layoutgen->tableHeaderCell($field->setName, 1);
      }

      $table .= $this->layoutgen->tableNormalRowEnd();

  $table .= $this->layoutgen->tableHeaderEnd();


  $table .= $this->layoutgen->tableBodyStart();




  foreach ($rows as $row) {
    $table .= $this->layoutgen->tableNormalRowStart();
    foreach ($fields as $field) {

      if ($field->isFK) {
        $tblColName = $field->initialName;
        $fkId = $row->$tblColName;
        if ($tblColName == 'assignedTo') {
          $recdata = $this->fieldnames->getEmployeeName($fkId);
        }
        else{
          $recdata = $this->fieldnames->getForeignKeyValue($tblColName, $fkId);
        }
         
        $table .= $this->layoutgen->tableNormalCell($recdata, 1);
      }
      else{
        $tblColName = $field->initialName;
        if ($field->dataType == 'date') {
          $table .= $this->layoutgen->tableNormalCell($this->datalib->userdateformat($row->$tblColName), 1);
        }
        else if ($field->isMonetary == '1') {
          $table .= $this->layoutgen->tableNormalCell(monetaryformat($row->$tblColName), 1);
        }
        else{
          $table .= $this->layoutgen->tableNormalCell($row->$tblColName, 1);
        }
        

        
      }
      
      
    }
    $table .= $this->layoutgen->tableNormalRowEnd();
  }
    
  $table .= $this->layoutgen->tableBodyEnd();

  $table .= tablerowstart('class="'.getcolorclass(3).' '.getcolorclass(5).'"');
      foreach ($fields as $field) {
        if ($field->includeTotals=='1') {
          $totals = 0;
          $tblColName = $field->initialName;
          foreach ($rows as $row) {
            $totals = $totals+$row->$tblColName;
          }
          if ($field->isMonetary == '1') {
            $totals = monetaryformat($totals);
          }
          $table .=  mdltablecell('<b><i> '.$totals.'</i></b>', 'class="mdl-data-table__cell--non-numeric"');
        }
        else{
          $table .=  mdltablecell('', 'class="mdl-data-table__cell--non-numeric"');
        }

      }
    $table .= tablerowend();

  $table .= $this->layoutgen->dataTableEnd();

  $this->displayData['title']        = 'Report';
  $this->displayData['pageTitle']    = ' '.breadcrumb($reportName);
  $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/reportView';
  

  $this->displayData['report'] = $table;      
  renderpage($this->displayData);
  
 
}




}