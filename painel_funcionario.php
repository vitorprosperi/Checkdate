<?php

include('protect.php');
include('conexao.php');

date_default_timezone_set('America/Sao_Paulo');

if(!empty($_GET['search'])){

    $data = $_GET['search'];
    $sql = "SELECT * FROM produtos WHERE codigo LIKE '%$data%' or nome LIKE '%$data%' or lote LIKE '%$data%' ORDER BY datavalidade ASC";

}else{
    $sql = "SELECT * FROM produtos ORDER BY datavalidade ASC";
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
        echo "</tr>";
    }
    ?>
            </tbody>
        </table>
    </div>

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
        window.location = 'painel_funcionario.php?search='+search.value;
    }    
</script>

</html>