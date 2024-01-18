<?php
    include_once 'db_structure.php';
    include_once 'db_response.php';
    include_once 'db_api.php';

    abstract class DBBasicType {
        protected $action;
        protected $pdo = null;
        protected $db_tables = null;
        protected $id = null;

        public function __construct($pdo, $dataArray, $tables = null) {
            if ($tables === null) {
                $tables = DBStructure::getDefaultTables();
            }

            if (!isset($dataArray['id'])) {
                $this->id = null;
            } else {
                $this->id = $dataArray['id'];
            }

            if (!isset($dataArray['action'])) {
                $this->action = null;
            } else {
                $this->action = $dataArray['action'];
            }

            $this->pdo = $pdo;
            $this->db_tables = $tables;
        }

        public function executeAction() {

            switch($this->action) {
                case 'exists':
                    return $this->exists();
                break;
                case 'insert':
                    return $this->insert();
                break;
                case 'update':
                    return $this->update();
                break;
                case 'push':
                    return $this->push();
                break;
                case 'pull':
                    return $this->pull();
                break;
                case 'get':
                    return $this->get();
                break;
                case 'delete':
                    return $this->delete();
                break;
            }
            return DBResponse::error("Invalid action");
        }

        abstract public function pull();
        abstract public function delete();
        abstract public function get();
        abstract public function exists();
        abstract public function insert();
        abstract public function update();

        protected function execQueryAndGetRows($sql, $params) {
            $res = DBAPI::executeQuery($this->pdo, $sql, $params);
            if (DBResponse::isERROR($res)) {
                return $res;
            }
            $rows = DBResponse::getData($res)['rows'];
            return DBResponse::ok($rows);
        }

        protected function execQueryAndCheckExists($sql, $params) {
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
        
        protected function execQueryAndGetInsertId($sql, $params) {
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

        protected function execQueryAndGetRowsAffected($sql, $params) {
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
            $existsRes = $this->exists();
            if (DBResponse::isERROR($existsRes)){
                return $existsRes;
            }
            if (DBResponse::isTRUE($existsRes)) {
                return $this->update();
            }

            return $this->insert();
        }
    }
?>