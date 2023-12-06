<?php

include('protect.php');
include('conexao.php');

date_default_timezone_set('America/Sao_Paulo');

if (!empty($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $sqlSelect = "SELECT * FROM categorias WHERE id = $codigo";
    
    $result = $mysqli->query($sqlSelect);

    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {
            
            $id = $user_data['id'];
            $nome = $user_data['nome'];
            $descricao = $user_data['descricao'];
            $cadastro = $user_data['cadastro'];
        }
    } else {
        header('Location: show_categ.php');
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

        <form action="saveEdit_categ.php" method="POST">
            <label for="id">Id:</label>
            <input type="text" id="id" name="id" value="<?php echo $id ?>" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $nome ?>" required>

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" value="<?php echo $descricao ?>" required>


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