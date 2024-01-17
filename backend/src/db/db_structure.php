<?php
    class DBStructure {
        public static $DB_NAME = "emmgweb";
        public static $EMPRESA_TABLE = "empresas";
        public static $EMPLEADOS_TABLE = "empleados";

        public static function dropDB($conn, $dbName) {
            $sql = "DROP DATABASE IF EXISTS $dbName";
            return mysqli_query($conn, $sql);
        }
        public static function createDB($conn, $dbName) {
            $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
            return mysqli_query($conn, $sql);
        }
        public static function createEmpresaTable($conn, $tableName) {
            $sql = "CREATE TABLE IF NOT EXISTS $tableName (
                id BIGINT NOT NULL AUTO_INCREMENT, 
                cuit VARCHAR(32) NOT NULL, 
                razon VARCHAR(128) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }
        public static function createEmpleadosTable($conn, $empleadoTable, $empresaTable) {
            $sql = "CREATE TABLE IF NOT EXISTS $empleadoTable (
                    em_id BIGINT NOT NULL, 
                    id BIGINT  NOT NULL AUTO_INCREMENT,
                    PRIMARY KEY (id, em_id), 
                    FOREIGN KEY (em_id) REFERENCES $empresaTable (id)
                    ) ENGINE=InnoDB;";
            return mysqli_query($conn, $sql);
        }
    }
?>