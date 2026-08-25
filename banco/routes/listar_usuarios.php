<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include("../config/conexao.php");

$sql = "
SELECT
    id,
    nome_usuario AS nome,
    email,
    plano
FROM FS_usuarios
WHERE ativo = 1
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao buscar usuários: " . $conn->error
    ]);
    exit;
}

$usuarios = [];

while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);

?>