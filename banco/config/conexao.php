<?php
$host = "143.106.241.4";   // servidor remoto
$user = "cl204211";        // seu usuário
$pass = "cl#08112008";  // sua senha
$db   = "cl204211";        // nome do banco

$conn = new mysqli($host, $user, $pass, $db);

// Verifica erro de conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Define charset (evita problemas com acentos)
$conn->set_charset("utf8");
?>