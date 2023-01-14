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
<div class="h2 text-center mb-3 fw-bold">Relatório de Agendamentos</div>

<div class="mt-2 p-2">
    <div class="bg-light px-4 py-2 border rounded shadow mb-3">
        <div class="mt-3 d-flex justify-content-center p-2">
            <form action="" method="POST" class="w-100">
                <div class="row">
                    <div class="form-group col-xl-2 col-lg-3 col-md-6 mt-3">
                        <label class="mb-2 fw-bold">Local</label class="mb-2 fw-bold">
                        <select required class="form-control" type="number" name="local_origem_consulta">
                            <option value="0">Selecione</option>
                            <?php $array = $object->selectLocal();

                            foreach ($array as $key => $row) {
                                echo '<option value='.$row['id'].'>'.$row['local_origem'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                        
                    <div class="form-group col-xl-2 col-lg-3 col-md-6 mt-3">
                        <label class="mb-2 fw-bold">Funcionário</label class="mb-2 fw-bold">
                        <select required class="form-control" name="usuario">
                            <option value="0">Selecione</option>
                            <?php $array = $object->selectUser();

                            foreach ($array as $key => $row) {
                                echo '<option value='.$row['cnpj_cpf'].'>'.$row['nome'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                        
                    <div class="form-group col-xl-2 col-lg-3 col-md-6 mt-3">
                        <label class="mb-2 fw-bold">De</label class="mb-2 fw-bold">
                        <input type="date" class="form-control" name="data_agendamento_consulta_inicio" 
                        value="<?php 
                                    if(!isset($_POST['data_agendamento_consulta_inicio'])){
                                        $date = date('Y-m-d'); echo $date;
                                    }else
                                        echo $_POST['data_agendamento_consulta_inicio'];
                                ?>">
                    </div>
                                
                    <div class="form-group col-xl-2 col-lg-3 col-md-6 mt-3">
                        <label class="mb-2 fw-bold">Até</label class="mb-2 fw-bold">
                        <input type="date" class="form-control" name="data_agendamento_consulta_fim" 
                        value="<?php 
                                    if(!isset($_POST['data_agendamento_consulta_fim'])){
                                        $date = date('Y-m-d'); echo $date;
                                    }else
                                        echo $_POST['data_agendamento_consulta_fim'];
                                ?>">
                    </div>
                                
                    <div class="form-group col-xl-2 col-lg-3 col-md-6 mt-3">
                        <label class="mb-2 fw-bold">Hora</label class="mb-2 fw-bold">
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
                    <div class="form-group col-xl-2 col-lg-3 col-md-6 mt-3">
                        <label class="mb-2 fw-bold">Situação</label class="mb-2 fw-bold">
                        <select class="form-control" name="situacao">
                            <?php $array = $object->selectSituacao();
                            foreach ($array as $key => $row) {
                                echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                            }?>
                            <option value="0">Todos</option>
                        </select>
                    </div>
                        
                    <div class="d-flex align-items-end flex-row-reverse col-xl-12 col-lg-6 col-md-12 mt-3">
                        <button type="submit" class="btn btn-dark-blue fw-bold">
                            Consultar
                        </button>
                    </div>
                </div>
            </form>
        </div>    

        <div class="d-flex align-items-center justify-content-between mt-2" id="title"> 
            <table class="table table-hover">
                <thead class="bg-grey text-dark">
                    <tr>
                        <th scope="col" class="text-center">Local Agenda</th>
                        <th scope="col" class="text-center">Data</th>
                        <th scope="col" class="text-center">Hora</th>
                        <th scope="col" class="text-center">Nome</th>
                        <th scope="col" class="text-center">Negócio</th>
                        <th scope="col" class="text-center">Situação</th>
                        <th scope="col" class="text-center">Ação</th>
                    </tr>
                </thead>    
                <tbody>
                <?php
                    foreach ($array_filter as $key => $row) {
                        echo '<tr>';
                        echo '<td class="text-center">'. $row['local_origem'].'</td>';
                        echo '<td class="text-center">'. $row['data_agendamento'].'</td>';
                        echo '<td class="text-center">'. $row['hora'].'</td>';
                        echo '<td class="text-center">'. $row['nome'].'</td>';
                        echo '<td class="text-center">'. $row['negocio'].'</td>';
                        echo '<td class="text-center">'. $row['situacao'].'</td>';
                        if($row['id_situacao'] <> 3){    
                        echo '<td class="text-center align-middle">
                                <form action="" method="POST" class="text-center">
                                    <button type="submit" class="btn btn-danger" name="cancel" value="' . $row['id'] . '"">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                             </td>';                           
                        }
                    }
                ?>
                </tbody>
            </table>              
        </div>
    </div>
</div>
<?php 
    include '../components/footer.php';
?> 