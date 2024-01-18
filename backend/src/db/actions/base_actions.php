<?php
    include_once dirname(__FILE__). '/../db_api.php';
    include_once dirname(__FILE__). '/../db_structure.php';
    include_once dirname(__FILE__). '/../db_response.php';

    class DBBaseActions {

        public static function insert($pdo, $table, $params = [], $tableStructure = null) {
            if ($tableStructure === null) {
                $tableStructure == DBStructure::getStructure();
            }

            if (!isset($tableStructure[$table])) {
                return DBResponse::error("The given table does not exists.");
            }

            $tableData = $tableStructure[$table];
            $fields = $tableData['fields'];
            $fieldsData = [];
            $fieldsNames = [];
            
            foreach($fields as $field => $fieldPararms) {
                if (!isset($params[$field])) {
                    return DBResponse::error("Field $field is not set");
                }
                $fieldsData[] = ["name" => $field, "value" => $params[$field], "type" =>  $fieldPararms['pdo_type']];
                $fieldsNames[] = $field;
            }

            $sql = "INSERT INTO $table (".implode(", ", $fieldsNames).") VALUES ( ".implode(", ", array_map(function($name) { return ":$name"; }, $fieldsNames))." );";

            $pdoParams = [];
            foreach($fieldsData as $fData) {
                $pdoParams[$fData['name']] = [$fData['value'], $fData['type']];
            }

            return DBAPI::execQueryAndGetInsertId($pdo, $sql, $pdoParams);
        }

    }
?>