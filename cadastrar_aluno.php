<?php
// Inicia a sessão e o buffer de saída
session_start();
ob_start();

// Filtra o botão de cadastro do usuário
$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);

if ($btnCadUsuario) {
    include_once 'conexao.php';

    // Filtra e sanitiza os dados recebidos via POST
    $dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $erro = false;

    $dados_st = array_map('strip_tags', $dados_rc);
    $dados = array_map('trim', $dados_st);

    // Verifica se todos os campos foram preenchidos
    if (in_array('', $dados)) {
        $erro = true;+
        $_SESSION['msg'] = "Necessário preencher todos os campos";
    } elseif (strlen($dados['senha']) < 6) {
        $erro = true;
        $_SESSION['msg'] = "A senha deve ter no mínimo 6 caracteres";
    } elseif (stristr($dados['senha'], "'")) {
        $erro = true;
        $_SESSION['msg'] = "Caractere (') utilizado na senha é inválido";
    } else {
        // Consulta preparada para verificar se o nome já está cadastrado
        $query = "SELECT id FROM usuarios WHERE nome=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $dados['nome']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $erro = true;
            $_SESSION['msg'] = "Este aluno já está cadastrado";
        }

        // Consulta preparada para verificar se o email já está cadastrado
        $query = "SELECT id FROM usuarios WHERE email=?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $dados['email']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $erro = true;
            $_SESSION['msg'] = "Este e-mail já está cadastrado";
        }
    }

    if (!$erro) {
        // Gerar um hash seguro para a senha
        $senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);

        // Consulta preparada para inserir o usuário no banco de dados
        $query = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "sss", $dados['nome'], $dados['email'], $senha_hash);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['msgcad'] = "Usuário cadastrado com sucesso";
            header("Location: cadastrar_aluno.php");
        } else {
            $_SESSION['msg'] = "Erro ao cadastrar o usuário";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Configurações do cabeçalho -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" type="text/css" href="css/cadastrarA.css">
</head>

<body>
    <div class="container">
        <!-- Botão para fechar a janela de cadastro -->
        <span class="close-button" onclick="closeForm()">X</span>

        <h2>Cadastro de Aluno</h2>
        <form method="POST" action="cadastro_aluno.php">
            <!-- Campos do formulário -->
            <label for="nome">Nome</label>
            <input type="text" name="nome" placeholder="Nome completo do aluno">

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="E-mail institucional">

            <label for="senha">Senha</label>
            <input type="password" name="senha" placeholder="Digite uma senha">
            <br>

            <!-- Botão de envio do formulário -->
            <button type="submit" name="btnCadUsuario" class="btn btn-danger">Cadastrar</button>
        </form>

        <!-- Exibição de mensagens de erro ou sucesso -->
        <?php
        if (isset($_GET['mensagem'])) {
            echo '<div class="aviso">' . $_GET['mensagem'] . '</div>';
            unset($_GET['mensagem']);
        }
        ?>
    </div>

    <!-- Script JavaScript para fechar a janela -->
    <script>
        function closeForm() {
            // Fecha a janela atual (é possível que alguns navegadores bloqueiem isso)
            window.close();

            // OU
            // Redireciona para outra página
            window.location.href = "areadm.php";
        }
    </script>
</body>

</html>
