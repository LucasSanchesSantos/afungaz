<?php
    include 'classes/banco.class.php';
    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    
    if(isset($_GET['logout'])){
        $obj->logout();
    }

    if($_POST){
        $obj->createAgendamento($_POST['id_local_origem'],$_POST['data_agendamento']);
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
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <title>agendamento</title>
</head>

<body>
    
    <header class="d-flex">
        <div class="container d-flex align-items-center justify-content-between" id="title">
            <a href="../index.php"><h1>Home</h1></a>
            <div class="welcome">
                Bem vindo, <?php echo $_SESSION['nome'] ?>.
                <a href="?logout" class="text-white"> Sair </a>
            </div>
        </div>
    </header> 



    <div class="container d-flex align-items-center justify-content-between" id="title">
        <table class="table table-striped">
            <!-- <div class="mt-5 d-flex justify-content-center ">
                <h3 id="title2">Quiosques já agendados</h3> -->
           
            <thead>
                <tr>
                    <th scope="col" class="text-center">Número quiosques</th>
                    <th scope="col" class="text-center">Data</th>
                    <th scope="col" class="text-center">Situação</th>
                </tr>
            </thead>    
            <tbody>
            <?php
            $array = $obj->readQuioesque();
            foreach ($array as $key => $row) {
                echo '<tr>';
                echo '<th class="text-center">'. $row['id_local_origem'].'</th>';
                echo '<th class="text-center">'. $row['data_agendamento'].'</th>';
                echo '<th class="text-center">Agendado</th>';

            }  
                ?>
            </tbody>
        </table>

        <div class="mt-3 d-flex justify-content-center p-2">
            <form action="" method="POST">
            <div class="form-group ">
                <label>Número do quiosque</label>
                <select required class="form-control" type="integer" name="id_local_origem">
                    <option value="0">Selecione</option>
                    <?php $array = $obj->readLocal();
                    
                    foreach ($array as $key => $row) {
                        echo '<option value='.$row['id'].'>'.$row['id_local_origem'].'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group btn">
                <label>Data inicio</label>
                <input type="date" required  class="form-control" min="<?php echo date('Y-m-d')?>"
                name="data_agendamento" value="<?php $date = date('Y-m-d'); echo $date;?>">
            </div>

            <button type="submit" class="btn btn-primary " >
                Agendar
            </button>

            </form>
        </div>                   

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>     