<?php
header("Content-Type: application/json");
require "../config/conexao.php";

$id = $_POST["id"] ?? null;

if (!$id) {
    echo json_encode(["status" => "erro", "msg" => "ID inválido"]);
    exit;
}

$sql = "UPDATE FS_administradores SET ativo = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao preparar atualização"
    ]);
    exit;
}
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "ok",
        "msg" => "Administrador reativado"
    ]);
} else {
    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao reativar administrador"
    ]);
}
$stmt->close();

?>