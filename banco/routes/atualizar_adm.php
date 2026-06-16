<?php
header("Content-Type: application/json");
require "../config/conexao.php";

$data = json_decode(file_get_contents("php://input"), true);

$id    = $data["id"] ?? null;
$nome  = $data["nome"] ?? null;
$email = $data["email"] ?? null;
$senha = $data["senha"] ?? null;

if (!$id || !$nome || !$email || !$senha) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Todos os campos são obrigatórios"
    ]);
    exit;
}

try {

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "UPDATE FoodSaver_Adm 
            SET nome = ?, 
                email = ?, 
                senha = ?, 
                updated_at = NOW()
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $email, $senhaHash, $id);

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

} catch (Exception $e) {

    echo json_encode([
        "status" => "erro",
        "msg" => $e->getMessage()
    ]);

}
?>