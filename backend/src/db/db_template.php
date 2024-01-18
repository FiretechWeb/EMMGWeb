<?php
    class DBTemplate
    {
        public static function getFieldTemplates() {
            return [
            "id" => [
                "primary" => true,
                "sql_type" => "BIGINT",
                "pdo_type" => PDO::PARAM_INT,
                "not_null" => true,
                "extra_params" => "AUTO_INCREMENT",
                "foreign_key" => null
            ],
            "bigint" => [
                "primary" => false,
                "sql_type" => "BIGINT",
                "pdo_type" => PDO::PARAM_INT,
                "not_null" => true,
                "extra_params" => "",
                "foreign_key" => null
            ],
            "int" => [
                "primary" => false,
                "sql_type" => "INT",
                "pdo_type" => PDO::PARAM_INT,
                "not_null" => true,
                "extra_params" => "",
                "foreign_key" => null
            ],
            "varchar_32" => [
                "primary" => false,
                "sql_type" => "VARCHAR(32)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "foreign_key" => null
            ],
             "varchar_64" => [
                "primary" => false,
                "sql_type" => "VARCHAR(64)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "foreign_key" => null
            ],
            "varchar_128" => [
                "primary" => false,
                "sql_type" => "VARCHAR(128)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "foreign_key" => null
            ],
            "varchar_256" => [
                "primary" => false,
                "sql_type" => "VARCHAR(256)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "foreign_key" => null
            ],
            "varchar_512" => [
                "primary" => false,
                "sql_type" => "VARCHAR(512)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "foreign_key" => null
            ],
            "date" => [
                "primary" => false,
                "sql_type" => "DATE",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "foreign_key" => null
            ],
            "boolean" => [
                "primary" => false,
                "sql_type" => "TINYINT(1)",
                "pdo_type" => PDO::PARAM_BOOL,
                "not_null" => true,
                "extra_params" => "",
                "foreign_key" => null
            ],
        ];
        }

        public static function getTableTemplates() {
           $fieldTemplates = self::getFieldTemplates(); 
            return [
                "id_name" => [
                    "id" => $fieldTemplates['id'],
                    "name" => $fieldTemplates['varchar_64']
                ],
                "id_name_128" => [
                    "id" => $fieldTemplates['id'],
                    "name" => $fieldTemplates['varchar_128']
                ],
                "id_name_256" => [
                    "id" => $fieldTemplates['id'],
                    "name" => $fieldTemplates['varchar_256']
                ],
                "id_code_name" => [
                    "id" => $fieldTemplates['id'],
                    "code" => $fieldTemplates['bigint'],
                    "name" => $fieldTemplates['varchar_64']
                ],
                "id_code_name_128" => [
                    "id" => $fieldTemplates['id'],
                    "code" => $fieldTemplates['bigint'],
                    "name" => $fieldTemplates['varchar_128']
                ],
                "id_code_name_256" => [
                    "id" => $fieldTemplates['id'],
                    "code" => $fieldTemplates['bigint'],
                    "name" => $fieldTemplates['varchar_256']
                ]
            ];
        }

        public static function getTemplateField($templateField, $primary = null, $notNull = null, $params = null, $foreign_key = null) {
            $field = self::getFieldTemplates()[$templateField];
            if ($primary !== null) {
                $field['primary'] = $primary;
            }
            if ($notNull !== null) {
                $field['not_null'] = $notNull;
            }
            if ($params !== null) {
                $field['extra_params'] = $params;
            }
            if ($foreign_key !== null) {
                $field['foreign_key'] = $foreign_key;
            }

            return $field;
        }
    }
?>