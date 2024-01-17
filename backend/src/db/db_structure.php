<?php
    class DBStructure {
        public static $DB_NAME = "emmgweb";

        public static function getDefaultTables() {
            return array(
                "t_empresa" => "empresa",
                "t_empleado" => "empleado",
                "t_obra_social" => "obra_social",
                "t_modalidad" => "modalidad_contrato",
                "t_situacion" => "situacion_revista", 
                "t_regimen" => "regimen",
                "t_ART" => "ART",
                "t_tipo_servicio" => "tipo_servicio",
                "t_convenio" => "convenio_colectivo",
                "t_cat_empleado" => "categoria_empleado",
                "t_puesto" => "puesto_empleado",
                "t_actividad_ec" => "actividad_economica", 
                "t_mod_liquidacion" => "modalidad_liquidacion"
            );
        }

        public static function dropDB($conn, $dbName) {
            $sql = "DROP DATABASE IF EXISTS $dbName";
            return mysqli_query($conn, $sql);
        }

        public static function createDB($conn, $dbName) {
            $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
            return mysqli_query($conn, $sql);
        }

        public static function createEmpresaTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_empresa']} (
                id BIGINT NOT NULL AUTO_INCREMENT, 
                cuit VARCHAR(32) NOT NULL, 
                razon VARCHAR(128) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createPuestoEmpleadoTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_puesto']} (
                id BIGINT NOT NULL AUTO_INCREMENT, 
                descripcion VARCHAR(256) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createActEconomicaTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_actividad_ec']} (
                id BIGINT NOT NULL AUTO_INCREMENT, 
                nombre VARCHAR(128) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createRegimenTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_regimen']} (
                id BIGINT NOT NULL AUTO_INCREMENT, 
                nombre VARCHAR(64) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createObrasSocialTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_obra_social']} (
                id BIGINT NOT NULL AUTO_INCREMENT, 
                code BIGINT NOT NULL, 
                nombre VARCHAR(256) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createModalidadContratoTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_modalidad']} (
                id BIGINT NOT NULL, 
                code BIGINT NOT NULL, 
                nombre VARCHAR(256) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createSituacionTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_situacion']} (
                id BIGINT NOT NULL, 
                code BIGINT NOT NULL, 
                nombre VARCHAR(64) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createARTTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_ART']} (
                id BIGINT NOT NULL, 
                code BIGINT NOT NULL, 
                nombre VARCHAR(256) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createTipoServicioTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_tipo_servicio']} (
                id BIGINT NOT NULL, 
                code BIGINT NOT NULL, 
                nombre VARCHAR(256) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createConvColectivoTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_convenio']} (
                id BIGINT NOT NULL AUTO_INCREMENT, 
                codigo VARCHAR(32) NOT NULL, 
                descripcion VARCHAR(512) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        }

        public static function createCategoriaTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_convenio']} (
                id BIGINT NOT NULL AUTO_INCREMENT, 
                codigo BIGINT NOT NULL, 
                nombre VARCHAR(64) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        } 

        public static function createPuestoTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_cat_empleado']} (
                id BIGINT NOT NULL AUTO_INCREMENT, 
                codigo BIGINT NOT NULL, 
                nombre VARCHAR(256) NOT NULL, 
                PRIMARY KEY (id) 
                );";
            return mysqli_query($conn, $sql);
        } 

        public static function createEmpleadosTable($conn, $tables = null) {
            if ($tables === null) {
                $tables = self::getDefaultTables();
            }
            $sql = "CREATE TABLE IF NOT EXISTS {$tables['t_empleado']} (
                    em_id BIGINT NOT NULL, 
                    id BIGINT  NOT NULL AUTO_INCREMENT,
                    cuit VARCHAR(32) NOT NULL, 
                    nombre VARCHAR(64) NOT NULL, 
                    apellido VARCHAR(64) NOT NULL, 
                    fecha_inicio DATE NOT NULL, 
                    fecha_cese DATE, 
                    id_obra_social BIGINT NOT NULL, 
                    id_modalidad BIGINT NOT NULL, 
                    id_situacion BIGINT NOT NULL, 
                    id_ART BIGINT NOT NULL, 
                    id_regimen BIGINT NOT NULL, 
                    agropecuario TINYINT(1) NOT NULL, 
                    id_servicio BIGINT NOT NULL, 
                    id_convenio BIGINT NOT NULL, 
                    id_categoria BIGINT NOT NULL, 
                    id_puesto BIGINT NOT NULL, 
                    id_actividad BIGINT NOT NULL, 
                    domicilio_exp VARCHAR(256), 
                    PRIMARY KEY (id, em_id), 
                    FOREIGN KEY (em_id) REFERENCES {$tables['t_empresa']} (id), 
                    FOREIGN KEY (id_obra_social) REFERENCES {$tables['t_obra_social']} (id), 
                    FOREIGN KEY (id_modalidad) REFERENCES {$tables['t_modalidad']} (id), 
                    FOREIGN KEY (id_situacion) REFERENCES {$tables['t_situacion']} (id), 
                    FOREIGN KEY (id_ART) REFERENCES {$tables['t_ART']} (id), 
                    FOREIGN KEY (id_regimen) REFERENCES {$tables['t_regimen']} (id), 
                    FOREIGN KEY (id_servicio) REFERENCES {$tables['t_tipo_servicio']} (id), 
                    FOREIGN KEY (id_convenio) REFERENCES {$tables['t_convenio']} (id), 
                    FOREIGN KEY (id_categoria) REFERENCES {$tables['t_cat_empleado']} (id), 
                    FOREIGN KEY (id_puesto) REFERENCES {$tables['t_puesto']} (id), 
                    FOREIGN KEY (id_actividad) REFERENCES {$tables['t_actividad_ec']} (id) 
                    ) ENGINE=InnoDB;";
            return mysqli_query($conn, $sql);
        }
    }
?>