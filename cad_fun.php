<?php
include('protect.php');
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cadastro'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $cadastro = $_SESSION['id'];

        // Certifique-se de que o valor em $_SESSION['id'] existe na tabela adm
        $queryCheck = "SELECT id FROM adm WHERE id = '$cadastro'";
        $resultCheck = $mysqli->query($queryCheck);

        if ($resultCheck->num_rows > 0) {
            $sql = "INSERT INTO funcionarios (id, nome, cargo, login, senha, cadastro) VALUES 
            ('$id', '$nome', '$cargo', '$login', '$senha', '$cadastro')";

            $result = $mysqli->query($sql);

        } else {
            echo "Erro: O valor em cadastro não existe na tabela adm.";
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
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cargo">Cargo:</label>
            <input type="text" id="cargo" name="cargo" required>

            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required>

            <label for="senha">Senha:</label>
            <input type="text" id="senha" name="senha" required>

            <button type="submit" name="cadastro">Cadastrar</button>
        </form>
    </div>
</body>

</html>