<?php

include('protect.php');
include('conexao.php');


if (!empty($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $sqlSelect = "SELECT * FROM produtos WHERE codigo = $codigo";
    
    $result = $mysqli->query($sqlSelect);

    if ($result->num_rows > 0) {
        
        $sqlDelete = "DELETE FROM produtos WHERE codigo=$codigo";
        
        $resultDelete = $mysqli->query($sqlDelete);
    }
}

header('Location: painel_adm.php');

?>