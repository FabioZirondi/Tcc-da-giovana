<?php
// Inclusão do arquivo de conexão com o banco de dados
require("conexao.php");

// Obtenção do ID da vaga a ser excluída a partir dos parâmetros da URL ($_GET)
$id = $_GET['id'];

// Construção da consulta SQL para excluir a vaga com o ID especificado
$query = "DELETE FROM vagas WHERE id = $id";

// Execução da consulta no banco de dados
$result = mysqli_query($mysqli, $query);

// Redirecionamento para a página "areadm.php" após a exclusão
header("location:areadm.php");
?>

