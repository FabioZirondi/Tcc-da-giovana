<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/aluno.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Área do Aluno</title>
</head>

<body>
    <!-- Começo da barra de navegação -->
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container-fluid">
            <!-- Logo da barra de navegação -->
            <a class="navbar-brand" href="#">
                <img src="img/logo02.png" alt="Logo" class="navbar-brand">
            </a>

            <!-- Botão de alternância para menu responsivo -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <ion-icon name="menu-outline" id="menu"></ion-icon>
            </button>

            <!-- Itens da barra de navegação -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <!-- Link para a página "Sobre" -->
                        <a class="nav-link" href="sobre.php">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <!-- Link para a página de "Logout" -->
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Fim da barra de navegação -->

    <!-- Inclusão do script JavaScript -->
    <script src="main.js"></script>

    <!-- Início do conteúdo principal -->
    <main>
        <div class="conteudo">
            <div class="d-flex flex-row flex-wrap justify-content-around">
                <?php
                // Inclusão de arquivos PHP necessários
                require("conexao.php");
                include_once("protectu.php");

                // Consulta SQL para obter dados das vagas
                $query = "SELECT * FROM vagas";
                $result = mysqli_query($mysqli, $query);

                // Loop para exibir as vagas
                if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                        // Atribuição de valores a variáveis
                        $idVaga = $row["id"];
                        $titulo = $row["titulo"];
                        $area = $row["area"];
                        $descricao = $row["descricao"];
                        $tipo = $row["tipo"];
                        $horario = $row["horario"];
                        $salario = $row["salario"];
                        $beneficios = $row["beneficios"];
                ?>
                        <!-- Card exibindo informações da vaga -->
                        <div class="card" style="width: 16rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo "$titulo" ?></h5>
                                <p class="card-text"><?php echo "$area" ?></p>
                                <!-- Botões para exibir mais detalhes e candidatar-se -->
                                <button class="custom-button-red lerMaisBtn" data-titulo="<?php echo $titulo; ?>" data-area="<?php echo $area; 
                                ?>" data-descricao="<?php echo $descricao; ?>" data-tipo="<?php echo $tipo; ?>" data-horario="<?php echo $horario; 
                                ?>" data-salario="<?php echo $salario; ?>" data-beneficios="<?php echo $beneficios; ?>">
                                    Ler Mais
                                </button>
                                <button class="custom-button-red candidatarBtn" data-idvaga="<?php echo $idVaga; ?>">Candidatar-se</button>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
        <!-- Fim do conteúdo principal -->

        <!-- Janela modal "Ler Mais" -->
        <div id="modalLerMais" class="modal">
            <div class="modal-content">
                <!-- Botão para fechar o modal -->
                <span class="close" id="closeModalLerMaisBtn">&times;</span>
                <!-- Detalhes da vaga exibidos no modal -->
                <h2 id="modalTituloArea"></h2>
                <p id="modalDescricao"></p>
                <p id="modalTipo"></p>
                <p id="modalHorario"></p>
                <p id="modalSalario"></p>
                <p id="modalBeneficios"></p>
                <!-- Botão para candidatar-se no modal -->
                <button class="custom-button-red candidatarBtn" id="candidatarNoModal">Candidatar-se</button>
            </div>
        </div>
        <!-- Fim do modal "Ler Mais" -->

        <!-- Janela modal "Candidatar-se" -->
        <div id="modalCandidatar" class="modal">
            <div class="modal-content">
                <!-- Botão para fechar o modal -->
                <span class="close" id="closeModalCandidatarBtn">&times;</span>
                <!-- Formulário para envio de imagem -->
                <h2>Candidatar-se</h2>
                <form action="enviar_imagem.php" method="post" enctype="multipart/form-data">
                    <!-- Campo para seleção de imagem -->
                    <label for="imagem" require>Selecione uma imagem:</label>
                    <input type="file" name="imagem" id="imagem" require>
                    <!-- Campo oculto para enviar o ID da vaga -->
                    <?php
                    echo '<input type="hidden" name="id_vaga" id="idVaga" value="' . $idVaga . '">';
                    ?>
                    <br>
                    <br> 
                    
                    <!-- Botão para enviar o formulário -->
                    <input type="submit" value="Enviar Imagem">
                    <br>
                    <br>
                    <!-- Exibição de mensagem de sucesso, se houver -->
                    <?php
                    $sucesso = isset($_GET['sucesso']) ? urldecode($_GET['sucesso']) : '';
                    if ($sucesso) {
                    ?>
                        <p><?php echo $sucesso ?></p>
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>
        <!-- Fim do modal "Candidatar-se" -->

        <!-- Script JavaScript para interatividade dos botões e modais -->
        <script>
            // Seleção de elementos e atribuição de eventos
            const lerMaisBtns = document.querySelectorAll('.lerMaisBtn');
            const modalLerMais = document.getElementById('modalLerMais');
            const closeModalLerMaisBtn = document.getElementById('closeModalLerMaisBtn');
            const modalTituloArea = document.getElementById('modalTituloArea');
            const modalDescricao = document.getElementById('modalDescricao');
            const modalTipo = document.getElementById('modalTipo');
            const modalHorario = document.getElementById('modalHorario');
            const modalSalario = document.getElementById('modalSalario');
            const modalBeneficios = document.getElementById('modalBeneficios');

            const candidatarBtns = document.querySelectorAll('.candidatarBtn');
            const modalCandidatar = document.getElementById('modalCandidatar');
            const closeModalCandidatarBtn = document.getElementById('closeModalCandidatarBtn');
            const candidatarNoModal = document.getElementById('candidatarNoModal');

            const idVaga = document.getElementById('idVaga');

            // Evento para exibir detalhes da vaga no modal "Ler Mais"
            lerMaisBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Atribuição de dados aos elementos do modal
                    const titulo = btn.getAttribute('data-titulo');
                    const area = btn.getAttribute('data-area');
                    const descricao = btn.getAttribute('data-descricao');
                    const tipo = btn.getAttribute('data-tipo');
                    const horario = btn.getAttribute('data-horario');
                    const salario = btn.getAttribute('data-salario');
                    const beneficios = btn.getAttribute('data-beneficios');

                    // Atualização do conteúdo do modal
                    modalTituloArea.textContent = `${titulo} - ${area}`;
                    modalDescricao.textContent = `Descrição: ${descricao}`;
                    modalTipo.textContent = `Tipo: ${tipo}`;
                    modalHorario.textContent = `Horário: ${horario}`;
                    modalSalario.textContent = `Salário: ${salario}`;
                    modalBeneficios.textContent = `Benefícios: ${beneficios}`;

                    // Exibição do modal
                    modalLerMais.style.display = 'block';
                });
            });

            // Evento para abrir o modal "Candidatar-se"
            candidatarBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Exibição do modal e obtenção do ID da vaga
                    modalCandidatar.style.display = 'block';
                    const id = btn.getAttribute('data-idVaga');
                    idVaga.value = id;
                });
            });

            // Evento vazio para o botão "Candidatar-se" no modal
            candidatarNoModal.addEventListener('click', () => {});

            // Eventos para fechar os modais
            closeModalLerMaisBtn.addEventListener('click', () => {
                modalLerMais.style.display = 'none';
            });

            closeModalCandidatarBtn.addEventListener('click', () => {
                modalCandidatar.style.display = 'none';
            });
        </script>

        <!-- Scripts externos necessários (Bootstrap e Ionicons) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </main>
</body>
</html>
