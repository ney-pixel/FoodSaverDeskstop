<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config/conexao.php";

$sql = "
SELECT
    id,
    nome,
    email,
    data_criacao,
    TIMESTAMPDIFF(YEAR, data_criacao, NOW()) AS anos,
    TIMESTAMPDIFF(DAY, data_criacao, NOW()) AS dias
FROM FS_administradores
WHERE ativo = 1
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao buscar administradores: " . $conn->error
    ]);
    exit;
}

$admins = [];

while ($row = $result->fetch_assoc()) {
    $admins[] = $row;
}

echo json_encode($admins);
?>