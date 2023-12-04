<?php
require("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $empresa_id = $_POST["nome_emp"];
    $tipo = $_POST["tipo"];
    $area = $_POST["area"];
    $horario = $_POST["horario"];
    $salario = $_POST["salario"];
    $beneficios = $_POST["beneficios"];
    $descricao = $_POST["descricao"];

    $consulta_empresa = "SELECT nome FROM empresa WHERE id = $empresa_id";
    $resultado_empresa = $mysqli->query($consulta_empresa);

    if ($resultado_empresa->num_rows > 0) {
        $row = $resultado_empresa->fetch_assoc();
        $nome_empresa = $row["nome"];
    } else {
    }
    $query = "INSERT INTO vagas VALUES (null, '$nome_empresa', '$descricao', '$tipo', $salario, 
    '$beneficios', '$area', '$horario', $empresa_id );";

    if (mysqli_query($mysqli, $query)) {
        header("Location: areadm.php");
    } else {
        echo "Erro ao cadastrar a vaga: " . mysqli_error($mysqli);
    }
    mysqli_close($mysqli);
}
?>
