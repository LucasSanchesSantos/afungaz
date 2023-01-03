<?php
    include 'class_login/banco.class.php';


    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    $obj->checkCadastroAfungaz();
    
    if(isset($_GET['logout'])){
        $obj->logout();
    }

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

    <title>Afungaz</title>
</head>

<body>
    
    <header class="d-flex">
        <div class="container d-flex align-items-center justify-content-between" id="title">
            <a href="index.php"><h1>Afungaz</h1></a>
            <div class="welcome">
                Bem vindo, <?php echo $_SESSION['nome'] ?>.
                <a href="?logout" class="text-white"> Sair </a>
            </div>
        </div>
    </header> 

    <a href="agendamento_quioesque/agendamento.php">Agendar Quioesque</a><br>
    <a href="agendamento_chale/agendamento.php">Agendar Chalé</a><br>
    <a href="agendamento_quadra/agendamento.php">Agendar Campos</a><br>
    <a href="user/user.php">Meus agendamentos</a><br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>     