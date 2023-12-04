<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadados do Documento -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Folhas de Estilo -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;1,200;1,300;1,400&display=swap">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/areadm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Título da Página -->
    <title>Área do Administrador</title>
</head>

<body>
    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/logo02.png" alt="Logo" class="navbar-brand">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <!-- Ícone de Hambúrguer do Bootstrap -->
                <ion-icon name="menu-outline" id="menu"></ion-icon>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Links da Barra de Navegação -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="areadm.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastrar_aluno.php">Cadastrar alunos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastrar_vagas.php">Cadastrar vagas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastrar_empresa.php">Cadastrar empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="resultados.php">resultados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Script JavaScript -->
    <script src="main.js"></script>

    <!-- Exibição de Cards de Vagas -->
    <div class="d-flex flex-row flex-wrap justify-content-around">
        <?php
        // Inclusão do arquivo de conexão com o banco de dados
        require("conexao.php");
        
        // Inclusão do arquivo de proteção (se estiver relacionado à autenticação)
        include_once("protecta.php");

        // Consulta SQL para obter todas as vagas
        $query = "SELECT * FROM vagas";

        // Execução da consulta
        $result = mysqli_query($mysqli, $query);

        // Verificação se a consulta foi bem-sucedida
        if ($result) {
            // Loop para iterar sobre os resultados e exibir cards de vagas
            while ($row = mysqli_fetch_array($result)) {
                $titulo = $row["titulo"];
                $tipo = $row["tipo"];
                $area = $row["area"];
                $horario = $row["horario"];
                $salario = $row["salario"];
                $beneficios = $row["beneficios"];
                $descricao = $row["descricao"];
                $id = $row["id"];
        ?>
                <!-- Card de Vaga -->
                <div class="card" style="width: 16rem;">
                    <div class="card-body">
                        <!-- Exibição de Título e Área -->
                        <h5 class="card-title" style="color:black; text-decoration: none;"><?php echo "$titulo - $area" ?></h5>
                        <p class="card-text" style="color:black; text-decoration: none;"><?php echo "$area" ?></p>
                        
                        <!-- Botões de Edição e Apagar -->
                        <button class="custom-button editarBtn" data-id="<?php echo $id ?>" data-titulo="<?php echo $titulo ?>" data-tipo="<?php echo $tipo ?>" data-area="<?php echo $area ?>" data-horario="<?php echo $horario ?>" data-salario="<?php echo $salario ?>" data-beneficios="<?php echo $beneficios ?>" data-descricao="<?php echo $descricao ?>">Editar</button>
                        <button class="custom-button apagarBtn" data-id="<?php echo $id ?>">Apagar</button>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>

    <!-- Janela modal de edição -->
    <div id="modalEditar" class="modal">
        <!-- Conteúdo do Modal -->
        <div class="modal-content">
            <span class="close" id="closeModalEditarBtn">&times;</span>
            <h2>Editar Item</h2>
            
            <!-- Formulário de Edição -->
            <form name="editar" method="get" action="editarback.php">
                <input type="hidden" id="editItemId" name="id" value="">
                
                <!-- Campos de Edição -->
                <label for="titulo">Nome da Empresa:</label>
                <input type="text" id="editTitulo" name="titulo" required><br><br>
                
                <label for="tipo">Tipo (estagiario):</label>
                <input type="text" id="ediTipo" name="tipo" required><br><br>

                <label for="area">Área:</label>
                <input type="text" id="editArea" name="area" required><br><br>

                <label for="horario">Horario:</label>
                <input type="text" id="editHorario" name="horario" required><br><br>

                <label for="salario">Salario:</label>
                <input type="number" id="editSalario" name="salario" required><br><br>

                <label for="beneficios">Beneficios:</label>
                <input type="text" id="editBeneficios" name="beneficios" required><br><br>

                <label for="descricao">Descrição:</label>
                <textarea id="editDescricao" name="descricao" rows="3" required></textarea><br><br>

                <!-- Botão de Salvar Edição -->
                <button class="custom-button" id="salvarEdicaoBtn">Salvar</button>
            </form>
        </div>
    </div>

    <!-- Janela modal de confirmação de apagar -->
    <div id="modalApagar" class="modal">
        <!-- Conteúdo do Modal -->
        <div class="modal-content">
            <h2>Confirmar Apagar</h2>
            <p>Tem certeza de que deseja apagar este item?</p>
            
            <!-- Botões de Confirmação e Cancelamento -->
            <button class="custom-button" id="confirmarApagarBtn">Sim</button>
            <button class="custom-button" id="cancelarApagarBtn">Cancelar</button>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        // Seleção de elementos usando JavaScript
        const editarBtns = document.querySelectorAll('.editarBtn');
        const modalEditar = document.getElementById('modalEditar');
        const closeModalEditarBtn = document.getElementById('closeModalEditarBtn');
        const salvarEdicaoBtn = document.getElementById('salvarEdicaoBtn');
        const editItemId = document.getElementById('editItemId');
        const editTitulo = document.getElementById('editTitulo');
        const ediTipo = document.getElementById('ediTipo');
        const editArea = document.getElementById('editArea');
        const editHorario = document.getElementById('editHorario');
        const editSalario = document.getElementById('editSalario');
        const editBeneficios = document.getElementById('editBeneficios');
        const editDescricao = document.getElementById('editDescricao');

        const apagarBtns = document.querySelectorAll('.apagarBtn');
        const modalApagar = document.getElementById('modalApagar');
        const confirmarApagarBtn = document.getElementById('confirmarApagarBtn');
        const cancelarApagarBtn = document.getElementById('cancelarApagarBtn');

        // Adição de Event Listeners para interatividade
        editarBtns.forEach(editarBtn => {
            editarBtn.addEventListener('click', (e) => {
                const id = e.target.getAttribute('data-id');
                const titulo = e.target.getAttribute('data-titulo');
                const tipo = e.target.getAttribute('data-tipo');
                const area = e.target.getAttribute('data-area');
                const horario = e.target.getAttribute('data-horario');
                const salario = e.target.getAttribute('data-salario');
                const beneficios = e.target.getAttribute('data-beneficios');
                const descricao = e.target.getAttribute('data-descricao');

                // Atualização dos valores no formulário de edição
                editItemId.value = id;
                editTitulo.value = titulo;
                ediTipo.value = tipo;
                editArea.value = area;
                editHorario.value = horario;
                editSalario.value = salario;
                editBeneficios.value = beneficios;
                editDescricao.value = descricao;

                // Exibição da janela modal de edição
                modalEditar.style.display = 'block';
            });
        });

        // Adição de Event Listener para fechar a janela modal de edição
        closeModalEditarBtn.addEventListener('click', () => {
            modalEditar.style.display = 'none';
        });

        // Adição de Event Listener para salvar as edições (lógica fictícia)
        salvarEdicaoBtn.addEventListener('click', () => {
            // Lógica para salvar as edições (pode ser implementada conforme necessário)
            const novoTitulo = editTitulo.value;
            const novoTipo = ediTipo.value;
            const novoArea = editArea.value;
            const novoSalario = editSalario.value;
            const novoBeneficios = editBeneficios.value;
            const novaDescricao = editDescricao.value;

            // Atualização da interface (pode ser implementada conforme necessário)

            // Fechamento da janela modal de edição
            modalEditar.style.display = 'none';
        });

        // Adição de Event Listeners para interatividade de apagar
        apagarBtns.forEach(apagarBtn => {
            apagarBtn.addEventListener('click', (e) => {
                const id = e.target.getAttribute('data-id');
                editItemId.value = id;
                modalApagar.style.display = 'block';
            });
        });

        // Adição de Event Listener para confirmação de apagar
        confirmarApagarBtn.addEventListener('click', () => {
            // Lógica para confirmar apagar (pode ser implementada conforme necessário)
            window.location.href = "apagar_item.php?id=" + editItemId.value;
        });

        // Adição de Event Listener para cancelamento de apagar
        cancelarApagarBtn.addEventListener('click', () => {
            // Fechamento da janela modal de confirmação
            modalApagar.style.display = 'none';
        });

        // Função para tornar a barra de navegação responsiva
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


</body>

</html>