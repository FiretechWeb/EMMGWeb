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
                "configuracion" => [
                    "fields" => [
                        "id" => $f['id'],
                        "valor_mopre" => $s->displayName($f['decimal'], "Valor de MOPRE"),
                        "cant_mopre_max" => $s->displayName($f['decimal'], "Cantidad Máxima MOPRE"),
                        "cant_mopre_min" => $s->displayName($f['decimal'], "Cantidad Mínima MOPRE"),
                        "min_remunerativo" => $s->displayName($f['decimal'], "Mínimo remunerativo"),
                        "max_remunerativo" => $s->displayName($f['decimal'], "Máximo remunerativo"),
                        "min_remunerativo_sac" => $s->displayName($f['decimal'], "Mínimo remunerativo con SAC"),
                        "max_remunerativo_sac" => $s->displayName($f['decimal'], "Máximo remunerativo con SAC"),
                        "mb_vac_sac" => $s->displayName($f['boolean'], "MAXBRUTO incluye topes de vacaciones y SAC")
                    ],
                    "actions" => $a['updateonly'],
                    "display_name" => "Configuración General",
                    "group" => "Configuración"
                ],
                "modalidad_contratacion" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "modalidad" => $s->unique($s->displayName($f['varchar_256'], "Nombre de modalidad")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Modalidad de contratación",
                    "group" => "Configuración>Laborales"
                ],
                "situacion_revista" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_256'], "Descripción")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Situación de Revista",
                    "group" => "Configuración>Laborales"
                ],
                "condiciones" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_256'], "Descripción")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Condiciones",
                    "group" => "Configuración>Laborales"
                ],
                "actividades" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_256'], "Descripción")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Actividades",
                    "group" => "Configuración>Laborales"
                ],
                "obras_sociales" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_256'], "Descripción")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Obras Sociales",
                    "group" => "Configuración>Laborales"
                ],
                "tipo_cuenta_banco" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Tipo de cuenta")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Tipo de cuenta bancaria",
                    "group" => "Configuración>Datos"
                ],
                "provincia" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nombre")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Provincia",
                    "group" => "Configuración>Datos"
                ],
                "tipo_documento" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Tipo de documento")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Tipo de documento",
                    "group" => "Configuración>Datos"
                ],
                "nacionalidad" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nacionalidad")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Nacionalidad",
                    "group" => "Configuración>Datos"
                ],
                "genero" => [
                    "fields" => [
                        "id" => $f['id'],
                        "genero" => $s->unique($s->displayName($f['varchar_128'], "Genero")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Género",
                    "group" => "Configuración>Datos"
                ],
                "estado_civil" => [
                    "fields" => [
                        "id" => $f['id'],
                        "estado" => $s->unique($s->displayName($f['varchar_128'], "Estado civil")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Estado Civil",
                    "group" => "Configuración>Datos"
                ],
                "actividad" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "nombre" => $s->unique($s->displayName($f['varchar_256'], "Actividad")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Actividad",
                    "group" => "Configuración>Empresas"
                ],
                "tipos_empresa" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código AFIP")),
                        "tipo" => $s->unique($s->displayName($f['varchar_128'], "Tipo de Empresa")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Tipo de Empresa",
                    "group" => "Configuración>Empresas"
                ],
                "periodo_pago" => [
                    "fields" => [
                        "id" => $f['id'],
                        "periodo" => $s->unique($s->displayName($f['varchar_64'], "Nombre de periodo de pago")),
                        "dias" => $s->canBeNull($s->displayName($f['int'], "Días")),
                        "meses" => $s->canBeNull($s->displayName($f['int'], "Meses")),
                        "anios" => $s->canBeNull($s->displayName($f['int'], "Años")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Periodo de Pago",
                    "group" => "Configuración>Empresas"
                ],
                "regimen_jubilatorio" => [
                    "fields" => [
                        "id" => $f['id'],
                        "descripcion" => $s->unique($s->displayName($f['varchar_64'], "Descripción")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Régimen Jubilatorio",
                    "group" => "Configuración>Empresas"
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
                    "group" => "Empresas",
                    "field_groups" => [
                        "Datos Generales" => ["cuit", "razon", "tel", "domicilio", "ciudad", "id_provincia", "id_tipo"],
                        "Tipo y Actividad" => ["id_actividad", "cuenta_bancaria", "id_tcuenta_banco", "hs_completa", "dias_completa", "imp_detraccion"]
                    ] 
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
                "tablas_categoria" => [
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
                        "numero" => $s->unique($s->displayName($f['int'], "Número de tabla de categoria.")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Tablas de Categoria",
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
                        "id_tabla_cat" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Tabla de Categoria")),
                            [
                                'table' => 'tablas_categoria',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => 'Tabla Nº {numero}'
                            ]
                        ),
                        "numero" => $s->unique($s->displayName($f['int'], "Número de categoria")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_128'], "Descripción")),
                        "valor" => $s->displayName($f['decimal'], "Valor"),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Puestos de trabajo",
                    "group" => "Empresas"
                ],
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
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{nombre}'
                            ]), "Cuenta contable"),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Contribuciones Patronales",
                    "group" => "Empresas"
                ],
                "departamentos" => [
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
                        "tipo" => $s->unique($s->displayName($f['varchar_128'], "Departamento")),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Departamentos",
                    "group" => "Empresas"   
                ],
                "empleado" => [
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
                        "legajo" => $s->unique($s->displayName($f['int'], "Legajo")),
                        "cuil" => $s->unique($s->displayName($f['bigint'], "CUIL Empleado")),
                        "nombre" => $s->displayName($f['varchar_64'], "Nombre"),
                        "apellido" => $s->displayName($f['varchar_64'], "Apellido"),
                        "id_tipo_documento" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'tipo_documento',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Tipo de Documento"),
                        "nro_doc" => $s->unique($s->displayName($f['bigint'], "Número de documento")),
                        "id_nacionalidad" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'nacionalidad',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Nacionalidad"),
                        "fecha_nac" => $s->displayName($f['date'], "Fecha de nacimiento"),
                        "id_genero" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'genero',
                                'field' => 'id',
                                'format' => '{genero}'
                            ]), "Género"),
                        "id_estado_civil" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'estado_civil',
                                'field' => 'id',
                                'format' => '{estado}'
                            ]), "Estado Civil"),
                        "nro_tel" => $s->canBeNull($s->displayName($f['varchar_64'], "Número telefónico")),
                        "nro_cel" => $s->canBeNull($s->displayName($f['varchar_64'], "Número de celular")),
                        "nro_emergencias" => $s->canBeNull($s->displayName($f['varchar_64'], "Número de emergencias")),
                        "email" => $s->canBeNull($s->displayName($f['varchar_128'], "Correo electrónico")),
                        "dom_calle" => $s->canBeNull($s->displayName($f['varchar_128'], "Domicilio - Calle")),
                        "dom_numero" => $s->canBeNull($s->displayName($f['varchar_32'], "Domicilio - Número")),
                        "dom_departamento" => $s->canBeNull($s->displayName($f['varchar_128'], "Departamento")),
                        "dom_piso" => $s->canBeNull($s->displayName($f['varchar_16'], "Piso")),
                        "id_provincia" => $s->canBeNull($s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'provincia',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Provincia")),
                        "cod_postal" => $s->canBeNull($s->displayName($f['varchar_32'], "Código Postal")),
                        "id_tabla_cat" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Tabla Categoria")),
                            [
                                'table' => 'tablas_categoria',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => 'Tabla Nº {numero}'
                            ]
                        ),
                        "id_puesto" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Categoria Puesto")),
                            [
                                'table' => 'categoria_puesto',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id,id_tabla_cat:id_tabla_cat',
                                'format' => '{descripcion}'
                            ]
                        ),
                        "cal_categoria" => $s->canBeNull($s->displayName($f['varchar_64'], "Calific./Categoría")),
                        "area" => $s->canBeNull($s->displayName($f['varchar_64'], "Área")),
                        "tarea_asignada" => $s->canBeNull($s->displayName($f['varchar_64'], "Tarea Asignada")),
                        "seccion" => $s->canBeNull($s->displayName($f['varchar_64'], "Sección")),
                        "fecha_ingreso" => $s->displayName($f['date'], "Fecha de ingreso"),
                        "fecha_baja" => $s->canBeNull($s->displayName($f['date'], "Fecha de baja")),
                        "id_departamento" => $s->canBeNull($s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Departamento")),
                            [
                                'table' => 'departamentos',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{tipo}'
                            ]
                        )),
                        "fab_campo_libre" => $s->canBeNull($s->displayName($f['varchar_64'], "Fábrica / Campo Libre")),
                        "lugar_trabajo" => $s->canBeNull($s->displayName($f['varchar_64'], "Lugar de Trabajo")),
                        "seguro_obligatorio" => $s->displayName($f['boolean'], "Seguro de vida Obligatorio (SICOSS)"),
                        "dias_vacaciones" => $s->canBeNull($s->displayName($f['int'], "Días de vacaciones")),
                        "nro_cuenta_cbu" => $s->canBeNull($s->displayName($f['varchar_64'], "Nro. de cuenta o CBU")),
                        "nro_cuenta_alt" => $s->canBeNull($s->displayName($f['varchar_64'], "Nro. de cuenta 2")),
                        "id_tcuenta_banco" => $s->canBeNull($s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'tipo_cuenta_banco',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Tipo de cuenta bancaria")),
                        "sueldo_base" => $s->displayName($f['decimal'], "Sueldo base"),
                        "sucursal" => $s->canBeNull($s->displayName($f['varchar_64'], "Sucursal")),
                        "ant_ad_anios" => $s->canBeNull($s->displayName($f['int'], "Años")),
                        "ant_ad_meses" => $s->canBeNull($s->displayName($f['int'], "Meses")),
                        "ant_ad_dias" => $s->canBeNull($s->displayName($f['int'], "Dias")),
                        "renum_suma_fija1" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 1")),
                        "renum_suma_fija2" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 2")),
                        "renum_suma_fija3" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 3")),
                        "renum_suma_fija4" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 4")),
                        "renum_suma_fija5" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 5")),
                        "id_tabla_cat_sec" => $s->canBeNull($s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Tabla Categoria Secundaria")),
                            [
                                'table' => 'tablas_categoria',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => 'Tabla Nº {numero}'
                            ]
                        )),
                        "id_puesto_sec" => $s->canBeNull($s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Categoria secundaria")),
                            [
                                'table' => 'categoria_puesto',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id,id_tabla_cat:id_tabla_cat_sec',
                                'format' => '{descripcion}'
                            ]
                        )),
                        "id_tabla_cat_ter" => $s->canBeNull($s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Tabla Categoria Terciaria")),
                            [
                                'table' => 'tablas_categoria',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => 'Tabla Nº {numero}'
                            ]
                        )),
                        "id_puesto_ter" => $s->canBeNull($s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Categoria terciaria")),
                            [
                                'table' => 'categoria_puesto',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id,id_tabla_cat:id_tabla_cat_ter',
                                'format' => '{descripcion}'
                            ]
                        )),
                        "id_periodo_pago" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Periodo de pago")),
                            [
                                'table' => 'periodo_pago',
                                'field' => 'id',
                                'format' => '{periodo}'
                            ]
                        ),
                        "renum_lugar_pago" => $s->canBeNull($s->displayName($f['varchar_64'], "Lugar de pago")),
                        "renum_cuenta_desempleo" => $s->canBeNull($s->displayName($f['varchar_128'], "Cuenta fondo desempleo")),
                        "id_regimen_jub" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Régimen Jubilatorio")),
                            [
                                'table' => 'regimen_jubilatorio',
                                'field' => 'id',
                                'format' => '{descripcion}'
                            ]
                        ),
                        "renum_admin" =>  $s->canBeNull($s->displayName($f['varchar_128'], "Administradora")),
                        "renum_convencionado" => $s->displayName($f['boolean'], "Convencionado"),
                        "cont_aporte_adicional" => $s->displayName($f['decimal'], "Aporte Adicional SS %"),
                        "cont_diferencial" => $s->displayName($f['decimal'], "Contribución Diferencial SS %"),
                        "cont_num_patronal" => $s->displayName($f['decimal'], "Número de tabla para contribuciones"),
                        "cont_patronal_aporta" => $s->displayName($f['boolean'], "Aporta"),
                        "gan_enable_renum_acom" => $s->displayName($f['boolean'], "Forzar la remuneración acumulada"),
                        "gan_value_renum_acom" => $s->enabledBy($s->displayName($f['decimal'], "Valor de remuneración acumulada forzada"), "gan_enable_renum_acom"),
                        "gan_calc_12vo_sac" => $s->displayName($f['boolean'], "Calcular 12vo. SAC"),
                    ],
                    "actions" => $a['default'],
                    "display_name" => "Empleado",
                    "group" => "Personal",
                    "field_groups" => [
                        "Datos Personales" => ["id_tipo_documento", "nro_doc", "nombre", "apellido", "id_nacionalidad", "fecha_nac", "id_genero", "id_estado_civil", "nro_tel", "nro_cel", "nro_emergencias", "email", "dom_calle", "dom_numero", "dom_departamento", "dom_piso", "id_provincia", "cod_postal"],
                        
                        "Datos de Empresa" => ["legajo", "em_id", "cuil", "id_tabla_cat", "id_puesto", "cal_categoria", "area", "tarea_asignada", "seccion", "fecha_ingreso", "fecha_baja", "id_departamento", "fab_campo_libre", "lugar_trabajo", "seguro_obligatorio", "dias_vacaciones", "nro_cuenta_cbu", "nro_cuenta_alt", "id_tcuenta_banco", "sueldo_base", "sucursal"],

                        "Antigüedad reconocida adicional" => ["ant_ad_anios", "ant_ad_meses", "ant_ad_dias"],

                        "Remuneraciones" => ["renum_suma_fija1", "renum_suma_fija2", "renum_suma_fija3", "renum_suma_fija4", "renum_suma_fija5", "id_tabla_cat_sec", "id_puesto_sec", "id_tabla_cat_ter", "id_puesto_ter", "id_periodo_pago", "renum_lugar_pago", "renum_cuenta_desempleo", "id_regimen_jub", "renum_admin", "renum_convencionado"],

                        "Contribuciones" => ["cont_aporte_adicional", "cont_diferencial", "cont_num_patronal", "cont_patronal_aporta"],

                        "Ganancias" => ["gan_enable_renum_acom", "gan_value_renum_acom", "gan_calc_12vo_sac"]
                        
                    ] 
                ]
            ];
        }
    }
?>