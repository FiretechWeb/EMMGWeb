<?php
    include_once '../config/def.php';
    include_once '../config/run_settings.php';
    include_once '../lib/enable_cors.php';
    include_once '../lib/json_utils.php';
    include_once '../db/db_structure.php';
    include_once '../db/db_response.php';
    include_once '../db/db_api.php';

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
    $action = $decodedData['action'];
    $table = $decodedData['table'];
    $actionParams = $decodedData['params'];
    $res = DBAPI::execAction($pdo, $table, $action, $actionParams, DBStructure::getStructure());
    echo DBResponse::responseToJSON($res);
?>