<?php
    include_once '../config/def.php';
    include_once '../config/run_settings.php';
    include_once '../lib/enable_cors.php';
    include_once '../lib/json_utils.php';
    include_once '../db/db_structure.php';
    include_once '../db/db_api.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $jsonData = file_get_contents("php://input");
        $decodedData = json_decode($jsonData, true);

        if ($decodedData === null) {
            echo JSONResponse::error("Invalid json data");
            exit(0);
        }
        if (!isset($decodedData['action'])) {
            echo JSONResponse::error("Action was not send");
            exit(0);
        }

        $pdo = null;

        try {
            $DB = DBStructure::$DB_NAME;
            $pdo = new PDO("mysql:host=$HOST_URL;dbname=$DB", $HOST_USER, $HOST_PASSWORD);
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            echo JSONResponse::error($e->getMessage());
            exit(0);
        }
        
        if ($pdo === null) {
            echo JSONResponse::error("PDO is null");
            exit(0);
        }

        $api_instance = new DBAPI($pdo);

        switch($decodedData['action']) {
            case 'exists':
                if (!isset($decodedData['code'])) {
                    echo JSONResponse::error("Code was not sent");
                    exit(0);
                }
                $res = $api_instance->obraSocialExists($decodedData['code']);
                echo DBAPI::responseToJSON($res);
            break;
            case 'add':
                if (!isset($decodedData['code'])) {
                    echo JSONResponse::error("Code was not sent");
                    exit(0);
                }
                if (!isset($decodedData['nombre'])) {
                    echo JSONResponse::error("Nombre was not sent");
                    exit(0);
                }
                $res = $api_instance->addObraSocial($decodedData['code'], $decodedData['nombre']);
                echo DBAPI::responseToJSON($res);
            break;

            default:
                echo JSONResponse::error("Invalid action");
            break;
        }
    } else {
        echo JSONResponse::error("Invalid method");
    }
?>