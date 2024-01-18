<?php
    include_once dirname(__FILE__).'/../lib/json_utils.php';

    class DBStructure {
        public static $DB_NAME = "emmgweb";

        public static $STRUCTURE_TEMPLATES = [
            "id_name" => [
                "id" => [
                    "primary" => true,
                    "sql_type" => "BIGINT",
                    "pdo_type" => PDO::PARAM_INT,
                    "not_null" => true,
                    "extra_params" => "AUTO_INCREMENT",
                    "foreign_key" => null
                ],
                "name" => [
                    "primary" => false,
                    "sql_type" => "VARCHAR(64)",
                    "pdo_type" => PDO::PARAM_STR,
                    "not_null" => true,
                    "extra_params" => "",
                    "foreign_key" => null
                ]
            ],
            "id_code_name" => [
                "id" => [
                    "primary" => true,
                    "sql_type" => "BIGINT",
                    "pdo_type" => PDO::PARAM_INT,
                    "not_null" => true,
                    "extra_params" => "AUTO_INCREMENT",
                    "foreign_key" => null
                ],
                "code" => [
                    "primary" => false,
                    "sql_type" => "BIGINT",
                    "pdo_type" => PDO::PARAM_INT,
                    "not_null" => true,
                    "extra_params" => "",
                    "foreign_key" => null
                ],
                "name" => [
                    "primary" => false,
                    "sql_type" => "VARCHAR(64)",
                    "pdo_type" => PDO::PARAM_STR,
                    "not_null" => true,
                    "extra_params" => "",
                    "foreign_key" => null
                ]
            ]
        ];

        public static function getStructure() {
            return [
                "empresa" => [
                    "id" => [
                        "primary" => true,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "AUTO_INCREMENT",
                        "foreign_key" => null
                    ],
                    "cuit" => [
                        "primary" => false,
                        "sql_type" => "VARCHAR(32)",
                        "pdo_type" => PDO::PARAM_STR,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                    "razon" => [
                        "primary" => false,
                        "sql_type" => "VARCHAR(128)",
                        "pdo_type" => PDO::PARAM_STR,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                ], 
                "puesto_empleado" => self::$STRUCTURE_TEMPLATES['id_name'],
                "actividad_economica" => self::$STRUCTURE_TEMPLATES['id_name'],
                "regimen" => self::$STRUCTURE_TEMPLATES['id_name'],
                "obra_social" => self::$STRUCTURE_TEMPLATES['id_code_name'],
                "modalidad_contrato" => self::$STRUCTURE_TEMPLATES['id_code_name'],
                "situacion" => self::$STRUCTURE_TEMPLATES['id_code_name'],
                "ART" => self::$STRUCTURE_TEMPLATES['id_code_name'],
                "tipo_servicio" => self::$STRUCTURE_TEMPLATES['id_code_name'],
                "convenio_colectivo" => self::$STRUCTURE_TEMPLATES['id_code_name'],
                "categoria" => self::$STRUCTURE_TEMPLATES['id_code_name'],
                "puesto_trabajo" => self::$STRUCTURE_TEMPLATES['id_code_name'],
                "empleado" => [
                    "id" => [
                        "primary" => true,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "AUTO_INCREMENT",
                        "foreign_key" => null
                    ],
                    "em_id" => [
                        "primary" => true,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'empresa', 'field' => 'id']
                    ],
                    "cuit" => [
                        "primary" => false,
                        "sql_type" => "VARCHAR(32)",
                        "pdo_type" => PDO::PARAM_STR,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                    "nombre" => [
                        "primary" => false,
                        "sql_type" => "VARCHAR(64)",
                        "pdo_type" => PDO::PARAM_STR,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                    "apellido" => [
                        "primary" => false,
                        "sql_type" => "VARCHAR(64)",
                        "pdo_type" => PDO::PARAM_STR,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                    "fecha_inicio" => [
                        "primary" => false,
                        "sql_type" => "DATE",
                        "pdo_type" => PDO::PARAM_STR,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                    "fecha_cese" => [
                        "primary" => false,
                        "sql_type" => "DATE",
                        "pdo_type" => PDO::PARAM_STR,
                        "not_null" => false,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                    "agropecuario" => [
                        "primary" => false,
                        "sql_type" => "TINYINT(1)",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                    "domicilio_exp" => [
                        "primary" => false,
                        "sql_type" => "VARCHAR(128)",
                        "pdo_type" => PDO::PARAM_STR,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                    "id_obra_social" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'obra_social', 'field' => 'id']
                    ],
                    "id_modalidad" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'modalidad_contrato', 'field' => 'id']
                    ],
                    "id_situacion" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'situacion', 'field' => 'id']
                    ],
                    "id_ART" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'ART', 'field' => 'id']
                    ],
                    "id_regimen" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'regimen', 'field' => 'id']
                    ],
                    "id_servicio" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'tipo_servicio', 'field' => 'id']
                    ],
                    "id_convenio" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'convenio_colectivo', 'field' => 'id']
                    ],
                    "id_categoria" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'categoria', 'field' => 'id']
                    ],
                    "id_puesto" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'puesto_empleado', 'field' => 'id']
                    ],
                    "id_actividad" => [
                        "primary" => false,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'actividad_economica', 'field' => 'id']
                    ]
                ]
            ];
        }
        
        public static function generateTablesFromStructure($conn, $table_structure = null) {
            if ($table_structure === null) {
                $table_structure = self::getStructure(); 
            }
            $tables = [];
            foreach ($table_structure as $tableName => $fields) {
                $columns = [];
                $primary_keys = [];
                $foreign_keys = [];
                $tableDefinition = "CREATE TABLE IF NOT EXISTS $tableName (";
                foreach ($fields as $fieldName => $params) {
                    $columnDefinition = "$fieldName {$params['sql_type']} ";
                    if ($params['not_null'] === true) {
                        $columnDefinition .= "NOT NULL ";
                    }
                    $columnDefinition .= "{$params['extra_params']}";
                    $columns[] = $columnDefinition;

                    if ($params['primary']) {
                        $primary_keys[] = $fieldName;
                    }

                    if ($params['foreign_key'] !== null) {
                        $foreingKeyData = $params['foreign_key'];
                        $foreign_keys[] = $foreingKeyData;
                        $columns[] = "FOREIGN KEY ($fieldName) REFERENCES {$foreingKeyData['table']}({$foreingKeyData['field']})";
                    }
                }

                if (!empty($primary_keys)) {
                    $columns[] = "PRIMARY KEY (".implode(", ", $primary_keys).")";
                }
                $tableDefinition .= implode(", ", $columns);
                $tableDefinition .= ")";
                if (!empty($foreign_keys)) {
                    $tableDefinition .= " ENGINE=InnoDB";
                }
                $tables[] = $tableDefinition;
            }
            foreach ($tables as $tableSQL) {
                if (!mysqli_query($conn, $tableSQL)) {
                    return false;
                }
            }
            return true;
        }

        public static function dropDB($conn, $dbName) {
            $sql = "DROP DATABASE IF EXISTS $dbName";
            return mysqli_query($conn, $sql);
        }

        public static function createDB($conn, $dbName) {
            $sql = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            return mysqli_query($conn, $sql);
        }
    }
?>