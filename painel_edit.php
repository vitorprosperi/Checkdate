<?php

include('protect.php');
include('conexao.php');

date_default_timezone_set('America/Sao_Paulo');

if (!empty($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $sqlSelect = "SELECT * FROM produtos WHERE codigo = $codigo";
    
    $result = $mysqli->query($sqlSelect);

    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {
            
            $name = $user_data['nome'];
            $batch = $user_data['lote'];
            $price = (double)str_replace(',', '.', $user_data['preco']);
            $expirationDate = $user_data['datavalidade'];
            $fornecedor = $user_data['idfornecedor'];
            $categoria = $user_data['idcategoria'];
            $cadastro = $_SESSION['id'];
            $alterar = "Nome: " . $_SESSION['nome'] . " | " . date('d-m-Y H:i:s');
            $quantidade = $user_data['qtd'];
        }
    } else {
        header('Location: painel_adm.php');
    }
}

$queryFornecedores = "SELECT id, nome FROM fornecedores";
$resultFornecedores = $mysqli->query($queryFornecedores);

$queryCategorias = "SELECT id, nome FROM categorias";
$resultCategorias = $mysqli->query($queryCategorias);
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

        <form action="saveEdit.php" method="POST">
            <label for="name">Nome do Item:</label>
            <input type="text" id="name" name="name" value="<?php echo $name ?>" required>

            <label for="qtd">Quantidade:</label>
            <input type="text" id="qtd" name="qtd" value="<?php echo $quantidade ?>" required>

            <label for="batch">Lote do Item:</label>
            <input type="text" id="batch" name="batch" value="<?php echo $batch ?>" required>

            <label for="price">Preço do Item:</label>
            <input type="text" id="price" name="price" value="<?php echo $price ?>" required>

            <label for="expirationDate">Data de Validade:</label>
            <input type="date" id="expirationDate" name="expirationDate" value="<?php echo $expirationDate ?>" required>

            <label for="fornecedor">Fornecedor:</label>
            <select id="fornecedor" name="fornecedor" required>
                <?php
                while ($rowFornecedor = $resultFornecedores->fetch_assoc()) {
                    $selected = ($fornecedor == $rowFornecedor["id"]) ? "selected" : "";
                    echo "<option value='" . $rowFornecedor["id"] . "' $selected>" . $rowFornecedor["nome"] . "</option>";
                }
                ?>
            </select>

            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <?php
                while ($rowCategoria = $resultCategorias->fetch_assoc()) {
                    $selected = ($categoria == $rowCategoria["id"]) ? "selected" : "";
                    echo "<option value='" . $rowCategoria["id"] . "' $selected>" . $rowCategoria["nome"] . "</option>";
                }
                ?>
            </select>

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