<?php
header("Content-Type: application/json");
require "../config/conexao.php";


$total = 0;

$sql = "SELECT COUNT(*) as total FROM FoodSaver_usuarios";
$result = mysqli_query($conn, $sql);

if ($result) {
    $total = mysqli_fetch_assoc($result)["total"] ?? 0;
}


$mediaNivel = 0;

$sql = "
    SELECT AVG(s.nivel) as media_nivel
    FROM FoodSaver_usuario_stats s
    JOIN FoodSaver_usuarios u ON u.id = s.usuario_id
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $mediaNivel = mysqli_fetch_assoc($result)["media_nivel"] ?? 0;
    $mediaNivel = $mediaNivel ? round($mediaNivel, 1) : 0;
}


$mediaWaste = 0;

$sql = "
    SELECT AVG(r.total_desperdicio) as media_waste
    FROM FoodSaver_usuario_resumo r
    JOIN FoodSaver_usuarios u ON u.id = r.usuario_id
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $mediaWaste = mysqli_fetch_assoc($result)["media_waste"] ?? 0;
    $mediaWaste = $mediaWaste ? round($mediaWaste, 2) : 0;
}

echo json_encode([
    "total_usuarios" => $total,
    "media_nivel" => $mediaNivel,
    "media_desperdicio" => $mediaWaste
]);