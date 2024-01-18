<?php
    include_once dirname(__FILE__).'/../lib/json_utils.php';

    class DBResponse {
        public static function getData($res) {
            if (!isset($res['data'])) {
                return null;
            }

            return $res['data'];
        }
        public static function isERROR($res)
        {
            if (!isset($res['data']) || !isset($res['res'])) {
                return true;
            }
            if ($res['res'] !== 'error') {
                return false;
            }

            return true;
        }
        public static function isTRUE($res) {
            if (!isset($res['data']) || !isset($res['res'])) {
                return false;
            } 
            if ($res['res'] !== 'ok') {
                return false;
            }

            return ($res['data'] == true);
        }
        public static function ok($data) { 
            return array(
                "res" => "ok",
                "data" => $data
            );
        }
        public static function error($data) { 
            return array(
                "res" => "error",
                "data" => $data
            );
        }
        public static function responseToJSON($response) {
            if (!isset($response["res"])) {
                return JSONResponse::error($response);
            }
            if ($response["res"] === "ok") {
                return JSONResponse::ok($response["data"]);
            } else {
                return JSONResponse::error($response["data"]);
            }
        }
    }
?>