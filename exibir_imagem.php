<!DOCTYPE html>
<html>
<head>
    <title>Exibir Imagem</title>
    <style>
        body {
            background-color: #FFFFFF; /* Branco */
            font-family: Arial, sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    // Verifica se o parâmetro 'path' está definido na URL
    if (isset($_GET['path'])) {
        // Obtém o caminho da imagem a partir do parâmetro 'path' na URL
        $imagePath = $_GET['path'];

        // Exibe a imagem usando a tag <img> com o caminho fornecido
        echo "<img src='$imagePath' alt='Imagem'>";
    }
    ?>
</body>
</html>
