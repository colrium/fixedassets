<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-08-29 19:55:44 --> Query error: Unknown column 'fixedassets_categories.catName' in 'where clause' - Invalid query: SELECT IFNULL(fixedassets_assetlist.assetID, "") AS assetID, IFNULL(fixedassets_assetlist.assetCode, "") AS assetCode, IFNULL(fixedassets_assetlist.rfidTag, "") AS rfidTag, IFNULL(fixedassets_assetlist.assetItem, "") AS assetItem, IFNULL(fixedassets_assetlist.assetDesc, "") AS assetDesc, IFNULL(fixedassets_assetlist.serialNum, "") AS serialNum, IFNULL(fixedassets_assetlist.assetCat, "") AS assetCat, IFNULL(fixedassets_assetlist.assetPrimLoc, "") AS assetPrimLoc, IFNULL(fixedassets_assetlist.assetSecLoc, "") AS assetSecLoc, IFNULL(fixedassets_assetlist.assetTerLoc, "") AS assetTerLoc, IFNULL(fixedassets_assetlist.assignedTo, "") AS assignedTo, IFNULL(fixedassets_assetlist.assetStatus, "") AS assetStatus, IFNULL(fixedassets_assetlist.auditStatus, "") AS auditStatus,  (CASE  fixedassets_assetlist.lasDteAudit WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, IFNULL(fixedassets_assetlist.assetCondition, "") AS assetCondition FROM fixedassets_assetlist   WHERE 1  AND fixedassets_assetlist.assetID LIKE '%00069%'  OR fixedassets_assetlist.assetCode LIKE '%00069%'  OR fixedassets_assetlist.rfidTag LIKE '%00069%'  OR fixedassets_assetlist.assetItem LIKE '%00069%'  OR fixedassets_assetlist.assetDesc LIKE '%00069%'  OR fixedassets_assetlist.serialNum LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_categories.catName) LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_primaryloc.primlocIdentifier) LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_secondaryloc.seclocIdentifier) LIKE '%00069%'  OR fixedassets_assetlist.assetTerLoc LIKE '%00069%'  OR CONCAT_WS(' ', employeelist.empName) LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_statuses.statusName) LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_audit_statuses.statusName) LIKE '%00069%'  OR fixedassets_assetlist.lasDteAudit LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_conditions.condName) LIKE '%00069%'  GROUP BY fixedassets_assetlist.assetID;
ERROR - 2018-08-29 20:08:53 --> Severity: Notice --> Undefined variable: arr C:\xampp\htdocs\modules\application\models\utilities\Mdbdata.php 491
ERROR - 2018-08-29 20:08:53 --> Severity: Warning --> array_keys() expects parameter 1 to be array, null given C:\xampp\htdocs\modules\application\helpers\data_helper.php 288
ERROR - 2018-08-29 20:08:53 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\modules\application\helpers\data_helper.php 288
ERROR - 2018-08-29 20:08:53 --> Query error: Unknown column 'fixedassets_categories.catName' in 'where clause' - Invalid query: SELECT IFNULL(fixedassets_assetlist.assetID, "") AS assetID, IFNULL(fixedassets_assetlist.assetCode, "") AS assetCode, IFNULL(fixedassets_assetlist.rfidTag, "") AS rfidTag, IFNULL(fixedassets_assetlist.assetItem, "") AS assetItem, IFNULL(fixedassets_assetlist.assetDesc, "") AS assetDesc, IFNULL(fixedassets_assetlist.serialNum, "") AS serialNum, IFNULL(fixedassets_assetlist.assetCat, "") AS assetCat, IFNULL(fixedassets_assetlist.assetPrimLoc, "") AS assetPrimLoc, IFNULL(fixedassets_assetlist.assetSecLoc, "") AS assetSecLoc, IFNULL(fixedassets_assetlist.assetTerLoc, "") AS assetTerLoc, IFNULL(fixedassets_assetlist.assignedTo, "") AS assignedTo, IFNULL(fixedassets_assetlist.assetStatus, "") AS assetStatus, IFNULL(fixedassets_assetlist.auditStatus, "") AS auditStatus,  (CASE  fixedassets_assetlist.lasDteAudit WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, IFNULL(fixedassets_assetlist.assetCondition, "") AS assetCondition FROM fixedassets_assetlist   WHERE 1  AND fixedassets_assetlist.assetID LIKE '%00069%'  OR fixedassets_assetlist.assetCode LIKE '%00069%'  OR fixedassets_assetlist.rfidTag LIKE '%00069%'  OR fixedassets_assetlist.assetItem LIKE '%00069%'  OR fixedassets_assetlist.assetDesc LIKE '%00069%'  OR fixedassets_assetlist.serialNum LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_categories.catName) LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_primaryloc.primlocIdentifier) LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_secondaryloc.seclocIdentifier) LIKE '%00069%'  OR fixedassets_assetlist.assetTerLoc LIKE '%00069%'  OR CONCAT_WS(' ', employeelist.empName) LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_statuses.statusName) LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_audit_statuses.statusName) LIKE '%00069%'  OR fixedassets_assetlist.lasDteAudit LIKE '%00069%'  OR CONCAT_WS(' ', fixedassets_conditions.condName) LIKE '%00069%'  GROUP BY fixedassets_assetlist.assetID;
ERROR - 2018-08-29 20:09:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '00069'%'  GROUP BY fixedassets_assetlist.assetID' at line 1 - Invalid query: SELECT IFNULL(fixedassets_assetlist.assetID, "") AS assetID, IFNULL(fixedassets_assetlist.assetCode, "") AS assetCode, IFNULL(fixedassets_assetlist.rfidTag, "") AS rfidTag, IFNULL(fixedassets_assetlist.assetItem, "") AS assetItem, IFNULL(fixedassets_assetlist.assetDesc, "") AS assetDesc, IFNULL(fixedassets_assetlist.serialNum, "") AS serialNum, IFNULL(fixedassets_assetlist.assetCat, "") AS assetCat, IFNULL(fixedassets_assetlist.assetPrimLoc, "") AS assetPrimLoc, IFNULL(fixedassets_assetlist.assetSecLoc, "") AS assetSecLoc, IFNULL(fixedassets_assetlist.assetTerLoc, "") AS assetTerLoc, IFNULL(fixedassets_assetlist.assignedTo, "") AS assignedTo, IFNULL(fixedassets_assetlist.assetStatus, "") AS assetStatus, IFNULL(fixedassets_assetlist.auditStatus, "") AS auditStatus,  (CASE  fixedassets_assetlist.lasDteAudit WHEN '0000-00-00' THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, IFNULL(fixedassets_assetlist.assetCondition, "") AS assetCondition FROM fixedassets_assetlist   WHERE 1  AND assetCode LIKE '%'00069'%'  GROUP BY fixedassets_assetlist.assetID;
ERROR - 2018-08-29 20:18:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'WHEN NULL THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, CO' at line 1 - Invalid query: SELECT IFNULL(fixedassets_assetlist.assetID, "") AS assetID, IFNULL(fixedassets_assetlist.assetCode, "") AS assetCode, IFNULL(fixedassets_assetlist.rfidTag, "") AS rfidTag, IFNULL(fixedassets_assetlist.assetItem, "") AS assetItem, IFNULL(fixedassets_assetlist.assetDesc, "") AS assetDesc, IFNULL(fixedassets_assetlist.serialNum, "") AS serialNum, CONCAT_WS(' ', fixedassets_categories.catName) AS assetCat, CONCAT_WS(' ', fixedassets_primaryloc.primlocIdentifier) AS assetPrimLoc, CONCAT_WS(' ', fixedassets_secondaryloc.seclocIdentifier) AS assetSecLoc, IFNULL(fixedassets_assetlist.assetTerLoc, "") AS assetTerLoc, CONCAT_WS(' ', employeelist.empName) AS assignedTo, CONCAT_WS(' ', fixedassets_statuses.statusName) AS assetStatus, CONCAT_WS(' ', fixedassets_audit_statuses.statusName) AS auditStatus,  (CASE  fixedassets_assetlist.lasDteAudit WHEN '0000-00-00' THEN '' ELSE WHEN NULL THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, CONCAT_WS(' ', fixedassets_conditions.condName) AS assetCondition FROM fixedassets_assetlist    LEFT JOIN fixedassets_categories ON  fixedassets_assetlist.assetCat = fixedassets_categories.catId LEFT JOIN fixedassets_primaryloc ON  fixedassets_assetlist.assetPrimLoc = fixedassets_primaryloc.primlocID LEFT JOIN fixedassets_secondaryloc ON  fixedassets_assetlist.assetSecLoc = fixedassets_secondaryloc.seclocID LEFT JOIN employeelist ON  fixedassets_assetlist.assignedTo = employeelist.empID LEFT JOIN fixedassets_statuses ON  fixedassets_assetlist.assetStatus = fixedassets_statuses.statusId LEFT JOIN fixedassets_audit_statuses ON  fixedassets_assetlist.auditStatus = fixedassets_audit_statuses.statusId LEFT JOIN fixedassets_conditions ON  fixedassets_assetlist.assetCondition = fixedassets_conditions.condId  WHERE 1  AND assignedTo LIKE '%C7M6K9nO5eY%' GROUP BY fixedassets_assetlist.assetID;
ERROR - 2018-08-29 20:19:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'WHEN 'NULL' THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, ' at line 1 - Invalid query: SELECT IFNULL(fixedassets_assetlist.assetID, "") AS assetID, IFNULL(fixedassets_assetlist.assetCode, "") AS assetCode, IFNULL(fixedassets_assetlist.rfidTag, "") AS rfidTag, IFNULL(fixedassets_assetlist.assetItem, "") AS assetItem, IFNULL(fixedassets_assetlist.assetDesc, "") AS assetDesc, IFNULL(fixedassets_assetlist.serialNum, "") AS serialNum, CONCAT_WS(' ', fixedassets_categories.catName) AS assetCat, CONCAT_WS(' ', fixedassets_primaryloc.primlocIdentifier) AS assetPrimLoc, CONCAT_WS(' ', fixedassets_secondaryloc.seclocIdentifier) AS assetSecLoc, IFNULL(fixedassets_assetlist.assetTerLoc, "") AS assetTerLoc, CONCAT_WS(' ', employeelist.empName) AS assignedTo, CONCAT_WS(' ', fixedassets_statuses.statusName) AS assetStatus, CONCAT_WS(' ', fixedassets_audit_statuses.statusName) AS auditStatus,  (CASE  fixedassets_assetlist.lasDteAudit WHEN '0000-00-00' THEN '' ELSE WHEN 'NULL' THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, CONCAT_WS(' ', fixedassets_conditions.condName) AS assetCondition FROM fixedassets_assetlist    LEFT JOIN fixedassets_categories ON  fixedassets_assetlist.assetCat = fixedassets_categories.catId LEFT JOIN fixedassets_primaryloc ON  fixedassets_assetlist.assetPrimLoc = fixedassets_primaryloc.primlocID LEFT JOIN fixedassets_secondaryloc ON  fixedassets_assetlist.assetSecLoc = fixedassets_secondaryloc.seclocID LEFT JOIN employeelist ON  fixedassets_assetlist.assignedTo = employeelist.empID LEFT JOIN fixedassets_statuses ON  fixedassets_assetlist.assetStatus = fixedassets_statuses.statusId LEFT JOIN fixedassets_audit_statuses ON  fixedassets_assetlist.auditStatus = fixedassets_audit_statuses.statusId LEFT JOIN fixedassets_conditions ON  fixedassets_assetlist.assetCondition = fixedassets_conditions.condId  WHERE 1  AND assignedTo LIKE '%C7M6K9nO5eY%' GROUP BY fixedassets_assetlist.assetID;
ERROR - 2018-08-29 20:19:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'WHEN 'null' THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, ' at line 1 - Invalid query: SELECT IFNULL(fixedassets_assetlist.assetID, "") AS assetID, IFNULL(fixedassets_assetlist.assetCode, "") AS assetCode, IFNULL(fixedassets_assetlist.rfidTag, "") AS rfidTag, IFNULL(fixedassets_assetlist.assetItem, "") AS assetItem, IFNULL(fixedassets_assetlist.assetDesc, "") AS assetDesc, IFNULL(fixedassets_assetlist.serialNum, "") AS serialNum, CONCAT_WS(' ', fixedassets_categories.catName) AS assetCat, CONCAT_WS(' ', fixedassets_primaryloc.primlocIdentifier) AS assetPrimLoc, CONCAT_WS(' ', fixedassets_secondaryloc.seclocIdentifier) AS assetSecLoc, IFNULL(fixedassets_assetlist.assetTerLoc, "") AS assetTerLoc, CONCAT_WS(' ', employeelist.empName) AS assignedTo, CONCAT_WS(' ', fixedassets_statuses.statusName) AS assetStatus, CONCAT_WS(' ', fixedassets_audit_statuses.statusName) AS auditStatus,  (CASE  fixedassets_assetlist.lasDteAudit WHEN '0000-00-00' THEN '' ELSE WHEN 'null' THEN '' ELSE fixedassets_assetlist.lasDteAudit END) AS lasDteAudit, CONCAT_WS(' ', fixedassets_conditions.condName) AS assetCondition FROM fixedassets_assetlist    LEFT JOIN fixedassets_categories ON  fixedassets_assetlist.assetCat = fixedassets_categories.catId LEFT JOIN fixedassets_primaryloc ON  fixedassets_assetlist.assetPrimLoc = fixedassets_primaryloc.primlocID LEFT JOIN fixedassets_secondaryloc ON  fixedassets_assetlist.assetSecLoc = fixedassets_secondaryloc.seclocID LEFT JOIN employeelist ON  fixedassets_assetlist.assignedTo = employeelist.empID LEFT JOIN fixedassets_statuses ON  fixedassets_assetlist.assetStatus = fixedassets_statuses.statusId LEFT JOIN fixedassets_audit_statuses ON  fixedassets_assetlist.auditStatus = fixedassets_audit_statuses.statusId LEFT JOIN fixedassets_conditions ON  fixedassets_assetlist.assetCondition = fixedassets_conditions.condId  WHERE 1  AND assignedTo LIKE '%C7M6K9nO5eY%' GROUP BY fixedassets_assetlist.assetID;
