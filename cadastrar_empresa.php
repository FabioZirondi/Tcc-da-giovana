<?php
// Inicialize a variável de mensagem
$mensagem = "";

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    include_once("conexao.php");

    // Verifique se a conexão foi bem-sucedida
    if ($mysqli->connect_error) {
        die("Conexão com o banco de dados falhou: " . $mysqli->connect_error);
    }

    // Recupere os dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];

    // Verifique se a empresa já existe com base no email
    $verificar_sql = "SELECT * FROM empresa WHERE email = '$email'";
    $resultado = $mysqli->query($verificar_sql);

    if ($resultado->num_rows > 0) {
        // A empresa já existe
        $mensagem = "Esta empresa já está cadastrada.";
    } else {
        // A empresa não existe, insira os dados
        $inserir_sql = "INSERT INTO empresa (nome, email, telefone) VALUES ('$nome', '$email', '$telefone')";

        // Verifique se a inserção foi bem-sucedida
        if ($mysqli->query($inserir_sql) === true) {
            $mensagem = "Empresa cadastrada com sucesso.";
        } else {
            $mensagem = "Erro ao cadastrar a empresa: " . $mysqli->error;
        }
    }

    // Feche a conexão com o banco de dados
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Configurações do cabeçalho -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa</title>
    <link rel="stylesheet" type="text/css" href="css/cadastrarE.css">
</head>

<body>
    <!-- Formulário de cadastro -->
    <form action="" method="post">
        <!-- Link para voltar à página anterior -->
        <div class="voltar-link">
            <a href="javascript:history.go(-1)">X</a>
        </div>

        <!-- Título do formulário -->
        <h2 class="center-title">Cadastro de Empresa</h2>

        <!-- Campos do formulário -->
        <div>
            <label for="nome">Nome da Empresa:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div>
            <label for="email">Email da Empresa:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="telefone">Telefone da Empresa:</label>
            <input type="tel" id="telefone" name="telefone" required>
        </div>
        <div>
            <!-- Botão de envio do formulário -->
            <button type="submit">Cadastrar Empresa</button>
        </div>

        <!-- Exibição da mensagem resultante do cadastro -->
        <p><?php echo $mensagem; ?></p>
    </form>
</body>

</html>
