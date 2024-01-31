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
            "tipo_cuenta_banco" => [
                ["nombre" => "Cuenta Corriente"],
                ["nombre" => "Caja de Ahorro"]
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
            "actividad" => [
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
            ]
        ];
    }
}

?>