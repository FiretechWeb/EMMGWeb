<?php
    include_once dirname(__FILE__). '/../db_api.php';
    include_once dirname(__FILE__). '/../db_structure.php';
    include_once dirname(__FILE__). '/../db_response.php';

    class DBBaseActions {

        public static function update($pdo, $table, $params = [], $tableStructure = null) {
            if ($tableStructure === null) {
                $tableStructure == DBStructure::getStructure();
            }

            if (!isset($tableStructure[$table])) {
                return DBResponse::error("The given table does not exists.");
            }
            
            $tableData = $tableStructure[$table];
            $fields = $tableData['fields'];
        }

        public static function get($pdo, $table, $params = [], $tableStructure = null) {
            if ($tableStructure === null) {
                $tableStructure == DBStructure::getStructure();
            }

            if (!isset($tableStructure[$table])) {
                return DBResponse::error("The given table does not exists.");
            }

            $tableData = $tableStructure[$table];
            $fields = $tableData['fields'];
            $filterFields = [];
            $filtersColumn = [];

            foreach($fields as $field => $fieldPararms) {
                if (isset($params[$field])) {
                    $filterFields[] = ["name" => $field, "value" => $params[$field], "type" =>  $fieldPararms['pdo_type']];
                    $filtersColumn[] = "$field = :$field";
                }
            }

            $sql = "SELECT * FROM $table";
            if (!empty($filtersColumn)) {
                $sql.= " WHERE ";
                $sql.= implode(" AND ", $filtersColumn)." ;";
            }

            $pdoParams = [];
            foreach($filterFields as $fData) {
                $pdoParams[$fData['name']] = [$fData['value'], $fData['type']];
            }

            return DBAPI::execQueryAndGetRows($pdo, $sql, $pdoParams);
        }

        public static function insert($pdo, $table, $params = [], $tableStructure = null) {
            if ($tableStructure === null) {
                $tableStructure == DBStructure::getStructure();
            }

            if (!isset($tableStructure[$table])) {
                return DBResponse::error("The given table does not exists.");
            }

            $tableData = $tableStructure[$table];
            $fields = array_filter($tableData['fields'], function($field) {
                return $field['allow_insert'];
            });

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