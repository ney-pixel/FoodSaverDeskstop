<?php

header("Content-Type: application/json");
require "../config/conexao.php";

$id = $_POST["id"] ?? null;

if (!$id) {
    echo json_encode([
        "status" => "erro",
        "msg" => "ID inválido"
    ]);
    exit;
}

$sql = "UPDATE FS_usuarios
        SET ativo = 0
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "ok",
        "msg" => "Usuário desativado"
    ]);

} else {

    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao desativar usuário"
    ]);

}

?>