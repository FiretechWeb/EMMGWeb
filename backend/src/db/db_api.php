<?php
    include_once 'db_response.php';

    class DBAPI {

        public static function executeQuery($pdo, $sql, $params = []) {
            try {
                $stmt = $pdo->prepare($sql);
                foreach ($params as $param => $value) {
                    $stmt->bindParam($param, $value[0], $value[1]);
                }
                if ($stmt->execute()) {
                    return DBResponse::ok([
                        'row_count' => $stmt->rowCount(),
                        'rows' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                        'lastInsertId' => $pdo->lastInsertId()
                    ]);
                } else {
                    return DBResponse::error("SQL ERROR in executeCountQuery");
                }
            } catch (Exception $e) {
                return DBResponse::error($e->getMessage());
            }
        }
    }
?>