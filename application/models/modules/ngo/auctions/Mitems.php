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
      $this->load->model('auctions/mitems', 'cItems');
--------------------------------------------------------------------

---------------------------------------------------------------------*/


class Mitems extends CI_Model{

   public
       $lAuctionID, $lPackageID, $lNumItems, $items,
       $strWhereExtra;

   public function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------
		parent::__construct();
      $this->lAuctionID = $this->lPackageID = $this->lItemID = $this->items =
      $this->lNumPackages = $this->packagess = null;
      $this->strWhereExtra = '';
   }


      /* ---------------------------------------------------
                         I T E M S
         --------------------------------------------------- */
   function lCountItemsViaAID($lAuctionID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT COUNT(*) AS lNumRecs
         FROM ngo_gifts_auctions_items
            INNER JOIN gifts_auctions_packages ON ait_lPackageID=ap_lKeyID
         WHERE ap_lAuctionID=? AND NOT ait_bRetired;";
      $query = $this->db->query($sqlStr, $lAuctionID);
      $row = $query->row();
      return($row->lNumRecs);
   }

   function curEstValueViaAID($lAuctionID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT SUM(ait_curEstAmnt) AS curEstValue
         FROM ngo_gifts_auctions_items
            INNER JOIN gifts_auctions_packages ON ait_lPackageID=ap_lKeyID
         WHERE ap_lAuctionID=? AND NOT ait_bRetired;";
      $query = $this->db->query($sqlStr, array($lAuctionID));
      $row = $query->row();
      return((float)$row->curEstValue);
   }

   function curOutOfPocketViaAID($lAuctionID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT SUM(ait_curOutOfPocket) AS curOOP
         FROM ngo_gifts_auctions_items
            INNER JOIN ngo_gifts_auctions_packages ON ait_lPackageID=ap_lKeyID
         WHERE ap_lAuctionID=? AND NOT ait_bRetired;";
      $query = $this->db->query($sqlStr, array($lAuctionID));
      $row = $query->row();
      return((float)$row->curOOP);
   }

   function lNumWinningBidsViaAID($lAuctionID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT COUNT(*) AS lNumWin
         FROM ngo_gifts_auctions_packages
         WHERE ap_lAuctionID=?
            AND ap_lBidWinnerID IS NOT NULL ";
      $query = $this->db->query($sqlStr, array($lAuctionID));
      $row = $query->row();
      return((int)$row->lNumWin);
   }

   function lNumUnfulfilledViaAID($lAuctionID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT COUNT(*) AS lNum
         FROM ngo_gifts_auctions_packages
         WHERE ap_lAuctionID=?
            AND ap_lGiftID IS NULL
            AND ap_lBidWinnerID IS NOT NULL ";
      $query = $this->db->query($sqlStr, array($lAuctionID));
      $row = $query->row();
      return((int)$row->lNum);
   }

   function curIncomeViaAID($lAuctionID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT SUM(gi_curAmnt) AS curIncome
         FROM ngo_gifts_auctions_packages
            INNER JOIN ngo_gifts ON ap_lGiftID = gi_lKeyID
         WHERE ap_lAuctionID=?
            AND NOT gi_bRetired;";
      $query = $this->db->query($sqlStr, array($lAuctionID));
      $row = $query->row();
      return((float)$row->curIncome);
   }

   function curWinningBidAmntViaAID($lAuctionID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT SUM(ap_curWinBidAmnt) AS curWinningBid
         FROM ngo_gifts_auctions_packages
         WHERE ap_lAuctionID=?
            AND ap_lBidWinnerID IS NOT NULL;";
      $query = $this->db->query($sqlStr);
      $row = $query->row();
      return((float)$row->curWinningBid, array($lAuctionID));
   }

   function lCountItemsViaPID($lPackageID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT COUNT(*) AS lNumRecs
         FROM ngo_gifts_auctions_items
         WHERE ait_lPackageID=? AND NOT ait_bRetired;";
      $query = $this->db->query($sqlStr, array($lPackageID));
      $row = $query->row();
      return($row->lNumRecs);
   }

   function curEstValueViaPID($lPackageID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT SUM(ait_curEstAmnt) AS curEstValue
         FROM ngo_gifts_auctions_items
         WHERE ait_lPackageID=? AND NOT ait_bRetired;";
      $query = $this->db->query($sqlStr, array($lPackageID));
      $row = $query->row();
      return((float)$row->curEstValue);
   }

   function curOutOfPocketViaPID($lPackageID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr = "
         SELECT SUM(ait_curOutOfPocket) AS curOOP
         FROM ngo_gifts_auctions_items
         WHERE ait_lPackageID=? AND NOT ait_bRetired;";
      $query = $this->db->query($sqlStr, array($lPackageID));
      $row = $query->row();
      return((float)$row->curOOP);
   }

   function loadItemViaItemID($lItemID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->strWhereExtra = " AND ait_lKeyID=$lItemID ";
      $this->loadItems();
   }

   function loadItemsViaPackageID($lPackageID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->strWhereExtra = " AND ait_lPackageID=$lPackageID ";
      $this->loadItems();
   }

   function loadItems(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $this->items = array();
      $sqlStr =
        "SELECT
            ait_lKeyID, ait_lPackageID, ait_strItemName, ait_strDescription,
            ait_strInternalNotes,
            ait_dteItemObtained,
            ait_lItemDonorID, ait_strDonorAck,
            ait_curEstAmnt, ait_curOutOfPocket,

            ap_lAuctionID, ap_strPackageName, auc_strAuctionName,

            pe_bBiz, pe_strFName, pe_strLName,

            ait_lOriginID, ait_lLastUpdateID,
            usersC.first_name AS strCFName, usersC.last_name AS strCLName,
            usersL.first_name AS strLFName, usersL.last_name AS strLLName,
            UNIX_TIMESTAMP(ait_dteOrigin) AS dteOrigin,
            UNIX_TIMESTAMP(ait_dteLastUpdate) AS dteLastUpdate

         FROM ngo_gifts_auctions_items
            INNER JOIN users AS usersC   ON ait_lOriginID     = usersC.id
            INNER JOIN users AS usersL   ON ait_lLastUpdateID = usersL.id
            INNER JOIN ngo_gifts_auctions_packages ON ait_lPackageID    = ap_lKeyID
            INNER JOIN ngo_gifts_auctions          ON ap_lAuctionID     = auc_lKeyID
            LEFT  JOIN ngo_donors            ON ait_lItemDonorID  = pe_lKeyID

         WHERE NOT ait_bRetired $this->strWhereExtra
         ORDER BY auc_strAuctionName, ap_strPackageName, ait_strItemName, ait_lKeyID;";

      $query = $this->db->query($sqlStr);
      $this->lNumItems = $lNumItems = $query->num_rows();
      if ($lNumItems == 0){
         $this->items[0] = new stdClass;
         $item = &$this->items[0];

         $item->lKeyID               =
         $item->strItemName          =
         $item->strSafeItemName      =
         $item->strDescription       =
         $item->strInternalNotes     =
         $item->mdteItemObtained     =
         $item->dteObtained          =

         $item->lItemDonorID         =
         $item->strDonorAck          =
         $item->itemDonor_bBiz       =
         $item->itemDonor_strFName   =
         $item->itemDonor_strLName   =
         $item->itemDonor_safeName   =

         $item->curEstAmnt           =
         $item->curOutOfPocket       =
         $item->lAuctionID           =
         $item->lPackageID           =
         $item->strPackageName       =
         $item->strAuctionName       =
         $item->auc_lOriginID        =
         $item->auc_lLastUpdateID    =
         $item->strCFName            =
         $item->strCLName            =
         $item->strLFName            =
         $item->strLLName            =
         $item->dteOrigin            =
         $item->dteLastUpdate        = null;
      }else {
         $idx = 0;
         foreach ($query->result() as $row){
            $this->items[$idx] = new stdClass;
            $item = &$this->items[$idx];

            $item->lKeyID               = $row->ait_lKeyID;
            $item->strItemName          = $row->ait_strItemName;
            $item->strSafeItemName      = htmlspecialchars($row->ait_strItemName);
            $item->strDescription       = $row->ait_strDescription;
            $item->strInternalNotes     = $row->ait_strInternalNotes;
            $item->mdteItemObtained     = $row->ait_dteItemObtained;
            $item->dteObtained          = dteMySQLDate2Unix($row->ait_dteItemObtained);

            $item->lItemDonorID         = $row->ait_lItemDonorID;
            $item->itemDonor_bBiz       = $bBiz = $row->pe_bBiz;
            $item->itemDonor_strFName   = $row->pe_strFName;
            $item->itemDonor_strLName   = $row->pe_strLName;
            if ($bBiz){
               $item->itemDonor_safeName = htmlspecialchars($item->itemDonor_strLName);
            }else {
               $item->itemDonor_safeName = htmlspecialchars($item->itemDonor_strFName.' '.$item->itemDonor_strLName);
            }
            $item->strDonorAck          = $row->ait_strDonorAck;
            if ($item->strDonorAck==''){
               if ($bBiz){
                  $item->strDonorAck = $item->itemDonor_strLName;
               }else {
                  $item->strDonorAck = $item->itemDonor_strFName.' '.$item->itemDonor_strLName;
               }
            }

            $item->curEstAmnt           = $row->ait_curEstAmnt;
            $item->curOutOfPocket       = $row->ait_curOutOfPocket;
            $item->lAuctionID           = $row->ap_lAuctionID;
            $item->lPackageID           = $row->ait_lPackageID;
            $item->strPackageName       = $row->ap_strPackageName;
            $item->strAuctionName       = $row->auc_strAuctionName;
            $item->auc_lOriginID        = $row->ait_lOriginID;
            $item->auc_lLastUpdateID    = $row->ait_lLastUpdateID;
            $item->strCFName            = $row->strCFName;
            $item->strCLName            = $row->strCLName;
            $item->strLFName            = $row->strLFName;
            $item->strLLName            = $row->strLLName;
            $item->dteOrigin            = $row->dteOrigin;
            $item->dteLastUpdate        = $row->dteLastUpdate;

            ++$idx;
         }
      }
   }

   function loadItemProfileImage(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $cImages = new mimage_doc;
      if ($this->lNumItems > 0){
         $idx = 0;

         foreach ($this->items as $item){
            $lItemID = $item->lKeyID;

               // profile image
            $cImages->loadProfileImage(CENUM_CONTEXT_AUCTIONITEM, $lItemID);

            if ($cImages->lNumImageDocs==0){
               $item->profileImage = null;
            }else {
               $item->profileImage = new stdClass;
               $pImg = &$cImages->imageDocs[0];

               $item->profileImage->imageID          = $pImg->lKeyID;
               $item->profileImage->caption          = $pImg->strCaptionTitle;
               $item->profileImage->strUserFN        = $pImg->strUserFN;
               $item->profileImage->strSystemFN      = $pImg->strSystemFN;
               $item->profileImage->strSystemThumbFN = $pImg->strSystemThumbFN;
               $item->profileImage->strPath          = $pImg->strPath;
            }
            ++$idx;
         }
      }
   }

   public function addNewItem($lDonorID, $lPackageID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $glUserID = USERID;
      $item = &$this->items[0];

      $sqlStr =
         'INSERT INTO ngo_gifts_auctions_items
          SET '.$this->strSQLCommonItems().",
             ait_bRetired     = 0,
             ait_lPackageID   = ?,
             ait_lItemDonorID = ?,
             ait_lOriginID    = $glUserID,
             ait_dteOrigin    = NOW();";

      $this->db->query($sqlStr, array($lPackageID, $lDonorID));
      $item->lKeyID = $this->db->insert_id();
      return($item->lKeyID);
   }

   public function updateItem($lItemID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $sqlStr =
         'UPDATE ngo_gifts_auctions_items
          SET '.$this->strSQLCommonItems()."
          WHERE ait_lKeyID=?;";

      $this->db->query($sqlStr, array($lItemID));
   }

   private function strSQLCommonItems(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $glUserID = USERID;
      $item = &$this->items[0];
      return('
             ait_strItemName      = '.strPrepStr($item->strItemName).',
             ait_strDonorAck      = '.strPrepStr($item->strDonorAck).',
             ait_strDescription   = '.strPrepStr($item->strDescription).',
             ait_strInternalNotes = '.strPrepStr($item->strInternalNotes).',
             ait_dteItemObtained  = '.strPrepStr($item->mdteItemObtained).',
             ait_curEstAmnt       = '.number_format($item->curEstAmnt, 2, '.', '').',
             ait_curOutOfPocket   = '.number_format($item->curOutOfPocket, 2, '.', '').",
             ait_lLastUpdateID    = $glUserID,
             ait_dteLastUpdate    = NOW() ");
   }

   public function strItemHTMLSummary(){
   //-----------------------------------------------------------------------
   // assumes user has called $cItems->loadItemViaItemID($lItemID);
   //-----------------------------------------------------------------------
      global $genumDateFormat;

      $params = array('enumStyle' => 'terse');
      $clsRpt = new generic_rpt($params);
      $clsRpt->setEntrySummary();

      $item    = &$this->items[0];
      $lAuctionID = $item->lAuctionID;
      $lPackageID = $item->lPackageID;
      $lItemID    = $item->lKeyID;
      $strOut =
          $clsRpt->openReport('', '')
         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Auction Name:')
         .$clsRpt->writeCell (htmlspecialchars($item->strAuctionName))
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Auction ID:')
         .$clsRpt->writeCell (
                               str_pad($lAuctionID, 5, '0', STR_PAD_LEFT).'&nbsp;'
                              .strLinkView_AuctionRecord($lAuctionID, 'View auction record', true))
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Package Name:')
         .$clsRpt->writeCell (htmlspecialchars($item->strPackageName))
         .$clsRpt->closeRow  ()

         .$clsRpt->openRow   (false)
         .$clsRpt->writeLabel('Package ID:')
         .$clsRpt->writeCell (
                               str_pad($lPackageID, 5, '0', STR_PAD_LEFT).'&nbsp;'
                              .strLinkView_AuctionPackageRecord($lPackageID, 'View auction package record', true))
         .$clsRpt->closeRow  ()

         .$clsRpt->closeReport('<br>');
      return($strOut);
   }

   public function removeItemViaItemID($lItemID){
      $glUserID = USERID;
      $sqlStr =
         "UPDATE ngo_gifts_auctions_items
          SET ait_bRetired=1,
             ait_lLastUpdateID= $glUserID
          WHERE ait_lKeyID=?;";
      $query = $this->db->query($sqlStr, array($lItemID));
   }

   public function removeItemsViaPackageID($lPackageID){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $glUserID = USERID;
      $sqlStr =
         "UPDATE ngo_gifts_auctions_items
          SET ait_bRetired=1,
             ait_lLastUpdateID= $glUserID
          WHERE ait_lPackageID=? AND NOT ait_bRetired;";
      $query = $this->db->query($sqlStr, array($lPackageID));

   }

}