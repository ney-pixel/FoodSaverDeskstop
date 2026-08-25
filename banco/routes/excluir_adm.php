<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

require "../config/conexao.php";

try {

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    $id = $data["id"] ?? null;

    if (!$id) {
        throw new Exception("ID não fornecido.");
    }

    $sql = "UPDATE FS_administradores 
            SET ativo = 0 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Erro no prepare: " . $conn->error);
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        echo json_encode([
            "status" => "ok",
            "msg" => "Administrador desativado com sucesso!"
        ]);

    } else {

        throw new Exception("Erro ao executar atualização.");

    }

} catch (Exception $e) {

    echo json_encode([
        "status" => "erro",
        "msg" => $e->getMessage()
    ]);
}

?>