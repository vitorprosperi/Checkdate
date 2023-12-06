<?php

include('conexao.php');
include('protect.php');

date_default_timezone_set('America/Sao_Paulo');

if(isset($_POST['update'])){

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $contato = $_POST['contato'];
        $cadastro = $_SESSION['id'];
        $endereco = $_POST['endereco'];

        $sqlUpdate = "UPDATE fornecedores SET id='$id', nome='$nome', contato='$contato', cadastro='$cadastro', endereco='$endereco' WHERE id='$id'";

        $result = $mysqli->query($sqlUpdate);
        
            
}

if ($_SESSION['privilegio'] == 1){
        header('Location: show_forne.php');      
}else{
        header('Location: painel_funcionario.php');
}

?>