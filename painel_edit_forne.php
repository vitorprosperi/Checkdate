<?php

include('protect.php');
include('conexao.php');

date_default_timezone_set('America/Sao_Paulo');

if (!empty($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $sqlSelect = "SELECT * FROM fornecedores WHERE id = $codigo";
    
    $result = $mysqli->query($sqlSelect);

    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {
            
            $id = $user_data['id'];
            $nome = $user_data['nome'];
            $endereco = $user_data['endereco'];
            $contato = $user_data['contato'];
            $cadastro = $user_data['cadastro'];
        }
    } else {
        header('Location: show_forne.php');
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
    <div class="container">
        <h1><font color=#FFFF00>Editar Item</font></h1>

        <form action="saveEdit_forne.php" method="POST">
            <label for="id">Id:</label>
            <input type="text" id="id" name="id" value="<?php echo $id ?>" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $nome ?>" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?php echo $endereco ?>" required>

            <label for="contato">Contato:</label>
            <input type="text" id="contato" name="contato" value="<?php echo $contato ?>" required>


            <input type="hidden" name="codigo" value="<?php echo $codigo ?>">
            <button type="submit" name="update">Salvar</button>
        </form>
    </div>

    <script>
        // JavaScript para exibir o formulário de adição de item
        document.addEventListener('DOMContentLoaded', function () {
            var addItemForm = document.getElementById('addItemForm');
            addItemForm.style.display = 'block';
        });
    </script>
</body>

</html>