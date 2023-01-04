<?php
    include 'classes/banco.class.php';
    $object = new quioesque;

    include '../class_start/banco.class.login.php';
    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    
    if(isset($_GET['logout'])){
        $obj->logout();
    }
    
    if($_POST){
        if(!isset($_POST['data_agendamento_consulta_inicio'])){
            if(!isset($_POST['local_origem'])){
                $array_filter = $object->readChale();
            }else{
                if($_POST['local_origem'] == 0){
                    echo '<script>alert("Precisa selecionar pelomenos uma quadra e um horário!");</script>';
                    $array_filter = $object->readChale();
                }else{
                    $object->Agendamento($_POST['local_origem'],$_POST['data_agendamento']); 
                    $array_filter = $object->readChale();
                }
            }
        }else{
            $array_filter = $object->readChaleFilter($_POST['local_origem_consulta'],$_POST['data_agendamento_consulta_inicio'],$_POST['data_agendamento_consulta_fim']);
        }
    }else{
        $array_filter = $object->readChale();
    }

    // var_dump($_POST['local_origem_consulta']);
    // var_dump($_POST['data_agendamento_consulta_inicio']);
    // var_dump($_POST['data_agendamento_consulta_fim']);
    //var_dump($array_filter);
    //echo $array_filter['id_local'];
    include '../components/head.php';
?>  
    <div class="mt-3 d-flex justify-content-center p-2">
        <form action="" method="POST">
        <div class="form-group ">
            <label>Campo</label>
            <select required class="form-control" type="number" name="local_origem_consulta">
                <option value="0">Selecione</option>
                <?php $array = $object->readLocal();
                
                foreach ($array as $key => $row) {
                    echo '<option value='.$row['id'].'>'.$row['local_origem'].'</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group btn">
            <label>De</label>
            <input type="date" required  class="form-control" min="<?php echo date('Y-m-d')?>"
            name="data_agendamento_consulta_inicio" 
            value="<?php 
                        if(!isset($_POST['data_agendamento_consulta_inicio'])){
                            $date = date('Y-m-d'); echo $date;
                        }else
                            echo $_POST['data_agendamento_consulta_inicio'];
                    ?>">
        </div>

        <div class="form-group btn">
            <label>Até</label>
            <input type="date" required  class="form-control" min="<?php echo date('Y-m-d')?>"
            name="data_agendamento_consulta_fim" 
            value="<?php 
                        if(!isset($_POST['data_agendamento_consulta_fim'])){
                            $date = date('Y-m-d'); echo $date;
                        }else
                            echo $_POST['data_agendamento_consulta_fim'];
                    ?>">
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
                    <th scope="col" class="text-center">Chalé</th>
                    <th scope="col" class="text-center">Data</th>
                    <th scope="col" class="text-center">Situação</th>
                </tr>
            </thead>    
            <tbody>
            <?php
            
            foreach ($array_filter as $key => $row) {
                echo '<tr>';
                echo '<th class="text-center">'. $row['local_origem'].'</th>';
                echo '<th class="text-center">'. $row['data_agendamento'].'</th>';
                echo '<th class="text-center">Agendado</th>';

            }  
                ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-center p-2">
            <form action="" method="POST">
            <div class="form-group ">
                <label>Chalé</label>
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
                <label>Data inicio</label>
                <input type="date" required  class="form-control" min="<?php echo date('Y-m-d')?>"
                name="data_agendamento" value="<?php $date = date('Y-m-d'); echo $date;?>">
            </div>

            <button type="submit" class="btn btn-primary " >
                Agendar
            </button>

            </form>
        </div>                   
<?php 
    include '../components/footer.php';
?>