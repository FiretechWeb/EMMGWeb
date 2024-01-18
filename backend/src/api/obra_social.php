<?php
    include_once '../config/def.php';
    include_once '../config/run_settings.php';
    include_once '../lib/enable_cors.php';
    include_once '../lib/json_utils.php';
    include_once '../db/db_structure.php';
    include_once '../db/db_response.php';
    include_once '../db/db_api.php';
    include_once '../db/db_obra_social.php';

    $res = DBAPI::checkAndGetPOSTfromJSON();

    if (DBResponse::isERROR($res)) {
        echo DBResponse::responseToJSON($res);
        exit(0);
    }
    $decodedData = DBResponse::getData($res);
    
    $res = DBAPI::startPDO();
    if (DBResponse::isERROR($res)) {
        echo DBResponse::responseToJSON($res);
        exit(0);
    }

    $pdo = DBResponse::getData($res);
    $obraSocial = new DBObraSocial($pdo, $decodedData);
    $res = $obraSocial->executeAction();
    echo DBResponse::responseToJSON($res);
?>