<?php
    include 'alunos/classes/banco.class.php';
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
    <!-- <nav class="col-md-3 p-2 menu">
        <ul class="text-center">
            <h2 id="recadotitle">Olá, estudante, seja bem vindo!</h2>
        </ul>
        <h6 id="recado"><?php echo $_SESSION['nome']?>,  esse é <b>Contador de Dedinhos</b>, o seu portal do estudante. Aqui você poderá, e deverá marcar sua presença diáriamente sempre que for utilizar o ônibus! :) </br> Você também terá acesso ao seu cadastro atual, mantenha-o sempre atualizado, pois isso vai ajudar quando precisarmos entrar em contato com você.</h6>
        <h6 id="recado">Ah, estou deixando uma caixinha de sugestão também, se encontrou um bug, ou tem alguma sugestão, você pode preencher por ali que vamos ler tudinho! Ou, você pode entrar em contato com a gente da coordenação no email: cooerdacao@email.com</h6>
    
        <h6>Ah, lembre-se de que esse é um trabalho voluntário que estamos fazendo, sem lucro algum, então vamos nos ajudar para que tenhamos a maior acertividade possível!</br><a href="alunos/coordenacao.php"> Clique aqui</a> para ver nossos contatos e quem somos!</h6>
        <div class="row">
            <h3 class="mt-5 d-flex justify-content-center" id="recadotitle">Bons estudos!</h3>
        </div>
    </nav> -->
    

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
                        <a href="alunos/update.php" class="text-white">Manutenção de cadastro</a>
                    </button>
                    <button type="submit" class="btn btn-success btn-block mb-4">
                        <a href="alunos/contador.php" class="text-white">Marcar presença</a>
                    </button>
                    <?php if ($_SESSION['id_tipo_usuario'] == 2) {?>
                        <button type="submit" class="btn btn-dark btn-block mb-4">
                            <a href="?dir=alunos&file=read" class="text-white">Admin Usuários</a>
                        </button>

                        <button type="submit" class="btn btn-dark btn-block mb-4">
                            <a href="?dir=motorista&file=read" class="text-white">Admin motorista</a>
                        </button>
                        
                        <button type="submit" class="btn btn-dark btn-block mb-4">
                            <a href="?dir=facul&file=read_facul" class="text-white">Admin universidades</a>
                        </button>

                        <button type="submit" class="btn btn-info btn-block mb-4">
                            <a href="alunos/relatorio.php" class="text-white">Relatório detalhado (Presença)</a>
                        </button>
        
                        <table class="table table-striped">
                        <div class="mt-5 d-flex justify-content-center">
                            <h3 id="title2">Alunos por motorista</h3>
                        </div>
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Id motorista</th>
                                    <th scope="col" class="text-center">Motorista</th>
                                    <th scope="col" class="text-center">Quantidade máxima</th>
                                    <th scope="col" class="text-center">Quantidade hoje</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $array = $obj->countOnibus();
                            foreach ($array as $key => $row) {
                                echo '<tr>';
                                echo '<th class="text-center">'. $row['id'].'</th>';
                                echo '<td class="text-center">'. $row['nome'].'</td>';
                                echo '<td class="text-center">'. $row['limite'].'</td>';
                                echo '<td class="text-center">'. $row['contador'].'</td>';
                                //echo '<td width=0>';
                            }  
                                ?>
                            </tbody>
                        </table>

                        <table class="table table-striped">
                        <div class="mt-5 d-flex justify-content-center">
                            <h3 id="title2">Alunos por instituição</h3>
                        </div>
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Id instituição</th>
                                    <th scope="col" class="text-center">Instituicao</th>
                                    <th scope="col" class="text-center">Motorista</th>
                                    <th scope="col" class="text-center">Quantidade hoje</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $array = $obj->countFacul();
                            foreach ($array as $key => $row) {
                                echo '<tr>';
                                echo '<th class="text-center">'. $row['id'].'</th>';
                                echo '<td class="text-center">'. $row['nome'].'</td>';
                                echo '<td class="text-center">'. $row['nomemotorista'].'</td>';
                                echo '<td class="text-center">'. $row['contador'].'</td>';
                            }
                            ?>
                            </tbody>
                        </table>



                    <?php }?>
                </div>
            </div>
            
    </main>
    </section>
    </div>

    <footer>
        <div class="d-flex justify-content-center">
            <div class="row">
                Desenvolvido por Lucas Sanches - Copyrigth <?php echo date("M/Y"); ?>
            </div>
        </div>
    </footer>  
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html> 