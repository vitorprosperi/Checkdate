<?php

include('protect.php');
include('conexao.php');

if (!isset($_SESSION['privilegio']) || $_SESSION['privilegio'] != 1) {
    // Redireciona para outra página ou mostra uma mensagem de erro
    header("Location: index.php");
    exit();
}

date_default_timezone_set('America/Sao_Paulo');
    
    if(!empty($_GET['search'])){
    
        $data = $_GET['search'];
        $sql = "SELECT * FROM produtos WHERE codigo LIKE '%$data%' or nome LIKE '%$data%' or lote LIKE '%$data%' or datavalidade like '%$data%' or alterar like '%$data%' ORDER BY datavalidade ASC";
    
    }else{
        $sql = "SELECT * FROM produtos ORDER BY datavalidade ASC";
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        if (isset($_POST['submitItem'])) {
            
            $name = $_POST['name'];
            $batch = $_POST['batch'];
            $price = (double)str_replace(',', '.', $_POST['price']);
            $expirationDate = $_POST['expirationDate'];
            $fornecedor = $_POST['fornecedor'];
            $categoria = $_POST['categoria'];
            $cadastro = $_SESSION['id'];
            $alterar = "Nome: " . $_SESSION['nome'] . " | " . date('d-m-Y H:i:s');
            $quantidade = $_POST['qtd'];
    
            $sql = "INSERT INTO produtos (nome, lote, preco, datavalidade, idfornecedor, idcategoria, cadastro, alterar, qtd) VALUES ('$name', '$batch', '$price', '$expirationDate','$fornecedor', '$categoria','$cadastro','$alterar', $quantidade)";
    
            $result = $mysqli->query($sql);
    
            if (!$result) {
                echo "Erro ao adicionar item: " . $mysqli->error;
            } else {
                echo "Item adicionado com sucesso!";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }
    
    $queryFornecedores = "SELECT id, nome FROM fornecedores";
    $resultFornecedores = $mysqli->query($queryFornecedores);
    
    $queryCategorias = "SELECT id, nome FROM categorias";
    $resultCategorias = $mysqli->query($queryCategorias);
    
    $result = $mysqli->query($sql);
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
    </style>
</head>

<body>
    <h1>Bem Vindo! <?php echo $_SESSION['nome']; ?></h1>
    <div class="container">
        <!-- Barra de filtro -->
        <div id="box-search">
            <input type="search" id="pesquisar" placeholder="Pesquisar">
            <button onclick="searchData()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
            </button>
        </div>

        <ul id="item-list">

        </ul>

        <button class="add" onclick="showAddItemForm()">Adicionar Item</button>
        <a href="show_adm.php" class="add-button">Administradores</a>
        <a href="show_fun.php" class="show-button">Funcionários</a>
        <a href="show_categ.php" class="add-button">Categorias</a>
        <a href="show_forne.php" class="add-button">Fornecedores</a>

        <form action="" method="POST" id="addItemForm" style="display: none;">
            <h2>Adicionar Item</h2>
            <label for="name">Nome do Item:</label>
            <input type="text" id="name" name="name" required>

            <label for="qtd">Quantidade:</label>
            <input type="text" id="qtd" name="qtd" required>

            <label for="batch">Lote do Item:</label>
            <input type="text" id="batch" name="batch" required>

            <label for="price">Preço do Item:</label>
            <input type="text" id="price" name="price" required>

            <label for="expirationDate">Data de Validade:</label>
            <input type="date" id="expirationDate" name="expirationDate" required>

            <label for="fornecedor">Fornecedor:</label>
            <select id="fornecedor" name="fornecedor" required>
                <?php
                while ($rowFornecedor = $resultFornecedores->fetch_assoc()) {
                    echo "<option value='" . $rowFornecedor["id"] . "'>" . $rowFornecedor["nome"] . "</option>";
                }
                ?>
            </select>

            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <?php
                while ($rowCategoria = $resultCategorias->fetch_assoc()) {
                    echo "<option value='" . $rowCategoria["id"] . "'>" . $rowCategoria["nome"] . "</option>";
                }
                ?>
            </select>

            <button type="submit" name="submitItem">Adicionar</button>
        </form>

        <p><a class="logout" href="logout.php">Logout</a></p>
    </div>

    <div class="m-5">
        <table>
        <h1><font color=#FFFF00>Lista de Itens</h1></font>
            <thead>
                <th scope="col">Código</th>
                <th scope="col">Descrição</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Preço</th>
                <th scope="col">Desconto</th>
                <th scope="col">Preço com Desconto</th>
                <th scope="col">Data de Validade</th>
                <th scope="col">Lote</th>
                <th scope="col">Ultima Alteração</th>
            </thead>

            <tbody>
            <?php
    while ($user_data = mysqli_fetch_assoc($result)) {
        $preco = $user_data['preco'];
        $hoje = new DateTime();
        $datavalidade = new DateTime($user_data['datavalidade']);
        $diferenca = $datavalidade->getTimestamp() - $hoje->getTimestamp();
        // Converter a diferença de segundos para dias (1 dia = 24 * 60 * 60 segundos)
        $diferencaDias = floor($diferenca / (24 * 60 * 60));
        // Inicia a linha da tabela com a tag <tr> e aplica o estilo se a condição for atendida
        echo "<tr";
        if ($diferencaDias <= 0) {
            echo " style='background-color: #FA3138;'";
            $desconto = 0;
            $precodesconto = 0;
        } elseif ($diferencaDias <= 60) {
            echo " style='background-color: yellow;'";
            $desconto = 40/100;
            $precodesconto = $preco - ($preco * $desconto);
        } elseif ($diferencaDias <= 120) {        
            echo " style='background-color: #00FF60;'";
            $desconto = 30/100;
            $precodesconto = $preco - ($preco * $desconto);
        }elseif ($diferencaDias <= 180) {        
            echo " style='background-color: #00EBFF;'";
            $desconto = 20/100;
            $precodesconto = $preco - ($preco * $desconto);
        
        } else{
            $desconto = 0;
            $precodesconto = $preco - ($preco * $desconto);
        }
        echo ">";
        
        echo "<td>" . $user_data['codigo'] . "</td>";
        echo "<td>" . $user_data['nome'] . "</td>";
        echo "<td>" . $user_data['qtd'] . "</td>";
        echo "<td>" . $user_data['preco'] . "</td>";
        echo "<td>" . ($desconto*100)."%". "</td>";
        echo "<td>" . $precodesconto . "</td>";                    
        echo "<td>" . $user_data['datavalidade'] . "</td>";
        echo "<td>" . $user_data['lote'] . "</td>";
        echo "<td>" . $user_data['alterar'] . "</td>";
        echo "<td>
                <a class='btn edit' href='painel_edit.php?codigo={$user_data['codigo']}'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                    </svg>
                </a>
            </td>";
        echo "<td>
                <a class='btn edit' href='delete.php?codigo={$user_data['codigo']}'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                        <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                    </svg>
                </a>
            </td>";

        echo "</tr>";
    }
    ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript para exibir o formulário de adição de item
        function showAddItemForm() {
            var addItemForm = document.getElementById('addItemForm');
            addItemForm.style.display = 'block';
        }

        if (!document.getElementById('closeButton')) {
            var closeButton = document.createElement('button');
            closeButton.id = 'closeButton';
            closeButton.textContent = 'Fechar Formulário';
            closeButton.onclick = function() {
                closeAddItemForm();
            };
            addItemForm.appendChild(closeButton);
        }

        function closeAddItemForm() {
        var addItemForm = document.getElementById('addItemForm');
        addItemForm.style.display = 'none';

        var closeButton = document.getElementById('close');
        if (closeButton) {
            closeButton.parentNode.removeChild(closeButton);
        }
    }
    </script>
</body>

<script>
    var search = document.getElementById('pesquisar');
    
    search.addEventListener("keydown", function(event) {
        if (event.key === "Enter") 
        {
            searchData();
        }
    });
    
    function searchData(){
        window.location = 'painel_adm.php?search='+search.value;
    }    
</script>

</html>