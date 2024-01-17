<?php
    include_once 'db_structure.php';
    include_once '../lib/json_utils.php';

    class DBAPI {
        private $pdo = null;
        private $db_tables = null;

        public static function responseIsERROR($data)
        {
            if (!isset($data['data']) || !isset($data['res'])) {
                return true;
            }
            if ($data['res'] !== 'error') {
                return false;
            }

            return true;
        }
        public static function responseIsTRUE($data) {
            if (!isset($data['data']) || !isset($data['res'])) {
                return false;
            } 
            if ($data['res'] !== 'ok') {
                return false;
            }

            return ($data['data'] == true);
        }
        public static function ok($data) { 
            return array(
                "res" => "ok",
                "data" => $data
            );
        }
        public static function error($data) { 
            return array(
                "res" => "error",
                "data" => $data
            );
        }
        public static function responseToJSON($response) {
            if (!isset($response["res"])) {
                return JSONResponse::error($response);
            }
            if ($response["res"] === "ok") {
                return JSONResponse::ok($response["data"]);
            } else {
                return JSONResponse::error($response["data"]);
            }
        }

        public function __construct($pdo, $tables = null)
        {
            if ($tables === null) {
                $tables = DBStructure::getDefaultTables();
            }
            $this->pdo = $pdo;
            $this->db_tables = $tables;
        }

        public function obraSocialExists($code) {
            if (!is_numeric($code)) {
                return self::error("code must be a valid number.");
            }
            try {
                $sql = "SELECT COUNT(*) as count FROM {$this->db_tables['t_obra_social']} WHERE code=:code";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':code', $code, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $count = $result['count'];
                if ($count > 0) {
                    return self::ok(true);
                } else {
                    return self::ok(false);
                }
            } catch(Exception $e) {
                return self::error($e->getMessage());
            }
        }

        public function addObraSocial($code, $nombre) {
            $existsRes = $this->obraSocialExists($code);
            if (self::responseIsERROR($existsRes)){
                return $existsRes;
            }
            if (self::responseIsTRUE($existsRes)) {
                return self::error("Obra social already exists");
            }

            try {
                $sql = "INSERT INTO {$this->db_tables['t_obra_social']}
                 (code, nombre) VALUES (:code, :nombre)";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':code', $code, PDO::PARAM_INT);
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $insertedRows = $stmt->rowCount();
                    if ($insertedRows > 0) {
                        $lastInsertId = $this->pdo->lastInsertId();
                        if ($lastInsertId !== false) {
                            return self::ok($lastInsertId);
                        } else {
                            return self::error($stmt->errorInfo());
                        }   
                    } else { 
                        return self::error("No rows were inserted.");
                    }
                } else {
                    return self::error("ERROR executing the SQL statement");
                }
            } catch (Exception $e) {
                return self::error($e->getMessage());
            }
        }
    }
?>