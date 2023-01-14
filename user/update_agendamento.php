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
        $object->updateAgendamento($_GET['id'],$_POST['data_agendamento'],$_POST['id_local'],$_POST['hora']);
    }

?>

<body>
<div class="d-flex justify-content-center">
    <form action="" method="POST">
        <div class="form-group">
            <label>CPF</label>
            <input type="text" disabled class="form-control" value="<?= $row['cnpj_cpf'];?>"> 
        </div>
        <div class="form-group">
            <label>Nome</label>
            <input type="text" disabled class="form-control" value="<?= $row['nome'];?>"> 
        </div>
        <div class="form-group btn">
            <label>Data agendamento</label>
            <select class="form-control" name="data_agendamento">
                <?= '<option value='.$row['id_situacao'].'>'.$row['situacao'].'</option>';
                $array = $object->selectSituacaoFilter($row['id_situacao']);
                foreach ($array as $key => $column) {
                    echo '<option value='.$column['id'].'>'.$column['descricao'].'</option>';
                }?>
            </select>
        </div>


        <div class="form-group btn">
            <label>Local</label>
            <select class="form-control" name="id_local">
                <?= '<option value='.$row['id_situacao'].'>'.$row['situacao'].'</option>';
                $array = $object->selectSituacaoFilter($row['id_situacao']);
                foreach ($array as $key => $column) {
                    echo '<option value='.$column['id'].'>'.$column['descricao'].'</option>';
                }?>
            </select>
        </div>


      
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">
                Efetuar alterações
            </button>
        </div>
    </form>
</div>
