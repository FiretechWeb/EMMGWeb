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
            //Sindicatos START
            "uocra_categoria" => [
                ["nombre" => "No informado"],
                ["nombre" => "Oficial especializado"],
                ["nombre" => "Oficial"],
                ["nombre" => "Medio oficial"],
                ["nombre" => "Ayudante"],
                ["nombre" => "Sereno"],
            ],
            "uocra_convenio" => [
                ["nombre" => "Arte estrafalario y religioso"],
                ["nombre" => "Aserraderos de Marmol"],
                ["nombre" => "Calefaccionistas"],
                ["nombre" => "Caleros"],
                ["nombre" => "Caños de Hormigón"],
                ["nombre" => "Electricistas de obras y afines"],
                ["nombre" => "Obreros de la construcción"],
                ["nombre" => "Areas petroleras y gasíferas"]
            ],
            "aec_rosario_categoria" => [
                ["nombre" => "A"],
                ["nombre" => "A 16A"],
                ["nombre" => "B"],
                ["nombre" => "B 16A"],
                ["nombre" => "C"],
                ["nombre" => "C 16A"],
                ["nombre" => "A"],
                ["nombre" => "D"],
                ["nombre" => "E"],
                ["nombre" => "F"]
            ],
            "aec_rosario_puesto" => [
                ["nombre" => "Administrativo"],
                ["nombre" => "Vendedor"],
                ["nombre" => "Cajero"],
                ["nombre" => "Aux. Especializado"],
                ["nombre" => "Auxiliar"],
                ["nombre" => "Maestranza"],
                ["nombre" => "Jornada 6 horas"]
            ],
            "aec_rosario_licencia" => [
                ["nombre" => "Sin licencia"],
                ["nombre" => "Reserva de puesto"],
                ["nombre" => "Licencia sin goze de sueldo"],
                ["nombre" => "Licencia por maternidad"],
                ["nombre" => "Suspensión"],
                ["nombre" => "Estado de excedencia"],
                ["nombre" => "Enfermedad familiar"]
            ],
            "uom_categoria" => [
                ["nombre" => "Operario"],
                ["nombre" => "Operario calificado"],
                ["nombre" => "Operario especializado"],
                ["nombre" => "Operario especialiado multiple"],
                ["nombre" => "Ayudante"],
                ["nombre" => "Medio oficial"],
                ["nombre" => "Oficial"],
                ["nombre" => "Oficial multiple"],
                ["nombre" => "Técnico de 1a."],
                ["nombre" => "Técnico de 2a."],
                ["nombre" => "Técnico de 3a."],
                ["nombre" => "Técnico de 4a."],
                ["nombre" => "Técnico de 5a."],
                ["nombre" => "Técnico de 6a."]
            ],
            "uom_revista" => [
                ["nombre" => "Recibe haberes regularmente"],
                ["nombre" => "Maternidad"],
                ["nombre" => "Reserva por enfermedad"],
                ["nombre" => "Reserva por accidente"],
                ["nombre" => "Desempleo"],
                ["nombre" => "Excedencia"],
                ["nombre" => "Licencia extraordinaria"],
                ["nombre" => "Receso contrato temporada"],
                ["nombre" => "Licencia gremial"],
                ["nombre" => "Otras suspensiones màs de tres meses"],
                ["nombre" => "No se conoce situaciòn de revista"],
                ["nombre" => "Contrato"],
                ["nombre" => "Normal"]
            ],
            "sec_santiago_categoria" => [
                ["nombre" => "ADMINISTRATIVO A"],
                ["nombre" => "ADMINISTRATIVO B"],
                ["nombre" => "ADMINISTRATIVO C"],
                ["nombre" => "ADMINISTRATIVO D"],
                ["nombre" => "ADMINISTRATIVO E"],
                ["nombre" => "ADMINISTRATIVO F"],
                ["nombre" => "AUXILIAR ESPECIALIAZDO A"],
                ["nombre" => "AUXILIAR ESPECIALIAZDO B"],
                ["nombre" => "CAJERO A"],
                ["nombre" => "CAJERO B"],
                ["nombre" => "CAJERO C"],
                ["nombre" => "MAESTRANZA A"],
                ["nombre" => "MAESTRANZA B"],
                ["nombre" => "MAESTRANZA C"],
                ["nombre" => "PERSONAL AUXILIAR A"],
                ["nombre" => "PERSONAL AUXILIAR B"],
                ["nombre" => "PERSONAL AUXILIAR C"],
                ["nombre" => "VENDEDOR A"],
                ["nombre" => "VENDEDOR B"],
                ["nombre" => "VENDEDOR C"],
                ["nombre" => "VENDEDOR D"],
            ],
            "faecys_categoria" => [
                ["nombre" => "Maestranza A"],
                ["nombre" => "Maestranza B"],
                ["nombre" => "Maestranza C"],
                ["nombre" => "Administrativo A"],
                ["nombre" => "Administrativo B"],
                ["nombre" => "Administrativo C"],
                ["nombre" => "Administrativo D"],
                ["nombre" => "Administrativo E"],
                ["nombre" => "Administrativo F"],
                ["nombre" => "Cajeros A"],
                ["nombre" => "Cajeros B"],
                ["nombre" => "Cajeros C"],
                ["nombre" => "Personal Auxiliar A"],
                ["nombre" => "Personal Auxiliar B"],
                ["nombre" => "Personal Auxiliar C"]
            ],
            "spep_sgto_estero_cargo" => [
                [
                    "codigo" => 112396,
                    "nombre" => "Cat. Ordenanza"
                ],
                [
                    "codigo" => 60013,
                    "nombre" => "Rector de instituto superior"
                ],
                [
                    "codigo" => 60045,
                    "nombre" => "Secretario de instituto superior"
                ],
                [
                    "codigo" => 60084,
                    "nombre" => "Director de instituto superior"
                ],
                [
                    "codigo" => 60105,
                    "nombre" => "Bedel"
                ],
                [
                    "codigo" => 60113,
                    "nombre" => "Bibliotecario de instituto superior"
                ],
                [
                    "codigo" => 60127,
                    "nombre" => "Ayudante de trabajos pràcticos"
                ],
                [
                    "codigo" => 60132,
                    "nombre" => "Hora cátedra nivel superior"
                ],
                [
                    "codigo" => 60492,
                    "nombre" => "Profesor de trabajs prácticos"
                ],
                [
                    "codigo" => 60610,
                    "nombre" => "Instructor J.C."
                ],
                [
                    "codigo" => 60735,
                    "nombre" => "Jefe de trabajos prácticos"
                ]
            ],
            "spep_sgto_estero_sit" => [
                ["nombre" => "SUBVENCIONADO"],
                ["nombre" => "PRIVADO"]
            ],
            "spep_sgto_estero_rev" => [
                ["nombre" => "No aplica"],
                ["nombre" => "Titular"],
                ["nombre" => "Provisorio"],
                ["nombre" => "Suplente"],
            ],
            "spep_sgto_estero_lvl" => [
                ["nombre" => "Inicial"],
                ["nombre" => "Primaria"],
                ["nombre" => "Medio"],
                ["nombre" => "Superior no universitario"],
                ["nombre" => "Especial"],
                ["nombre" => "Adultos"]
            ],
            "spep_sgto_estero_obra" => [
                ["nombre" => "OPLAD"],
                ["nombre" => "OSDOP"],
                ["nombre" => "Otra provincial obligatoria"],
                ["nombre" => "Otras"]
            ],
            "spep_sgto_estero_cat" => array_map(function($val) { return ["categoria" => $val]; }, range(1, 30)),
            //Sindicatos END
            //CONCEPTOS START
            "concepto_liquidaciones" => [
                ["nombre" => "Todas las liquidaciones"],
                ["nombre" => "1º Quincena"],
                ["nombre" => "2º Quincena / Mes"],
                ["nombre" => "Por única vez"]
            ],
            "concepto_cat_ganancias" => [
                ["nombre" => "Remuneración habitual"],
                ["nombre" => "Remuneración NO habitual"],
                ["nombre" => "Descuento deducible"],
                ["nombre" => "Indemnización o asignación"],
                ["nombre" => "No aplica"]
            ],
            //CONCEPTOS END
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
            "parentesco" => [
                ["tipo" => "Conyuge"],
                ["tipo" => "Hijo/a"],
                ["tipo" => "Esposa"],
                ["tipo" => "Adherente"],
                ["tipo" => "Adherente Voluntario"],
                ["tipo" => "Concubino/a"],
                ["tipo" => "Otro"]
            ],
            "deduc_ganancias_hijo" => [
                ["porcentaje" => 0.5],
                ["porcentaje" => 1.0]
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