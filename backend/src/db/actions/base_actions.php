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

        public static function duplicated($pdo, $table, $params = [], $tableStructure = null) {
            if ($tableStructure === null) {
                $tableStructure == DBStructure::getStructure();
            }

            if (!isset($tableStructure[$table])) {
                return DBResponse::error("The given table does not exists.");
            }

            if (!isset($params['fields'])) {
                return DBResponse::error("No fields to check duplicated given.");
            }

            $tableData = $tableStructure[$table];
            $fields = $tableData['fields'];
            $fieldData = $params['fields'];
            $primaryKeys = [];
            if (isset($params['keys'])) {
                $primaryKeys = $params['keys'];
            }
            $conditionColumns = [];
            $primaryConditions = [];
            $preparedStatements = [];
            $i = 0;

            foreach ($primaryKeys as $key => $keyValue) {
                if (isset($fields[$key]) && $fields[$key]['primary']) {
                    $primaryConditions[] = "$key <> :result_$i";
                    $preparedStatements[] = ["name" => "result_$i", "value" => $keyValue, "type" =>  $fields[$key]['pdo_type']];
                    $i++;
                }
            }
            foreach($fields as $field => $fieldParams) {
                if (isset($fieldData[$field])) {
                    if ($fieldParams['unique']) {
                        if ($fieldParams['sql_type'] == "DATE") {
                            $fieldData[$field] = (new DateTime($fieldData[$field]))->format('Y-m-d');
                        }

                        $preparedValue = $fieldData[$field];
                        if (strpos($fieldParams['sql_type'], "DECIMAL") !== false) {
                            $preparedValue = strval($preparedValue);
                        }

                        $conditionColumns[] = "$field = :result_$i";
                        $preparedStatements[] = ["name" => "result_$i", "value" => $preparedValue, "type" =>  $fieldParams['pdo_type']];
                        $i++;
                    }
                }
            }

            if (empty($conditionColumns)) {
                return DBResponse::ok(false);
            }

            $sql = "SELECT * FROM $table WHERE ";
            if (!empty($primaryConditions)) {
                $sql.= "( ".implode(" AND ", $primaryConditions)." ) AND ( " .implode(" OR ", $conditionColumns). " );";
            } else {
                $sql .= implode(" OR ", $conditionColumns)." ;";
            }
            $pdoParams = [];
            foreach($preparedStatements as $ps) {
                $pdoParams[$ps['name']] = [$ps['value'], $ps['type']];
            }

            return DBAPI::execQueryAndCheckExists($pdo, $sql, $pdoParams);
        }

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
            $primaryKeys = [];
            if (isset($params['keys'])) {
                $primaryKeys = $params['keys'];
            }
            $conditionColumns = [];
            $preparedStatements = [];
            $i = 0;
            
            foreach ($primaryKeys as $key => $keyValue) {
                if (isset($fields[$key]) && $fields[$key]['primary']) {
                    $conditionColumns[] = "$key = :result_$i";
                    $preparedStatements[] = ["name" => "result_$i", "value" => $keyValue, "type" =>  $fields[$key]['pdo_type']];
                    $i++;
                }
            }
            foreach($conditions as $conditionData) {
                if (isset($fields[$conditionData['field']])) {
                    $fieldName = $conditionData['field'];
                    $conditionName = $conditionData['condition'];
                    $result = $conditionData['result'];
                    $fieldParams =  $fields[$fieldName];

                    if (!isValidCondition($conditionName)) {
                        return DBResponse::error("Invalid conditional statement");
                    }

                    if (strpos($fieldParams['sql_type'], "DECIMAL") !== false) {
                        $result = strval($result);
                    }

                    $conditionColumns[] = "$fieldName $conditionName :result_$i";
                    $preparedStatements[] = ["name" => "result_$i", "value" => $result, "type" =>  $fieldParams['pdo_type']];
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

            if (!isset($params['fields'])) {
                return DBResponse::error("No fields to update given.");
            }

            $duplicatedRes = DBAPI::execAction($pdo, $table, 'duplicated', $params, $tableStructure);
            
            if (DBResponse::isERROR($duplicatedRes)) {
                return $duplicatedRes;
            }
            if (DBResponse::getData($duplicatedRes)) {
                return DBResponse::error("Duplicated already exists");
            }
            
            $tableData = $tableStructure[$table];
            $fields = $tableData['fields'];
            $fieldsAllowedToSet = array_filter($tableData['fields'], function($field) {
                return $field['allow_insert'];
            });

            $fieldData = $params['fields'];
            $conditions = $params['conditions'];
            $primaryKeys = [];
            if (isset($params['keys'])) {
                $primaryKeys = $params['keys'];
            }
            $preparedStatements = [];
            $setColumns = [];
            $conditionColumns = [];
            $uniqueFields = [];
            $i = 0;

            foreach($fieldsAllowedToSet as $field => $fieldParams) {
                if (isset($fieldData[$field])) {
                    if ($fieldParams['sql_type'] == "DATE") {
                        $fieldData[$field] = (new DateTime($fieldData[$field]))->format('Y-m-d');
                    }

                    if ($fieldParams['unique']) {
                        $uniqueFields[] = $field;
                    }

                    $preparedValue = $fieldData[$field];
                    if (strpos($fieldParams['sql_type'], "DECIMAL") !== false) {
                        $preparedValue = strval($preparedValue);
                    }

                    $preparedStatements[] = ["name" => $field, "value" => $preparedValue, "type" =>  $fieldParams['pdo_type']];
                    $setColumns[] = "$field = :$field";
                }
            }

            if (empty($setColumns)) {
                return DBResponse::error("There are no columns to update.");
            }

            foreach ($primaryKeys as $key => $keyValue) {
                if (isset($fields[$key]) && $fields[$key]['primary']) {
                    $conditionColumns[] = "$key = :result_$i";
                    $preparedStatements[] = ["name" => "result_$i", "value" => $keyValue, "type" =>  $fields[$key]['pdo_type']];
                    $i++;
                }
            }

            foreach($conditions as $conditionData) {
                if (isset($fields[$conditionData['field']])) {
                    $fieldName = $conditionData['field'];
                    $conditionName = $conditionData['condition'];
                    $result = $conditionData['result'];
                    $fieldParams =  $fields[$fieldName];

                    if (!isValidCondition($conditionName)) {
                        return DBResponse::error("Invalid conditional statement");
                    }

                    if (strpos($fieldParams['sql_type'], "DECIMAL") !== false) {
                        $result = strval($result);
                    }

                    $conditionColumns[] = "$fieldName $conditionName :result_$i";
                    $preparedStatements[] = ["name" => "result_$i", "value" => $result, "type" =>  $fieldParams['pdo_type']];
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
            $relatedColumns = [];
            $i = 0;
            if (isset($params['related_data']) && $params['related_data']) {
                foreach($fields as $fieldName => $fieldParams) {
                    if ($fieldParams['foreign_key'] !== null) {
                        $foreingKeyData = $fieldParams['foreign_key'];
                        $relatedColumns[] = "JOIN {$foreingKeyData['table']} ON {$foreingKeyData['table']}.{$foreingKeyData['field']} = {$table}.{$fieldName}";
                    }
                }
            }
            foreach($conditions as $conditionData) {
                if (isset($fields[$conditionData['field']])) {
                    $fieldName = $conditionData['field'];
                    $conditionName = $conditionData['condition'];
                    $result = $conditionData['result'];
                    $fieldParams =  $fields[$fieldName];

                    if (!isValidCondition($conditionName)) {
                        return DBResponse::error("Invalid conditional statement");
                    }

                    if (strpos($fieldParams['sql_type'], "DECIMAL") !== false) {
                        $result = strval($result);
                    }

                    $conditionColumns[] = "$fieldName $conditionName :result_$i";
                    $preparedStatements[] = ["name" => "result_$i", "value" => $result, "type" =>  $fieldParams['pdo_type']];
                    $i++;
                }
            }

            $sql = "";
            if (!empty($relatedColumns)) {
                $tableFieldNames = [];
                foreach($fields as $fieldName => $fieldParams) {
                    $tableFieldNames[] = "$table.$fieldName AS $table"."_"."$fieldName";
                    if ($fieldParams['foreign_key'] !== null) {
                        $foreingKeyData = $fieldParams['foreign_key'];
                        $foreignTable = $foreingKeyData['table'];
                        $foreignTableData = $tableStructure[$foreignTable];
                        $foreignFields = $foreignTableData['fields'];
                        foreach($foreignFields as $foreignFieldName => $data) {
                            $tableFieldNames[] = "$foreignTable.$foreignFieldName AS $foreignTable"."_"."$foreignFieldName";
                        }
                    }
                }

                $sql = "SELECT ".implode(", ", $tableFieldNames)." FROM $table";
                $sql.= " ".implode(" ", $relatedColumns)." ";
            } else {
                $sql = "SELECT * FROM $table";
            }
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

            $duplicatedRes = DBAPI::execAction($pdo, $table, 'duplicated', $params, $tableStructure);
            
            if (DBResponse::isERROR($duplicatedRes)) {
                return $duplicatedRes;
            }
            if (DBResponse::getData($duplicatedRes)) {
                return DBResponse::error("Duplicated already exists");
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
                    if (!$fields[$field]['not_null']) {
                        continue;
                    }
                    return DBResponse::error("Field $field is not set");
                }
                if ($fieldParams['sql_type'] == "DATE") {
                    $fieldData[$field] = (new DateTime($fieldData[$field]))->format('Y-m-d');
                }
                $preparedValue = $fieldData[$field];
                if (strpos($fieldParams['sql_type'], "DECIMAL") !== false) {
                    $preparedValue = strval($preparedValue);
                }

                $fieldsData[] = ["name" => $field, "value" => $preparedValue, "type" =>  $fieldParams['pdo_type']];
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