<?php
    include_once '../config/def.php';
    include_once '../config/run_settings.php';
    include_once '../lib/enable_cors.php';
    include_once '../lib/json_utils.php';
    include_once '../db/db_structure.php';
    include_once '../db/db_response.php';
    include_once '../db/db_api.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo JSONResponse::ok(DBStructure::getStructure());
    } else {
        echo JSONResponse::error("Invalid method");
    } 
?>