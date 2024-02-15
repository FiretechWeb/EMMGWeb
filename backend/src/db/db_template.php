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
                ],
                "readonly" => [
                    "get" => ['DBBaseActions', 'get'],
                    "duplicated" => ['DBBaseActions', 'duplicated']
                ],
                "updateonly" => [
                    "get" => ['DBBaseActions', 'get'],
                    "update" => ['DBBaseActions', 'update'],
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
                "unique" => true,
                "enabled_by" => null
            ],
            "bigint" => [
                "primary" => false,
                "sql_type" => "BIGINT",
                "pdo_type" => PDO::PARAM_INT,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "int" => [
                "primary" => false,
                "sql_type" => "INT",
                "pdo_type" => PDO::PARAM_INT,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "varchar_16" => [
                "primary" => false,
                "sql_type" => "VARCHAR(16)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "varchar_32" => [
                "primary" => false,
                "sql_type" => "VARCHAR(32)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
             "varchar_64" => [
                "primary" => false,
                "sql_type" => "VARCHAR(64)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "varchar_128" => [
                "primary" => false,
                "sql_type" => "VARCHAR(128)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "varchar_256" => [
                "primary" => false,
                "sql_type" => "VARCHAR(256)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "varchar_512" => [
                "primary" => false,
                "sql_type" => "VARCHAR(512)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "date" => [
                "primary" => false,
                "sql_type" => "DATE",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "boolean" => [
                "primary" => false,
                "sql_type" => "TINYINT(1)",
                "pdo_type" => PDO::PARAM_BOOL,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "decimal" => [
                "primary" => false,
                "sql_type" => "DECIMAL(12,2)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "low_decimal" => [
                "primary" => false,
                "sql_type" => "DECIMAL(9,2)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
            ],
            "high_decimal" => [
                "primary" => false,
                "sql_type" => "DECIMAL(15,2)",
                "pdo_type" => PDO::PARAM_STR,
                "not_null" => true,
                "extra_params" => "",
                "allow_insert" => true,
                "foreign_key" => null,
                "unique" => false,
                "enabled_by" => null
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

    class DBActionShortHand {
        public function add($actions, $actionToAdd, $actionData) {
            $actions[$actionToAdd] = $actionData;
            return $actions;
        }
    }

    class DBFieldShortHand {
        public function unique($field) {
            $field['unique'] = true;
            return $field;
        }
        public function notUnique($field) {
            $field['unique'] = false;
            return $field;
        }
        public function primary($field) {
            $field['primary'] = true;
            return $field;
        }
        public function notPrimary($field) {
            $field['primary'] = false;
            return $field;
        }
        public function allowInsert($field) {
            $field['allow_insert'] = true;
            return $field;
        }
        public function notAllowInsert($field) {
            $field['allow_insert'] = false;
            return $field;
        }
        public function notNull($field) {
            $field['not_null'] = true;
            return $field; 
        }
        public function canBeNull($field) {
            $field['not_null'] = false;
            return $field; 
        }
        public function displayName($field, $displayName) {
            $field['display_name'] = $displayName;
            return $field; 
        }
        public function foreignKey($field, $foreingKey) {
            $field['foreign_key'] = $foreingKey;
            return $field;     
        }
        public function enabledBy($field, $enablerFieldName) {
            $field['enabled_by'] = $enablerFieldName;
            return $field;     
        }
        public function params($field, $params) {
            if (strpos($params, "primary") !== false) {
                $field["primary"] = strpos($params, "!primary") === false;
            }
            if (strpos($params, "not_null") !== false) {
                $field["primary"] = strpos($params, "!not_null") === false;
            }
            if (strpos($params, "allow_insert") !== false) {
                $field["primary"] = strpos($params, "!allow_insert") === false;
            }
            if (strpos($params, "unique") !== false) {
                $field["primary"] = strpos($params, "!unique") === false;
            }
            return $field;
        }
    }
?>