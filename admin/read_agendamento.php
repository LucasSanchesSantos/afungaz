<?php
    $config = include("{$_SERVER['DOCUMENT_ROOT']}/afungaz/config.php");

    include 'classes/banco.class.agendamento.php';
    $object = new agendamento;

    include '../class_start/banco.class.login.php';
    $obj = new banco;
    session_start();
    $obj->checkLogin();
    if(isset($_GET['logout'])){
        $obj->logout();
    }

    if($_SESSION['id_tipo_funcionario'] <> 2){
        header('location:'.$config['URL']);
    }

    $array_filter = $object->readAgendamento();
    if($_POST){
        if(!isset($_POST['data_agendamento_consulta_inicio'])){
            if(!isset($_POST['id_cancel'])){}
            else{
                $object->cancelaAgendamento($_POST['id_cancel'],$_SESSION['cnpj_cpf']);
            }
        }else{
            $array_filter = $object->readAgendamentoFilter($_POST['local_origem_consulta']
                                                           ,$_POST['usuario']
                                                           ,$_POST['data_agendamento_consulta_inicio']
                                                           ,$_POST['data_agendamento_consulta_fim']
                                                           ,$_POST['hora']
                                                           ,$_POST['situacao']
                                                           );
        }
    }
    include '../components/head.php';
?>
<link rel="stylesheet" type="text/css" href="<?= $config['URL'] ?>/css/head.css">
    <div class="mt-3 d-flex justify-content-center p-2">
        <form action="" method="POST">
        <div class="form-group ">
            <label>Campo</label>
            <select required class="form-control" type="number" name="local_origem_consulta">
                <option value="0">Selecione</option>
                <?php $array = $object->selectLocal();
                
                foreach ($array as $key => $row) {
                    echo '<option value='.$row['id'].'>'.$row['local_origem'].'</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group ">
            <label>Funcionário</label>
            <select required class="form-control" name="usuario">
                <option value="0">Selecione</option>
                <?php $array = $object->selectUser();
                
                foreach ($array as $key => $row) {
                    echo '<option value='.$row['cnpj_cpf'].'>'.$row['nome'].'</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group btn">
            <label>De</label>
            <input type="date" class="form-control" name="data_agendamento_consulta_inicio" 
            value="<?php 
                        if(!isset($_POST['data_agendamento_consulta_inicio'])){
                            $date = date('Y-m-d'); echo $date;
                        }else
                            echo $_POST['data_agendamento_consulta_inicio'];
                    ?>">
        </div>

        <div class="form-group btn">
            <label>Até</label>
            <input type="date" class="form-control" name="data_agendamento_consulta_fim" 
            value="<?php 
                        if(!isset($_POST['data_agendamento_consulta_fim'])){
                            $date = date('Y-m-d'); echo $date;
                        }else
                            echo $_POST['data_agendamento_consulta_fim'];
                    ?>">
        </div>

        <div class="form-group btn">
            <label>Hora</label>
            <select class="form-control" name="hora">
                <?php if(!isset($_POST['hora']) or $_POST['hora'] == 0){
                    echo '<option value="0">Selecione</option>';
                }else{
                    echo '<option value='.$_POST['hora'].'>'.$_POST['hora'].":00".'</option>';
                } ?>
                <?php
                    for($i=10; $i <= 22; $i++){
                        echo '<option value='.$i.'>'.$i.":00".'</option>';
                    }   
                ?>
                <option value="0">Todos</option>
            </select>
        </div>
        <div class="form-group btn">
            <label>Situação Agendamento</label>
            <select class="form-control" name="situacao">
                <?php $array = $object->selectSituacao();
                foreach ($array as $key => $row) {
                    echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                }?>
                <option value="0">Todos</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
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
                    <th scope="col" class="text-center">Nome</th>
                    <th scope="col" class="text-center">Negócio</th>
                    <th scope="col" class="text-center">Situação</th>
                    <th scope="col" class="text-center">Cancelar Agendamento</th>
                </tr>
            </thead>    
            <tbody>
            <?php
                foreach ($array_filter as $key => $row) {
                    echo '<tr>';
                    echo '<th class="text-center">'. $row['local_origem'].'</th>';
                    echo '<th class="text-center">'. $row['data_agendamento'].'</th>';
                    echo '<th class="text-center">'. $row['hora'].'</th>';
                    echo '<th class="text-center">'. $row['nome'].'</th>';
                    echo '<th class="text-center">'. $row['negocio'].'</th>';
                    echo '<th class="text-center">'. $row['situacao'].'</th>';
                    echo '<td width=200>';
                    if($row['id_situacao'] <> 3){
                    echo '<form action="" method="POST" class="text-center">';       
                    echo '<button type="submit" name="id_cancel" class="btn btn-danger" value="'.$row['id'].'"><i class="bi bi-trash3-fill"></i></button>';    
                    echo '</form>';
                    echo '</td>';
                    }
                }
            ?>
            </tbody>
        </table>              
    </div>
<?php 
    include '../components/footer.php';
?> 