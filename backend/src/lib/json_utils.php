<?php
    class JSONResponse
    {
        public static function ok($data) {
            return json_encode(array(
                "res" => "ok",
                "data" => $data
            ));
        }
        public static function error($msg, $data=null) {
            if ($data === null) {
                return json_encode(array(
                    "res" => "error",
                    "msg" => $msg
                ));
            } else {
                return json_encode(array(
                    "res" => "error",
                    "msg" => $msg,
                    "data" => $data
                ));
            }
        }
    }
?>