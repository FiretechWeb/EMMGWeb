<?php

class DBDefaultValues {
    public static function getDefaultData() {
        return [
            "configuracion" => [
                [
                    "valor_mopre" => 556.71,
                    "cant_mopre_max" => 75,
                    "cant_mopre_min" => 3,
                    "min_remunerativo" => 16881.84,
                    "max_remunerativo" => 548651.9,
                    "min_remunerativo_sac" => 25322.76,
                    "max_remunerativo_sac" => 822977.85,
                    "mb_vac_sac" => 1
                ]
            ],
            "periodo_pago" => [
                [
                    "periodo" => "Diario",
                    "dias" => "1",
                    "meses" => "0",
                    "anios" => "0",
                ],
                [
                    "periodo" => "Semanal",
                    "dias" => "7",
                    "meses" => "0",
                    "anios" => "0",
                ],
                [
                    "periodo" => "Quincenal",
                    "dias" => "15",
                    "meses" => "0",
                    "anios" => "0",
                ],
                [
                    "periodo" => "Mensual",
                    "dias" => "0",
                    "meses" => "1",
                    "anios" => "0",
                ],
            ],
            "tipo_cuenta_banco" => [
                ["nombre" => "Cuenta Corriente"],
                ["nombre" => "Caja de Ahorro"]
            ],
            "regimen_jubilatorio" => [
                ["descripcion" => "SIPA"]
            ],
            "forma_pago" => [
                ["forma" => "Efectivo"],
                ["forma" => "Cheque"],
                ["forma" => "Acreditación en cuenta"]
            ],
            "tipo_contratacion" => [
                ["tipo" => "Tiempo Parcial"],
                ["tipo" => "Jornada completa"],
                ["tipo" => "Media Jornada"]
            ],
            "modalidad_contratacion" => [
                [
                    "codigo" => "0",
                    "modalidad" => "Contrato Modalidad Promovida.Reducción 0%"
                ],
                [
                    "codigo" => "1",
                    "modalidad" => "A tiempo parcial: Indeterminado/permanente"
                ],
                [
                    "codigo" => "10",
                    "modalidad" => "Práctica profesionalizante - Dcto. 1374/11 - Pasantía sin obra social"
                ],
                [
                    "codigo" => "100",
                    "modalidad" => "Contrato modalidad promovida.Reducción 100%"
                ],
                [
                    "codigo" => "101",
                    "modalidad" => "Pre-SIJP (Anterior a 07/1994)"
                ],
                [
                    "codigo" => "102",
                    "modalidad" => "Empleado Servicio Eventual en Usuaria DTO 762"
                ],
                [
                    "codigo" => "103",
                    "modalidad" => "Retiro Voluntario - Decreto 263/2018 y otros"
                ],
                [
                    "codigo" => "11",
                    "modalidad" => "Trabajo de temporada"
                ],
                [
                    "codigo" => "110",
                    "modalidad" => "Trabajo permanente prestación continua Ley 26727"
                ],
                [
                    "codigo" => "111",
                    "modalidad" => "Trabajo temporario Ley 26727"
                ],
                [
                    "codigo" => "112",
                    "modalidad" => "Trabajo permanente discontinuo ley 26727"
                ],
                [
                    "codigo" => "113",
                    "modalidad" => "Trabajo por equipo o cuadrilla fafmilar Ley 26727"
                ],
                [
                    "codigo" => "114",
                    "modalidad" => "Trabajo temporario con Reducción Ley 26727"
                ],
                [
                    "codigo" => "115",
                    "modalidad" => "Trabajo permanente discontinuo con Reducción ley 26727"
                ],
                [
                    "codigo" => "12",
                    "modalidad" => "Trabajo eventual"
                ]
            ],
            "situacion_revista" => [
                [
                    "codigo" => "1",
                    "descripcion" => "Activo"
                ],
                [
                    "codigo" => "2",
                    "descripcion" => "Bajas otras causales"
                ],
                [
                    "codigo" => "3",
                    "descripcion" => "Activo Decreto N°796/97"
                ],
                [
                    "codigo" => "4",
                    "descripcion" => "Baja otras causales Decreto N° 796/97"
                ],
                [
                    "codigo" => "5",
                    "descripcion" => "Licencia por maternidad"
                ],
                [
                    "codigo" => "6",
                    "descripcion" => "Suspensiones otras causales"
                ],
                [
                    "codigo" => "7",
                    "descripcion" => "Baja por despido"
                ],
                [
                    "codigo" => "8",
                    "descripcion" => "Baja por despido Decreto N° 796/97"
                ],
                [
                    "codigo" => "9",
                    "descripcion" => "Suspendido. Ley 20744 art.223bis"
                ],
                [
                    "codigo" => "10",
                    "descripcion" => "Licencia por excedencia"
                ],
            ],
            "condiciones" => [
                [
                    "codigo" => "1",
                    "descripcion" => "SERVICIOS COMUNES Mayor de 18 años"
                ],
                [
                    "codigo" => "10",
                    "descripcion" => "Pensión (NO SIPA)"
                ],
                [
                    "codigo" => "11",
                    "descripcion" => "Pensión no Contributiva (NO SIPA)"
                ],
                [
                    "codigo" => "12",
                    "descripcion" => "Art. 8º Ley Nº 27426"
                ],
                [
                    "codigo" => "13",
                    "descripcion" => "Servicios Diferenciados no alcanzados por el Dto. 633/2018"
                ],
                [
                    "codigo" => "2",
                    "descripcion" => "Jubilado"
                ],
                [
                    "codigo" => "3",
                    "descripcion" => "Menor"
                ],
                [
                    "codigo" => "4",
                    "descripcion" => "Menor Anterior"
                ],
                [
                    "codigo" => "5",
                    "descripcion" => "SERVICIOS DIFERENCIADOS Mayor de 18 años"
                ],
                [
                    "codigo" => "6",
                    "descripcion" => "SIN SERVICIOS REALES"
                ]
            ],
            "actividad_laboral" => [
                [
                    "codigo" => "0",
                    "descripcion" => "Zona de Desastre. Decreto 1386/01 excepto actividad agropecuaria"
                ],
                [
                    "codigo" => "1",
                    "descripcion" => "Producción Primaria excepto actividad agropecuaria"
                ],
                [
                    "codigo" => "10",
                    "descripcion" => "UNIVERSIDADES PRIVADAS. Personal no Docente D.1123/99"
                ],
                [
                    "codigo" => "100",
                    "descripcion" => "CSJN Corte Supr de Justicia, Magistrados provinciales, Revisores de Cta sin"
                ]
            ],
            "obras_sociales" => [
                [
                    "codigo" => "307",
                    "descripcion" => "OS  PORTUARIOS ARGENTINOS DE MAR DEL PLATA"
                ],
                [
                    "codigo" => "406",
                    "descripcion" => "OS  DEL PERSONAL DE ORGANISMOS DE CONTROL EXTERNO"
                ],
                [
                    "codigo" => "505",
                    "descripcion" => "OS  DE CAPITANES,  PILOTOS Y PATRONES DE PESCA"
                ],
                [
                    "codigo" => "604",
                    "descripcion" => "O.S.DE AGENTES DE LOTERIAS Y AFINES DE LA REPUBLICA ARGENTINA"
                ],
            ],
            "provincia" => [
                ["nombre" => "Buenos Aires"],
                ["nombre" => "Córdoba"],
                ["nombre" => "La Pampa"],
                ["nombre" => "Santa Fé"],
                ["nombre" => "Neuquén"],
                ["nombre" => "La Rioja"],
                ["nombre" => "Chubut"],
                ["nombre" => "Formosa"],
                ["nombre" => "Rio Negro"],
                ["nombre" => "Tierra del fuego"],
                ["nombre" => "Formosa"]
            ],
            "localidades" => [
                [
                    "prov_id" => 1, //Buenos Aires
                    "nombre" => "Monte Grande"
                ],
                [
                    "prov_id" => 1, //Buenos Aires
                    "nombre" => "Lomas de Zamora"
                ],
                [
                    "prov_id" => 1, //Buenos Aires
                    "nombre" => "Banfield"
                ],
                [
                    "prov_id" => 1, //Buenos Aires
                    "nombre" => "Jagüel"
                ],
                [
                    "prov_id" => 1, //Buenos Aires
                    "nombre" => "Luis Guillon"
                ],
            ],
            "tipo_documento" => [
                ["nombre" => "DNI"],
                ["nombre" => "Pasaporte"],
                ["nombre" => "CUIL"],
                ["nombre" => "Cédula"],
                ["nombre" => "LE"],
                ["nombre" => "LC"],
                ["nombre" => "Otro"]
            ],
            "nacionalidad" => [
                ["nombre" => "Argentina"],
                ["nombre" => "Brasileña"],
                ["nombre" => "Costa Rica"],
                ["nombre" => "Uruguay"],
                ["nombre" => "Estados Unidos"],
                ["nombre" => "Nicaragua"],
                ["nombre" => "Paraguay"],
                ["nombre" => "Peru"],
                ["nombre" => "Bolivia"],
                ["nombre" => "Chile"],
                ["nombre" => "Guatemala"],
                ["nombre" => "Ecuador"],
                ["nombre" => "Venezuela"],
                ["nombre" => "Cuba"]
            ],
            "genero" => [
                ["genero" => "Masculino"],
                ["genero" => "Femenino"],
                ["genero" => "Otro"]
            ],
            "estado_civil" => [
                ["estado" => "Soltero/a"],
                ["estado" => "Casado/a"],
                ["estado" => "Divorciado/a"],
                ["estado" => "Viudo/a"],
                ["estado" => "Separado/a"],
                ["estado" => "Concubino/a"]
            ],
            "actividad_empresa" => [
                [
                    "codigo" => 171200,
                    "nombre" => "ACABADO DE PRODUCTOS TEXTILES"
                ],
                [
                    "codigo" => 112000,
                    "nombre" => "ACTIVIDADES  DE SERVICIOS RELACIONADAS CON LA EXTRACCION DE PETROLEO Y GAS, EXCEPTO LAS ACTIVIDADES DE PROSPECCION"
                ],
                [
                    "codigo" => 659810,
                    "nombre" => "ACTIVIDADES DE CREDITO PARA FINANCIAR OTRAS ACTIVIDADES ECONOMICAS"
                ],
                [
                    "codigo" => 452520,
                    "nombre" => "ACTIVIDADES DE HINCADO DE PILOTES, CIMENTACION Y OTROS TRABAJOS DE HORMIGON ARMADO"
                ],
                [
                    "codigo" => 729000,
                    "nombre" => "ACTIVIDADES DE INFORMATICA N.C.P."
                ],
                [
                    "codigo" => 452590,
                    "nombre" => "ACTIVIDADES ESPECIALIZADAS DE CONSTRUCCION N.C.P."
                ],
                [
                    "codigo" => 662000,
                    "nombre" => "ADMINISTRACION DE FONDOS DE JUBILACIONES Y PENSIONES (A.F.J.P.)"
                ],
                [
                    "codigo" => 14292,
                    "nombre" => "ALBERGUE Y CUIDADO DE  ANIMALES DE TERCEROS"
                ],
                [
                    "codigo" => 713009,
                    "nombre" => "ALQUILER DE EFECTOS PERSONALES Y ENSERES DOMESTICOS N.C.P."
                ],
                [
                    "codigo" => 455000,
                    "nombre" => "ALQUILER DE EQUIPO DE CONSTRUCCION O DEMOLICION DOTADO DE OPERARIOS"
                ]
            ],
            "tipos_empresa" => [
                [
                    "codigo" => 0,
                    "tipo" => "Administración Pública"
                ],
                [
                    "codigo" => 1,
                    "tipo" => "Dec 814/01, Art. 2 Inc. B"
                ],
                [
                    "codigo" => 2,
                    "tipo" => "Servicios Eventuales Inc. 2 Art. B"
                ],
                [
                    "codigo" => 3,
                    "tipo" => "Provincias y otros"
                ],
                [
                    "codigo" => 4,
                    "tipo" => "Dec 814/01, Art. 2 Inc. A"
                ],
                [
                    "codigo" => 5,
                    "tipo" => "Servicios Eventuales Inc. 2 Art. A"
                ],
                [
                    "codigo" => 6,
                    "tipo" => "Decreto N° 814/01 art. 2° inciso b). P"
                ],
                [
                    "codigo" => 7,
                    "tipo" => "Enseñanza Privada"
                ],
                [
                    "codigo" => 8,
                    "tipo" => "Decreto 212/03, AFA Clubes"
                ]
            ],
            "ganancias_config" => [
                [
                    "ali_calc_12vo" => 0,
                    "ali_dec249_ley617" => 1,
                    "ali_tope_inf_2do" => 700875.0,
                    "ali_tope_sup_2do" => 808341.0,
                ]
            ],
            "tipo_tope" => [
                [ "tipo" => "Valor Tope" ],
                [ "tipo" => "Tope Porcentural"],
                [ "tipo" => "Sin Tope"]
            ],
        ];
    }
}

?>