<?php
// Inclui o arquivo de conexão com o banco de dados
include('conexao.php');

// Inicializa as variáveis de erro
$emailError = $senhaError = "";

// Verifica se o formulário foi enviado
if (isset($_POST['email']) && isset($_POST['senha'])) {

    // Verifica se o campo de e-mail está vazio
    if (strlen($_POST['email']) == 0) {
        $emailError = "Preencha seu e-mail";
    } 
    // Verifica se o campo de senha está vazio
    else if (strlen($_POST['senha']) == 0) {
        $senhaError = "Preencha sua senha";
    } else {
        // Obtém e escapa os valores do formulário
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $_POST['senha'];

        // Consulta SQL para verificar se o e-mail existe no banco de dados
        $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        // Obtém o número de linhas retornadas pela consulta
        $tipo = $sql_query->num_rows;

        // Verifica se o e-mail existe
        if ($tipo > 0) {
            $percorrer = mysqli_fetch_array($sql_query);
            $hashArmazenado = $percorrer['senha'];

            // Verifica se a senha corresponde ao hash armazenado
            if (password_verify($senha, $hashArmazenado)) {
                $id = $percorrer['id'];
                $email = $percorrer['email'];
                $tipo = $percorrer['tipo'];

                // Inicia a sessão e armazena informações relevantes
                session_start();
                $_SESSION['tipo'] = $tipo;
                
                // Redireciona com base no tipo de usuário
                if ($tipo == 1) {
                    header("location:areadm.php");
                } else {
                    $_SESSION['email'] = $email;
                    header("location:aluno.php");
                }
            } else {
                $senhaError = "Falha ao logar! E-mail ou senha incorretos";
            }
        } else {
            $senhaError = "Falha ao logar! E-mail ou senha incorretos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen"/>
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-lg-4 col-md-6">
            <div class="card custom-card-l red-background">
                <div class="card-body">
                    <form action="index.php" method="POST">
                        <div class="text-center">
                            <img src="img/logo02.png" alt="Logo">
                            <h3></h3>
                        </div>
                        <div class="mb-3">
                            <label for="email" style="color: black;">Email</label>
                            <input type="text" name="email" id="email" placeholder="Digite seu e-mail institucional" class="form-control">
                            <span style="color: red;"><?php echo $emailError; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="senha" style="color: black;">Senha</label>
                            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" class="form-control">
                            <span style="color: red;"><?php echo $senhaError; ?></span>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary custom-button" style="background-color: #800000;">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
