<?php

//START: Enabling CORS in my localhost server
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
//END: Enabling CORS in my localhost server

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST["test_id"])) {
            echo json_encode(array(
                "resp" => "error",
                "msg" => "test_id is not set"
            ));
            exit(0);
        }
        $test_id = filter_var($_POST["test_id"], FILTER_VALIDATE_INT);

        if ($test_id === false) {
            echo json_encode(array(
                "resp" => "error",
                "msg" => "test_id is not a number"
            ));
            exit(0);
        }

        switch($test_id) {
            case 0:
                echo json_encode(
                    array(
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
                echo json_encode(array(
                    "resp" => "error",
                    "msg" => "invalid test_id"
                ));
            break;
                
        }
    } else {
        echo json_encode(array(
            "resp" => "error",
            "msg" => "invalid method"
        ), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
?>