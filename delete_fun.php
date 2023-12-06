<?php

include('protect.php');
include('conexao.php');



if (!empty($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $sqlSelect = "SELECT * FROM funcionarios WHERE id = $codigo";
    
    $result = $mysqli->query($sqlSelect);

    if ($result->num_rows > 0) {
        
        $sqlDelete = "DELETE FROM funcionarios WHERE id=$codigo";
        
        $resultDelete = $mysqli->query($sqlDelete);
    }
}

header('Location: show_fun.php');

?>