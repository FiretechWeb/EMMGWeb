<?php
    include 'config/def.php';
    include 'config/run_settings.php';
    include 'lib/enable_cors.php';
    include 'lib/json_utils.php';
    include 'db/db_structure.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {    
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = mysqli_connect($HOST_URL, $HOST_USER, $HOST_PASSWORD);

            if (!$conn) {
                echo JSONResponse::error("Connection failed: " . mysqli_connect_error());
                exit(0);
            }
            if (!DBStructure::dropDB($conn, DBStructure::$DB_NAME)) {
                echo JSONResponse::error("Error dropping database: ".mysqli_error($conn));
                exit(0);
            }
            if (!DBStructure::createDB($conn, DBStructure::$DB_NAME)) {
                echo JSONResponse::error("Error creating database: ".mysqli_error($conn));
                exit(0);
            }
            
            if (!mysqli_select_db($conn, DBStructure::$DB_NAME)) {
                echo JSONResponse::error("Connection to database failed: " .  mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createEmpresaTable($conn, DBStructure::$EMPRESA_TABLE)) {
                echo JSONResponse::error("Error creating empresas table: ".mysqli_error($conn));
                exit(0);
            }
            if (!DBStructure::createEmpleadosTable($conn, DBStructure::$EMPLEADOS_TABLE, DBStructure::$EMPRESA_TABLE)) {
                echo JSONResponse::error("Error creating empresas table: ".mysqli_error($conn));
                exit(0);
            }
            
            mysqli_close($conn);
            echo JSONResponse::ok("Database structure created successfully");
        } catch(Exception $e) {
            echo JSONResponse::error($e->getMessage());
        }
    } else {
        echo JSONResponse::error("Can only be called via POST");
    }
?>