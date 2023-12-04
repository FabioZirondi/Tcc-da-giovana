<?php
// Inicia a sessão
session_start();

// Verifica se o tipo de usuário não está definido na sessão ou se não é um aluno
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 0) {
    // Redireciona para a página inicial se o usuário não for um aluno
    header("Location: index.php");
    // Encerra o script para evitar que o restante do código seja executado desnecessariamente
    exit();
}
?>
