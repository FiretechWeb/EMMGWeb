<?php
    //U: All DB classes will have only add, get, remove and exists methods.
    include_once 'db_structure.php';
    include_once 'db_response.php';
    include_once 'db_api.php';
    include_once 'db_basic_type.php';
    
    class DBObraSocial extends DBBasicType {
        //fields
        private $nombre = null;
        private $code = null;

        public function __construct($pdo, $dataArray, $tables = null)
        {
            parent::__construct($pdo, $dataArray, $tables);

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

            return parent::execQueryAndGetRowsAffected($sql, $params);
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
            
            return parent::execQueryAndGetRows($sql, $params);
        }

        public function exists() {
            if ($this->code === null || !is_numeric($this->code)) {
                return DBResponse::error("code must be a valid number.");
            }

            $sql = "SELECT * FROM {$this->getTableName()} WHERE code=:code";
            $params = [':code' => [$this->code, PDO::PARAM_INT]];

            return parent::execQueryAndCheckExists($sql, $params);
        }

        public function insert() {
            if ($this->code === null || !is_numeric($this->code)) {
                return DBResponse::error("code must be a valid number.");
            }
            if ($this->nombre === null) {
                return DBResponse::error("nombre is null");
            }

            $existsRes = $this->exists();
            if (DBResponse::isERROR($existsRes)){
                return $existsRes;
            }
            if (DBResponse::isTRUE($existsRes)) {
                return DBResponse::error("Obra social already exist");
            }

            $sql = "INSERT INTO {$this->getTableName()}
                (code, nombre) VALUES (:code, :nombre)";
            $params = [':code' => [$this->code, PDO::PARAM_INT], ':nombre' => [$this->nombre, PDO::PARAM_STR]];
            
            return parent::execQueryAndGetInsertId($sql, $params);
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

            return parent::execQueryAndGetRowsAffected($sql, $params);
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