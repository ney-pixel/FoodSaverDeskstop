<?php

header("Content-Type: application/json");

require "../config/conexao.php";

$sql = "
SELECT
    COUNT(*) AS total,
    AVG(TIMESTAMPDIFF(YEAR, data_criacao, NOW())) AS media_anos,
    AVG(TIMESTAMPDIFF(DAY, data_criacao, NOW())) AS media_dias
FROM FS_administradores
WHERE ativo = 1
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao buscar estatísticas: " . $conn->error
    ]);
    exit;
}

$row = $result->fetch_assoc();

echo json_encode([
    "total" => $row["total"] ?? 0,
    "media_anos" => round($row["media_anos"] ?? 0, 1),
    "media_dias" => round($row["media_dias"] ?? 0, 0)
]);

?>