<?php
    include_once 'db_response.php';
    include_once dirname(__FILE__).'/../config/def.php';

    class DBAPI {
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
                return DBResponse::error("No rows were updated.");
            }
        }
    }
?>