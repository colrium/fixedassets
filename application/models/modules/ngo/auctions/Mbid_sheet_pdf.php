<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid CRM!
//
// copyright (c) 2013 by  Collins Riungu
// Nairobi Kenya
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
---------------------------------------------------------------------
      $this->load->model('auctions/mbid_sheet_pdf', 'cBSPDF');
--------------------------------------------------------------------

---------------------------------------------------------------------*/

require_once('./application/libraries/fpdf/fpdf.php');
//require_once('./application/libraries/tcpdf/tcpdf.php');

class bsPDF extends FPDF {
//class bsPDF extends TCPDF {

   public $bs, $package;

// Page header
   function Header(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gpdf, $gbHeaderSet;

      $gpdf->lTopMargin = $gpdf->lLeftMargin = $gpdf->lRightMargin = 40;
      $gpdf->lBottomMargin = 55;
      paperSizeDimPts($gpdf->bs->enumPaperType, $gpdf->lPageWidth, $gpdf->lPageHeight);

      $this->SetMargins($gpdf->lLeftMargin, $gpdf->lTopMargin);

      $gbHeaderSet = true;
   }

   function createBidSheet(){
      global $gpdf;

      switch ($gpdf->bs->lTemplateID){
         case CENUM_BSTEMPLATE_SIMPLEPACK:
            $this->headerSimplePack();
            break;
         case CENUM_BSTEMPLATE_PACKAGEPIC:
            $this->headerSimplePackagePic();
            break;
         case CENUM_BSTEMPLATE_MIN:
            $this->headerMinimal();
            break;
         case CENUM_BSTEMPLATE_ITEMS:
            $this->headerEverything();
            break;
      }
   }

   private function headerEverything(){
   //---------------------------------------------------------------------
   // show package and individual item descriptions
   //---------------------------------------------------------------------
      global $gpdf, $gclsChapter;

      $lTop = $gpdf->lTopMargin;
      $lTitleLeft  = $gpdf->lLeftMargin;
      $lAvailSpace = $gpdf->lPageWidth - ($gpdf->lRightMargin + $gpdf->lLeftMargin);

         // thanks to http://stackoverflow.com/questions/3514076/special-characters-in-fpdf-with-php
      $strCur = html_entity_decode($gpdf->package->strCurrencySymbol);
      $strCur = iconv('UTF-8', 'windows-1252', $strCur);

      $lLineX = array();  // x coordinate of separator line
      $lLineX[] = $gpdf->lTopMargin;

//      if ($this->PageNo()==1){
         // organization name
      $this->SetXY($lTitleLeft, $lTop);
      if ($gpdf->bs->bIncludeOrgName){
         $strPName = $gclsChapter->strChapterName;
         $lFS = lFontSizeThatFits($this, 'Arial', 'B', 16, 10, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+1, $strPName, 0, 2, 'C');
         $lTop = $lLineX[] = $this->GetY();
      }

         // auction name
      $strAName = $gpdf->package->strAuctionName;
      $lFS = lFontSizeThatFits($this, 'Arial', 'B', 18, 10, $lAvailSpace, $strAName, $lWidth);
      $this->Cell(0, $lFS+1, $strAName, 0, 2, 'C');
      $lTop = $lLineX[] = $this->GetY();

         // auction date
      if ($gpdf->bs->bIncludeDate){
         $strPName = date('F jS, Y', $gpdf->package->dteAuction);
         $lFS = lFontSizeThatFits($this, 'Arial', '', 13, 10, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+5, $strPName, 0, 2, 'C');
         $lTop = $lLineX[] = $this->GetY();
      }

      $lPackInfoLeft   = $gpdf->lLeftMargin;
      $lPackInfoBottom = $imageBottom = $gpdf->lTopMargin;

          // Package image?
      $bShowPackImg = !is_null($gpdf->package->profileImage) && $gpdf->bs->bIncludePackageImage;
      if ($bShowPackImg){
         $lPackInfoWidth = $lAvailSpace * 0.55;
         $lImgLeft = $lPackInfoLeft + $lPackInfoWidth + 20;
         $maxWidth = ($lAvailSpace - $lImgLeft) + 20;
         $lPackImgTop = $lTop + 20;
      }else {
         $lPackInfoWidth = $lAvailSpace;
      }

         // package name
      if ($gpdf->bs->bIncludePackageName){
         $this->SetXY($lPackInfoLeft, $lTop+10);
         $strPName = $gpdf->package->strPackageName;
         $lFS = lFontSizeThatFits($this, 'Arial', 'B', 15, 10, $lPackInfoWidth, $strPName, $lWidth);
         $this->Cell($lPackInfoWidth, $lFS+1, $strPName, 0, 2, 'C');
         $lTop = $lLineX[] = $this->GetY();
      }

         // package ID
      if ($gpdf->bs->bIncludePackageID){
         $strPName = 'package ID: '.str_pad($gpdf->package->lKeyID, 5, '0', STR_PAD_LEFT);
         $lFS = lFontSizeThatFits($this, 'Courier', '', 10, 8, $lPackInfoWidth, $strPName, $lWidth);
         $this->Cell($lPackInfoWidth, $lFS, $strPName, 0, 2, 'C');
         $lTop = $lLineX[] = $this->incTopPos(0, $this->GetY()+5);
      }

         // package description
      $lFS = 11;
      $this->SetFont('Arial', '', $lFS);
      if ($gpdf->bs->bIncludePackageDesc){
         $this->MultiCell($lPackInfoWidth, $lFS+1, $gpdf->package->strDescription, 0, 'L');
         
         $lTop = $lLineX[] = $this->incTopPos(0, $this->GetY()+10);
      }

          // Package image
      if ($bShowPackImg){
         $strFN = $gpdf->package->profileImage->strPath.'/'.$gpdf->package->profileImage->strSystemFN;
         if (file_exists($strFN)){
            $maxHeight = 3.0*72;
            $imgSize = getimagesize($strFN, $imageinfo);
            $width = optimumImageWidth($imgSize, $maxWidth, $maxHeight, $sngAspect, $sngOptY);
            $lImgLeft = $lImgLeft +(($maxWidth - $width)/2);
            $this->Image($strFN, $lImgLeft, $lPackImgTop, $width);
            $lTop = $lLineX[] = $imageBottom = $lPackImgTop + $sngOptY + 20;
         }
      }

      $lTop = max($lLineX); // max value in array     // max($lPackInfoBottom, $imageBottom, $lTopAuctionName, $lPackNameBottom, $lPackIDBottom);
      $lFS = 10;
      $this->SetFont('Arial', '', $lFS);

         // starting bid
      if ($gpdf->bs->bIncludeMinBid){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Starting Bid:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curMinBidAmnt, 2), '0', '1', 'R');
      }

         // bid increment
      if ($gpdf->bs->bIncludeMinBidInc){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Minimum Bid Increment:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curMinBidInc, 2), '0', '1', 'R');
      }

         // buy it now
      if ($gpdf->bs->bIncludeBuyItNow && !is_null($gpdf->package->curBuyItNowAmnt)){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Buy it now for:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curBuyItNowAmnt, 2), '0', '1', 'R');
      }

         // estimated value
      if ($gpdf->bs->bIncludePackageEstValue){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Estimated Value:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curEstValue, 2), '0', '1', 'R');
      }

         // reserve amount
      if ($gpdf->bs->bIncludeReserve){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Reserve Amount:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curReserveAmnt, 2), '0', '1', 'R');
      }

      $lTop = $this->incTopPos($lTop, 12);

         // line separator
      $this->SetLineWidth(1);
      $this->Line($gpdf->lLeftMargin, $lTop, $gpdf->lPageWidth - $gpdf->lLeftMargin, $lTop);


      $cOpts = new stdClass;
      $cOpts->fontFamily   = 'Arial';
      $cOpts->fontStyle    = '';
      $cOpts->fontSize     = 10;
      $cOpts->cellWidth    = $lAvailSpace;
      $cOpts->lineHeight   = $cOpts->fontSize + 1;
      $cOpts->strCur       = $strCur;
//      $cOpts->pageBottom   = $gpdf->lPageHeight - ($gpdf->lTopMargin+$gpdf->lBottomMargin+20);
      $cOpts->pageBottom   = $gpdf->lPageHeight - ($gpdf->lBottomMargin+20);

      $itemImage = new stdClass;
      if ($gpdf->bs->bIncludeItemImage){
//         $lTop += 15;
         $lTop = $this->incTopPos($lTop, 15);
         $itemImage->maxWidth  = 100;
         $itemImage->maxHeight = 75;
         $cOpts->cellX = $gpdf->lLeftMargin + $itemImage->maxWidth + 20;
      }else {
         $itemImage->maxWidth  = 0;
         $itemImage->maxHeight = 0;
         $cOpts->cellX = $gpdf->lLeftMargin;
      }

      $lBottom = $gpdf->lPageHeight - $gpdf->lBottomMargin;
      $this->SetFont($cOpts->fontFamily, '', $cOpts->fontSize);

      if ($gpdf->lNumItems > 0){
         foreach ($gpdf->items as $item){
            $this->addItemToBS($item, $cOpts, $itemImage, $lTop, $lBottom);
         }
      }

      $lTop += 35;
      $this->addSignUpColumns($lTop);
   }

   function addItemToBS(&$item, &$cOpts, &$itemImage, &$lTop, $lBottom){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gpdf, $gbHeaderSet;

      $lCellHeight = 0;
      $this->SetXY($cOpts->cellX, $lTop);
      $lImageBottom = $lTop;

          // item image
      if (!is_null($item->profileImage) && $gpdf->bs->bIncludeItemImage){
         $strFN = $item->profileImage->strPath.'/'.$item->profileImage->strSystemThumbFN;
         if (file_exists($strFN)){
            $lImageX  = $gpdf->lLeftMargin;
            $maxWidth = $itemImage->maxWidth;

            $maxHeight = $itemImage->maxHeight;
            $imgSize = getimagesize($strFN, $imageinfo);
            $width = optimumImageWidth($imgSize, $maxWidth, $maxHeight, $sngAspect, $sngOptY);

            $lImageBottom = $sngOptY+$lTop+13;
/*            
$zzzlPos = strrpos(__FILE__, '\\'); $zzzlLen=strlen(__FILE__); echo('<font class="debug">'.substr(__FILE__, strrpos(__FILE__, '\\',-(($zzzlLen-$zzzlPos)+1))) .': '.__LINE__
.":\$lImageBottom = $lImageBottom, \$cOpts->pageBottom=".$cOpts->pageBottom." <br></font>\n");
*/  
  
            if ($lImageBottom > $cOpts->pageBottom){
               $this->AddPage();
               $lTop = $gpdf->lTopMargin;
               $lImageBottom = $sngOptY+$lTop+3;
               $this->SetXY($cOpts->cellX, $lTop);
            }

            $lImageLeft = $lImageX +(($maxWidth - $width)/2);
            $this->Image($strFN, $lImageLeft, $lTop+3, $width);
         }
      }

      $gbHeaderSet = false;
      if ($gpdf->bs->bIncludeItemName){
         $this->SetFont($cOpts->fontFamily, 'B', $cOpts->fontSize);
         $this->MultiCell($cOpts->cellWidth, $cOpts->lineHeight, $item->strItemName);
         $this->SetFont($cOpts->fontFamily, '', $cOpts->fontSize);
         $this->SetX($cOpts->cellX);
      }
      if ($gpdf->bs->bIncludeItemDesc && $item->strDescription != ''){
         $this->MultiCell(0, $cOpts->lineHeight, $item->strDescription);
         $this->SetX($cOpts->cellX);
      }
      if ($gpdf->bs->bIncludeItemID){
         $strItemID = 'Item ID '.str_pad($item->lKeyID, 5, '0', STR_PAD_LEFT);
         $this->SetFont($cOpts->fontFamily, 'I', $cOpts->fontSize-1);
         $this->MultiCell($cOpts->cellWidth, $cOpts->lineHeight, $strItemID);
         $this->SetFont($cOpts->fontFamily, '', $cOpts->fontSize);
         $this->SetX($cOpts->cellX);
      }

      if ($gpdf->bs->bIncludeItemDonor){
         $this->SetFont($cOpts->fontFamily, 'I', $cOpts->fontSize-1);
         $this->MultiCell($cOpts->cellWidth, $cOpts->lineHeight, 'Donated by '.$item->strDonorAck);  //$item->itemDonor_strFName.' '.$item->itemDonor_strLName );
         $this->SetFont($cOpts->fontFamily, '', $cOpts->fontSize);
         $this->SetX($cOpts->cellX);
      }

      if ($gpdf->bs->bIncludeItemEstValue){
         $this->SetFont($cOpts->fontFamily, 'I', $cOpts->fontSize-1);
         $this->MultiCell($cOpts->cellWidth, $cOpts->lineHeight,
                       'Estimated Value: '.$cOpts->strCur.' '.number_format($item->curEstAmnt, 2));
         $this->SetFont($cOpts->fontFamily, '', $cOpts->fontSize);
         $this->SetX($cOpts->cellX);
      }

      if ($gbHeaderSet){
         $lTop = $this->GetY()+12;
      }else {
         $lTop = max($this->GetY()+12, $lImageBottom);
      }
   }


   private function headerMinimal(){
   //---------------------------------------------------------------------
   // show package image
   //---------------------------------------------------------------------
      global $gpdf, $gclsChapter;

         // thanks to http://stackoverflow.com/questions/3514076/special-characters-in-fpdf-with-php
      $strCur = html_entity_decode($gpdf->package->strCurrencySymbol);
      $strCur = iconv('UTF-8', 'windows-1252', $strCur);

         // organization name
      $lTop = $gpdf->lTopMargin;
      $lAvailSpace = $gpdf->lPageWidth-($gpdf->lRightMargin + $gpdf->lLeftMargin);
      $this->SetXY($gpdf->lRightMargin, $lTop);

      if ($gpdf->bs->bIncludeOrgName){
         $strPName = $gclsChapter->strChapterName;
         $lFS = lFontSizeThatFits($this, 'Arial', 'B', 16, 10, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+1, $strPName, 0, 2, 'C');
         $lTop = $this->GetY();
      }
         // auction name
      $strAName = $gpdf->package->strAuctionName;
      $lFS = lFontSizeThatFits($this, 'Arial', 'B', 24, 10, $lAvailSpace, $strAName, $lWidth);
      $this->Cell(0, $lFS+12, $strAName, 0, 2, 'C');
      $lTop = $this->GetY();

         // package name
      if ($gpdf->bs->bIncludePackageName){
         $strPName = $gpdf->package->strPackageName;
         $lFS = lFontSizeThatFits($this, 'Arial', 'B', 18, 10, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+3, $strPName, 0, 2, 'C');
         $lTop = $this->GetY();
      }

         // package ID
      if ($gpdf->bs->bIncludePackageID){
         $strPName = 'package ID: '.str_pad($gpdf->package->lKeyID, 5, '0', STR_PAD_LEFT);
         $lFS = lFontSizeThatFits($this, 'Courier', '', 10, 8, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+15, $strPName, 0, 2, 'C');
      }

      $lFS = 11;
      $this->SetFont('Arial', '', $lFS);

         // package description
      if ($gpdf->bs->bIncludePackageDesc){
         $this->MultiCell(0, $lFS+1, $gpdf->package->strDescription, 0, 'L');
      }

      $lTop = $this->GetY()+8;

         // starting bid
      if ($gpdf->bs->bIncludeMinBid){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Starting Bid:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curMinBidAmnt, 2), '0', '1', 'R');
      }
         // bid increment
      if ($gpdf->bs->bIncludeMinBidInc){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Minimum Bid Increment:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curMinBidInc, 2), '0', '1', 'R');
      }

         // buy it now
      if ($gpdf->bs->bIncludeBuyItNow && !is_null($gpdf->package->curBuyItNowAmnt)){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Buy it now for:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curBuyItNowAmnt, 2), '0', '1', 'R');
      }

         // estimated value
      if ($gpdf->bs->bIncludePackageEstValue){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Estimated Value:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curEstValue, 2), '0', '1', 'R');
      }

         // reserve amount
      if ($gpdf->bs->bIncludeReserve){
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Reserve Amount:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curReserveAmnt, 2), '0', '1', 'R');
      }

      $lTop = $this->GetY()+25;
      $this->addSignUpColumns($lTop);
   }

   private function headerSimplePackagePic(){
   //---------------------------------------------------------------------
   // show package image
   //---------------------------------------------------------------------
      global $gpdf, $gclsChapter;

         // max logo dimensions in points
      $maxWidth = 1.5*72; $maxHeight = 1.5*72;
      $lTitleLeft = $gpdf->lLeftMargin;
      $imageBottom = $lRightColBot = $gpdf->lTopMargin;

         // thanks to http://stackoverflow.com/questions/3514076/special-characters-in-fpdf-with-php
      $strCur = html_entity_decode($gpdf->package->strCurrencySymbol);
      $strCur = iconv('UTF-8', 'windows-1252', $strCur);
      $lLogoBot = $gpdf->lTopMargin;

      if ($gpdf->bs->bIncludeOrgLogo && !is_null($gpdf->bs->lLogoImgID)){
             // Logo
         $strFN = $gpdf->bs->strPath.'/'.$gpdf->bs->strSystemFN;
         if (file_exists($strFN)){
            $imgSize = getimagesize($strFN, $imageinfo);
            $width = optimumImageWidth($imgSize, $maxWidth, $maxHeight, $sngAspect, $sngOptY);

            $this->Image($strFN, $gpdf->lLeftMargin, $gpdf->lTopMargin, $width);
            $lTitleLeft = $gpdf->lLeftMargin + $width + 5;
            $lLogoBot = $gpdf->lTopMargin + $sngOptY + 20;
         }
      }

         // organization name
      $lTop = $gpdf->lTopMargin;
      $lAvailSpace = ($gpdf->lPageWidth-$gpdf -> lRightMargin) - $lTitleLeft;
      $this->SetXY($lTitleLeft, $lTop);
      if ($gpdf->bs->bIncludeOrgName){
         $strPName = $gclsChapter->strChapterName;
         $lFS = lFontSizeThatFits($this, 'Arial', 'B', 16, 10, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+1, $strPName, 0, 2, 'C');
         $lTop = $this->GetY();
      }

         // auction name
      $strAName = $gpdf->package->strAuctionName;
      $lFS = lFontSizeThatFits($this, 'Arial', 'B', 24, 10, $lAvailSpace, $strAName, $lWidth);
      $this->Cell(0, $lFS+1, $strAName, 0, 2, 'C');
      $lTop = $this->GetY();

         // package name
      if ($gpdf->bs->bIncludePackageName){
         $this->SetXY($lTitleLeft, $lTop+10);
         $strPName = $gpdf->package->strPackageName;
         $lFS = lFontSizeThatFits($this, 'Arial', 'B', 18, 10, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+1, $strPName, 0, 2, 'C');
         $lTop = $this->GetY();
      }

         // package ID
      if ($gpdf->bs->bIncludePackageID){
         $strPName = 'package ID: '.str_pad($gpdf->package->lKeyID, 5, '0', STR_PAD_LEFT);
         $lFS = lFontSizeThatFits($this, 'Courier', '', 10, 8, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS, $strPName, 0, 2, 'C');
         $lTop = $this->GetY()+5;
      }

         // line separator
      $this->SetLineWidth(1);
      $this->Line($lTitleLeft, $lTop, $gpdf->lPageWidth - $gpdf->lLeftMargin, $lTop);
      $lTop = max($lTop, $lLogoBot);

      $lTop += 5;

          // Package image
      $maxWidth = $gpdf->lPageWidth - ($gpdf->lLeftMargin+$gpdf->lRightMargin); // for no package image
      if (!is_null($gpdf->package->profileImage) && $gpdf->bs->bIncludePackageImage){
         $strFN = $gpdf->package->profileImage->strPath.'/'.$gpdf->package->profileImage->strSystemFN;
         if (file_exists($strFN)){

               // image nominally starts 20 pts right of midline
            $lImageX = $gpdf->lPageWidth/2 + 20;
            $maxWidth = $gpdf->lPageWidth/2 - ($gpdf->lLeftMargin+20);

            $maxHeight = 3.0*72;
            $imgSize = getimagesize($strFN, $imageinfo);
            $width = optimumImageWidth($imgSize, $maxWidth, $maxHeight, $sngAspect, $sngOptY);
            $lImageLeft = $lImageX +(($maxWidth - $width)/2);
            $this->Image($strFN, $lImageLeft, $lTop, $width);
            $imageBottom = $lTop + $sngOptY + 20;
         }
      }
      $lFS = 11;
      $this->SetFont('Arial', '', $lFS);

         // package description
      if ($gpdf->bs->bIncludePackageDesc){
//         $lTop += 2;
         $lTop = $this->incTopPos($lTop, 2);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->MultiCell($maxWidth+15, $lFS+1, $gpdf->package->strDescription, 0, 'L');
         $lTop = $this->GetY()+10;
      }
         // starting bid
      if ($gpdf->bs->bIncludeMinBid){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Starting Bid:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curMinBidAmnt, 2), '0', '1', 'R');
      }
         // bid increment
      if ($gpdf->bs->bIncludeMinBidInc){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Minimum Bid Increment:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curMinBidInc, 2), '0', '1', 'R');
      }

         // buy it now
      if ($gpdf->bs->bIncludeBuyItNow && !is_null($gpdf->package->curBuyItNowAmnt)){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Buy it now for:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curBuyItNowAmnt, 2), '0', '1', 'R');
      }

         // estimated value
      if ($gpdf->bs->bIncludePackageEstValue){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Estimated Value:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curEstValue, 2), '0', '1', 'R');
      }

         // reserve amount
      if ($gpdf->bs->bIncludeReserve){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Reserve Amount:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curReserveAmnt, 2), '0', '1', 'R');
      }
      $lTop += 25;

      if ($imageBottom > $lTop) $lTop = $imageBottom;   // case where the image extends lower than the other details
      if ($lLogoBot > $lTop) $lTop = $lLogoBot + 25;
      $this->addSignUpColumns($lTop);
   }

   private function incTopPos($lTop, $lPts){
      global $gpdf;

      $lTop += $lPts;
      if ($lTop >= ($gpdf->lPageHeight - $gpdf->lBottomMargin)){
         $this->addPage();
         $lTop = $gpdf->lTopMargin;
      }
      return($lTop);
   }

private function testImageSize($x, $y, $maxX, $maxY){
   $imgSize = array($x, $y);
   $optX = optimumImageWidth($imgSize, $maxX, $maxY, $sngAspect, $optY);
   echoT('<table border="1">
       <tr>
          <td><b>X</b></td>
          <td><b>Y</b></td>
          <td><b>aspect</b></td>
          <td><b>maxX</b></td>
          <td><b>maxY</b></td>
          <td><b>optX</b></td>
          <td><b>opyY</b></td>
       </tr>
       <tr>
          <td>'.$x.'</td>
          <td>'.$y.'</td>
          <td>'.number_format($sngAspect, 3).'</td>
          <td>'.$maxX.'</td>
          <td>'.$maxY.'</td>
          <td>'.number_format($optX, 3).'</td>
          <td>'.number_format($optY, 3).'</td>
       </tr>
    </table><br>');

}

   private function headerSimplePack(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gpdf, $gclsChapter;

         // max logo dimensions in points
      $maxWidth = 3*72; $maxHeight = 2*72;
      $lTitleLeft = $gpdf->lLeftMargin;
      $imageBottom = $lRightColBot = $gpdf->lTopMargin;

         // thanks to http://stackoverflow.com/questions/3514076/special-characters-in-fpdf-with-php
      $strCur = html_entity_decode($gpdf->package->strCurrencySymbol);
      $strCur = iconv('UTF-8', 'windows-1252', $strCur);
/*
$this->testImageSize(50, 25, 200, 200);
$this->testImageSize(25, 50, 200, 200);
die;
*/
      $bImageSet = false;
      if ($gpdf->bs->bIncludeOrgLogo && !is_null($gpdf->bs->lLogoImgID)){
             // Logo
         $strFN = $gpdf->bs->strPath.'/'.$gpdf->bs->strSystemFN;
         if (file_exists($strFN)){
            $imgSize = getimagesize($strFN, $imageinfo);
            $width   = optimumImageWidth($imgSize, $maxWidth, $maxHeight, $sngAspect, $sngOptY);

            $this->Image($strFN, $gpdf->lLeftMargin + (($maxWidth-$width)/2), $gpdf->lTopMargin, $width);
            $lTitleLeft = $gpdf->lLeftMargin + $maxWidth + 5;
            $imageBottom = $gpdf->lTopMargin + $sngOptY + 10;
            $bImageSet = true;
         }
      }

         // auction name
      $strAName = $gpdf->package->strAuctionName;
      $lAvailSpace = ($gpdf->lPageWidth-$gpdf -> lRightMargin) - $lTitleLeft;
      $lFS = lFontSizeThatFits($this, 'Arial', 'B', 28, 10, $lAvailSpace, $strAName, $lWidth);
      $lTop = $gpdf->lTopMargin;
      $this->SetXY($lTitleLeft, $lTop);
      $this->Cell(0, $lFS+1, $strAName, 0, 2, 'C');
      $lTop = $this->GetY();

         // auction date
      if ($gpdf->bs->bIncludeDate){
         $strPName = date('F jS, Y', $gpdf->package->dteAuction);
         $lFS = lFontSizeThatFits($this, 'Arial', '', 13, 10, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+5, $strPName, 0, 2, 'C');
         $lTop = $this->GetY();
      }

         // organization name
      if ($gpdf->bs->bIncludeOrgName){
         $strPName = $gclsChapter->strChapterName;
         $lFS = lFontSizeThatFits($this, 'Arial', 'B', 15, 10, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+1, $strPName, 0, 2, 'C');
         $lTop = $this->GetY();
      }

         // package name
      if ($gpdf->bs->bIncludePackageName){
         $this->SetXY($lTitleLeft, $lTop+10);
         $strPName = $gpdf->package->strPackageName;
         $lFS = lFontSizeThatFits($this, 'Arial', 'B', 18, 10, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS+1, $strPName, 0, 2, 'C');
         $lTop = $this->GetY();
      }

         // package ID
      if ($gpdf->bs->bIncludePackageID){
         $strPName = 'package ID: '.str_pad($gpdf->package->lKeyID, 5, '0', STR_PAD_LEFT);
         $lFS = lFontSizeThatFits($this, 'Courier', '', 10, 8, $lAvailSpace, $strPName, $lWidth);
         $this->Cell(0, $lFS, $strPName, 0, 2, 'C');
         $lTop = $this->GetY()+5;
      }

      $lFS = 11;
      $this->SetFont('Arial', '', $lFS);

         // package description
      if ($gpdf->bs->bIncludePackageDesc){
//         $lTop += 2;
         $lTop = $this->incTopPos($lTop, 2);
         $this->SetXY($lTitleLeft, $lTop);
         $this->MultiCell(0, $lFS+1, $gpdf->package->strDescription, 0, 'L');
         $lTop = $this->GetY();
      }
      $lRightColBot = $lTop;
      if ($bImageSet && ($imageBottom < $lRightColBot)) $lTop = $imageBottom;

         // starting bid
      if ($gpdf->bs->bIncludeMinBid){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Starting Bid:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curMinBidAmnt, 2), '0', '1', 'R');
      }

         // bid increment
      if ($gpdf->bs->bIncludeMinBidInc){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Minimum Bid Increment:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curMinBidInc, 2), '0', '1', 'R');
      }

         // buy it now
      if ($gpdf->bs->bIncludeBuyItNow && !is_null($gpdf->package->curBuyItNowAmnt)){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Buy it now for:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curBuyItNowAmnt, 2), '0', '1', 'R');
      }

         // estimated value
      if ($gpdf->bs->bIncludePackageEstValue){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Estimated Value:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curEstValue, 2), '0', '1', 'R');
      }

         // reserve amount
      if ($gpdf->bs->bIncludeReserve){
//         $lTop += 12;
         $lTop = $this->incTopPos($lTop, 12);
         $this->SetXY($gpdf->lLeftMargin, $lTop);
         $this->Cell(0, 0, 'Reserve Amount:');
         $this->SetXY($gpdf->lLeftMargin+140, $lTop);
         $this->Cell(50, 0, $strCur.' '.number_format($gpdf->package->curReserveAmnt, 2), '0', '1', 'R');
      }
      $lTop += 20;
 //     }else {
 //        $lTop = $gpdf->lTopMargin;
 //     }
      $lTop += 20;
      if ($imageBottom > $lTop) $lTop = $imageBottom;   // case where the image extends lower than the other details
      if ($lRightColBot > $lTop) $lTop = $lRightColBot + 25;
      $this->addSignUpColumns($lTop);
   }

   function addSignUpColumns($lTop){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gpdf;

         // user can optionally not include signup entries
      if (!$gpdf->bs->bIncludeSignup) return;

      $signupLeft  = array($gpdf->lLeftMargin, $gpdf->lLeftMargin+150, $gpdf->lLeftMargin+400);
      $signupWidth = array(130,
                           200,
                           $gpdf->lPageWidth - ($gpdf->lLeftMargin+$gpdf->lRightMargin+300));
      $lBottom = $gpdf->lPageHeight - $gpdf->lBottomMargin;

      if ($lTop > ($lBottom-30)){
         $this->AddPage();
         $lTop = $gpdf->lTopMargin;
      }

         // sign-up sheet headings
      $lPageWidth = $gpdf->lPageWidth - ($gpdf->lLeftMargin + $gpdf->lRightMargin);
      $lLeft = $gpdf->lLeftMargin;
      $this->SetFont('Arial', '', 11);
      if ($lTop < $lBottom){
         foreach ($gpdf->bs->signUpCols as $suCol){
            if ($suCol->bShow){
               $this->SetXY($lLeft, $lTop);
               $this->Cell(0, 0, $suCol->heading);
               $lZoneWidth = $lPageWidth * ($suCol->width/100);
               $suCol->left = $lLeft + 4;
               $lLeft = $lLeft + $lZoneWidth;
               $suCol->lineWidth = $lZoneWidth - 15;
            }
         }
         $lTop += 25;
      }

      $this->SetLineWidth(1);
      while ($lTop < $lBottom){
         foreach ($gpdf->bs->signUpCols as $suCol){
            if ($suCol->bShow){
               $this->Line($suCol->left, $lTop, $suCol->left+$suCol->lineWidth, $lTop);
            }
         }
         $lTop += 25;
      }
   }

      // Page footer
   function Footer(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gpdf;
      if ($gpdf->bs->bIncludeFooter)
            // Position at 40pt from bottom
         $this->SetXY($gpdf->lLeftMargin, -40);
         $lWidth = $gpdf->lPageWidth - ($gpdf->lLeftMargin + $gpdf->lRightMargin);

            // Arial italic 9
         $this->SetFont('Arial','I',9);

         $strPName = 'package ID: '.str_pad($gpdf->package->lKeyID, 5, '0', STR_PAD_LEFT)
                       ."\n".'Page '.$this->PageNo();

            // Page number
         $this->MultiCell($lWidth, 12, $strPName.'/{nb}', 0, 'C');
//         $this->Cell(0, 10, $strPName.'/{nb}',0,0,'C');
   }


}

class Mbid_sheet_pdf extends CI_Model{

   public
       $strWhereExtra;

   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->lNumBidSheets = $this->bidSheets = null;
      $this->strWhereExtra = '';
   }


/*
function testLongCell(){
   global $gpdf, $gclsChapter;

$strText = '
Gone with the Wind is a novel written by Margaret Mitchell, first published in 1936.
It is often placed in the literary sub-genre of the historical romance novel.[2] However,
it has been argued the novel is a "near miss" and does not contain all of the elements of the romance genre,[3] making it simply a historical novel.

The story is set in Clayton County, Georgia, and Atlanta during the American Civil
War and Reconstruction. It depicts the experiences of Scarlett O\'Hara, the spoiled daughter of a well-to-do plantation owner, who must use every means at her disposal to come out of the poverty she finds herself in after Sherman\'s "March to the Sea".
Gone with the Wind takes place in the southern United States in the state of Georgia during the American Civil War (1861–1865) and the Reconstruction Era (1865–1877) that followed the war. The novel unfolds against the backdrop of rebellion wherein seven southern states, Georgia among them, have declared their secession from the United States (the "Union") and formed the Confederate States of America (the "Confederacy"), after Abraham Lincoln was elected president with no ballots from ten Southern states where slavery was legal. A dispute over states\' rights has arisen[11] involving enslaved African people who were the source of manual labor on cotton plantations throughout the South. The story opens in April 1861 at the "Tara" plantation, which is owned by a wealthy Irish immigrant family, the O\'Haras. The reader is told Scarlett O\'Hara, the sixteen-year-old daughter of Gerald and Ellen O\'Hara, "was not beautiful, but"[12] had an effect on men, especially when she took notice of them. It is the day before the men are called to war, Fort Sumter having been fired on two days earlier.

There are brief but vivid descriptions of the South as it began and grew, with backgrounds of the main characters: the stylish and highbrow French, the gentlemanly English, the forced-to-flee and looked-down-upon Irish. Miss Scarlett learns that one of her many beaux, Ashley Wilkes, is soon to be engaged to his cousin, Melanie Hamilton. She is stricken at heart. The following day at the Wilkeses\' barbecue at "Twelve Oaks," Scarlett informs Ashley she loves him and Ashley admits he cares for her.[11] However, he knows he would not be happily married to Scarlett because of their personality differences. Scarlett loses her temper at Ashley and he silently takes it.
Then Scarlett meets Rhett Butler, a man who wears "the clothes of a dandy"[13] and has a reputation as a rogue. Rhett had been alone in the library when Ashley and Scarlett entered, and felt it wiser to not make his presence known while the argument took place. Rhett applauds Scarlett for the unladylike spirit she displayed with Ashley. Infuriated and humiliated, Scarlett tells Rhett, "You aren\'t fit to wipe Ashley\'s boots!"[11]

Upon leaving the library and rejoining the other party guests, she finds out that war has been declared and the men are going to enlist. Seeking revenge for being jilted by Ashley, Scarlett accepts a proposal of marriage from Melanie\'s brother, Charles Hamilton. They marry two weeks later. Charles dies from measles two months after the war begins. Scarlett is pregnant with her first child. A widow at merely sixteen, she gives birth to a boy, Wade Hampton Hamilton, named after his father\'s general.[14] As a widow, she is bound by tradition to wear black and avoid conversation with young men. Scarlett is despondent as a result of the restrictions placed upon her.
Aunt Pittypat, who is living with Melanie in Atlanta, invites Scarlett to stay with them. In Atlanta, Scarlett\'s spirits revive and she is busy with hospital work and sewing circles for the Confederate army. Scarlett encounters Rhett Butler again at a dance for the Confederacy. Although Rhett believes the war is a lost cause, he is blockade running for the profit in it. The men must bid for a dance with a lady and Rhett bids "one hundred fifty dollars-in gold"[13] for a dance with Scarlett. Everyone at the dance is shocked that Rhett would bid for Scarlett, the widow still dressed in black. Melanie comes to Scarlett\'s defense because she is supporting the Cause for which her husband, Ashley, is fighting.

At Christmas (1863), Ashley has been granted a furlough from the army and returns to Atlanta to be with Melanie. The war is going badly for the Confederacy. Atlanta is under siege (September 1864), "hemmed in on three sides,"[15] it descends into a desperate state while hundreds of wounded Confederate soldiers lie dying or dead in the city. Melanie goes into labor with only the inexperienced Scarlett to assist, as all the doctors are busy attending the soldiers. Prissy, a young Negro servant girl, cries out in despair and fear, "De Yankees is comin!"[16] In the chaos, Scarlett, left to fend for herself, cries for the comfort and safety of her mother and Tara. The tattered Confederate States Army sets flame to Atlanta as they abandon it to the Union Army.
Melanie gives birth to a boy she names "Beau", and now they must hurry for refuge. Scarlett tells Prissy to go find Rhett, but she is afraid to "go runnin\' roun\' in de dahk". Scarlett replies to Prissy, "Haven\'t you any gumption?"[16] Prissy then finds Rhett, and Scarlett begs him to take herself, Wade, Melanie, Beau, and Prissy to Tara. Rhett laughs at the idea, but steals an emaciated horse and a small wagon, and they follow the retreating army out of Atlanta.

Part way to Tara, Rhett has a change of heart and he abandons Scarlett to enlist in the army. Scarlett makes her way to Tara where she is welcomed on the steps by her father, Gerald. It is clear things have drastically changed: Gerald has lost his mind, Scarlett\'s mother is dead, her sisters are sick with typhoid fever, the field slaves left after Emancipation, the Yankees have burned all the cotton and there is no food in the house.

The long tiring struggle for post-war survival begins that has Scarlett working in the fields. There are hungry people to feed and little food. There is the ever present threat of the Yankees who steal and burn, and at one point, Scarlett kills a Yankee marauder with a single shot from Charles\'s pistol leaving "a bloody pit where the nose had been."[17]

A long succession of Confederate soldiers returning home stop at Tara to find food and rest. Two men stay on, an invalid Cracker, Will Benteen, and Ashley Wilkes, whose spirit is broken. Life at Tara slowly begins to recover when a new threat appears in the form of new taxes on Tara.

Scarlett knows only one man who has enough money to help her pay the taxes, Rhett Butler. She goes to Atlanta to find him only to learn Rhett is in jail. As she is leaving the jailhouse, Scarlett runs into Frank Kennedy, who is betrothed to Scarlett\'s sister, Suellen, and running a store in Atlanta. Soon realizing Frank also has money, Scarlett hatches a plot and tells Frank that Suellen has changed her mind about marrying him. Thereafter Frank succumbs to Scarlett\'s feminine charms and he marries her two weeks later knowing he has done "something romantic and exciting for the first time in his life."[18] Always wanting Scarlett to be happy and radiant, Frank gives her the money to pay the taxes on Tara.

While Frank has a cold and is being pampered by Aunt Pittypat, Scarlett goes over the accounts at Frank\'s store and finds many of his friends owe him money. Scarlett is now terrified about the taxes and decides money, a lot of it, is needed. She takes control of his business while he is away and her business practices leave many Atlantans resentful of her. Then with a loan from Rhett she buys a sawmill and runs the lumber business herself, all very unladylike conduct. Much to Frank\'s relief, Scarlett learns she is pregnant, which curtails her activities for a while. She convinces Ashley to come to Atlanta and manage the mill, all the while still in love with him. At Melanie\'s urging, Ashley takes the job at the mill. Melanie soon becomes the center of Atlanta society, and Scarlett gives birth to a girl named Ella Lorena. "Ella for her grandmother Ellen, and Lorena because it was the most fashionable name of the day for girls."[19]

The state of Georgia is under martial law and life there has taken on a new and more frightening tone. For protection, Scarlett keeps Frank\'s pistol tucked in the upholstery of the buggy. Her trips alone to and from the mill take her past a shanty town where criminal elements live. On one evening when she is coming home from the mill, Scarlett is accosted by two men who attempt to rob her, but she escapes with the help of Big Sam, the former negro foreman from Tara. Attempting to avenge the assault on his wife, Frank and the Ku Klux Klan raid the shanty town whereupon Frank is shot dead. Scarlett is a widow for a second time.
';


$this->SetXY(10, 10);
$this->SetFont('Arial', '', 10);
$this->MultiCell(0, 11, $strText);
//$gpdf->bItemLayoutInProcess = false;
return;
'

}
*/



}
