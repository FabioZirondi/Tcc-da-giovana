<?php
include_once("conexao.php");

session_start();
$emailusuario = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['imagem'])) {
    $pasta = __DIR__ . "/uploads/";
    $extensoes_permitidas = array("jpg", "jpeg", "png");

    $imagem = $_FILES['imagem'];
    $nomeDoArquivo = $imagem['name'];
    $extensao = pathinfo($nomeDoArquivo, PATHINFO_EXTENSION);
    $extensao = strtolower($extensao);

    if ($imagem['error'] === UPLOAD_ERR_OK) {
        if (in_array($extensao, $extensoes_permitidas)) {
            if (!is_dir($pasta)) {
                mkdir($pasta, 0755, true);
            }

            $caminhoCompleto = $pasta . $nomeDoArquivo;

            if (move_uploaded_file($imagem['tmp_name'], $caminhoCompleto)) {

                $idVaga = $_POST["id_vaga"];
                $nome_arquivo = $mysqli->real_escape_string($nomeDoArquivo);
                $caminho_arquivo = $mysqli->real_escape_string($caminhoCompleto);

                // Inserção de dados na tabela 'inscricao'
                $inserir = "INSERT INTO inscricao (data, path, vagas_id, email_usuarios)
                VALUES (NOW(), ?, ?, ?)";

                $stmt = $mysqli->prepare($inserir);
                $stmt->bind_param("sss", $caminho_arquivo, $idVaga, $emailusuario);

                if ($stmt->execute()) {
                    $sucesso = "Imagem Enviada com sucesso!";
                    header("Location: aluno.php?sucesso=" . urlencode($sucesso));
                    exit;
                } else {
                    echo "Erro ao inserir informações na tabela 'inscricao': " . $stmt->error;
                }

                $mysqli->close();
            } else {
                echo "Falha ao mover a imagem para a pasta de destino.";
            }
        } else {
            echo "Tipo de arquivo não aceito. Apenas JPG, JPEG, PNG e GIF são permitidos.";
        }
    } else {
        echo "Erro ao enviar a imagem. Código de erro: " . $imagem['error'];
    }
}

// Consulta para selecionar todas as inscrições e seus respectivos nomes de vaga para o usuário atual
$consulta = "SELECT i.id, i.data, i.path, i.vagas_id, i.email_usuarios, v.titulo AS titulo_vaga
             FROM inscricao AS i
             INNER JOIN vagas AS v ON i.vagas_id = v.id
             WHERE i.email_usuarios = ?";

// Utilize declaração preparada para evitar SQL Injection
$stmt = $mysqli->prepare($consulta);
$stmt->bind_param("s", $emailusuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "<table>";
    echo "<tr><th class='red-background'>Nome</th><th class='red-background'>Data</th><th class='red-background'>Caminho da Imagem</th><th class='red-background'>ID da Vaga</th><th class='red-background'>Email do Usuário</th></tr>";

    while ($linha = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $linha["titulo_vaga"] . "</td>";
        echo "<td>" . $linha["data"] . "</td>";
        echo "<td><a class='image-link' href='exibir_imagem.php?path=" . $linha["path"] . "'>" . $linha["path"] . "</a></td>";
        echo "<td>" . $linha["vagas_id"] . "</td>";
        echo "<td>" . $linha["email_usuarios"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nenhuma inscrição encontrada.";
}

$stmt->close();
$mysqli->close();
?>