<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Configurações do cabeçalho -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Link para a folha de estilos CSS -->
    <link rel="stylesheet" type="text/css" href="css/cadastrarV.css">
</head>

<body>
    <!-- Formulário de cadastro de vagas -->
    <form action="processa_formulario.php" method="POST">
        <!-- Link para voltar à página anterior -->
        <div class="voltar-link">
            <a href="javascript:history.go(-1)">X</a>
        </div>
        <!-- Título do formulário -->
        <h2 class="center-title">Cadastro de vagas</h2>
        
        <!-- Campo para selecionar a empresa -->
        <div>
            <label for="nome_emp">Empresa:</label>
            <select class="custom-select" id="nome_emp" name="nome_emp" required>
                <!-- Opção padrão desabilitada e selecionada -->
                <option value="" disabled selected>Selecione a empresa</option>
                <?php
                // Inclusão do arquivo de conexão
                include_once("conexao.php");

                // Verificação de erro na conexão
                if ($mysqli->connect_error) {
                    die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
                }

                // Consulta para selecionar as empresas
                $consulta_empresas = "SELECT id, nome FROM empresa";
                $resultado_empresas = $mysqli->query($consulta_empresas);

                // Preenchimento das opções do menu suspenso com os dados das empresas
                if ($resultado_empresas->num_rows > 0) {
                    while ($empresa = $resultado_empresas->fetch_assoc()) {
                        echo '<option value="' . $empresa['id'] . '">' . $empresa['nome'] . '</option>';
                    }
                }

                // Fechamento da conexão com o banco de dados
                $mysqli->close();
                ?>
            </select>
        </div>
        
        <!-- Campos do formulário -->
        <div>
            <label for="tipo">Tipo (ex: estágio):</label>
            <input type="text" id="tipo" name="tipo" required>
        </div>
        <div>
            <label for="area">Área:</label>
            <input type="text" id="area" name="area" required>
        </div>
        <div>
            <label for="horario">Horário de Trabalho:</label>
            <input type="text" id="horario" name="horario" required>
        </div>
        <div>
            <label for="salario">Salário:</label>
            <input type="number" id="salario" name="salario" required>
        </div>
        <div>
            <label for="beneficios">Benefícios:</label>
            <input type="text" id="beneficios" name="beneficios" required>
        </div>

        <div>
            <label for="descricao">Descrição da Vaga:</label>
            <textarea id="descricao" name="descricao" rows="4" required></textarea>
        </div>
        
        <!-- Botão de envio do formulário -->
        <div>
            <button type="submit">Cadastrar</button>
        </div>
    </form>
</body>

</html>
