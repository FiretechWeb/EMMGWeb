<?php
    include_once 'db_response.php';
    include_once dirname(__FILE__).'/../config/def.php';

    class DBAPI {

        public static function generateTablesFromStructure($conn, $tableStructure) {
            $tables = [];
            foreach ($tableStructure as $tableName => $data) {
                $fields = $data['fields'];
                $columns = [];
                $primary_keys = [];
                $foreign_keys = [];
                $tableDefinition = "CREATE TABLE IF NOT EXISTS $tableName (";
                foreach ($fields as $fieldName => $params) {
                    $columnDefinition = "$fieldName {$params['sql_type']} ";
                    if ($params['not_null'] === true) {
                        $columnDefinition .= "NOT NULL ";
                    }
                    $columnDefinition .= "{$params['extra_params']}";
                    $columns[] = $columnDefinition;

                    if ($params['primary']) {
                        $primary_keys[] = $fieldName;
                    }

                    if ($params['foreign_key'] !== null) {
                        $foreingKeyData = $params['foreign_key'];
                        $foreign_keys[] = $foreingKeyData;
                        $columns[] = "FOREIGN KEY ($fieldName) REFERENCES {$foreingKeyData['table']}({$foreingKeyData['field']})";
                    }
                }

                if (!empty($primary_keys)) {
                    $columns[] = "PRIMARY KEY (".implode(", ", $primary_keys).")";
                }
                $tableDefinition .= implode(", ", $columns);
                $tableDefinition .= ")";
                if (!empty($foreign_keys)) {
                    $tableDefinition .= " ENGINE=InnoDB";
                }
                $tables[] = $tableDefinition;
            }
            foreach ($tables as $tableSQL) {
                if (!mysqli_query($conn, $tableSQL)) {
                    return false;
                }
            }
            return true;
        }

        public static function dropDB($conn, $dbName) {
            $sql = "DROP DATABASE IF EXISTS $dbName";
            return mysqli_query($conn, $sql);
        }

        public static function createDB($conn, $dbName) {
            $sql = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            return mysqli_query($conn, $sql);
        }

        public static function checkAndGetPOSTfromJSON() {
            $decodedData = null;
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $jsonData = file_get_contents("php://input");
                $decodedData = json_decode($jsonData, true);

                if ($decodedData === null) {
                    return DBResponse::error("Invalid json data");
                }
                if (!isset($decodedData['action'])) {
                    return DBResponse::error("Action was not send");
                }
                if (!isset($decodedData['table'])) {
                    return DBResponse::error("table was not send");
                }
            } else {
                return DBResponse::error("Invalid method");
            }
            return DBResponse::ok($decodedData);
        }

        public static function startPDO() {
            $pdo = null;
            try {
                $DB = DBStructure::$DB_NAME;
                $URL = Config::$HOST_URL;
                $USER = Config::$HOST_USER;
                $PASS = Config::$HOST_PASSWORD;
                $pdo = new PDO("mysql:host=$URL;dbname=$DB", $USER, $PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                return DBResponse::error($e->getMessage());
            }
            if ($pdo === null) {
                return DBResponse::error("Failed to create PDO");
            }
            return DBResponse::ok($pdo);
        }

        public static function executeQuery($pdo, $sql, $params = []) {
            try {
                $stmt = $pdo->prepare($sql);
                foreach ($params as $param => $value) {
                    $stmt->bindParam($param, $value[0], $value[1]);
                }
                if ($stmt->execute()) {
                    $rows = [];
                    try { //XXX: Try catch inside another try catch can't be good...
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (Exception $ie) {
                        $rows = [];
                    }
                    return DBResponse::ok([
                        'row_count' => $stmt->rowCount(),
                        'rows' => $rows,
                        'lastInsertId' => $pdo->lastInsertId()
                    ]);
                } else {
                    return DBResponse::error("SQL ERROR in executeCountQuery");
                }
            } catch (Exception $e) {
                return DBResponse::error($e->getMessage());
            }
        }
        public static function execQueryAndGetRows($pdo, $sql, $params) {
            $res = self::executeQuery($pdo, $sql, $params);
            if (DBResponse::isERROR($res)) {
                return $res;
            }
            $rows = DBResponse::getData($res)['rows'];
            return DBResponse::ok($rows);
        }

        public static function execQueryAndCheckExists($pdo, $sql, $params) {
            $res = self::executeQuery($pdo, $sql, $params);
            if (DBResponse::isERROR($res)) {
                return $res;
            }

            $rowCount = DBResponse::getData($res)['row_count'];
            if ($rowCount  > 0) {
                return DBResponse::ok(true);
            } else {
                return DBResponse::ok(false);
            }
        }
        
        public static function execQueryAndGetInsertId($pdo, $sql, $params) {
            $res = self::executeQuery($pdo, $sql, $params);
            if (DBResponse::isERROR($res)) {
                return $res;
            }
            $lastInsertId = DBResponse::getData($res)['lastInsertId'];
            if ($lastInsertId !== false) {
                return DBResponse::ok($lastInsertId);
            } else {
                return DBResponse::error("there was not inserted id");
            }
        }

        public static function execQueryAndGetRowsAffected($pdo, $sql, $params) {
            $res = self::executeQuery($pdo, $sql, $params);
            if (DBResponse::isERROR($res)) {
                return $res;
            }
            $rowsAffected = DBResponse::getData($res)['row_count'];
            if ($rowsAffected > 0) {
                return DBResponse::ok($rowsAffected);
            } else {
                return DBResponse::error("No rows were affected.");
            }
        }

        public static function execAction($pdo, $tableName, $action, $params, $tableStructure) {
            if (!isset($tableStructure[$tableName])) {
                return DBResponse::error("Invalid table."); 
            }
            $tableData = $tableStructure[$tableName];
            $tableActions = $tableData['actions'];

            foreach($tableActions as $currentAction => $callbackData) {
                if ($action == $currentAction) {
                    return call_user_func_array($callbackData, [$pdo, $tableName, $params, $tableStructure]);
                }
            }
            
            return DBResponse::error("Invalid action."); 
        }
    }
?>