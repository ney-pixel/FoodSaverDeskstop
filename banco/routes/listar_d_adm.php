<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../config/conexao.php";

$sql = "
SELECT 
    id,
    nome,
    email,
    senha,
    created_at,
    TIMESTAMPDIFF(YEAR, created_at, NOW()) AS anos,
    TIMESTAMPDIFF(DAY, created_at, NOW()) AS dias
FROM FoodSaver_Adm
WHERE ativo = 1
";

$result = $conn->query($sql);

$admins = [];

while ($row = $result->fetch_assoc()) {
    $admins[] = $row;
}

echo json_encode($admins);