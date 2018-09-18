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
      $this->load->model('financials/mdeposits', 'clsDeposits');
---------------------------------------------------------------------


---------------------------------------------------------------------*/

//-----------------------------------------------------------------------
//
//-----------------------------------------------------------------------
class Mwelcome extends CI_Model{

   public $whereExtra, $whereExtra2, $sdate1, $sdate2, $cdate1, $cdate2;

   function __construct() {
   //-----------------------------------------------------------------------
   // constructor
   //-----------------------------------------------------------------------


		parent::__construct();
   }



public function accountsAggregate(){
	$sqlStr =
         "SELECT
            gi_lKeyID AS giftID,
            IF((pe_bBiz*gi_lForeignID)=0, null, gi_lForeignID) AS businessID,
            IF((pe_bBiz*gi_lForeignID)=0, gi_lForeignID, null) AS peopleID,
            IF (pe_bBiz, pe_strLName, null) AS `Business Name`,
            IF (pe_bBiz, null, pe_strLName) AS `Last Name`,
            IF (pe_bBiz, null, pe_strFName) AS `First Name`,
            IF (gi_lSponsorID IS NULL , 'No', 'Yes') AS `Sponsorship Payment`,
            gi_lSponsorID         AS sponsorID,

            gi_lDepositLogID      AS `Deposit ID`,

            ga_lKeyID             AS accountID,
            ga_strAccount         AS Account,

            gi_lCampID            AS campaignID,
            gc_strCampaign        AS Campaign,

            SUM(gi_curAmnt) AS Amount_total,
            gi_lACOID             AS `Accounting Country ID`,
            aco_strName           AS `Accounting Country`,
            gi_dteDonation AS `Date of Donation`,
            listAttrib.lgen_strListItem   AS `Attributed To`,
            IF (gi_bGIK, 'Yes', 'No')      AS `In Kind Donation`,
            IF (gi_bGIK, gi_lGIK_ID, NULL) AS inKindID,
            IF (gi_bGIK, listInKind.lgen_strListItem, NULL) AS `In-Kind Type`,
            gi_strImportID                AS importID,
            gi_strNotes                   AS Notes,
            gi_strCheckNum                AS `Check Number`,
            gi_lPaymentType               AS paymentTypeID,
            listPayType.lgen_strListItem  AS `Payment Type`,
            gi_lMajorGiftCat              AS giftCategoryID,
            listGiftCat.lgen_strListItem  AS `Major Gift Category`,

            IF (gi_bAck, 'Yes', 'No') AS `Acknowledged?`,
            gi_dteAck AS `Date Acknowledged`,

            gi_dteOrigin AS `Record Creation Date`,
            gi_dteLastUpdate AS `Record Last Update`

         FROM ngo_gifts
            INNER JOIN ngo_donors    ON gi_lForeignID = pe_lKeyID
            INNER JOIN ngo_admin_aco       ON gi_lACOID     = aco_lKeyID
            INNER JOIN ngo_gifts_campaigns ON gi_lCampID=gc_lKeyID
            INNER JOIN ngo_gifts_accounts  ON ga_lKeyID=gc_lAcctID
            LEFT  JOIN ngo_lists_generic AS listAttrib  ON gi_lAttributedTo = listAttrib.lgen_lKeyID
            LEFT  JOIN ngo_lists_generic AS listInKind  ON gi_lGIK_ID       = listInKind.lgen_lKeyID
            LEFT  JOIN ngo_lists_generic AS listPayType ON gi_lPaymentType  = listPayType.lgen_lKeyID
            LEFT  JOIN ngo_lists_generic AS listGiftCat ON gi_lMajorGiftCat = listGiftCat.lgen_lKeyID

         WHERE NOT gi_bRetired

         GROUP BY ga_strAccount";
       
    $query = $this->db->query($sqlStr);
    return $query->result();

}

public function entitiesAggregate(){
	$sqlStr =
         "SELECT
            gi_lKeyID AS giftID,
            IF((pe_bBiz*gi_lForeignID)=0, null, gi_lForeignID) AS businessID,
            IF((pe_bBiz*gi_lForeignID)=0, gi_lForeignID, null) AS peopleID,
            IF (pe_bBiz, pe_strLName, null) AS `BusinessName`,
            IF (pe_bBiz, null, pe_strLName) AS `Last Name`,
            IF (pe_bBiz, null, pe_strFName) AS `First Name`,
            IF (gi_lSponsorID IS NULL , 'No', 'Yes') AS `Sponsorship Payment`,
            gi_lSponsorID         AS sponsorID,

            gi_lDepositLogID      AS `Deposit ID`,

            ga_lKeyID             AS accountID,
            ga_strAccount         AS Account,

            gi_lCampID            AS campaignID,
            gc_strCampaign        AS Campaign,

            SUM(gi_curAmnt) AS Amount_total,
            gi_lACOID             AS `Accounting Country ID`,
            aco_strName           AS `Accounting Country`,
            gi_dteDonation AS `Date of Donation`,
            listAttrib.lgen_strListItem   AS `Attributed To`,
            IF (gi_bGIK, 'Yes', 'No')      AS `In Kind Donation`,
            IF (gi_bGIK, gi_lGIK_ID, NULL) AS inKindID,
            IF (gi_bGIK, listInKind.lgen_strListItem, NULL) AS `In-Kind Type`,
            gi_strImportID                AS importID,
            gi_strNotes                   AS Notes,
            gi_strCheckNum                AS `Check Number`,
            gi_lPaymentType               AS paymentTypeID,
            listPayType.lgen_strListItem  AS `Payment Type`,
            gi_lMajorGiftCat              AS giftCategoryID,
            listGiftCat.lgen_strListItem  AS `Major Gift Category`,

            IF (gi_bAck, 'Yes', 'No') AS `Acknowledged?`,
            gi_dteAck AS `Date Acknowledged`,

            gi_dteOrigin AS `Record Creation Date`,
            gi_dteLastUpdate AS `Record Last Update`

         FROM ngo_gifts
            INNER JOIN ngo_donors    ON gi_lForeignID = pe_lKeyID
            INNER JOIN ngo_admin_aco       ON gi_lACOID     = aco_lKeyID
            INNER JOIN ngo_gifts_campaigns ON gi_lCampID=gc_lKeyID
            INNER JOIN ngo_gifts_accounts  ON ga_lKeyID=gc_lAcctID
            LEFT  JOIN ngo_lists_generic AS listAttrib  ON gi_lAttributedTo = listAttrib.lgen_lKeyID
            LEFT  JOIN ngo_lists_generic AS listInKind  ON gi_lGIK_ID       = listInKind.lgen_lKeyID
            LEFT  JOIN ngo_lists_generic AS listPayType ON gi_lPaymentType  = listPayType.lgen_lKeyID
            LEFT  JOIN ngo_lists_generic AS listGiftCat ON gi_lMajorGiftCat = listGiftCat.lgen_lKeyID

         WHERE NOT gi_bRetired

         GROUP BY IF((pe_bBiz*gi_lForeignID)=0, null, gi_lForeignID)";
       
    $query = $this->db->query($sqlStr);
    return $query->result();

}

public function loadCurNotifacation($userID){
    $previewDays = 2;
     $sqlStr = "SELECT DISTINCT re_lKeyID
            FROM 
                  ngo_reminders
               INNER JOIN ngo_reminders_dates  ON rd_lRemID    =re_lKeyID
               INNER JOIN ngo_reminders_inform ON ri_lRemDateID=rd_lKeyID
            WHERE 
               rd_dteEndDisplayDate >= NOW()
               AND rd_dteDisplayDate    <= DATE_ADD(NOW(),INTERVAL $previewDays DAY)

               AND (ri_lUserID=$userID OR ri_lUserID=-1)
              
               AND NOT re_bRetired;";

      $query = $this->db->query($sqlStr);
      return ($query->num_rows());




}

public function donationTotal(){

     $sqlStr = "SELECT SUM(gi_curAmnt) AS year_total FROM ngo_gifts WHERE YEAR(gi_dteDonation) = YEAR(CURDATE()) AND NOT gi_bRetired;";

      $query = $this->db->query($sqlStr);
      
      foreach ($query->result() as $row) {
         $total= $row->year_total;
      }

      return $total;


}

public function expectedTotal(){
   $expectedTotal = 0;
     $sqlStr = "SELECT * FROM ngo_expected_amounts WHERE year = YEAR(CURDATE());";

      $query = $this->db->query($sqlStr);
      
      foreach ($query->result() as $row) {
         $expectedTotal= $row->amount;
      }

      return $expectedTotal;


}


public function attributeList(){

   $sqlStr = "SELECT * FROM ngo_lists_generic 
   WHERE lgen_enumListType = 'attrib' AND NOT lgen_bRetired;";

   $query = $this->db->query($sqlStr);
    return $query->result();
}



public function peopleAttributedTo($id,$month){
   $sqlStr =  "SELECT            
               COUNT(`ngo_donors`.`pe_lAttributedTo`) AS `attributedTotal`,
               MONTH(`ngo_donors`.`pe_dteOrigin`) AS `forMonth`,
               `ngo_lists_generic`.`lgen_strListItem` AS `attributedToName`
                        
            FROM
               `ngo_donors` AS `ngo_donors`,
               `ngo_lists_generic` AS `ngo_lists_generic`
            WHERE    
               `ngo_donors`.`pe_lAttributedTo` = `ngo_lists_generic`.`lgen_lKeyID` 
            AND NOT 
               `ngo_donors`.`pe_bRetired`
            AND 
               YEAR(`ngo_donors`.`pe_dteOrigin`) = YEAR(CURDATE())
            AND 
               `ngo_lists_generic`.`lgen_lKeyID`=$id 
            AND
               MONTH(`ngo_donors`.`pe_dteOrigin`) = $month";
   $query = $this->db->query($sqlStr);
   foreach ($query->result() as $row) {
      $totalPeople = $row->attributedTotal;
   }

return $totalPeople;



}

public function giftAttributedTo($id,$month){
   $totalGifts = 0;
   $sqlStr =  "SELECT            
               SUM(`ngo_gifts`.`gi_curAmnt`) AS `attributedTotal`,
               MONTH(`ngo_gifts`.`gi_dteDonation`) AS `forMonth`,
               `ngo_lists_generic`.`lgen_strListItem` AS `attributedToName`
                        
            FROM
               `ngo_gifts` AS `ngo_gifts`,
               `ngo_lists_generic` AS `ngo_lists_generic`
            WHERE    
               `ngo_gifts`.`gi_lAttributedTo` = `ngo_lists_generic`.`lgen_lKeyID` 
            AND NOT 
               `ngo_gifts`.`gi_bRetired`
            AND 
               YEAR(`ngo_gifts`.`gi_dteDonation`) = YEAR(CURDATE())
            AND 
               `ngo_lists_generic`.`lgen_lKeyID`=$id 
            AND
               MONTH(`ngo_gifts`.`gi_dteDonation`) = $month
            GROUP BY MONTH(`ngo_gifts`.`gi_dteDonation`)";
   $query = $this->db->query($sqlStr);
   foreach ($query->result() as $row) {
      $totalGifts = $row->attributedTotal;
   }

return $totalGifts;



}












}

 