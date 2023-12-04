<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/resultados.css">
    <title>Informações de Inscrições</title>
    
</head>
<body>
    <div class="container">
        <a href="areadm.php">X</a>
        <h1>Informações de Inscrições</h1>
    

        <?php
// Inclui o arquivo de conexão com o banco de dados
include_once("conexao.php");

// Verifica se há erro na conexão com o banco de dados
if ($mysqli->connect_error) {
    die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
}

$consulta = "SELECT i.id, i.data, i.path, i.vagas_id, i.email_usuarios, v.titulo AS titulo_vaga
FROM inscricao AS i
INNER JOIN vagas AS v ON i.vagas_id = v.id;
";

$resultado = $mysqli->query($consulta);

if ($resultado->num_rows > 0) {
    echo "<table>";
    echo "<tr><th class='red-background'>Nome</th>
    <th class='red-background'>Data</th>
    <th class='red-background'>Caminho da Imagem</th>
    <th class='red-background'>ID da Vaga</th><th class='red-background'>Email do Usuário</th></tr>";

    while ($linha = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $linha["titulo_vaga"] . "</td>";
        echo "<td>" . $linha["data"] . "</td>";
        echo "<td><a class='image-link' href='exibir_imagem.php?path="
         . $linha["path"] . "'>" . $linha["path"] . "</a></td>";
        echo "<td>" . $linha["vagas_id"] . "</td>";
        echo "<td>" . $linha["email_usuarios"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nenhuma inscrição encontrada.";
}

// Fecha a conexão com o banco de dados
$mysqli->close();
?>

    </div>
</body>
</html>
