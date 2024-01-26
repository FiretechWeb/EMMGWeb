<?php
    include_once dirname(__FILE__).'/../lib/json_utils.php';
    include_once dirname(__FILE__).'/db_template.php';

    class DBStructure {
        public static function getStructure() {
            $f = DBTemplate::getFieldTemplates();
            $t = DBTemplate::getTableTemplates();
            $a = DBTemplate::getTemplateActions();
            $s = new DBFieldShortHand();

            return [
                "tipo_cuenta_banco" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Tipo de cuenta")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Tipo de cuenta bancaria",
                    "group" => "Configuración"
                ],
                "provincia" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nombre")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Provincia",
                    "group" => "Configuración"
                ],
                "actividad" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Actividad")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Actividad",
                    "group" => "Empresas"   
                ],
                "tipos_empresa" => [
                    "fields" => [
                        "id" => $f['id'],
                        "tipo" => $s->unique($s->displayName($f['varchar_128'], "Tipo de Empresa")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Tipo de Empresa",
                    "group" => "Empresas"   
                ],
                "empresas" => [
                    "fields" => [
                        "id" => $f['id'],
                        "cuit" => $s->unique($s->displayName($f['bigint'], "CUIT")),
                        "razon" => $s->displayName($f['varchar_128'], "Razón Social"),
                        "tel" => $s->displayName($f['varchar_64'], "Teléfono"),
                        "domicilio" => $s->displayName($f['varchar_128'], "Domicilio"),
                        "ciudad" => $s->displayName($f['varchar_128'], "Ciudad"),
                        "id_provincia" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'provincia',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Provincia"),
                        "id_tipo" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'tipos_empresa',
                                'field' => 'id',
                                'format' => '{tipo}'
                            ]), "Tipo de Empresa"),
                        "id_actividad" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'actividad',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Actividad"),
                        "cuenta_bancaria" => $s->canBeNull($s->displayName($f['varchar_64'], "Cuenta Bancaria")),
                        "id_tcuenta_banco" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'tipo_cuenta_banco',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Tipo de cuenta bancaria"),
                        "hs_completa" => $s->displayName($f['int'], "Horas de jornada completa"),
                        "dias_completa" => $s->displayName($f['int'], "Días de jornada completa"),
                        "imp_detraccion" => $s->canBeNull(
                            $s->displayName($f['decimal'], "Importe detracción")
                        ),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Empresa",
                    "group" => "Empresas"
                ],
                "cuenta_contable" => [
                    "fields" => [
                        "id" => $f['id'],
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "codigo" => $s->unique($s->displayName($f['varchar_64'], "Código")),
                        "nombre" => $s->displayName($f['varchar_64'], "Nombre"),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Cuenta Contable",
                    "group" => "Empresas"
                ],
                "centro_costos" => [
                    "fields" => [
                        "id" => $f['id'],
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nombre")),
                        "cuenta" => $s->unique($s->displayName($f['varchar_64'], "Cuenta")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Centro de Costos",
                    "group" => "Empresas"
                ],
                "categoria_puesto" => [
                    "fields" => [
                        "id" => $f['id'],
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "numero" => $s->unique($s->displayName($f['int'], "Número de categoria")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_128'], "Descripción")),
                        "valor" => $s->unique($s->displayName($f['decimal'], "Valor")),

                    ],
                    "actions" => $a['default'],
                    "display_name" => "Puestos de trabajo",
                    "group" => "Empresas"
                ]
                ,
                "ART" => [
                    "fields" => [
                        "id" => $f['id'],
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "numero" => $s->unique($s->displayName($f['bigint'], "Número de seguro")),
                        "descripcion" => $s->displayName($f['varchar_128'], "Descripción")
                    ],
                    "actions" => $a['default'],
                    "display_name" => "ART - Seguros de vida",
                    "group" => "Empresas"
                ],
                "tabla_antiguedad" => [
                    "fields" => [
                        "id" => $f['id'],
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "antiguedad" => $s->unique($s->displayName($f['int'], "Antigüedad")),
                        "valor" => $s->displayName($f['decimal'], "Valor")
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Tablas de antigüedad",
                    "group" => "Empresas"
                ],
                "patronales" => [
                    "fields" => [
                        "id" => $f['id'],
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "descripcion" => $s->displayName($f['varchar_128'], "Descripción"),
                        "tabla_1" => $s->canBeNull($s->displayName($f['decimal'], "Porcentaje I")),
                        "tabla_2" => $s->canBeNull($s->displayName($f['decimal'], "Porcentaje II")),
                        "tabla_3" => $s->canBeNull($s->displayName($f['decimal'], "Porcentaje III")),
                        "tabla_4" => $s->canBeNull($s->displayName($f['decimal'], "Porcentaje IV")),
                        "tabla_5" => $s->canBeNull($s->displayName($f['decimal'], "Porcentaje V")),
                        "importe" => $s->displayName($f['decimal'], "Importe fijo"),
                        "id_cuenta_contable" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'cuenta_contable',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Cuenta contable"),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Contribuciones Patronales",
                    "group" => "Empresas"
                ]
            ];
        }
        /*
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
            $returnStructure['puesto_empleado']['fields']['name']['display_name'] = 'Puesto';

            $returnStructure['actividad_economica']['display_name'] = "Actividad económica";
            $returnStructure['actividad_economica']['fields']['name']['display_name'] = 'Nombre';

            $returnStructure['regimen']['display_name'] = "Régimen";
            $returnStructure['regimen']['fields']['name']['display_name'] = 'Nombre';

            $returnStructure['obra_social']['display_name'] = "Obra social";
            $returnStructure['obra_social']['fields']['name']['display_name'] = 'Nombre';
            $returnStructure['obra_social']['fields']['code']['display_name'] = 'Código';

            $returnStructure['modalidad_contrato']['display_name'] = "Modalidad de contrato";
            $returnStructure['modalidad_contrato']['fields']['name']['display_name'] = 'Nombre';
            $returnStructure['modalidad_contrato']['fields']['code']['display_name'] = 'Código';

            $returnStructure['situacion']['display_name'] = "Situación";
            $returnStructure['situacion']['fields']['name']['display_name'] = 'Nombre';
            $returnStructure['situacion']['fields']['code']['display_name'] = 'Código';

            $returnStructure['tipo_servicio']['display_name'] = "Tipo de servicio";
            $returnStructure['tipo_servicio']['fields']['name']['display_name'] = 'Servicio';
            $returnStructure['tipo_servicio']['fields']['code']['display_name'] = 'Código';

            $returnStructure['convenio_colectivo']['display_name'] = "Convenio colectivo";
            $returnStructure['convenio_colectivo']['fields']['name']['display_name'] = 'Nombre';
            $returnStructure['convenio_colectivo']['fields']['code']['display_name'] = 'Código';

            $returnStructure['categoria']['display_name'] = "Categoria";
            $returnStructure['categoria']['fields']['name']['display_name'] = 'Nombre';
            $returnStructure['categoria']['fields']['code']['display_name'] = 'Código';


            $returnStructure['empleado']['display_name'] = "Empleado";

            return $returnStructure;
        }
        */
    }
?>