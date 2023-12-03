<?php

include('conexao.php');
if(isset($_POST['email']) || isset($_POST['senha'])){

    if (strlen($_POST['email']) == 0) {
        echo "Preencha seu email!";
    } else if (strlen($_POST['senha']) == 0 ){
        echo "Preencha sua senha!";
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
        
        // Verifica na tabela 'adm'
        $sql_adm = "SELECT * FROM adm WHERE login = '$email' AND senha = '$senha'";
        $sql_query_adm = $mysqli->query($sql_adm) or die("Falha na execução do código SQL para administradores");

        $quantidade_adm = $sql_query_adm->num_rows;

        if ($quantidade_adm == 1) {
            $usuario_adm = $sql_query_adm->fetch_assoc();

            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario_adm['id'];
            $_SESSION['nome'] = $usuario_adm['nome'];

            header("Location: painel_adm.php");

        } else {
            // Se não encontrou na tabela 'adm', verifica na tabela 'funcionarios'
            $sql_func = "SELECT * FROM funcionarios WHERE login = '$email' AND senha = '$senha'";
            $sql_query_func = $mysqli->query($sql_func) or die("Falha na execução do código SQL para funcionários");

            $quantidade_func = $sql_query_func->num_rows;

            if ($quantidade_func == 1) {
                $usuario_func = $sql_query_func->fetch_assoc();

                if(!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['id'] = $usuario_func['id'];
                $_SESSION['nome'] = $usuario_func['nome'];

                header("Location: painel_funcionario.php");

            } else {
                echo "Falha ao logar! E-mail ou senha incorretos";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <h1>CHECKDATE</h1>
    <form action="" method="POST">

        <h2>Login</h2>
        <input type="text" id="email" name="email" placeholder="Login" required>
        <input type="password" id="senha" name="senha" placeholder="Senha" required>

        <button type="submit">Entrar</button>

    </form>
</body>
</html>