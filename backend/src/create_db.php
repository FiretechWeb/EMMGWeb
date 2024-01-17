<?php
    include 'config/def.php';
    include 'config/run_settings.php';
    include 'lib/enable_cors.php';
    include 'lib/json_utils.php';

    function dropDB($conn, $dbName) {
        $sql = "DROP DATABASE IF EXISTS $dbName";
        if (!mysqli_query($conn, $sql)) {
            echo JSONResponse::error("Error destroying database: ".mysqli_error($conn));
            exit(0);
        }
    }
    function createDB($conn, $dbName) {
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
        if (!mysqli_query($conn, $sql)) {
            echo JSONResponse::error("Error creating database: ".mysqli_error($conn));
            exit(0);
        }
    }
    function createEmpresaTable($conn, $tableName) {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            id BIGINT NOT NULL AUTO_INCREMENT, 
            cuit VARCHAR(32) NOT NULL, 
            razon VARCHAR(128) NOT NULL, 
            PRIMARY KEY (id) 
            );";
        if (!mysqli_query($conn, $sql)) {
            echo JSONResponse::error("Error creating empresa table: ".mysqli_error($conn));
            exit(0);
        }
    }
    function createEmpleadosTable($conn, $empleadoTable, $empresaTable) {
        $sql = "CREATE TABLE IF NOT EXISTS $empleadoTable (
                em_id BIGINT NOT NULL, 
                id BIGINT  NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (id, em_id), 
                FOREIGN KEY (em_id) REFERENCES $empresaTable (id)
                ) ENGINE=InnoDB;";
        if (!mysqli_query($conn, $sql)) {
            echo JSONResponse::error("Error creating empleados table: ".mysqli_error($conn));
            exit(0);
        }
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {    
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = mysqli_connect($HOST_URL, $HOST_USER, $HOST_PASSWORD);

            if (!$conn) {
                echo JSONResponse::error("Connection failed: " . mysqli_connect_error());
                exit(0);
            }
            dropDB($conn, $HOST_DB);
            createDB($conn, $HOST_DB);
            if (!mysqli_select_db($conn, $HOST_DB)) {
                echo JSONResponse::error("Connection to database failed: " .  mysqli_error($conn));
                exit(0);
            }
            createEmpresaTable($conn, "empresas");
            createEmpleadosTable($conn, "empleados", "empresas");
            mysqli_close($conn);
            echo JSONResponse::ok("Database structure created successfully");
        } catch(Exception $e) {
            echo JSONResponse::error($e->getMessage());
        }
    } else {
        echo JSONResponse::error("Can only be called via POST");
    }
?>