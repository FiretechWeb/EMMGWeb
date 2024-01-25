<?php
    include_once dirname(__FILE__).'/../lib/json_utils.php';
    include_once dirname(__FILE__).'/db_template.php';

    class DBStructure {
        public static function getStructure() {
            $fieldTemplates = DBTemplate::getFieldTemplates();
            $tableTemplates = DBTemplate::getTableTemplates();
            $actionsTemplates = DBTemplate::getTemplateActions();
            $returnStructure = [
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
                "empleado" => [
                    "fields" => [
                        "id" => $fieldTemplates['id'],
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
                            "allow_insert" => true,
                            "foreign_key" => null,
                            "unique" => false
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
                    ],  
                    "actions" => $actionsTemplates['default']
                ]
            ];
            
            $returnStructure['puesto_empleado']['display_name'] = "Puesto de empleado";
            $returnStructure['actividad_economica']['display_name'] = "Actividad económica";
            $returnStructure['regimen']['display_name'] = "Régimen";
            $returnStructure['obra_social']['display_name'] = "Obra social";
            $returnStructure['modalidad_contrato']['display_name'] = "Modalidad de contrato";
            $returnStructure['situacion']['display_name'] = "Situación";
            $returnStructure['tipo_servicio']['display_name'] = "Tipo de servicio";
            $returnStructure['convenio_colectivo']['display_name'] = "Convenio colectivo";
            $returnStructure['categoria']['display_name'] = "Categoria";
            $returnStructure['empleado']['display_name'] = "Empleado";

            return $returnStructure;
        }
    }
?>