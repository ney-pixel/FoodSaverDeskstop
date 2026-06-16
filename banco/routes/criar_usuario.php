<?php
header("Content-Type: application/json");
require "../config/conexao.php";

$nome = $_POST["nome"] ?? null;
$email = $_POST["email"] ?? null;
$senha = $_POST["senha"] ?? null;

if (!$nome || !$email || !$senha) {
    echo json_encode(["status" => "erro", "msg" => "Campos obrigatórios"]);
    exit;
}

// hash de senha (boa prática)
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// cria usuário como ATIVO (0 = ativo)
$sql = "INSERT INTO FoodSaver_usuarios (nome, email, senha, ativo, data_criacao)
        VALUES (?, ?, ?, 0, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $senhaHash);

if ($stmt->execute()) {

    $userId = $stmt->insert_id;

   
    $conn->query("INSERT INTO FoodSaver_usuario_stats (usuario_id, nivel, xp) VALUES ($userId, 1, 0)");
    $conn->query("INSERT INTO FoodSaver_usuario_resumo (usuario_id, total_desperdicio) VALUES ($userId, 0)");

    echo json_encode(["status" => "ok", "msg" => "Usuário criado"]);
} else {
    echo json_encode(["status" => "erro", "msg" => "Erro ao criar"]);
}