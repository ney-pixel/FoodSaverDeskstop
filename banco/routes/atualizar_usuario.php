<?php
header("Content-Type: application/json");
include("../config/conexao.php");

$data = json_decode(file_get_contents("php://input"));

$id = $data->id ?? null;
$nome = $data->nome ?? null;
$email = $data->email ?? null;
$senha = $data->senha ?? null;

if (!$id || !$nome || !$email || !$senha) {
    echo json_encode([
        "status" => "erro",
        "msg" => "Todos os campos são obrigatórios"
    ]);
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "UPDATE FS_usuarios
        SET nome_usuario = ?,
            email = ?,
            senha = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $nome, $email, $senhaHash, $id);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "ok",
        "msg" => "Usuário atualizado com sucesso"
    ]);

} else {

    echo json_encode([
        "status" => "erro",
        "msg" => "Erro ao atualizar usuário"
    ]);

}
?>