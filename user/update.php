<?php
    include '../class_start/banco.class.create.php';
    $obj2 = new create;

    include 'classes/banco.class.update.php';
    $obj3 = new UserUpdate;


    include '../class_start/banco.class.login.php';
    $obj = new banco;
    session_start();
    $obj->checkLogin();
    if(isset($_GET['logout'])){
        $obj->logout();
    }
    
    $array = $obj3->readUser($_SESSION['cnpj_cpf']);
    foreach ($array as $key => $rowOrigin) {
    }

    if($_POST){
        $obj3->UpdateUser($_SESSION['cnpj_cpf'],$_POST['ramal'],$_POST['telefone'],$_POST['negocio'],$_POST['cargo']);
    }

?>

<!doctype html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <title>agendamento</title>
</head>

<body>
    <header class="d-flex">
        <div class="container d-flex align-items-center justify-content-between" id="title">
            <a href="../index.php"><h1>Afungaz</h1></a>
            <div class="welcome">
                Bem vindo, <?php echo $_SESSION['nome'] ?>.
                <a href="?logout" class="text-white"> Sair </a>
            </div>
        </div>
    </header> 


    <div class="mt-3 d-flex justify-content-center p-2">
        <form action="" method="POST">

            <div class="form-group">
                <label>CPF</label>
                <input type="text" disabled class="form-control" name="cnpj_cpf"
                value="<?php 
                        echo $rowOrigin['cnpj_cpf'];
                        ?>"
                >
            </div>

            <div class="form-group">
                <label>Nome</label>
                <input type="text" disabled class="form-control" name="nome"
                value="<?php 
                        echo $rowOrigin['nome'];
                        ?>"
                >
            </div>

            <div class="form-group">
                <label>Ramal</label>
                <input type="number" required class="form-control" name="ramal" placeholder="Ramal"
                value="<?php 
                        if(!isset($_POST['ramal'])){
                            echo $rowOrigin['ramal'];
                        }else
                            echo $_POST['ramal'];
                        ?>"
                >
            </div>

            <div class="form-group">
                <label>Telefone</label>
                <input type="number" required class="form-control" name="telefone" placeholder="Ex: 9 99999999"
                value="<?php 
                        if(!isset($_POST['telefone'])){
                            echo $rowOrigin['telefone'];
                        }else
                            echo $_POST['telefone'];
                        ?>"
                >
            </div>

            <div class="form-group">
                <label>Negócio</label>
                <select required class="form-control" name="negocio">
                    <?php 
                    echo '<option value='.$rowOrigin['id_negocio'].'>'.$rowOrigin['desc_negocio'].'</option>';
                    
                    $array = $obj2->readNegocio();
                    foreach ($array as $key => $row) {
                        echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Cargo</label>
                <select required class="form-control" name="cargo">
                    <?php 
                    echo '<option value='.$rowOrigin['id_cargo'].'>'.$rowOrigin['desc_cargo'].'</option>';
                    
                    $array = $obj2->readCargo();
                    foreach ($array as $key => $row) {
                        echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                    }
                    ?>
                </select>
            </div>

            </br>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    Cadastrar
                </button>
            </div>
        </form>
    </div>    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>     