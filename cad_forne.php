<?php
include('protect.php');
include('conexao.php');

if (!isset($_SESSION['privilegio']) || $_SESSION['privilegio'] != 1) {
    // Redireciona para outra página ou mostra uma mensagem de erro
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cadastro'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $contato = $_POST['contato'];
        $cadastro = $_SESSION['id'];

        // Certifique-se de que o valor em $_SESSION['id'] existe na tabela adm
        $queryCheck = "SELECT id FROM adm WHERE id = '$cadastro'";
        $resultCheck = $mysqli->query($queryCheck);

        if ($resultCheck->num_rows > 0) {
            $sql = "INSERT INTO fornecedores (id, nome, endereco, contato, cadastro) VALUES 
            ('$id', '$nome', '$endereco', '$contato','$cadastro')";

            $result = $mysqli->query($sql);

            if (!$result) {
                echo "Erro ao adicionar: " . $mysqli->error;
            } else {
                echo "Sucesso!";
                header("Location: show_forne.php"); 
                exit();
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
    <link rel="stylesheet" href="paineldef.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <title>Painel</title>
</head>

<body>
<?php
    echo "<td>
        <a class='btn edit' href='painel_adm.php'>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-return-left' viewBox='0 0 16 16'>
            <path fill-rule='evenodd' d='M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5'/>
        </svg>
                </a>
            </td>";
    ?>
    <div class="container">
        <h1><font color=#FFFF00>Cadastro</font></h1>

        <form action="" method="POST">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>

            <label for="contato">Contato:</label>
            <input type="text" id="contato" name="contato" required>

            <button type="submit" name="cadastro">Cadastrar</button>
        </form>
    </div>
</body>

</html>