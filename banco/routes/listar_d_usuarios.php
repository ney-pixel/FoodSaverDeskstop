<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include("../config/conexao.php");

$sql = "
SELECT 
    u.id,
    u.nome,
    u.email,
    s.nivel,
    s.xp,
    IFNULL(r.total_desperdicio, 0) AS desperdicio
FROM FoodSaver_usuarios u
JOIN FoodSaver_usuario_stats s ON u.id = s.usuario_id
LEFT JOIN FoodSaver_usuario_resumo r ON u.id = r.usuario_id
WHERE u.ativo = 1
";

$result = $conn->query($sql);

$usuarios = [];

while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);