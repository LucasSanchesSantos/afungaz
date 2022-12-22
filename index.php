<?php
    include 'pessoa/classes/banco.class.php';
    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    
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

    <title>Painel Administrativo</title>
</head>

<body>
    
    <header class="d-flex">
        <div class="container d-flex align-items-center justify-content-between" id="title">
            <h1>Central do Aluno</h1>
            <div class="welcome">
                Bem vindo, <?php echo $_SESSION['nome'] ?>.
                <a href="?logout" class="text-white"> Sair </a>
            </div>
        </div>
    </header>
    <?php

    //if verifica o parametro enviado pela url
    if (isset($_GET['dir']) and isset($_GET['file'])) {
    ;
        // include inclui o arquivo solicitado
        include(__DIR__ . "/{$_GET['dir']}/{$_GET['file']}.php");
    } else {
        
    ?>
    <div class="d-flex">

    <main class="col-md-11 p-5">
    <section class="container">
            <div class="container d-flex justify-content-center">
                <div class="row" id="subtitle">
                    <h3>Selecione uma ação</h3>
                </div>
            </div>
            <div class="mt-5 d-flex justify-content-center">
                <div class="form-outline">
                    <button type="submit" class="btn btn-primary btn-block mb-4">
                        <a href="pessoa/update.php" class="text-white">Manutenção de cadastro</a>
                    </button>
                    <button type="submit" class="btn btn-success btn-block mb-4">
                        <a href="pessoa/agendamento.php" class="text-white">Agendamento</a>
                    </button>
                    
                </div>
            </div>
            
    </main>
    </section>
    </div>

    
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html> 