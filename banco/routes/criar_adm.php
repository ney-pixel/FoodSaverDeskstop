<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require "../config/conexao.php";

try {

    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $nome  = $dados["nome"] ?? null;
    $email = $dados["email"] ?? null;
    $senha = $dados["senha"] ?? null;

    if (!$nome || !$email || !$senha) {
        echo json_encode([
            "status" => "erro",
            "msg" => "Campos obrigatórios"
        ]);
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $conn->begin_transaction();

    $sql = "INSERT INTO FS_administradores 
            (nome, email, senha, ativo)
            VALUES (?, ?, ?, 1)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Erro prepare: " . $conn->error);
    }

    $stmt->bind_param("sss", $nome, $email, $senhaHash);

    if (!$stmt->execute()) {
        throw new Exception("Erro insert: " . $stmt->error);
    }

    $admId = $stmt->insert_id;

    $conn->commit();

    echo json_encode([
        "status" => "ok",
        "msg" => "Administrador criado com sucesso",
        "id" => $admId
    ]);

} catch (Exception $e) {

    if (isset($conn)) {
        $conn->rollback();
    }

    echo json_encode([
        "status" => "erro",
        "msg" => $e->getMessage()
    ]);
}

?>