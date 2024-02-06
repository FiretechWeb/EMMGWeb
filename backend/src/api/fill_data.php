<?php
    include_once '../config/def.php';
    include_once '../config/run_settings.php';
    include_once '../lib/enable_cors.php';
    include_once '../lib/json_utils.php';
    include_once '../db/db_structure.php';
    include_once '../db/db_response.php';
    include_once '../db/db_api.php';
    include_once '../db/db_test.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = mysqli_connect(Config::$HOST_URL, Config::$HOST_USER, Config::$HOST_PASSWORD);

            if (!$conn) {
                echo JSONResponse::error("Connection failed: " . mysqli_connect_error());
                exit(0);
            }
            if (!mysqli_select_db($conn, Config::$HOST_DB)) {
                echo JSONResponse::error("Connection to database failed: " .  mysqli_error($conn));
                exit(0);
            }

            $randData = DBTestData::getRandomData(DBStructure::getStructure(), 3);
            if (!DBAPI::insertDataFromStructure($conn, $randData, DBStructure::getStructure())) {
                echo JSONResponse::error("Error popullating with random data ".mysqli_error($conn));
                exit(0); 
            }

            mysqli_close($conn);
            echo JSONResponse::ok($randData);
        } catch(Exception $e) {
            echo JSONResponse::error($e->getMessage());
        }
    } else {
        echo JSONResponse::error("Can only be called via POST");
    }
?>