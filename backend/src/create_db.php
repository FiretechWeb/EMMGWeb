<?php
    include 'config/def.php';
    include 'config/run_settings.php';
    include 'lib/enable_cors.php';
    include 'lib/json_utils.php';

    function createDB($conn, $dbName) {
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
        if (!mysqli_query($conn, $sql)) {
            echo JSONResponse::error("Error creating database: ".mysqli_error($conn));
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
            createDB($conn, $HOST_DB);
            mysqli_close($conn);
            echo JSONResponse::ok("Database structure created successfully");
        } catch(Exception $e) {
            echo JSONResponse::error($e->getMessage());
        }
    } else {
        echo JSONResponse::error("Can only be called via POST");
    }
?>