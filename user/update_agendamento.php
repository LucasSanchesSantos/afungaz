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

    $current_agendamento = $object->readForUpdate($_GET['id']);
    foreach ($current_agendamento as $key => $row) {}

    include '../components/head.php';

    if($_POST){
        $object->updateAgendamento($_GET['id'],$_POST['id_local'],$_POST['data_agendamento'],$_POST['hora']);
    }

?>

<body>
<div class="h2 text-center mb-3 fw-bold">Alterar agendamento</div>
<div class="mt-2 p-2">
    <div class="bg-light px-4 py-2 border rounded shadow mb-3">
        <div class="mt-3 d-flex justify-content-center p-2">
            <form action="" method="POST" class="w-100">
                <div class="row">
                    <div class="form-group col-md-12 mb-3">
                        <label class="mb-1 fw-bold">CPF</label>
                            <input type="text" disabled class="form-control" value="<?= $row['cnpj_cpf'];?>"> 
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">Nome</label>
                            <input type="text" disabled class="form-control" value="<?= $row['nome'];?>"> 
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label>Data agendamento</label>
                            <input type="date" class="form-control" name="data_agendamento" value="<?= $row['data_agendamento'];?>"  min="<?php echo date('Y-m-d') ?>"> 

                        </div>

                        <div class="form-group col-md-12 mb-3">
                        <label class="mb-1 fw-bold">Local</label>
                        <select class="form-control" type="numeric" name="id_local">
                                <?= '<option value='.$row['id_local'].'>'.$row['local_origem'].'</option>';
                                $current_array_local = $object->current_local($row['id_local'],$_GET['id_tipo_local']);
                                foreach ($current_array_local as $key => $column_local) {
                                    echo '<option value='.$column_local['id'].'>'.$column_local['local_origem'].'</option>';
                                }?>
                            </select>
                        </div>

                        <?php if($row['id_tipo_local'] == 3) {?>
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">Hora</label>
                            <select class="form-control" name="hora">
                            <?= '<option value='.$row['hora'].'>'.$row['hora'].':00</option>';
                                $current_array_hora = $object->hora();
                                foreach ($current_array_hora as $key => $column_hora) {
                                    echo '<option value='.$column_hora['hora'].'>'.$column_hora['hora'].':00</option>';
                                }?>
                            </select>
                        </div>
                        <?php }?>
                    
                        <div class="form-actions mt-3 text-end">
                            <button type="submit" class="btn btn-success fw-bold">
                                Atualizar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>    
    </div>   
</div>
