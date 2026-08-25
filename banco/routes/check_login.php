<?php

session_start();

header("Content-Type: application/json");

if (isset($_SESSION['administrador'])) {
    echo json_encode([
        "status" => "ok",
        "administrador" => $_SESSION['administrador']
    ]);
} else {
    echo json_encode([
        "status" => "erro"
    ]);
}

?>