<?php
include('protect.php');
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cadastro'])) {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $cadastro = $_SESSION['id'];

        // Certifique-se de que o valor em $_SESSION['id'] existe na tabela adm
        $queryCheck = "SELECT id FROM adm WHERE id = '$cadastro'";
        $resultCheck = $mysqli->query($queryCheck);

        if ($resultCheck->num_rows > 0) {
            $sql = "INSERT INTO categorias (nome, descricao, cadastro) VALUES 
            ('$nome', '$descricao', '$cadastro')";

            $result = $mysqli->query($sql);

            if (!$result) {
                echo "Erro ao adicionar categoria: " . $mysqli->error;
            } else {
                echo "Categoria adicionada com sucesso!";
                header("Location: painel_adm.php"); 
                exit(); // Certifique-se de encerrar o script após o redirecionamento
            }
            

        } 
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js">
    <link rel="stylesheet" href="painel.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <title>Painel</title>
</head>

<body>
    <div class="container">
        <h1><font color=#FFFF00>Cadastro</font></h1>

        <form action="" method="POST">

            <label for="nome">Nome da Categoria:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" required>

            <button type="submit" name="cadastro">Cadastrar</button>
        </form>
    </div>
</body>

</html>