<?php
    include 'classes/banco.class.php';
    $object = new quadra;

    include '../class_login/banco.class.php';
    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    
    if(isset($_GET['logout'])){
        $obj->logout();
    }
    
    //or $_POST['hora'] 
    if($_POST){
        if(!isset($_POST['local_origem'])){
        }else{
            if($_POST['local_origem'] == 0 or $_POST['hora'] == 0){
                echo '<script>alert("Precisa selecionar pelomenos uma quadra e um horário!");</script>';
            }else{
                $object->validaAgendamento($_POST['local_origem'],$_POST['data_agendamento'],$_POST['hora']); 
            }
        }
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
        <div class="form-group ">
            <label>Campo</label>
            <select required class="form-control" type="integer" name="local_origem_consulta">
                <option value="0">Selecione</option>
                <?php $array = $object->readLocal();
                
                foreach ($array as $key => $row) {
                    echo '<option value='.$row['id'].'>'.$row['local_origem'].'</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group btn">
            <label>Data</label>
            <input type="date" required  class="form-control" min="<?php echo date('Y-m-d')?>"
            name="data_agendamento_consulta" value="<?php $date = date('Y-m-d'); echo $date;?>">
        </div>

        <button type="submit" class="btn btn-primary " >
            Consultar
        </button>

        </form>
    </div>     












    <div class="container d-flex align-items-center justify-content-between" id="title"> 
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Campos</th>
                    <th scope="col" class="text-center">Data</th>
                    <th scope="col" class="text-center">Hora</th>
                    <th scope="col" class="text-center">Situação</th>
                </tr>
            </thead>    
            <tbody>
            <?php

                if($_POST){
                    if(!isset($_POST['local_origem_consulta']) or !isset($_POST['data_agendamento_consulta'])){
                    }else{
                        $array = $object->readQuioesqueFilter($_POST['local_origem_consulta'],$_POST['data_agendamento_consulta']);
                    }
                }else{
                    $array = $object->readQuioesque();
                }
                foreach ($array as $key => $row) {
                    echo '<tr>';
                    echo '<th class="text-center">'. $row['local_origem'].'</th>';
                    echo '<th class="text-center">'. $row['data_agendamento'].'</th>';
                    echo '<th class="text-center">'. $row['hora'].":00".'</th>';
                    echo '<th class="text-center">Agendado</th>';
                }
              
            ?>
            </tbody>
        </table>              

    </div>

    <div class="mt-3 d-flex justify-content-center p-2">
            <form action="" method="POST">
            <div class="form-group ">
                <label>Número do quiosque</label>
                <select required class="form-control" type="integer" name="local_origem">
                    <option value="0">Selecione</option>
                    <?php $array = $object->readLocal();
                    
                    foreach ($array as $key => $row) {
                        echo '<option value='.$row['id'].'>'.$row['local_origem'].'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group btn">
                <label>Data</label>
                <input type="date" required  class="form-control" min="<?php echo date('Y-m-d')?>"
                name="data_agendamento" value="<?php $date = date('Y-m-d'); echo $date;?>">
            </div>

            <div class="form-group btn">
                <label>Hora</label>
                <select required class="form-control" type="numeric" name="hora">
                    <option value="0">Selecione</option>
                    <?php
                        for($i=10; $i <= 22; $i++){
                            echo '<option value='.$i.'>'.$i.":00".'</option>';
                        }   
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary " >
                Agendar
            </button>

            </form>
        </div>     

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>     