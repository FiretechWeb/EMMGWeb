<?php
    include_once dirname(__FILE__).'/../lib/json_utils.php';
    include_once dirname(__FILE__).'/db_template.php';

    class DBStructure {
        public static function getStructure() {
            $f = DBTemplate::getFieldTemplates();
            $t = DBTemplate::getTableTemplates();
            $ta = DBTemplate::getTemplateActions();
            $s = new DBFieldShortHand();
            $a = new DBActionShortHand();

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
                    "actions" => $ta['updateonly'],
                    "display_name" => "Configuración General",
                    "group" => "Configuración",
                    "store_clientside" => true
                ],
                "modalidad_contratacion" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "modalidad" => $s->unique($s->displayName($f['varchar_256'], "Nombre de modalidad")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Modalidad de contratación",
                    "group" => "Configuración>Laborales",
                    "store_clientside" => true
                ],
                "tipo_contratacion" => [
                    "fields" => [
                        "id" => $f['id'],
                        "tipo" => $s->unique($s->displayName($f['varchar_64'], "Tipo")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Tipo de contratación",
                    "group" => "Configuración>Laborales",
                    "store_clientside" => true
                ],
                "forma_pago" => [
                    "fields" => [
                        "id" => $f['id'],
                        "forma" => $s->unique($s->displayName($f['varchar_128'], "Forma de pago")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Forma de pago",
                    "group" => "Configuración>Laborales",
                    "store_clientside" => true
                ],
                "situacion_revista" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_256'], "Descripción")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Situación de Revista",
                    "group" => "Configuración>Laborales",
                    "store_clientside" => true
                ],
                "condiciones" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_256'], "Descripción")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Condiciones",
                    "group" => "Configuración>Laborales",
                    "store_clientside" => true
                ],
                "actividad_laboral" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_256'], "Descripción")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Actividades",
                    "group" => "Configuración>Laborales",
                    "store_clientside" => true
                ],
                "obras_sociales" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "descripcion" => $s->unique($s->displayName($f['varchar_256'], "Descripción")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Obras Sociales",
                    "group" => "Configuración>Laborales",
                    "store_clientside" => true
                ],
                "tipo_cuenta_banco" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Tipo de cuenta")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Tipo de cuenta bancaria",
                    "group" => "Configuración>Datos",
                    "store_clientside" => true
                ],
                "provincia" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nombre")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Provincia",
                    "group" => "Configuración>Datos",
                    "store_clientside" => true
                ],
                "localidades" => [
                    "fields" => [
                        "id" => $f['id'],
                        "prov_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'provincia',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        ),
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nombre"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Localidades",
                    "group" => "Configuración>Datos",
                    "store_clientside" => true
                ],
                "tipo_documento" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Tipo de documento")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Tipo de documento",
                    "group" => "Configuración>Datos",
                    "store_clientside" => true
                ],
                "nacionalidad" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nacionalidad")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Nacionalidad",
                    "group" => "Configuración>Datos",
                    "store_clientside" => true
                ],
                "parentesco" => [
                    "fields" => [
                        "id" => $f['id'],
                        "tipo" => $s->unique($s->displayName($f['varchar_64'], "Tipo de parentesco")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Parentesco",
                    "group" => "Configuración>Datos",
                    "store_clientside" => true
                ],
                "genero" => [
                    "fields" => [
                        "id" => $f['id'],
                        "genero" => $s->unique($s->displayName($f['varchar_128'], "Genero")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Género",
                    "group" => "Configuración>Datos",
                    "store_clientside" => true
                ],
                "estado_civil" => [
                    "fields" => [
                        "id" => $f['id'],
                        "estado" => $s->unique($s->displayName($f['varchar_128'], "Estado civil")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Estado Civil",
                    "group" => "Configuración>Datos",
                    "store_clientside" => true
                ],
                "actividad_empresa" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "nombre" => $s->unique($s->displayName($f['varchar_256'], "Actividad")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Actividad",
                    "group" => "Configuración>Empresas",
                    "store_clientside" => true
                ],
                "tipos_empresa" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código AFIP")),
                        "tipo" => $s->unique($s->displayName($f['varchar_128'], "Tipo de Empresa")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Tipo de Empresa",
                    "group" => "Configuración>Empresas",
                    "store_clientside" => true
                ],
                "periodo_pago" => [
                    "fields" => [
                        "id" => $f['id'],
                        "periodo" => $s->unique($s->displayName($f['varchar_64'], "Nombre de periodo de pago")),
                        "dias" => $s->canBeNull($s->displayName($f['int'], "Días")),
                        "meses" => $s->canBeNull($s->displayName($f['int'], "Meses")),
                        "anios" => $s->canBeNull($s->displayName($f['int'], "Años")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Periodo de Pago",
                    "group" => "Configuración>Empresas",
                    "store_clientside" => true
                ],
                "regimen_jubilatorio" => [
                    "fields" => [
                        "id" => $f['id'],
                        "descripcion" => $s->unique($s->displayName($f['varchar_64'], "Descripción")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Régimen Jubilatorio",
                    "group" => "Configuración>Empresas",
                    "store_clientside" => true
                ],
                "ganancias_config" => [
                    "fields" => [
                        "id" => $f['id'],
                        "ali_calc_12vo" => $s->displayName($f['boolean'], "Cálcular 12vo sin considerar descuentos deducibles"),
                        "ali_dec249_ley617" => $s->displayName($f['boolean'], "Áplica Dec. 249/21 - Ley 27.617"),
                        "ali_tope_inf_2do" => $s->displayName($f['decimal'], "Tope inferior deducción especial Incr. - 2da Parte"),
                        "ali_tope_sup_2do" => $s->displayName($f['decimal'], "Tope superior deducción especial Incr. - 2da Parte")
                    ],
                    "actions" => $ta['updateonly'],
                    "display_name" => "Configuración",
                    "group" => "Configuración>Ganancias",
                    "field_groups" => [
                        "Álicuotas" => ["ali_calc_12vo", "ali_dec249_ley617", "ali_tope_inf_2do", "ali_tope_sup_2do"],
                    ],
                    "store_clientside" => true
                ],
                "deduc_ganancias_hijo" => [
                    "fields" => [
                        "id" => $f['id'],
                        "porcentaje" => $s->displayName($f['decimal'], "Tipo")
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Deducción hijo",
                    "group" => "Configuración>Ganancias",
                    "store_clientside" => true
                ],
                "tipo_tope" => [
                    "fields" => [
                        "id" => $f['id'],
                        "tipo" => $s->unique($s->displayName($f['varchar_64'], "Tipo"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Tipos de tope",
                    "group" => "Configuración>Ganancias",
                    "store_clientside" => true
                ],
                "alicuotas" => [
                    "fields" => [
                        "id" => $f['id'],
                        "anio" => $s->displayName($f['int'], "Año"),
                        "mes" => $s->displayName($f['int'], "Mes"),
                        "desde" => $s->displayName($f['decimal'], "Desde"),
                        "impuesto_base" => $s->displayName($f['decimal'], "Impuesto Base"),
                        "alicuota" => $s->displayName($f['int'], "Alícuota"),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Álicuotas",
                    "group" => "Configuración>Ganancias",
                    "store_clientside" => true
                ],
                "deducciones_personales" => [
                    "fields" => [
                        "id" => $f['id'],
                        "anio" => $s->displayName($f['int'], "Año"),
                        "mes" => $s->displayName($f['int'], "Mes"),
                        "minimo_no_imp" => $s->displayName($f['decimal'], "Mínimo no Imp."),
                        "deduccion_esp" => $s->displayName($f['decimal'], "Deducción Esp."),
                        "conyuge" => $s->displayName($f['decimal'], "Cónyuge"),
                        "hijos" => $s->displayName($f['decimal'], "Hijos"),
                        "otras_cargas" => $s->displayName($f['decimal'], "Otras cargas")
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Deducciones Personales",
                    "group" => "Configuración>Ganancias",
                    "store_clientside" => true
                ],
                "deducciones_generales" => [
                    "fields" => [
                        "id" => $f['id'],
                        "anio" => $s->displayName($f['int'], "Año"),
                        "descripcion" => $s->displayName($f['varchar_128'], "Descripción"),
                        "id_tipo_tope" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'tipo_tope',
                                'field' => 'id',
                                'format' => '{tipo}'
                            ]), "Tipo Tope"),
                        "enero" => $s->displayName($f['decimal'], "Enero"),
                        "febrero" => $s->displayName($f['decimal'], "Febrero"),
                        "marzo" => $s->displayName($f['decimal'], "Marzo"),
                        "abril" => $s->displayName($f['decimal'], "Abril"),
                        "mayo" => $s->displayName($f['decimal'], "Mayo"),
                        "junio" => $s->displayName($f['decimal'], "Junio"),
                        "julio" => $s->displayName($f['decimal'], "Julio"),
                        "agosto" => $s->displayName($f['decimal'], "Agosto"),
                        "septiembre" => $s->displayName($f['decimal'], "Septiembre"),
                        "octubre" => $s->displayName($f['decimal'], "Octubre"),
                        "noviembre" => $s->displayName($f['decimal'], "Noviembre"),
                        "diciembre" => $s->displayName($f['decimal'], "Diciembre")
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Deducciones Generales",
                    "group" => "Configuración>Ganancias",
                    "store_clientside" => true
                ],
                "concepto_liquidaciones" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nombre de inclusión")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Liquidaciones",
                    "group" => "Configuración>Conceptos",
                    "store_clientside" => true
                ],
                "concepto_cat_ganancias" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nombre de categoria")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Categoría Ganancias",
                    "group" => "Configuración>Conceptos",
                    "store_clientside" => true
                ],
                "concepto_unidad_lsueldo" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_32'], "Unidad en libro sueldo digital")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Unidad libro sueldo",
                    "group" => "Configuración>Conceptos",
                    "store_clientside" => true
                ],
                "concepto_tipo_empleador" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_64'], "Tipo")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Tipos de conceptos empleador",
                    "group" => "Configuración>Conceptos",
                    "store_clientside" => true
                ],
                "concepto_cat_aplicar" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Categoría")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Categorías a aplicar",
                    "group" => "Configuración>Conceptos",
                    "store_clientside" => true
                ],
                "concepto_codigo_spep" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Descripción"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "SPEP Sgo del Estero",
                    "group" => "Configuración>Conceptos",
                    "store_clientside" => true
                ],
                "concepto_tipo_afip" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_64'], "Descripción"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Tipo conceptos AFIP",
                    "group" => "Configuración>Conceptos",
                    "store_clientside" => true
                ],
                "uocra_categoria" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_64'], "Categoria"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Categorias",
                    "group" => "Sindicatos>UOCRA",
                    "store_clientside" => true
                ],
                "uocra_convenio" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Convenio"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Convenios",
                    "group" => "Sindicatos>UOCRA",
                    "store_clientside" => true
                ],
                "aec_rosario_categoria" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_32'], "Categoria"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Categorias",
                    "group" => "Sindicatos>AEC Rosario",
                    "store_clientside" => true
                ],
                "aec_rosario_puesto" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Puesto"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Puestos",
                    "group" => "Sindicatos>AEC Rosario",
                    "store_clientside" => true
                ],
                "aec_rosario_licencia" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Licencia"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Licencias",
                    "group" => "Sindicatos>AEC Rosario",
                    "store_clientside" => true
                ],
                "uom_categoria" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Categoría"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Categoria",
                    "group" => "Sindicatos>UOM",
                    "store_clientside" => true
                ],
                "uom_revista" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Sit. Revista"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Situación de revista",
                    "group" => "Sindicatos>UOM",
                    "store_clientside" => true
                ],
                "sec_santiago_categoria" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Categoría"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Categoría",
                    "group" => "Sindicatos>SEC Santiago del Estero",
                    "store_clientside" => true
                ],
                "faecys_categoria" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Categoría"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Categoría",
                    "group" => "Sindicatos>FAECYS",
                    "store_clientside" => true
                ],
                "spep_sgto_estero_cargo" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código AFIP")),
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Cargo"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Cargos",
                    "group" => "Sindicatos>SPEP Stgo. del Estero",
                    "store_clientside" => true
                ],
                "spep_sgto_estero_sit" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Situación de cargo"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Situación",
                    "group" => "Sindicatos>SPEP Stgo. del Estero",
                    "store_clientside" => true
                ],
                "spep_sgto_estero_rev" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Revista cargo"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Revista",
                    "group" => "Sindicatos>SPEP Stgo. del Estero",
                    "store_clientside" => true
                ],
                "spep_sgto_estero_lvl" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Nivel de enseñanza"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Nivel de enseñanza",
                    "group" => "Sindicatos>SPEP Stgo. del Estero",
                    "store_clientside" => true
                ],
                "spep_sgto_estero_obra" => [
                    "fields" => [
                        "id" => $f['id'],
                        "nombre" => $s->unique($s->displayName($f['varchar_128'], "Obra social obligatoría"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Obra Social",
                    "group" => "Sindicatos>SPEP Stgo. del Estero",
                    "store_clientside" => true
                ],
                "spep_sgto_estero_cat" => [
                    "fields" => [
                        "id" => $f['id'],
                        "categoria" => $s->unique($s->displayName($f['int'], "Categoría"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Categoría",
                    "group" => "Sindicatos>SPEP Stgo. del Estero",
                    "store_clientside" => true
                ],
                "concepto_afip" => [
                    "fields" => [
                        "id" => $f['id'],
                        "codigo" => $s->displayName($f['bigint'], "Código AFIP"),
                        "nombre" => $s->displayName($f['varchar_256'], "Nombre"),
                        "id_tipo_concepto" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'concepto_tipo_afip',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Tipo de concepto"),
                        "sipa_aporta" => $s->displayName($f['boolean'], "Aportes (Rem. 1)"),
                        "sipa_contribuye" => $s->displayName($f['boolean'], "Contribuciones (Rem. 2)"),
                        "inssjyp_aporta" => $s->displayName($f['boolean'], "Aportes (Rem. 5)"),
                        "inssjyp_contribuye" => $s->displayName($f['boolean'], "Contribuciones (Rem. 2)"),
                        "obra_social_aporta" => $s->displayName($f['boolean'], "Aportes (Rem. 4)"),
                        "obra_social_contribuye" => $s->displayName($f['boolean'], "Contribuciones (Rem. 8)"),
                        "fondo_sol_aporta" => $s->displayName($f['boolean'], "Aportes (Rem. 4)"),
                        "fondo_sol_contribuye" => $s->displayName($f['boolean'], "Contribuciones (Rem. 8)"),
                        "renatea_aporta" => $s->displayName($f['boolean'], "Aportes (Rem. 1)"),
                        "renatea_contribuye" => $s->displayName($f['boolean'], "Contribuciones (Rem. 3)"),
                        "asig_contribuye" => $s->displayName($f['boolean'], "Contribuciones (Rem. 3)"),
                        "fondo_empleo_contribuye" => $s->displayName($f['boolean'], "Contribuciones (Rem. 3)"),
                        "ley_riesgos_contribuye" => $s->displayName($f['boolean'], "Contribuciones (Rem. 9)"),
                        "seguro_vida_contribuye" => $s->displayName($f['boolean'], "Contribuciones"),
                        "reg_dif_aporta" => $s->displayName($f['boolean'], "Aportes (Rem. 6)"),
                        "reg_esp_aporta" => $s->displayName($f['boolean'], "Aportes (Rem. 7)")
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "AFIP (Libro sueldo digital)",
                    "group" => "Conceptos",
                    "field_groups" => [
                        "Datos Generales" => ["codigo", "nombre", "id_tipo_concepto"],
                        "Sistema Previsional Argentino - SIPA" => ["sipa_aporta", "sipa_contribuye"],
                        "INSSJyP" => ["inssjyp_aporta", "inssjyp_contribuye"],
                        "Obra Social" => ["obra_social_aporta", "obra_social_contribuye"],
                        "Fondo solidario de Redistribución (ex ANSSAL)" => ["fondo_sol_aporta", "fondo_sol_contribuye"],
                        "RENATEA (ex RENATRE)" => ["renatea_aporta", "renatea_contribuye"],
                        "Asignaciones familiares" => ["asig_contribuye"],
                        "Fondo nacional de empleo" => ["fondo_empleo_contribuye"],
                        "Ley de Riesgos del Trabajo" => ["ley_riesgos_contribuye"],
                        "Seguro colectivo de vida Olbigatorio" => ["seguro_vida_contribuye"],
                        "Régimenes Diferenciales" => ["reg_dif_aporta"],
                        "Régimenes Especiales" => ["reg_esp_aporta"]
                    ],
                    "store_clientside" => true
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
                                'table' => 'actividad_empresa',
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
                    "actions" => $ta['default'],
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
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "nombre" => $s->displayName($f['varchar_64'], "Nombre"),
                    ],
                    "actions" => $ta['default'],
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
                    "actions" => $ta['default'],
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
                    "actions" => $ta['default'],
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
                    "actions" => $ta['default'],
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
                    "actions" => $ta['default'],
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
                    "actions" => $ta['default'],
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
                    "actions" => $ta['default'],
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
                    "actions" => $ta['default'],
                    "display_name" => "Departamentos",
                    "group" => "Empresas"   
                ],
                //concepto_tipo_empleador
                "conceptos_empleador" => [
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
                        "codigo" => $s->unique($s->displayName($f['bigint'], "Código")),
                        "descripcion" => $s->displayName($f['varchar_128'], "Descripción"),
                        "id_tipo" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'concepto_tipo_empleador',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Tipo de Concepto"),
                        "id_liquidaciones" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'concepto_liquidaciones',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Incluir concepto en"),
                        "titulo_impresion" => $s->displayName($f['varchar_128'], "Título de impresión"),
                        "imp_en_recibos" => $s->displayName($f['boolean'], "Imprimir en recibos"),
                        "usa_mopre" => $s->displayName($f['boolean'], "Utiliza MOPRE"),
                        "id_cat_ganancias" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'concepto_cat_ganancias',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Categoría Ganancias"),
                        "retencion_ganancias" => $s->displayName($f['boolean'], "Este concepto constituye la retención de ganancias"),
                        "horas_extras" => $s->displayName($f['boolean'], "Concepto representa horas extras gravadas por gcias."),
                        "id_concepto_afip" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'concepto_afip',
                                'field' => 'id',
                                'format' => '{codigo} {nombre}'
                            ]), "Concepto AFIP para Libro Sueldos Digital"),
                        "id_unidad_libro_sueldo" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'concepto_unidad_lsueldo',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Unidad en Libro de Sueldos Digital"),
                        "id_cuenta_contable" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'cuenta_contable',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{nombre}'
                            ]), "Cuenta contable"),
                        "id_cat_aplicar" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'concepto_cat_aplicar',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Categoría a aplicar en Dec. en línea / libro sueldos digital / SICOSS"),
                        "formula" => $s->displayName($f['varchar_256'], "Fórmula para cálculos"),
                        "id_codigo_spep" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'concepto_codigo_spep',
                                'field' => 'id',
                                'format' => '{codigo} {nombre}'
                            ]), "Código SPEP Santiago del Estero"),
                        "adic_no_rem9" => $s->displayName($f['boolean'], "No incluir en remuneración 9 (Dec. en linea y LSD)"),
                        "adic_rem_variable" => $s->displayName($f['boolean'], "Es remuneración variable"),
                        "adic_inc_142020" => $s->displayName($f['boolean'], "Representa el incremento Dec. 14/2020"),
                        "adic_maternidad" => $s->displayName($f['boolean'], "Maternidad (Dec. en línea y LSD)"),
                        "adic_exportar_can" => $s->displayName($f['boolean'], "Exportar CAN a Libro de Sueldos Digital"),
                        "bdif_aporte_os_fsr" => $s->displayName($f['boolean'], "Base dif. de aporte OS y FSR (Suma a Rem. 4)"),
                        "bdif_contrib_os_fsr" => $s->displayName($f['boolean'], "Base dif. de aporte OS y FSR (Suma a Rem. 8)"),
                        "bdif_lrt" => $s->displayName($f['boolean'], "Base dif. de LRT (Suma a Rem. 9)"),
                        "bdif_aporte_ss" => $s->displayName($f['boolean'], "Base dif. de aporte SS (Suma a Rem. 1 y 5)"),
                        "bdif_contrib_ss" => $s->displayName($f['boolean'], "Base dif. de contrib. SS (Suma a Rem. 2 y 3)")
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Conceptos Empleador",
                    "field_groups" => [
                        "Datos Generales" => ["em_id", "codigo", "descripcion", "id_tipo", "id_liquidaciones", "titulo_impresion", "imp_en_recibos", "usa_mopre", "id_cat_ganancias", "retencion_ganancias", "horas_extras", "id_concepto_afip", "id_unidad_libro_sueldo", "id_cuenta_contable", "id_cat_aplicar", "formula", "id_codigo_spep"],

                        "Opciones adicionales" => ["adic_no_rem9", "adic_rem_variable", "adic_inc_142020", "adic_maternidad", "adic_exportar_can"],

                        "Bases Cálculo Diferencial (LSD)" => ["bdif_aporte_os_fsr", "bdif_contrib_os_fsr", "bdif_lrt", "bdif_aporte_ss", "bdif_contrib_ss"]
                    ],
                    "group" => "Conceptos"
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
                            $s->displayName($f['bigint'], "Tabla Categoria"),
                            [
                                'table' => 'tablas_categoria',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => 'Tabla Nº {numero}'
                            ]
                        ),
                        "id_puesto" => $s->foreignKey(
                            $s->displayName($f['bigint'], "Categoria Puesto"),
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
                            $s->displayName($f['bigint'], "Departamento"),
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
                        "cont_aporte_adicional" => $s->canBeNull($s->displayName($f['decimal'], "Aporte Adicional SS %")),
                        "cont_diferencial" => $s->canBeNull($s->displayName($f['decimal'], "Contribución Diferencial SS %")),
                        "cont_num_patronal" => $s->canBeNull($s->displayName($f['int'], "Número de tabla para contribuciones")),
                        "gan_enable_renum_acom" => $s->canBeNull($s->displayName($f['boolean'], "Forzar la remuneración acumulada")),
                        "gan_value_renum_acom" => $s->canBeNull($s->enabledBy($s->displayName($f['decimal'], "Valor de remuneración acumulada forzada"), "gan_enable_renum_acom")),
                        "gan_calc_12vo_sac" => $s->canBeNull($s->displayName($f['boolean'], "Calcular 12vo. SAC")),
                        "id_modalidad_cont" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Modalidad de contratación"),
                            [
                                'table' => 'modalidad_contratacion',
                                'field' => 'id',
                                'format' => '{codigo} - {modalidad}'
                            ]
                        )),
                        "id_tipo_contratacion" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Tipo de contratación"),
                            [
                                'table' => 'tipo_contratacion',
                                'field' => 'id',
                                'format' => '{tipo}'
                            ]
                        )),
                        "lab_vencimiento" => $s->canBeNull($s->displayName($f['date'], "Vencimiento")),
                        "lab_ley26940" => $s->canBeNull($s->displayName($f['boolean'], "Ley 26940 - No detraer mínimo")),
                        "id_jurisdiccion" => $s->canBeNull($s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'provincia',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Jurisdicción")),
                        "id_revista1" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Situación de Revista 1"),
                            [
                                'table' => 'situacion_revista',
                                'field' => 'id',
                                'format' => '{codigo} {descripcion}'
                            ]
                        )),
                        "lab_dia_revista1" => $s->canBeNull($s->displayName($f['int'], "Día Inicio Sit Rev. 1")),
                        "id_revista2" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Situación de Revista 2"),
                            [
                                'table' => 'situacion_revista',
                                'field' => 'id',
                                'format' => '{codigo} {descripcion}'
                            ]
                        )),
                        "lab_dia_revista2" => $s->canBeNull($s->displayName($f['int'], "Día Inicio Sit Rev. 2")),
                        "id_revista3" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Situación de Revista 3"),
                            [
                                'table' => 'situacion_revista',
                                'field' => 'id',
                                'format' => '{codigo} {descripcion}'
                            ]
                        )),
                        "lab_dia_revista3" => $s->canBeNull($s->displayName($f['int'], "Día Inicio Sit Rev. 3")),
                        "id_condicion" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Condición"),
                            [
                                'table' => 'condiciones',
                                'field' => 'id',
                                'format' => '{codigo} {descripcion}'
                            ]
                        )),
                        "id_actividad" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Actividad"),
                            [
                                'table' => 'actividad_laboral',
                                'field' => 'id',
                                'format' => '{codigo} {descripcion}'
                            ]
                        )),
                        "id_obra_social" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Obra social"),
                            [
                                'table' => 'obras_sociales',
                                'field' => 'id',
                                'format' => '{codigo} {descripcion}'
                            ]
                        )),
                        "id_provincia_laboral" => $s->canBeNull($s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'provincia',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Provincia")),
                        "id_localidad_laboral" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Localidad"),
                            [
                                'table' => 'localidades',
                                'field' => 'id',
                                'extra_relation' => 'prov_id:id_provincia_laboral',
                                'format' => '{nombre}'
                            ]
                        )),
                        "id_forma_pago" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Forma de pago"),
                            [
                                'table' => 'forma_pago',
                                'field' => 'id',
                                'format' => '{forma}'
                            ]
                        )),
                        "lab_obs" => $s->canBeNull($s->displayName($f['varchar_256'], "Observaciones"))
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Empleado",
                    "group" => "Personal",
                    "field_groups" => [
                        "Datos Personales" => ["id_tipo_documento", "nro_doc", "nombre", "apellido", "id_nacionalidad", "fecha_nac", "id_genero", "id_estado_civil", "nro_tel", "nro_cel", "nro_emergencias", "email", "dom_calle", "dom_numero", "dom_departamento", "dom_piso", "id_provincia", "cod_postal"],
                        
                        "Datos de Empresa" => ["legajo", "em_id", "cuil", "id_tabla_cat", "id_puesto", "cal_categoria", "area", "tarea_asignada", "seccion", "fecha_ingreso", "fecha_baja", "id_departamento", "fab_campo_libre", "lugar_trabajo", "seguro_obligatorio", "dias_vacaciones", "nro_cuenta_cbu", "nro_cuenta_alt", "id_tcuenta_banco", "sueldo_base", "sucursal"],

                        "Antigüedad reconocida adicional" => ["ant_ad_anios", "ant_ad_meses", "ant_ad_dias"],

                        "Contribuciones" => ["cont_aporte_adicional", "cont_diferencial", "cont_num_patronal"],

                        "Ganancias" => ["gan_enable_renum_acom", "gan_value_renum_acom", "gan_calc_12vo_sac"],

                        "Laborales" => ["id_modalidad_cont", "id_tipo_contratacion", "lab_vencimiento", "lab_ley26940", "id_jurisdiccion", "id_revista1", "lab_dia_revista1", "id_revista2", "lab_dia_revista2", "id_revista3", "lab_dia_revista3", "id_condicion", "id_actividad", "id_obra_social", "id_provincia_laboral", "id_localidad_laboral", "id_forma_pago", "lab_obs"]
                    ] 
                ],
                "empleado_remuneraciones" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "renum_suma_fija1" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 1")),
                        "renum_suma_fija2" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 2")),
                        "renum_suma_fija3" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 3")),
                        "renum_suma_fija4" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 4")),
                        "renum_suma_fija5" => $s->canBeNull($s->displayName($f['decimal'], "Suma Fija 5")),
                        "id_tabla_cat_sec" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Tabla Categoria Secundaria"),
                            [
                                'table' => 'tablas_categoria',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => 'Tabla Nº {numero}'
                            ]
                        )),
                        "id_puesto_sec" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Categoria secundaria"),
                            [
                                'table' => 'categoria_puesto',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id,id_tabla_cat:id_tabla_cat_sec',
                                'format' => '{descripcion}'
                            ]
                        )),
                        "id_tabla_cat_ter" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Tabla Categoria Terciaria"),
                            [
                                'table' => 'tablas_categoria',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => 'Tabla Nº {numero}'
                            ]
                        )),
                        "id_puesto_ter" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Categoria terciaria"),
                            [
                                'table' => 'categoria_puesto',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id,id_tabla_cat:id_tabla_cat_ter',
                                'format' => '{descripcion}'
                            ]
                        )),
                        "id_periodo_pago" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Periodo de pago"),
                            [
                                'table' => 'periodo_pago',
                                'field' => 'id',
                                'format' => '{periodo}'
                            ]
                        )),
                        "renum_lugar_pago" => $s->canBeNull($s->displayName($f['varchar_64'], "Lugar de pago")),
                        "renum_cuenta_desempleo" => $s->canBeNull($s->displayName($f['varchar_128'], "Cuenta fondo desempleo")),
                        "id_regimen_jub" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Régimen Jubilatorio"),
                            [
                                'table' => 'regimen_jubilatorio',
                                'field' => 'id',
                                'format' => '{descripcion}'
                            ]
                        )),
                        "renum_admin" =>  $s->canBeNull($s->displayName($f['varchar_128'], "Administradora")),
                        "renum_convencionado" => $s->canBeNull($s->displayName($f['boolean'], "Convencionado")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Remuneraciones",
                    "group" => "Personal"   
                ],
                "empleado_uocra" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "id_uocra_cat" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Categoría"),
                            [
                                'table' => 'uocra_categoria',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "id_uocra_convenio" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Convenio"),
                            [
                                'table' => 'uocra_convenio',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "uocra_afiliado" => $s->canBeNull($s->displayName($f['boolean'], "Afiliado")),
                        "uocra_admin_pub" => $s->canBeNull($s->displayName($f['boolean'], "Administración Pública")),
                        "uocra_gremio" => $s->canBeNull($s->displayName($f['boolean'], "Pertenece al gremio")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "UOCRA",
                    "group" => "Personal>Sindicatos / Organismos"   
                ],
                "empleado_aoec_rosario" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "id_aec_rosario_cat" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Convenio"),
                            [
                                'table' => 'aec_rosario_categoria',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "id_aec_rosario_puesto" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Puesto"),
                            [
                                'table' => 'aec_rosario_puesto',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "id_aec_rosario_licencia" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Licencia"),
                            [
                                'table' => 'aec_rosario_licencia',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "aec_rosario_afiliado" => $s->canBeNull($s->displayName($f['boolean'], "Afiliado")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "AEC Rosario",
                    "group" => "Personal>Sindicatos / Organismos"   
                ],
                "empleado_uom" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "id_uom_categoria" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Categoria"),
                            [
                                'table' => 'uom_categoria',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "id_uom_revista" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Situación de revista"),
                            [
                                'table' => 'uom_revista',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "uom_afiliado" => $s->canBeNull($s->displayName($f['boolean'], "Afiliado")),
                        "uom_sindicato" => $s->canBeNull($s->displayName($f['boolean'], "Sindicato")),
                        "uom_incapacitado" => $s->canBeNull($s->displayName($f['boolean'], "Incapacitado")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "UOM",
                    "group" => "Personal>Sindicatos / Organismos"   
                ],
                "empleado_sec_stgo" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "id_sec_santiago_cat" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Categoria"),
                            [
                                'table' => 'sec_santiago_categoria',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "sec_santiago_afiliado" => $s->canBeNull($s->displayName($f['boolean'], "Afiliado")),
                        "sec_santiago_jubilado" => $s->canBeNull($s->displayName($f['boolean'], "Jubilado")),
                        "sec_santiago_cargas" => $s->canBeNull($s->displayName($f['boolean'], "Cargas de familia")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "SEC Santiago del Estero",
                    "group" => "Personal>Sindicatos / Organismos"   
                ],
                "empleado_faecys" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "id_faecys_cat" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Categoria"),
                            [
                                'table' => 'faecys_categoria',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "faecys_afiliado" => $s->canBeNull($s->displayName($f['boolean'], "Afiliado")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "FAECYS",
                    "group" => "Personal>Sindicatos / Organismos"   
                ],
                "empleado_spep" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "id_spep_lvl" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Nivel de enseñanza"),
                            [
                                'table' => 'spep_sgto_estero_lvl',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "spep_por_desc" => $s->canBeNull($s->displayName($f['decimal'], "Porc. Descuentos")),
                        "id_spep_obra" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Obra social obligatoria"),
                            [
                                'table' => 'spep_sgto_estero_obra',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "id_spep_cat" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Categoría"),
                            [
                                'table' => 'spep_sgto_estero_cat',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "id_spep_cargo1" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Cargo 1"),
                            [
                                'table' => 'spep_sgto_estero_cargo',
                                'field' => 'id',
                                'format' => '{codigo} {nombre}'
                            ]
                        )),
                        "id_spep_sit1" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Situación cargo 1"),
                            [
                                'table' => 'spep_sgto_estero_sit',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "spep_horas_cargo1" => $s->canBeNull($s->displayName($f['boolean'], "Horas cargo 1")),
                        "id_spep_rev1" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Revista cargo 1"),
                            [
                                'table' => 'spep_sgto_estero_rev',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "SPEP Sgo. del estero",
                    "group" => "Personal>Sindicatos / Organismos"   
                ],
                "empleado_spep_cargos" => [
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
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "id_spep_cargo" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Cargo"),
                            [
                                'table' => 'spep_sgto_estero_cargo',
                                'field' => 'id',
                                'format' => '{codigo} {nombre}'
                            ]
                        )),
                        "id_spep_sit" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Situación cargo"),
                            [
                                'table' => 'spep_sgto_estero_sit',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                        "spep_horas_cargo" => $s->canBeNull($s->displayName($f['boolean'], "Horas cargo")),
                        "id_spep_rev" => $s->canBeNull($s->foreignKey(
                            $s->displayName($f['bigint'], "Revista cargo"),
                            [
                                'table' => 'spep_sgto_estero_rev',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]
                        )),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "SPEP Cargos",
                    "group" => "Personal>Sindicatos / Organismos"   
                ],
                "empleado_patronales" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "pat_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Patronales")),
                            [
                                'table' => 'patronales',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{descripcion}'
                            ]
                        )
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Aportes patronales",
                    "group" => "Personal>Contribuciones"   
                ],
                "empleado_costos_asoc" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "centro_costo_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Patronales")),
                            [
                                'table' => 'centro_costos',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{nombre}'
                            ]
                        ),
                        "porcentaje" => $s->displayName($f['decimal'], "Porcentaje")
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Centros de costos asociados",
                    "group" => "Personal>Contribuciones"   
                ],
                "empleado_embargos" => [
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
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "descripcion" => $s->displayName($f['varchar_128'], "Descripción del embargo"),
                        "monto" => $s->displayName($f['decimal'], "Monto"),
                        "monto_abonar" => $s->displayName($f['decimal'], "Monto a abonar"),
                        "cbu_judicial" => $s->displayName($f['varchar_64'], "CBU Dep. Judiciar"),
                        "caratula_exp" => $s->displayName($f['varchar_64'], "Carátula Exp."),
                        "nro_doc_bef" => $s->displayName($f['bigint'], "Nro. Doc. Beneficiario"),
                        "orden_exp" => $s->displayName($f['int'], "Orden en Exportación"),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Embargos",
                    "group" => "Personal"   
                ],
                "empleado_familiares" => [
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
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                        "nombre" => $s->displayName($f['varchar_128'], "Nombre del familiar"),
                        "vinculo_comienzo" => $s->canBeNull($s->displayName($f['date'], "Comienzo del vínculo")),
                        "vinculo_fin" => $s->canBeNull($s->displayName($f['date'], "Finalización del vínculo")),
                        "id_tipo_documento" => $s->displayName(
                            $s->foreignKey($f['bigint'], 
                            [
                                'table' => 'tipo_documento',
                                'field' => 'id',
                                'format' => '{nombre}'
                            ]), "Tipo de Documento"),
                        "nro_doc" => $s->unique($s->displayName($f['bigint'], "Número de documento")),
                        "id_parentesco" => $s->displayName(
                            $s->foreignKey($f['bigint'],
                            [
                                'table' => 'parentesco',
                                'field' => 'id',
                                'format' => '{tipo}'
                            ]), "Parentesco"),
                        "imp_libro_ley" => $s->displayName($f['boolean'], "Imprime en libro ley"),
                        "escolarizado" => $s->displayName($f['boolean'], "Escolarizado/a"),
                        "discapacitado" => $s->displayName($f['boolean'], "Discapacitado/a"),
                        "deduce_ganancias" => $s->displayName($f['boolean'], "Deduce ganancias"),
                        "id_dec_ganancias_hijo" => $s->enabledBy($s->displayName(
                            $s->foreignKey($f['bigint'],
                            [
                                'table' => 'deduc_ganancias_hijo',
                                'field' => 'id',
                                'format' => '{porcentaje}'
                            ]), "% Deducción Ganancias Hijo"), "deduce_ganancias"),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Familiares",
                    "group" => "Personal"   
                ],
                "recibo" => [
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
                        "codigo_liquid" => $s->unique($s->displayName($f['bigint'], "ID de liquidación")),
                        "fecha_pago" => $s->displayName($f['date'], "Fecha de pago"),
                        "ini_periodo_liq" => $s->displayName($f['date'], "Inicio período de liq."),
                        "fin_periodo_liq" => $s->displayName($f['date'], "Fin período de liq."),
                        "cuil" => $s->displayName($f['bigint'], "CUIL"),
                        "comentarios" => $s->displayName($f['varchar_512'], "Comentarios"),
                    ],
                    "actions" => $a->add($ta['default'], 'liquidar', ['DBAPILiquidacion', 'calcularLiquidacion']),
                    "display_name" => "Recibo",
                    "group" => "Recibos"   
                ],
                "recibo_empleados" => [
                    "fields" => [
                        "em_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empresa")),
                            [
                                'table' => 'empresas',
                                'field' => 'id',
                                'format' => '{razon}'
                            ]
                        ),
                        "id_recibo" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Código de liquidación")),
                            [
                                'table' => 'recibo',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{codigo_liquid}'
                            ]
                        ),
                        "pr_id" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Empleado")),
                            [
                                'table' => 'empleado',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{cuil} - {nombre} {apellido}'
                            ]
                        ),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Recibo Empleados",
                    "group" => "Recibos"   
                ],
                "recibo_conceptos" => [
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
                        "id_recibo" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Código de liquidación")),
                            [
                                'table' => 'recibo',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{codigo_liquid}'
                            ]
                        ),
                        "id_concepto_empleador" => $s->foreignKey(
                            $s->primary($s->displayName($f['bigint'], "Concepto Empleador")),
                            [
                                'table' => 'conceptos_empleador',
                                'field' => 'id',
                                'extra_relation' => 'em_id:em_id',
                                'format' => '{codigo} {descripcion}'
                            ]
                        ),
                        "cantidad" => $s->canBeNull($s->displayName($f['decimal'], "Cantidad")),
                        "importe" =>  $s->canBeNull($s->displayName($f['decimal'], "Importe")),
                    ],
                    "actions" => $ta['default'],
                    "display_name" => "Recibo Conceptos",
                    "group" => "Recibos"   
                ],
            ];
        }
    }
?>