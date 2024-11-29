<?php
function TrueAdmin() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); 
    }

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: index.php');
        exit();
    }
}

function getNomeUsuario() {
    if (isset($_SESSION['usuario_nome'])) {
        return $_SESSION['usuario_nome'];  
    } else {
        return "Erro";  
    }
}

function DestroiAdmin() {
    session_start();
    if (isset($_SESSION['usuario_id'])) {
        session_unset();
        session_destroy();
    }
}

?>
