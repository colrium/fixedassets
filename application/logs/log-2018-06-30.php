<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-06-30 03:05:43 --> Severity: error --> Exception: syntax error, unexpected '$value' (T_VARIABLE) E:\WORKSPACE\PHP\www\modules\application\models\utilities\Mdbdata.php 323
ERROR - 2018-06-30 03:10:38 --> Severity: error --> Exception: syntax error, unexpected '") AS "' (T_CONSTANT_ENCAPSED_STRING) E:\WORKSPACE\PHP\www\modules\application\models\utilities\Mdbdata.php 323
ERROR - 2018-06-30 03:12:30 --> Severity: error --> Exception: syntax error, unexpected '", "' (T_CONSTANT_ENCAPSED_STRING) E:\WORKSPACE\PHP\www\modules\application\models\utilities\Mdbdata.php 323
ERROR - 2018-06-30 03:12:46 --> Severity: error --> Exception: syntax error, unexpected '")"' (T_CONSTANT_ENCAPSED_STRING) E:\WORKSPACE\PHP\www\modules\application\models\utilities\Mdbdata.php 323
ERROR - 2018-06-30 03:13:38 --> Query error: Incorrect parameters in the call to native function 'IFNULL' - Invalid query: SELECT IFNULL(reports.id AS id, ""), IFNULL(reports.name AS name, ""), IFNULL(reports.description AS description, ""), IFNULL(reports.icon AS icon, ""), IFNULL(reports.module AS module, ""), IFNULL(reports.entity AS entity, ""), IFNULL(reports.fields AS fields, ""), IFNULL(reports.filters AS filters, ""), IFNULL(reports.private AS private, ""), CONCAT_WS(' ', users.username) AS user FROM reports    LEFT JOIN users ON  reports.user = users.id  WHERE 1  AND reports.module = 'system'  AND reports.private = '1'  AND reports.user = 'iJr5CJQChnT'  GROUP BY reports.id;