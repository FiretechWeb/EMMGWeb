<?php
    include_once 'db_response.php';
    abstract class DBBasicType {
        protected $action;

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