<?php
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    include_once dirname(__FILE__). '/../db_api.php';
    include_once dirname(__FILE__). '/../db_structure.php';
    include_once dirname(__FILE__). '/../db_response.php';

    /*
    * Format of action params received from FrontEnd
    * {
    *  'fields': { 'fieldName': value, ...},
    *  'conditions': [{'field': field, 'condition': conditionString, 'result': result}, ...]
    * } 
    */

    class DBAPILiquidacion {
        public static function calcularLiquidacion($pdo, $table, $params = [], $tableStructure = null) {
            if ($tableStructure === null) {
                $tableStructure == DBStructure::getStructure();
            }
            if (!isset($tableStructure[$table])) {
                return DBResponse::error("The given table does not exists.");
            }

            //Step 1: Get all data needed
            $getRes = DBAPI::execAction($pdo, $table, 'get', $params, $tableStructure);
            if (DBResponse::isERROR($getRes)) {
                return $getRes;
            }
            $reciboData = DBResponse::getData($getRes);
            return DBResponse::ok($reciboData);
        }
    }
?>