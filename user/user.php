<?php
    include 'classes/banco.class.php';
    $object = new user;

    include '../class_start/banco.class.login.php';
    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    
    if(isset($_GET['logout'])){
        $obj->logout();
    }
    
    if($_POST){
        if(!isset($_POST['data_agendamento_consulta_inicio'])){
            if(!isset($_POST['cancel'])){
                $array_filter = $object->readUser();
            }else{
                $object->updateCancel($_POST['cancel'],$_SESSION['cnpj_cpf']);
            }
        }else{
            $array_filter = $object->readUserFilter($_POST['local_origem_consulta'],$_POST['data_agendamento_consulta_inicio'],$_POST['data_agendamento_consulta_fim']);
        }
    }else{
        $array_filter = $object->readUser();
    }

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
                    <th scope="col" class="text-center">Local Agenda</th>
                    <th scope="col" class="text-center">Data</th>
                    <th scope="col" class="text-center">Hora</th>
                    <th scope="col" class="text-center">Situação</th>
                    <th scope="col" class="text-center">Cancelar</th>
                </tr>
            </thead>    
            <tbody>
            <?php

                foreach ($array_filter as $key => $row) {
                    echo '<tr>';
                    echo '<th class="text-center">'. $row['local_origem'].'</th>';
                    echo '<th class="text-center">'. $row['data_agendamento'].'</th>';
                    echo '<th class="text-center">'. $row['hora'].'</th>';
                    echo '<th class="text-center">Agendado</th>';
                    echo '<td width=250>';
                    echo '<form action="" method="POST">';       
                    echo '<input type="submit" id=cancel name="cancel" class="btn bg-transparent" style="width:100;height:100" value="'.$row['id'].'"'."teste".' </input>';     
                    echo '</form>';
                    echo '</td>';
                }
              
            ?>

            </tbody>
        </table>              

    </div>
<?php 
    include '../components/footer.php';
?> 