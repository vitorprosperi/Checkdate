<?php

include('protect.php');
include('conexao.php');

if (!isset($_SESSION['privilegio']) || $_SESSION['privilegio'] != 1) {
    // Redireciona para outra página ou mostra uma mensagem de erro
    header("Location: index.php");
    exit();
}

if(!empty($_GET['search'])){

    $data = $_GET['search'];
    $sql = "SELECT * FROM categorias WHERE id LIKE '%$data%' or nome LIKE '%$data%' ORDER BY id DESC";

}else{
    $sql = "SELECT * FROM categorias ORDER BY id DESC";
}

$result = $mysqli->query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js">
    <link rel="stylesheet" href="paineldef.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <title>Painel</title>
</head>

<body>
    <?php
    echo "<td>
        <a class='btn edit' href='painel_adm.php'>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-return-left' viewBox='0 0 16 16'>
            <path fill-rule='evenodd' d='M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5'/>
        </svg>
                </a>
            </td>";
    ?>

    <div class="container">
        <!-- Barra de filtro -->
        <div id="box-search">
            <input type="search" id="pesquisar" placeholder="Pesquisar">
            <button onclick="searchData()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
            </button>
            <a href="cad_categ.php" class="add-button">Cadastrar Categorias</a>
        </div>
    </div>

    <div class="m-5">
        <table>
        <h1><font color=#FFFF00>Lista de Categorias</h1></font>
            <thead>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Cadastro</th>
                <th scope="col">Descrição</th>

            </thead>

            <tbody>
                <?php
                while ($user_data = mysqli_fetch_assoc($result)) {

                    echo "<tr>";
                    echo "<td>" . $user_data['id'] . "</td>";
                    echo "<td>" . $user_data['nome'] . "</td>";
                    echo "<td>" . $user_data['cadastro'] . "</td>";
                    echo "<td>" . $user_data['descricao'] . "</td>";
                    echo "<td>
                    <a class='btn edit' href='painel_edit_categ.php?codigo={$user_data['id']}'>
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
        window.location = 'show_categ.php?search='+search.value;
    }    
</script>

</html>