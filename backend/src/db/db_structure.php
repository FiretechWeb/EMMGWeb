<?php
    include_once dirname(__FILE__).'/../lib/json_utils.php';
    include_once dirname(__FILE__).'/db_template.php';

    class DBStructure {
        public static $DB_NAME = "emmgweb";

        public static function getStructure() {
            $fieldTemplates = DBTemplate::getFieldTemplates();
            $tableTemplates = DBTemplate::getTableTemplates();
            
            return [
                "empresa" => [
                    "id" => $fieldTemplates['id'],
                    "cuit" => $fieldTemplates['varchar_32'],
                    "razon" => $fieldTemplates['varchar_128']
                ], 
                "puesto_empleado" => $tableTemplates['id_name'],
                "actividad_economica" => $tableTemplates['id_name'],
                "regimen" => $tableTemplates['id_name'],
                "obra_social" => $tableTemplates['id_code_name'],
                "modalidad_contrato" => $tableTemplates['id_code_name'],
                "situacion" => $tableTemplates['id_code_name'],
                "ART" => $tableTemplates['id_code_name'],
                "tipo_servicio" => $tableTemplates['id_code_name'],
                "convenio_colectivo" => $tableTemplates['id_code_name'],
                "categoria" => $tableTemplates['id_code_name'],
                "puesto_trabajo" => $tableTemplates['id_code_name'],
                "empleado" => [
                    "id" => $fieldTemplates['id'],
                    "em_id" => [
                        "primary" => true,
                        "sql_type" => "BIGINT",
                        "pdo_type" => PDO::PARAM_INT,
                        "not_null" => true,
                        "extra_params" => "",
                        "foreign_key" => ['table' => 'empresa', 'field' => 'id']
                    ],
                    "cuit" => $fieldTemplates['varchar_32'],
                    "nombre" => $fieldTemplates['varchar_64'],
                    "apellido" => $fieldTemplates['varchar_64'],
                    "fecha_inicio" => $fieldTemplates['date'],
                    "fecha_cese" => [
                        "primary" => false,
                        "sql_type" => "DATE",
                        "pdo_type" => PDO::PARAM_STR,
                        "not_null" => false,
                        "extra_params" => "",
                        "foreign_key" => null
                    ],
                    "agropecuario" => $fieldTemplates['boolean'],
                    "domicilio_exp" => $fieldTemplates['varchar_128'],

                    "id_obra_social" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'obra_social', 'field' => 'id']),
                    
                    "id_modalidad" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'modalidad_contrato', 'field' => 'id']),

                    "id_situacion" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'situacion', 'field' => 'id']),
                    
                    "id_ART" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'ART', 'field' => 'id']),
                    
                    "id_regimen" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'regimen', 'field' => 'id']),

                    "id_servicio" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'tipo_servicio', 'field' => 'id']),

                    "id_convenio" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'convenio_colectivo', 'field' => 'id']),

                    "id_categoria" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'categoria', 'field' => 'id']),

                    "id_puesto" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'puesto_empleado', 'field' => 'id']),

                    "id_actividad" => DBTemplate::getTemplateField("bigint", null, null, null, ['table' => 'actividad_economica', 'field' => 'id'])
                ]
            ];
        }
    }
?>