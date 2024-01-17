<?php
    include 'config/def.php';
    include 'config/run_settings.php';
    include 'lib/enable_cors.php';
    include 'lib/json_utils.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the JSON data from the request body
        $jsonData = file_get_contents("php://input");
        
        // Decode the JSON data
        $decodedData = json_decode($jsonData, true);

        if ($decodedData === null) {
            echo JSONResponse::error("Invalid json data");
            exit(0);
        }

        if (!isset($decodedData["test_id"])) {
            echo JSONResponse::error("test_id is not set");
            exit(0);
        }

        $test_id = filter_var($decodedData["test_id"], FILTER_VALIDATE_INT);

        if ($test_id === false) {
            echo JSONResponse::error("test_id is not a number");
            exit(0);
        }

        switch($test_id) {
            case 0:
                echo JSONResponse::ok(array(
                    "resp" => "ok",
                    "data" => array(
                        "name" => "Gaston Florentin",
                        "age" => 30,
                        "hs_worked" => 48,
                        "services" => array(
                            "sv_1" => 1,
                            "sv_2" => "Not finished"
                        )
                    )
                ));
            break;
            default:
                echo JSONResponse::error("invalid test_id");
            break;
                
        }
    } else {
        echo JSONResponse::error("invalid method. Use POST.");
    }
?>