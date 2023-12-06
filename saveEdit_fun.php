<?php

include('conexao.php');
include('protect.php');

date_default_timezone_set('America/Sao_Paulo');

if(isset($_POST['update'])){

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        $cadastro = $_SESSION['id'];
        $login = $_POST['login'];
        $senha =$_POST['senha'];

        $sqlUpdate = "UPDATE funcionarios SET id='$id', nome='$nome', cargo='$cargo', cadastro='$cadastro', login='$login', senha='$senha' WHERE id='$id'";

        $result = $mysqli->query($sqlUpdate);
                    
}

if ($_SESSION['privilegio'] == 1){
        header('Location: show_fun.php');      
}else{
        header('Location: painel_funcionario.php');
}

?>*/