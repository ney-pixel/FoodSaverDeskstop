<?php

header("Content-Type: application/json");
require "../config/conexao.php";

$nome = $_POST["nome"] ?? null;
$email = $_POST["email"] ?? null;
$senha = $_POST["senha"] ?? null;

if (!$nome || !$email || !$senha) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Campos obrigatórios"
    ]);
    exit;
}

// Hash da senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Cria usuário como ATIVO (1 = ativo)
$sql = "INSERT INTO FS_usuarios 
        (nome_usuario, email, senha, ativo)
        VALUES (?, ?, ?, 1)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao preparar cadastro"
    ]);
    exit;
}

$stmt->bind_param("sss", $nome, $email, $senhaHash);

if ($stmt->execute()) {

    $userId = $stmt->insert_id;

    echo json_encode([
        "status" => "ok",
        "msg" => "Usuário criado",
        "id" => $userId
    ]);

} else {

    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao criar usuário"
    ]);
}

?>