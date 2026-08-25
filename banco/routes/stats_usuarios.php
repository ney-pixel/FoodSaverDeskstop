<?php

header("Content-Type: application/json");

require "../config/conexao.php";


// Total de usuários ativos
$total = 0;

$sql = "
    SELECT COUNT(*) AS total
    FROM FS_usuarios
    WHERE ativo = 1
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $total = mysqli_fetch_assoc($result)["total"] ?? 0;
}


// Total de usuários Premium
$totalPremium = 0;

$sql = "
    SELECT COUNT(*) AS total
    FROM FS_usuarios
    WHERE ativo = 1
    AND plano = 'premium'
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $totalPremium = mysqli_fetch_assoc($result)["total"] ?? 0;
}


// Total de usuários Gratuitos
$totalGratuito = 0;

$sql = "
    SELECT COUNT(*) AS total
    FROM FS_usuarios
    WHERE ativo = 1
    AND plano = 'gratuito'
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $totalGratuito = mysqli_fetch_assoc($result)["total"] ?? 0;
}


// Retorno
echo json_encode([
    "total_usuarios" => $total,
    "total_premium" => $totalPremium,
    "total_gratuito" => $totalGratuito
]);

?>