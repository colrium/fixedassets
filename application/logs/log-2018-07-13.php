<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-07-13 15:55:11 --> Query error: Unknown column 'attachments.id' in 'field list' - Invalid query: SELECT attachments.id AS id, attachments.ismainimage AS ismainimage, IFNULL(fixedassets_assetlist.assetID, "") AS assetID, IFNULL(fixedassets_assetlist.assetCode, "") AS assetCode, IFNULL(fixedassets_assetlist.rfidTag, "") AS rfidTag, IFNULL(fixedassets_assetlist.assetItem, "") AS assetItem, IFNULL(fixedassets_assetlist.assetDesc, "") AS assetDesc, IFNULL(fixedassets_assetlist.serialNum, "") AS serialNum, IFNULL(fixedassets_assetlist.assetCat, "") AS assetCat, IFNULL(fixedassets_assetlist.assetPrimLoc, "") AS assetPrimLoc, IFNULL(fixedassets_assetlist.assetSecLoc, "") AS assetSecLoc, IFNULL(fixedassets_assetlist.assetTerLoc, "") AS assetTerLoc, IFNULL(fixedassets_assetlist.assetModel, "") AS assetModel, IFNULL(fixedassets_assetlist.assetBrand, "") AS assetBrand, IFNULL(fixedassets_assetlist.assetMnfctr, "") AS assetMnfctr, IFNULL(fixedassets_assetlist.assetSctn, "") AS assetSctn, IFNULL(fixedassets_assetlist.assignedTo, "") AS assignedTo, IFNULL(fixedassets_assetlist.asset_currency, "") AS asset_currency, IFNULL(fixedassets_assetlist.assetCost, "") AS assetCost, IFNULL(fixedassets_assetlist.assetCTax1, "") AS assetCTax1, IFNULL(fixedassets_assetlist.assetCTax2, "") AS assetCTax2, IFNULL(fixedassets_assetlist.totalCost, "") AS totalCost,  (CASE  fixedassets_assetlist.dtePurchased WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dtePurchased END) AS dtePurchased, IFNULL(fixedassets_assetlist.lpoNumber, "") AS lpoNumber, IFNULL(fixedassets_assetlist.assetValue, "") AS assetValue, IFNULL(fixedassets_assetlist.replCost, "") AS replCost, IFNULL(fixedassets_assetlist.acCode, "") AS acCode, IFNULL(fixedassets_assetlist.assetDealer, "") AS assetDealer, IFNULL(fixedassets_assetlist.quantity, "") AS quantity,  (CASE  fixedassets_assetlist.dtePutIntoService WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dtePutIntoService END) AS dtePutIntoService, IFNULL(fixedassets_assetlist.deprMethod, "") AS deprMethod, IFNULL(fixedassets_assetlist.percdepPA, "") AS percdepPA, IFNULL(fixedassets_assetlist.salvageVal, "") AS salvageVal, IFNULL(fixedassets_assetlist.assetLYears, "") AS assetLYears, IFNULL(fixedassets_assetlist.assetStatus, "") AS assetStatus, IFNULL(fixedassets_assetlist.auditStatus, "") AS auditStatus,  (CASE  fixedassets_assetlist.lasDteAudit WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, IFNULL(fixedassets_assetlist.lastAuditedBy, "") AS lastAuditedBy, IFNULL(fixedassets_assetlist.checkedIn, "") AS checkedIn,  (CASE  fixedassets_assetlist.dteCheckedin WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dteCheckedin END) AS dteCheckedin, IFNULL(fixedassets_assetlist.assetCondition, "") AS assetCondition, IFNULL(fixedassets_assetlist.checkedOut, "") AS checkedOut,  (CASE  fixedassets_assetlist.dtecheckedOut WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dtecheckedOut END) AS dtecheckedOut, IFNULL(fixedassets_assetlist.checkoutReason, "") AS checkoutReason,  (CASE  fixedassets_assetlist.dueDteCheckout WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dueDteCheckout END) AS dueDteCheckout, IFNULL(fixedassets_assetlist.checkedOutTo, "") AS checkedOutTo, IFNULL(fixedassets_assetlist.boughtFrom, "") AS boughtFrom, IFNULL(fixedassets_assetlist.bizUse, "") AS bizUse, IFNULL(fixedassets_assetlist.color, "") AS color, IFNULL(fixedassets_assetlist.currentValue, "") AS currentValue,  (CASE  fixedassets_assetlist.dteSold WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dteSold END) AS dteSold, IFNULL(fixedassets_assetlist.soldTo, "") AS soldTo, IFNULL(fixedassets_assetlist.askingPrice, "") AS askingPrice, IFNULL(fixedassets_assetlist.sellingPrice, "") AS sellingPrice, IFNULL(fixedassets_assetlist.profit, "") AS profit, IFNULL(fixedassets_assetlist.percProfit, "") AS percProfit, IFNULL(fixedassets_assetlist.taxable, "") AS taxable, IFNULL(fixedassets_assetlist.insured, "") AS insured,  (CASE  fixedassets_assetlist.dteWarrantyExp WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dteWarrantyExp END) AS dteWarrantyExp, IFNULL(fixedassets_assetlist.warrantyType, "") AS warrantyType, IFNULL(fixedassets_assetlist.numberMade, "") AS numberMade, IFNULL(fixedassets_assetlist.size, "") AS size, IFNULL(fixedassets_assetlist.madeOf, "") AS madeOf, IFNULL(fixedassets_assetlist.shape, "") AS shape, IFNULL(fixedassets_assetlist.year, "") AS year, IFNULL(fixedassets_assetlist.isDisposed, "") AS isDisposed,  (CASE  fixedassets_assetlist.dteDisposed WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dteDisposed END) AS dteDisposed, IFNULL(fixedassets_assetlist.disposalMethod, "") AS disposalMethod, IFNULL(fixedassets_assetlist.disposeReason, "") AS disposeReason, IFNULL(fixedassets_assetlist.disposalBookValue, "") AS disposalBookValue, IFNULL(fixedassets_assetlist.disposalLossProfit, "") AS disposalLossProfit,  (CASE  fixedassets_assetlist.insurancedteExp WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.insurancedteExp END) AS insurancedteExp, IFNULL(fixedassets_assetlist.insuredBy, "") AS insuredBy, IFNULL(fixedassets_assetlist.insurePolicy, "") AS insurePolicy,  (CASE  fixedassets_assetlist.leaseBegin WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.leaseBegin END) AS leaseBegin,  (CASE  fixedassets_assetlist.leaseEnd WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.leaseEnd END) AS leaseEnd, IFNULL(fixedassets_assetlist.leaseDesc, "") AS leaseDesc, IFNULL(fixedassets_assetlist.comments, "") AS comments, IFNULL(fixedassets_assetlist.userField1, "") AS userField1, IFNULL(fixedassets_assetlist.userField2, "") AS userField2, IFNULL(fixedassets_assetlist.userField3, "") AS userField3, IFNULL(fixedassets_assetlist.userField4, "") AS userField4, IFNULL(fixedassets_assetlist.userField5, "") AS userField5, IFNULL(fixedassets_assetlist.userField6, "") AS userField6, IFNULL(fixedassets_assetlist.userField7, "") AS userField7, IFNULL(fixedassets_assetlist.userField8, "") AS userField8, IFNULL(fixedassets_assetlist.userField9, "") AS userField9, IFNULL(fixedassets_assetlist.userField10, "") AS userField10, IFNULL(fixedassets_assetlist.userField11, "") AS userField11, IFNULL(fixedassets_assetlist.userField12, "") AS userField12, IFNULL(fixedassets_assetlist.userField13, "") AS userField13, IFNULL(fixedassets_assetlist.userField14, "") AS userField14, IFNULL(fixedassets_assetlist.userField15, "") AS userField15,  (CASE  fixedassets_assetlist.userDateField1 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField1 END) AS userDateField1,  (CASE  fixedassets_assetlist.userDateField2 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField2 END) AS userDateField2,  (CASE  fixedassets_assetlist.userDateField3 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField3 END) AS userDateField3,  (CASE  fixedassets_assetlist.userDateField4 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField4 END) AS userDateField4,  (CASE  fixedassets_assetlist.userDateField5 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField5 END) AS userDateField5, IFNULL(fixedassets_assetlist.userIntField1, "") AS userIntField1, IFNULL(fixedassets_assetlist.userIntField2, "") AS userIntField2, IFNULL(fixedassets_assetlist.userIntField3, "") AS userIntField3, IFNULL(fixedassets_assetlist.userIntField4, "") AS userIntField4, IFNULL(fixedassets_assetlist.userIntField5, "") AS userIntField5, IFNULL(fixedassets_assetlist.bRetired, "") AS bRetired FROM fixedassets_assetlist    LEFT JOIN attachments ON  fixedassets_assetlist.assetID = attachments.record  WHERE 1  AND attachments.entity = 'fixedassets_assetlist'  GROUP BY fixedassets_assetlist.assetID;
ERROR - 2018-07-13 16:25:18 --> Severity: Notice --> Array to string conversion C:\xampp\htdocs\modules\application\models\utilities\Mdbdata.php 592
ERROR - 2018-07-13 16:25:18 --> Query error: Unknown column 'fixedassets_assetlist.Array' in 'group statement' - Invalid query: SELECT attachments.ismainimage AS ismainimage, IFNULL(fixedassets_assetlist.assetID, "") AS assetID, IFNULL(fixedassets_assetlist.assetCode, "") AS assetCode, IFNULL(fixedassets_assetlist.rfidTag, "") AS rfidTag, IFNULL(fixedassets_assetlist.assetItem, "") AS assetItem, IFNULL(fixedassets_assetlist.assetDesc, "") AS assetDesc, IFNULL(fixedassets_assetlist.serialNum, "") AS serialNum, IFNULL(fixedassets_assetlist.assetCat, "") AS assetCat, IFNULL(fixedassets_assetlist.assetPrimLoc, "") AS assetPrimLoc, IFNULL(fixedassets_assetlist.assetSecLoc, "") AS assetSecLoc, IFNULL(fixedassets_assetlist.assetTerLoc, "") AS assetTerLoc, IFNULL(fixedassets_assetlist.assetModel, "") AS assetModel, IFNULL(fixedassets_assetlist.assetBrand, "") AS assetBrand, IFNULL(fixedassets_assetlist.assetMnfctr, "") AS assetMnfctr, IFNULL(fixedassets_assetlist.assetSctn, "") AS assetSctn, IFNULL(fixedassets_assetlist.assignedTo, "") AS assignedTo, IFNULL(fixedassets_assetlist.asset_currency, "") AS asset_currency, IFNULL(fixedassets_assetlist.assetCost, "") AS assetCost, IFNULL(fixedassets_assetlist.assetCTax1, "") AS assetCTax1, IFNULL(fixedassets_assetlist.assetCTax2, "") AS assetCTax2, IFNULL(fixedassets_assetlist.totalCost, "") AS totalCost,  (CASE  fixedassets_assetlist.dtePurchased WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dtePurchased END) AS dtePurchased, IFNULL(fixedassets_assetlist.lpoNumber, "") AS lpoNumber, IFNULL(fixedassets_assetlist.assetValue, "") AS assetValue, IFNULL(fixedassets_assetlist.replCost, "") AS replCost, IFNULL(fixedassets_assetlist.acCode, "") AS acCode, IFNULL(fixedassets_assetlist.assetDealer, "") AS assetDealer, IFNULL(fixedassets_assetlist.quantity, "") AS quantity,  (CASE  fixedassets_assetlist.dtePutIntoService WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dtePutIntoService END) AS dtePutIntoService, IFNULL(fixedassets_assetlist.deprMethod, "") AS deprMethod, IFNULL(fixedassets_assetlist.percdepPA, "") AS percdepPA, IFNULL(fixedassets_assetlist.salvageVal, "") AS salvageVal, IFNULL(fixedassets_assetlist.assetLYears, "") AS assetLYears, IFNULL(fixedassets_assetlist.assetStatus, "") AS assetStatus, IFNULL(fixedassets_assetlist.auditStatus, "") AS auditStatus,  (CASE  fixedassets_assetlist.lasDteAudit WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, IFNULL(fixedassets_assetlist.lastAuditedBy, "") AS lastAuditedBy, IFNULL(fixedassets_assetlist.checkedIn, "") AS checkedIn,  (CASE  fixedassets_assetlist.dteCheckedin WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dteCheckedin END) AS dteCheckedin, IFNULL(fixedassets_assetlist.assetCondition, "") AS assetCondition, IFNULL(fixedassets_assetlist.checkedOut, "") AS checkedOut,  (CASE  fixedassets_assetlist.dtecheckedOut WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dtecheckedOut END) AS dtecheckedOut, IFNULL(fixedassets_assetlist.checkoutReason, "") AS checkoutReason,  (CASE  fixedassets_assetlist.dueDteCheckout WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dueDteCheckout END) AS dueDteCheckout, IFNULL(fixedassets_assetlist.checkedOutTo, "") AS checkedOutTo, IFNULL(fixedassets_assetlist.boughtFrom, "") AS boughtFrom, IFNULL(fixedassets_assetlist.bizUse, "") AS bizUse, IFNULL(fixedassets_assetlist.color, "") AS color, IFNULL(fixedassets_assetlist.currentValue, "") AS currentValue,  (CASE  fixedassets_assetlist.dteSold WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dteSold END) AS dteSold, IFNULL(fixedassets_assetlist.soldTo, "") AS soldTo, IFNULL(fixedassets_assetlist.askingPrice, "") AS askingPrice, IFNULL(fixedassets_assetlist.sellingPrice, "") AS sellingPrice, IFNULL(fixedassets_assetlist.profit, "") AS profit, IFNULL(fixedassets_assetlist.percProfit, "") AS percProfit, IFNULL(fixedassets_assetlist.taxable, "") AS taxable, IFNULL(fixedassets_assetlist.insured, "") AS insured,  (CASE  fixedassets_assetlist.dteWarrantyExp WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dteWarrantyExp END) AS dteWarrantyExp, IFNULL(fixedassets_assetlist.warrantyType, "") AS warrantyType, IFNULL(fixedassets_assetlist.numberMade, "") AS numberMade, IFNULL(fixedassets_assetlist.size, "") AS size, IFNULL(fixedassets_assetlist.madeOf, "") AS madeOf, IFNULL(fixedassets_assetlist.shape, "") AS shape, IFNULL(fixedassets_assetlist.year, "") AS year, IFNULL(fixedassets_assetlist.isDisposed, "") AS isDisposed,  (CASE  fixedassets_assetlist.dteDisposed WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.dteDisposed END) AS dteDisposed, IFNULL(fixedassets_assetlist.disposalMethod, "") AS disposalMethod, IFNULL(fixedassets_assetlist.disposeReason, "") AS disposeReason, IFNULL(fixedassets_assetlist.disposalBookValue, "") AS disposalBookValue, IFNULL(fixedassets_assetlist.disposalLossProfit, "") AS disposalLossProfit,  (CASE  fixedassets_assetlist.insurancedteExp WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.insurancedteExp END) AS insurancedteExp, IFNULL(fixedassets_assetlist.insuredBy, "") AS insuredBy, IFNULL(fixedassets_assetlist.insurePolicy, "") AS insurePolicy,  (CASE  fixedassets_assetlist.leaseBegin WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.leaseBegin END) AS leaseBegin,  (CASE  fixedassets_assetlist.leaseEnd WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.leaseEnd END) AS leaseEnd, IFNULL(fixedassets_assetlist.leaseDesc, "") AS leaseDesc, IFNULL(fixedassets_assetlist.comments, "") AS comments, IFNULL(fixedassets_assetlist.userField1, "") AS userField1, IFNULL(fixedassets_assetlist.userField2, "") AS userField2, IFNULL(fixedassets_assetlist.userField3, "") AS userField3, IFNULL(fixedassets_assetlist.userField4, "") AS userField4, IFNULL(fixedassets_assetlist.userField5, "") AS userField5, IFNULL(fixedassets_assetlist.userField6, "") AS userField6, IFNULL(fixedassets_assetlist.userField7, "") AS userField7, IFNULL(fixedassets_assetlist.userField8, "") AS userField8, IFNULL(fixedassets_assetlist.userField9, "") AS userField9, IFNULL(fixedassets_assetlist.userField10, "") AS userField10, IFNULL(fixedassets_assetlist.userField11, "") AS userField11, IFNULL(fixedassets_assetlist.userField12, "") AS userField12, IFNULL(fixedassets_assetlist.userField13, "") AS userField13, IFNULL(fixedassets_assetlist.userField14, "") AS userField14, IFNULL(fixedassets_assetlist.userField15, "") AS userField15,  (CASE  fixedassets_assetlist.userDateField1 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField1 END) AS userDateField1,  (CASE  fixedassets_assetlist.userDateField2 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField2 END) AS userDateField2,  (CASE  fixedassets_assetlist.userDateField3 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField3 END) AS userDateField3,  (CASE  fixedassets_assetlist.userDateField4 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField4 END) AS userDateField4,  (CASE  fixedassets_assetlist.userDateField5 WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.userDateField5 END) AS userDateField5, IFNULL(fixedassets_assetlist.userIntField1, "") AS userIntField1, IFNULL(fixedassets_assetlist.userIntField2, "") AS userIntField2, IFNULL(fixedassets_assetlist.userIntField3, "") AS userIntField3, IFNULL(fixedassets_assetlist.userIntField4, "") AS userIntField4, IFNULL(fixedassets_assetlist.userIntField5, "") AS userIntField5, IFNULL(fixedassets_assetlist.bRetired, "") AS bRetired FROM fixedassets_assetlist    LEFT JOIN attachments ON  fixedassets_assetlist.assetID = attachments.record  WHERE 1  GROUP BY fixedassets_assetlist.Array;