<?php
    include 'config/def.php';
    include 'config/run_settings.php';
    include 'lib/enable_cors.php';
    include 'lib/json_utils.php';
    include 'db/db_structure.php';
    include 'db/db_api.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {    
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = mysqli_connect(Config::$HOST_URL, Config::$HOST_USER, Config::$HOST_PASSWORD);

            if (!$conn) {
                echo JSONResponse::error("Connection failed: " . mysqli_connect_error());
                exit(0);
            }
            if (!DBAPI::dropDB($conn, DBStructure::$DB_NAME)) {
                echo JSONResponse::error("Error dropping database: ".mysqli_error($conn));
                exit(0);
            }
            if (!DBAPI::createDB($conn, DBStructure::$DB_NAME)) {
                echo JSONResponse::error("Error creating database: ".mysqli_error($conn));
                exit(0);
            }
            
            if (!mysqli_select_db($conn, DBStructure::$DB_NAME)) {
                echo JSONResponse::error("Connection to database failed: " .  mysqli_error($conn));
                exit(0);
            }
            if (!DBAPI::generateTablesFromStructure($conn, DBStructure::getStructure())) {
                echo JSONResponse::error("Error creating Tables From Structure ".mysqli_error($conn));
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