<?php

session_start();

header("Content-Type: application/json");

include("../config/conexao.php");

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$email = $data['email'] ?? $_POST['email'] ?? '';
$senha = $data['senha'] ?? $_POST['senha'] ?? '';

if (empty($email) || empty($senha)) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Preencha todos os campos"
    ]);
    exit;
}

// Busca o administrador pelo e-mail
$sql = "SELECT id, nome, senha, ativo
        FROM FS_administradores
        WHERE LOWER(email) = LOWER(?)
        LIMIT 1";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao preparar consulta"
    ]);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();

// bind_result funciona sem mysqlnd
$stmt->bind_result(
    $adminId,
    $adminNome,
    $adminSenha,
    $adminAtivo
);

$encontrado = $stmt->fetch();

$stmt->close();

if (!$encontrado) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Administrador não encontrado"
    ]);
    exit;
}

$adminSenha = (string) $adminSenha;

if (!$encontrado) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Administrador não encontrado"
    ]);
    exit;
}

// Verifica se o administrador está ativo
if (!$adminAtivo) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Administrador desativado"
    ]);
    exit;
}

// Verifica a senha
if (!password_verify($senha, $adminSenha)) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Senha incorreta"
    ]);
    exit;
}

// Cria a sessão do administrador
$_SESSION['administrador'] = [
    "id"   => $adminId,
    "nome" => $adminNome
];

echo json_encode([
    "status" => "ok",
    "nome"   => $adminNome
]);