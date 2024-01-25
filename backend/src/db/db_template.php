<?php
    include_once dirname(__FILE__). '/actions/base_actions.php';

    class DBTemplate
    {
        public static  function getTemplateActions() {
            return [
                "default" => [
                    "insert" => ['DBBaseActions', 'insert'],
                    "get" => ['DBBaseActions', 'get'],
                    "update" => ['DBBaseActions', 'update'],
                    "delete" => ['DBBaseActions', 'delete'],
                    "duplicated" => ['DBBaseActions', 'duplicated']
                ]
            ];
        }
        //call_user_func_array
        public static function getFieldTemplates() {
            return [
            "id" => [
                "primary" => true,
                "sql_type" => "BIGINT",
                "pdo_type" => PDO::PARAM_INT,
                "not_null" => true,
                "extra_params" => "AUTO_INCREMENT",
                "allow_insert" => false,
                "foreign_key" => null,
                "unique" => true
            ],
            "bigint" => [
                "primary" => false,
                "sql_type" => "BIGINT",
                "pdo_type" => PDO::PARAM_INT,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false
            ],
            "int" => [
                "primary" => false,
                "sql_type" => "INT",
                "pdo_type" => PDO::PARAM_INT,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false
            ],
            "varchar_32" => [
                "primary" => false,
                "sql_type" => "VARCHAR(32)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false
            ],
             "varchar_64" => [
                "primary" => false,
                "sql_type" => "VARCHAR(64)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false
            ],
            "varchar_128" => [
                "primary" => false,
                "sql_type" => "VARCHAR(128)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false
            ],
            "varchar_256" => [
                "primary" => false,
                "sql_type" => "VARCHAR(256)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false
            ],
            "varchar_512" => [
                "primary" => false,
                "sql_type" => "VARCHAR(512)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false
            ],
            "date" => [
                "primary" => false,
                "sql_type" => "DATE",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false
            ],
            "boolean" => [
                "primary" => false,
                "sql_type" => "TINYINT(1)",
                "pdo_type" => PDO::PARAM_BOOL,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false
            ],
        ];
        }

        public static function getTableTemplates() {
           $fieldTemplates = self::getFieldTemplates(); 
           $actionsTemplates = self::getTemplateActions();
            return [
                "id_name" => [
                    "fields" => [
                        "id" => $fieldTemplates['id'],
                        "name" => self::getTemplateField('varchar_64', null, null, null, null, true)
                    ], 
                    "actions" => $actionsTemplates['default']
                ],
                "id_name_128" => [
                    "fields" => [
                        "id" => $fieldTemplates['id'],
                        "name" => self::getTemplateField('varchar_128', null, null, null, null, true)
                    ],
                    "actions" => $actionsTemplates['default']
                ],
                "id_name_256" => [
                    "fields" => [
                        "id" => $fieldTemplates['id'],
                        "name" => self::getTemplateField('varchar_256', null, null, null, null, true)
                    ],
                    "actions" => $actionsTemplates['default']
                ],
                "id_code_name" => [
                    "fields" => [
                        "id" => $fieldTemplates['id'],
                        "code" => self::getTemplateField('bigint', null, null, null, null, true),
                        "name" => self::getTemplateField('varchar_64', null, null, null, null, true)
                    ],
                    "actions" => $actionsTemplates['default']
                ],
                "id_code_name_128" => [
                    "fields" => [
                        "id" => $fieldTemplates['id'],
                        "code" => self::getTemplateField('bigint', null, null, null, null, true),
                        "name" => self::getTemplateField('varchar_128', null, null, null, null, true)
                    ],
                    "actions" => $actionsTemplates['default']
                ],
                "id_code_name_256" => [
                    "fields" => [
                        "id" => $fieldTemplates['id'],
                        "code" => self::getTemplateField('bigint', null, null, null, null, true),
                        "name" => self::getTemplateField('varchar_256', null, null, null, null, true)
                    ],
                    "actions" => $actionsTemplates['default']
                ]
            ];
        }

        public static function getTemplateField($templateField, $primary = null, $notNull = null, $params = null, $foreign_key = null, $unique = null) {
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
            if ($unique !== null) {
                $field['unique'] = $unique;
            }

            return $field;
        }
    }
?>