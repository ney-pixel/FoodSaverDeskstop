<?php
header("Content-Type: application/json");
require "../config/conexao.php";

$sql = "
SELECT 
    COUNT(*) as total,
    AVG(TIMESTAMPDIFF(YEAR, created_at, NOW())) as media_anos,
    AVG(TIMESTAMPDIFF(DAY, created_at, NOW())) as media_dias
FROM FoodSaver_Adm
WHERE ativo = 0
";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode([
    "total" => $row["total"] ?? 0,
    "media_anos" => round($row["media_anos"] ?? 0, 1),
    "media_dias" => round($row["media_dias"] ?? 0, 0)
]);