<?php
// Importa as variáveis do HTML
$nome = $_POST['nome'];
$email = $_POST['email'];
$usersenha = $_POST['senha'];

// Faz conexão com o banco de dados
include_once("conexao.php");

// Utiliza a função mysqli_real_escape_string para evitar injeção de SQL
$nome = mysqli_real_escape_string($mysqli, $nome);
$email = mysqli_real_escape_string($mysqli, $email);
$senha = mysqli_real_escape_string($mysqli, $usersenha);

// Verifica se algum campo está vazio
if (empty($nome) || empty($email) || empty($senha)) {
    $mensagem = "mensagem: Todos os campos obrigatórios devem estar preenchidos.";
} else {
    // Verificar se o email já existe no banco de dados
    $check_query = "SELECT * FROM usuarios WHERE email = '$email'";
    $check_result = mysqli_query($mysqli, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $mensagem = "O email fornecido já está cadastrado.";
    } else {
        // Criptografar a senha usando password_hash
        $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir dados na tabela "usuarios"
        $query = "INSERT INTO usuarios (tipo, nome, email, senha) VALUES (0, '$nome', '$email', '$hashed_password')";

        if (mysqli_query($mysqli, $query)) {
            $mensagem = "Usuário $nome foi cadastrado com sucesso";
        } else {
            $mensagem = "Erro ao cadastrar o usuário: " . mysqli_error($mysqli);
        }
    }
}

// Redireciona de volta para a página de cadastro com a mensagem
header("Location: cadastrar_aluno.php?mensagem=" . urlencode($mensagem));
exit;
?>
