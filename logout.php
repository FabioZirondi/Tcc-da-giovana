<!-- Este código PHP lida com o encerramento da sessão do usuário e o 
redirecionamento para a página inicial do site -->

<?php

// Inicia a sessão se não estiver iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Destroi a sessão, removendo todas as variáveis de sessão
session_destroy();

// Redireciona para a página inicial do site (index.php)
header("Location: index.php");
?>
