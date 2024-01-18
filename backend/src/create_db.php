<?php
    include 'config/def.php';
    include 'config/run_settings.php';
    include 'lib/enable_cors.php';
    include 'lib/json_utils.php';
    include 'db/db_structure.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {    
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = mysqli_connect(Config::$HOST_URL, Config::$HOST_USER, Config::$HOST_PASSWORD);

            if (!$conn) {
                echo JSONResponse::error("Connection failed: " . mysqli_connect_error());
                exit(0);
            }
            if (!DBStructure::dropDB($conn, DBStructure::$DB_NAME)) {
                echo JSONResponse::error("Error dropping database: ".mysqli_error($conn));
                exit(0);
            }
            if (!DBStructure::createDB($conn, DBStructure::$DB_NAME)) {
                echo JSONResponse::error("Error creating database: ".mysqli_error($conn));
                exit(0);
            }
            
            if (!mysqli_select_db($conn, DBStructure::$DB_NAME)) {
                echo JSONResponse::error("Connection to database failed: " .  mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createActEconomicaTable($conn)) {
                echo JSONResponse::error("Error creating actividad economica table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createARTTable($conn)) {
                echo JSONResponse::error("Error creating ART table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createCategoriaTable($conn)) {
                echo JSONResponse::error("Error creating categoria table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createConvColectivoTable($conn)) {
                echo JSONResponse::error("Error creating convenio colectivo table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createModalidadContratoTable($conn)) {
                echo JSONResponse::error("Error creating modalidad de contrato table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createObrasSocialTable($conn)) {
                echo JSONResponse::error("Error creating obra social table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createPuestoTable($conn)) {
                echo JSONResponse::error("Error creating puesto de trabajo table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createRegimenTable($conn)) {
                echo JSONResponse::error("Error creating regimen table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createSituacionTable($conn)) {
                echo JSONResponse::error("Error creating situacion de revista table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createTipoServicioTable($conn)) {
                echo JSONResponse::error("Error creating tipo de servicio table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createPuestoEmpleadoTable($conn)) {
                echo JSONResponse::error("Error creating tipo de servicio table: ".mysqli_error($conn));
                exit(0);
            }

            if (!DBStructure::createEmpresaTable($conn)) {
                echo JSONResponse::error("Error creating empresas table: ".mysqli_error($conn));
                exit(0);
            }
            if (!DBStructure::createEmpleadosTable($conn)) {
                echo JSONResponse::error("Error creating empresas table: ".mysqli_error($conn));
                exit(0);
            }
            
            mysqli_close($conn);
            echo JSONResponse::ok("Database structure created successfully");
        } catch(Exception $e) {
            echo JSONResponse::error($e->getMessage());
        }
    } else {
        echo JSONResponse::error("Can only be called via POST");
    }
?>