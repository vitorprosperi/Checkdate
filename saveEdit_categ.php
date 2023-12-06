<?php

include('conexao.php');
include('protect.php');

date_default_timezone_set('America/Sao_Paulo');

if(isset($_POST['update'])){

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $cadastro = $_SESSION['id'];

        $sqlUpdate = "UPDATE categorias SET id='$id', nome='$nome', descricao='$descricao', cadastro='$cadastro' WHERE id='$id'";

        $result = $mysqli->query($sqlUpdate);
        
            
}

if ($_SESSION['privilegio'] == 1){
        header('Location: show_categ.php');      
}else{
        header('Location: painel_funcionario.php');
}

?>