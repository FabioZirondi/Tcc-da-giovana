<?php
// Inicia a sessão
session_start();

// Verifica se o tipo de usuário não está definido na sessão ou se não é um administrador (tipo 1)
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 1) {
    // Redireciona para a página inicial se o usuário não for um administrador
    header("Location: index.php");
    // Encerra o script para evitar que o restante do código seja executado desnecessariamente
    exit();
}
?>
