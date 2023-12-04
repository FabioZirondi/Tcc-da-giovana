<?php
require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Certifique-se de validar e filtrar os dados adequadamente para evitar SQL injection
    $id = mysqli_real_escape_string($mysqli, $_GET['id']);
    $novoTitulo = mysqli_real_escape_string($mysqli, $_GET['titulo']);
    $novoTipo = mysqli_real_escape_string($mysqli, $_GET['tipo']);
    $novaArea = mysqli_real_escape_string($mysqli, $_GET['area']);
    $novoHorario = mysqli_real_escape_string($mysqli, $_GET['horario']);
    $novoSalario = mysqli_real_escape_string($mysqli, $_GET['salario']);
    $novosBeneficios = mysqli_real_escape_string($mysqli, $_GET['beneficios']);
    $novaDescricao = mysqli_real_escape_string($mysqli, $_GET['descricao']);

    // Implemente a lógica para atualizar o item no banco de dados com os novos valores
    $query = "UPDATE vagas SET titulo = '$novoTitulo', tipo = '$novoTipo', area = '$novaArea', horario = '$novoHorario',
     salario = '$novoSalario', beneficios = '$novosBeneficios', descricao = '$novaDescricao' WHERE id = $id";
    $result = mysqli_query($mysqli, $query);

    // Verifica se a query de atualização foi bem-sucedida
    if ($result) {
        // Redireciona de volta para a página de administração
        header('Location: areadm.php');
    } else {
        // Em caso de falha, você pode redirecionar com uma mensagem de erro ou lidar de outra forma
        header('Location: areadm.php?erro=1');
    }

    // Responda em formato JSON (opcional, dependendo das necessidades do seu aplicativo)
    // header('Content-Type: application/json');
    // echo json_encode($response);
} else {
    // Responda com um erro se o método da solicitação não for GET
    http_response_code(405);
}
?>
