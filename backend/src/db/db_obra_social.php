<?php
    //U: All DB classes will have only add, get, remove and exists methods.
    include_once 'db_structure.php';
    include_once 'db_response.php';
    include_once 'db_api.php';
    include_once 'db_basic_type.php';
    
    class DBObraSocial extends DBBasicType {
        private $pdo = null;
        private $db_tables = null;

        //fields
        private $id = null;
        private $nombre = null;
        private $code = null;

        public function __construct($pdo, $dataArray, $tables = null)
        {
            if ($tables === null) {
                $tables = DBStructure::getDefaultTables();
            }

            if (!isset($dataArray['id'])) {
                $this->id = null;
            } else {
                $this->id = $dataArray['id'];
            }

            if (!isset($dataArray['nombre'])) {
                $this->nombre = null;
            } else {
                $this->nombre = $dataArray['nombre'];
            }

            if (!isset($dataArray['code'])) {
                $this->code = null;
            } else {
                $this->code = $dataArray['code'];
            }

            if (!isset($dataArray['action'])) {
                $this->action = null;
            } else {
                $this->action = $dataArray['action'];
            }

            $this->pdo = $pdo;
            $this->db_tables = $tables;
        }

        public function getTableName() {
            return $this->db_tables['t_obra_social'];
        }

        public function pull() {
            if ($this->code === null || !is_numeric($this->code)) {
                return DBResponse::error("code must be a valid number.");
            }

            $sql = "SELECT * FROM {$this->getTableName()} WHERE code = :code";
            $params = [':code' => [$this->code, PDO::PARAM_INT]];
            
            $res = DBAPI::executeQuery($this->pdo, $sql, $params);
            if (DBResponse::isERROR($res)) {
                return $res;
            }
            $rows = DBResponse::getData($res)['rows'];
            if (count($rows) > 0) {
                $firstElement = $rows[0];
                $this->id = $firstElement['id'];
                $this->code = $firstElement['code'];
                $this->nombre = $firstElement['nombre'];

                return DBResponse::ok($firstElement);
            } else {
                return DBResponse::error("Cannot pull");
            }
        }
        public function delete() {
            if ($this->code !== null && !is_numeric($this->code)) {
                return DBResponse::error("code must be a valid number.");
            }
            
            $sql = "DELETE FROM {$this->getTableName()} ";

            $params = array();

            if ($this->id !== null || $this->code !== null || $this->nombre !== null) {
                $sql .= "WHERE ";
            }
            if ($this->id !== null) {
                $sql .= "id = :id";
                $params[':id'] = [$this->id, PDO::PARAM_INT];
            }
            if ($this->code !== null) {
                $sql .= "code = :code";
                $params[':code'] = [$this->code, PDO::PARAM_INT];
            }
            if ($this->nombre !== null) {
                $sql .= "nombre = :nombre";
                $params[':nombre'] = [$this->nombre, PDO::PARAM_STR];
            }

            $res = DBAPI::executeQuery($this->pdo, $sql, $params);
            if (DBResponse::isERROR($res)) {
                return $res;
            }
            $rowsAffected = DBResponse::getData($res)['row_count'];
            if ($rowsAffected > 0) {
                return DBResponse::ok($rowsAffected);
            } else {
                return DBResponse::error("Nothing was deleted from the table.");
            }
        }

        public function get() {
            if ($this->code !== null && !is_numeric($this->code)) {
                return DBResponse::error("code must be a valid number.");
            }
            $sql = "SELECT * FROM {$this->getTableName()} ";

            $params = array();

            if ($this->code !== null || $this->nombre !== null) {
                $sql .= "WHERE ";
            }
            if ($this->code !== null) {
                $sql .= " code = :code";
                if ($this->nombre !== null) {
                    $sql .= " AND";
                }
                $params[':code'] = [$this->code, PDO::PARAM_INT];
            }
            if ($this->nombre !== null) {
                $sql .= " nombre = :nombre";
                $params[':nombre'] = [$this->nombre, PDO::PARAM_STR];
            }

            $res = DBAPI::executeQuery($this->pdo, $sql, $params);
            if (DBResponse::isERROR($res)) {
                return $res;
            }
            $rows = DBResponse::getData($res)['rows'];
            return DBResponse::ok($rows);
        }

        public function exists() {
            if ($this->code === null || !is_numeric($this->code)) {
                return DBResponse::error("code must be a valid number.");
            }

            $sql = "SELECT * FROM {$this->getTableName()} WHERE code=:code";
            $params = [':code' => [$this->code, PDO::PARAM_INT]];
            $res = DBAPI::executeQuery($this->pdo, $sql, $params);
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

        public function insert() {
            if ($this->code === null || !is_numeric($this->code)) {
                return DBResponse::error("code must be a valid number.");
            }
            if ($this->nombre === null) {
                return DBResponse::error("nombre is null");
            }

            $existsRes = $this->exists($this->code);
            if (DBResponse::isERROR($existsRes)){
                return $existsRes;
            }
            if (DBResponse::isTRUE($existsRes)) {
                return DBResponse::error("Obra social already exist");
            }

            $sql = "INSERT INTO {$this->getTableName()}
                (code, nombre) VALUES (:code, :nombre)";
            $params = [':code' => [$this->code, PDO::PARAM_INT], ':nombre' => [$this->nombre, PDO::PARAM_STR]];
            
            $res = DBAPI::executeQuery($this->pdo, $sql, $params);
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

        public function update() {
            if ($this->code === null || !is_numeric($this->code)) {
                return DBResponse::error("code must be a valid number.");
            }
            if ($this->nombre === null) {
                return DBResponse::error("nombre is null");
            }
            $sql = "UPDATE {$this->getTableName()}
             SET nombre = :nombre WHERE code = :code";
            $params = [':code' => [$this->code, PDO::PARAM_INT], ':nombre' => [$this->nombre, PDO::PARAM_STR]];

            $res = DBAPI::executeQuery($this->pdo, $sql, $params);
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

        public function push() {

            if ($this->code === null || !is_numeric($this->code)) {
                return DBResponse::error("code must be a valid number.");
            }
            if ($this->nombre === null) {
                return DBResponse::error("nombre is null");
            }

            return parent::push();
        }
    }
?>