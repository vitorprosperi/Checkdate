<?php

include('protect.php');
include('conexao.php');


if(!empty($_GET['search'])){

    $data = $_GET['search'];
    $sql = "SELECT * FROM funcionarios WHERE id LIKE '%$data%' or nome LIKE '%$data%' or cargo LIKE '%$data%' ORDER BY id DESC";

}else{
    $sql = "SELECT * FROM funcionarios ORDER BY id DESC";
}

$result = $mysqli->query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js">
    <link rel="stylesheet" href="painel.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <title>Painel</title>

    <style>
        .add-button, .show-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>

<body>
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
    </div>

    <div class="m-5">
        <table>
        <h1><font color=#FFFF00>Lista de Funcionários</h1></font>
            <thead>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Cargo</th>
                <th scope="col">Login</th>
                <th scope="col">Cadastro</th>
            </thead>

            <tbody>
                <?php
                while ($user_data = mysqli_fetch_assoc($result)) {

                    echo "<tr>";
                    echo "<td>" . $user_data['id'] . "</td>";
                    echo "<td>" . $user_data['nome'] . "</td>";
                    echo "<td>" . $user_data['cargo'] . "</td>";
                    echo "<td>" . $user_data['login'] . "</td>";
                    echo "<td>" . $user_data['cadastro'] . "</td>";
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
        window.location = 'show_fun.php?search='+search.value;
    }    
</script>

</html>