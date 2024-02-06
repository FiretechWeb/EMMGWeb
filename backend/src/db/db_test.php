<?php

class DBTestData {

    public static $randomValues = [
        "empresas" => [
            "data" => [
                "cuit" => [
                    20383614903,
                    30988694122,
                    24224990681,
                    34520141407,
                    34852262577
                ],
                "razon" => [
                    "BACIGALUPPI SRL",
                    "EMMG SRL",
                    "SIPA PARARRAYOS",
                    "GALANIZADOS LANÚS",
                    "TORRESUR SRL"
                ],
                "tel" => [
                    "4290-7551",
                    "3232-1235",
                    "7565-1235",
                    "9845-4235",
                    "88-88845"
                ],
                "domicilio" => [
                    "Nicolás Avellaneda 712",
                    "Carlos cervetti 125",
                    "Avenida Fair 1235",
                    "Pedro baltazar 456",
                    "Castex 756"
                ],
                "ciudad" => [
                    "Monte Grande",
                    "Lanús",
                    "Luis Guillón",
                    "Lomas de Zamora",
                    "Moreno"
                ],
                "id_provincia" => [1, 2, 3, 4, 5],
                "id_tipo" => [1, 2, 3, 4, 5],
                "id_actividad" => [1, 2, 3, 4, 5],
                "cuenta_bancaria" => [
                    "1235428/2",
                    "9845351/3",
                    "2351862/5",
                    "9786521/2",
                    "3758452/2",
                ],
                "id_tcuenta_banco" => [1, 2],
                "hs_completa" => [160, 128],
                "dias_completa" => [36, 40, 28],
                "imp_detraccion" => [2624.25, 1232.25, 7242.25]
            ],
            "min" => 2,
            "max" => 5
        ]
    ];

    public static function getRandomTableData($tableName, $tableStructure) {
        if (!isset(self::$randomValues[$tableName])) {
            return null;
        }
        if (!isset($tableStructure[$tableName])) {
            return null;
        }
        $tableFields = $tableStructure[$tableName]['fields'];
        $randomTableValues = self::$randomValues[$tableName]['data'];
        $r = [];

        foreach ($tableFields as $fieldName => $fieldData) {
            if (!isset($randomTableValues[$fieldName])) {
                continue;
            }
            $randomFields = $randomTableValues[$fieldName];
            $r[$fieldName] = $randomFields[array_rand($randomFields)];
        }

        return $r;
    }

    public static function getRandomData($tableStructure) {
        $r = [];
        foreach (self::$randomValues as $tableName => $randomData) {
            $count = rand($randomData['min'], $randomData['max']);
            $r[$tableName] = [];
            for ($i=0; $i < $count; $i++) {
                $r[$tableName][] = self::getRandomTableData($tableName, $tableStructure);
            }
        }
        return $r;
    }
}
?>