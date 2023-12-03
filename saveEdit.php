<?php

include('conexao.php');
include('protect.php');

date_default_timezone_set('America/Sao_Paulo');

if(isset($_POST['update'])){

        $codigo = $_POST['codigo'];
        $name = $_POST['name'];
        $batch = $_POST['batch'];
        $price = (double)str_replace(',', '.', $_POST['price']);
        $expirationDate = $_POST['expirationDate'];
        $fornecedor = $_POST['fornecedor'];
        $categoria = $_POST['categoria'];
        $quantidade = $_POST['qtd'];
        $desconto = $_POST['desconto'];

        $cadastro = $_SESSION['id'];
        $alterar = "Nome: " . $_SESSION['nome'] . " | " . date('d-m-Y H:i:s');

        $sqlUpdate = "UPDATE produtos SET nome='$name', lote='$batch', preco='$price', datavalidade='$expirationDate', idfornecedor='$fornecedor', idcategoria='$categoria', cadastro='$cadastro', alterar='$alterar', qtd='$quantidade', desconto='$desconto' WHERE codigo='$codigo'";

        $result = $mysqli->query($sqlUpdate);        
}


header('Location: painel_adm.php');

?>