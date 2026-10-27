<?php
$host = "143.106.241.4";   //servidor remoto
$user = "cl204211";        //usuário
$pass = "cl#08112008";  //senha
$db   = "cl204211";        //nome do banco

$conn = new mysqli($host, $user, $pass, $db);

//verifica erro de conexao
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

//para evitar erros com acento
$conn->set_charset("utf8");
?>