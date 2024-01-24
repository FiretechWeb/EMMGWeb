<?php
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    include_once dirname(__FILE__). '/../db_api.php';
    include_once dirname(__FILE__). '/../db_structure.php';
    include_once dirname(__FILE__). '/../db_response.php';

    function isValidCondition($condString) {
        return in_array($condString, ["LIKE", "=", ">", "<", "<>"]);
    }

    /*
    * Format of action params received from FrontEnd
    * {
    *  'fields': { 'fieldName': value, ...},
    *  'conditions': [{'field': field, 'condition': conditionString, 'result': result}, ...]
    * } 
    */

    class DBBaseActions {

        public static function delete($pdo, $table, $params = [], $tableStructure = null) {
            if ($tableStructure === null) {
                $tableStructure == DBStructure::getStructure();
            }

            if (!isset($tableStructure[$table])) {
                return DBResponse::error("The given table does not exists.");
            }

            $tableData = $tableStructure[$table];
            $fields = $tableData['fields'];
            $conditions = $params['conditions'];
            $conditionColumns = [];
            $preparedStatements = [];
            $i = 0;
            
            foreach($conditions as $conditionData) {
                if (isset($fields[$conditionData['field']])) {
                    $fieldName = $conditionData['field'];
                    $conditionName = $conditionData['condition'];
                    $result = $conditionData['result'];
                    $fieldPararms =  $fields[$fieldName];

                    if (!isValidCondition($conditionName)) {
                        return DBResponse::error("Invalid conditional statement");
                    }

                    $conditionColumns[] = "$fieldName $conditionName :result_$i";
                    $preparedStatements[] = ["name" => "result_$i", "value" => $result, "type" =>  $fieldPararms['pdo_type']];
                    $i++;
                }
            }
            if (empty($conditionColumns)) {
                return DBResponse::error("For security reasons, you can only delete with a condition.");
            }
            $sql = "DELETE FROM $table WHERE ".implode(" AND ", $conditionColumns)." ;";

            $pdoParams = [];
            foreach($preparedStatements as $ps) {
                $pdoParams[$ps['name']] = [$ps['value'], $ps['type']];
            }

            return DBAPI::execQueryAndGetRowsAffected($pdo, $sql, $pdoParams);
        }

        public static function update($pdo, $table, $params = [], $tableStructure = null) {
            if ($tableStructure === null) {
                $tableStructure == DBStructure::getStructure();
            }

            if (!isset($tableStructure[$table])) {
                return DBResponse::error("The given table does not exists.");
            }

            $tableData = $tableStructure[$table];
            $fields = $tableData['fields'];
            $fieldsAllowedToSet = array_filter($tableData['fields'], function($field) {
                return $field['allow_insert'];
            });

            $fieldData = $params['fields'];
            $conditions = $params['conditions'];
            $preparedStatements = [];
            $setColumns = [];
            $conditionColumns = [];
            $i = 0;

            foreach($fieldsAllowedToSet as $field => $fieldParams) {
                if (isset($fieldData[$field])) {
                    if ($fieldParams['sql_type'] == "DATE") {
                        $fieldData[$field] = (new DateTime($fieldData[$field]))->format('Y-m-d');
                    }
                    $preparedStatements[] = ["name" => $field, "value" => $fieldData[$field], "type" =>  $fieldParams['pdo_type']];
                    $setColumns[] = "$field = :$field";
                }
            }

            if (empty($setColumns)) {
                return DBResponse::error("There are no columns to update.");
            }

            foreach($conditions as $conditionData) {
                if (isset($fields[$conditionData['field']])) {
                    $fieldName = $conditionData['field'];
                    $conditionName = $conditionData['condition'];
                    $result = $conditionData['result'];
                    $fieldPararms =  $fields[$fieldName];

                    if (!isValidCondition($conditionName)) {
                        return DBResponse::error("Invalid conditional statement");
                    }

                    $conditionColumns[] = "$fieldName $conditionName :result_$i";
                    $preparedStatements[] = ["name" => "result_$i", "value" => $result, "type" =>  $fieldPararms['pdo_type']];
                    $i++;
                }
            }
            
            if (empty($conditionColumns)) {
                return DBResponse::error("For security reasons, you can only update with a condition.");
            }

            $sql = "UPDATE $table SET ".implode(" , ", $setColumns)." WHERE ".implode(" AND ", $conditionColumns);

            $pdoParams = [];
            foreach($preparedStatements as $ps) {
                $pdoParams[$ps['name']] = [$ps['value'], $ps['type']];
            }

            return DBAPI::execQueryAndGetRowsAffected($pdo, $sql, $pdoParams);
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
            $conditions = $params['conditions'];
            $conditionColumns = [];
            $preparedStatements = [];
            $i = 0;
            
            foreach($conditions as $conditionData) {
                if (isset($fields[$conditionData['field']])) {
                    $fieldName = $conditionData['field'];
                    $conditionName = $conditionData['condition'];
                    $result = $conditionData['result'];
                    $fieldPararms =  $fields[$fieldName];

                    if (!isValidCondition($conditionName)) {
                        return DBResponse::error("Invalid conditional statement");
                    }

                    $conditionColumns[] = "$fieldName $conditionName :result_$i";
                    $preparedStatements[] = ["name" => "result_$i", "value" => $result, "type" =>  $fieldPararms['pdo_type']];
                    $i++;
                }
            }

            $sql = "SELECT * FROM $table";
            if (!empty($conditionColumns)) {
                $sql.= " WHERE ";
                $sql.= implode(" AND ", $conditionColumns)." ;";
            }

            $pdoParams = [];
            foreach($preparedStatements as $ps) {
                $pdoParams[$ps['name']] = [$ps['value'], $ps['type']];
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
            if (!isset($params['fields'])) {
                return DBResponse::error("No fields to insert given.");
            }

            $tableData = $tableStructure[$table];
            $fields = array_filter($tableData['fields'], function($field) {
                return $field['allow_insert'];
            });

            $fieldData = $params['fields'];
            $fieldsData = [];
            $fieldsNames = [];

            foreach($fields as $field => $fieldParams) {
                if (!isset($fieldData[$field])) {
                    return DBResponse::error("Field $field is not set");
                }
                if ($fieldParams['sql_type'] == "DATE") {
                    $fieldData[$field] = (new DateTime($fieldData[$field]))->format('Y-m-d');
                }
                $fieldsData[] = ["name" => $field, "value" => $fieldData[$field], "type" =>  $fieldParams['pdo_type']];
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