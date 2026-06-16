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

$sql = "SELECT * FROM FoodSaver_Adm WHERE LOWER(Email) = LOWER(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Usuário não encontrado"
    ]);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($senha, $user['Senha'])) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Senha incorreta"
    ]);
    exit;
}

$_SESSION['usuario'] = [
    "id" => $user['ID'],   
    "nome" => $user['Nome']
];

echo json_encode([
    "status" => "ok",
    "nome" => $user["Nome"]
]);