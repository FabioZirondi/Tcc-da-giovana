<?php

$usuarios = 'giovana';
$senha = 'giovana123';
$database = 'estagionews';
$host = '108.181.92.75';

$mysqli = new mysqli($host, $usuarios, $senha, $database);

if($mysqli->error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->error);
} 
?>