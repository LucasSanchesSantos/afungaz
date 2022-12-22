<?php
    include 'alunos/classes/banco.class.php';

    if($_POST){
        $obj = new banco;
        $email = $_POST['cpf'];
        $senha = $_POST['senha'];

        $obj->sigin($email, $senha);
    }
    echo 'Current PHP version: ' . phpversion();

?>

<!doctype html>
<html lang="pt">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Insira seu usuário e senha</title>
</head>


<body>
    <div class="mt-5 d-flex justify-content-center">
        <form action="" method="post">   
            <div class="form-outline">
                <label>cpf</label> 
                <input type="text" name="cpf" maxlength="11" minlength="11" class="form-control">
            </div>
            <div class="form-outline">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control">
            </div>
            </br>
            <button type="submit" class="btn btn-primary btn-block mb-4">
                Entre
            </button>
            <a href="alunos/create.php" class="btn btn-block mb-4">
                Cadastre-se aqui!
            </a>
        </form>
    </div>

</body> 
</html>