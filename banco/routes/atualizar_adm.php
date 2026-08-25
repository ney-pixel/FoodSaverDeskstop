<?php

header("Content-Type: application/json");

require "../config/conexao.php";

$data = json_decode(file_get_contents("php://input"), true);

$id    = $data["id"] ?? null;
$nome  = $data["nome"] ?? null;
$email = $data["email"] ?? null;
$senha = $data["senha"] ?? null;

if (!$id || !$nome || !$email) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Nome e email são obrigatórios"
    ]);
    exit;
}

try {

    /*
     * Se a senha foi preenchida,
     * atualiza nome, email e senha.
     */
    if (!empty($senha)) {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "UPDATE FS_administradores
                SET nome = ?,
                    email = ?,
                    senha = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar atualização");
        }

        $stmt->bind_param(
            "sssi",
            $nome,
            $email,
            $senhaHash,
            $id
        );

    } else {

        /*
         * Se a senha estiver vazia,
         * mantém a senha atual.
         */
        $sql = "UPDATE FS_administradores
                SET nome = ?,
                    email = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar atualização");
        }

        $stmt->bind_param(
            "ssi",
            $nome,
            $email,
            $id
        );
    }

    if ($stmt->execute()) {

        echo json_encode([
            "status" => "ok",
            "msg" => "Administrador atualizado com sucesso"
        ]);

    } else {

        echo json_encode([
            "status" => "erro",
            "msg" => "Erro ao atualizar administrador"
        ]);
    }

    $stmt->close();

} catch (Exception $e) {

    echo json_encode([
        "status" => "erro",
        "msg" => $e->getMessage()
    ]);
}
?>