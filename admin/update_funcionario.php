<?php
    $config = include("{$_SERVER['DOCUMENT_ROOT']}/afungaz/config.php");

    include 'classes/banco.class.funcionario.php';
    $object = new funcionario;

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

    $funcionario = $object->readFuncionarioFilter($_GET['cnpj_cpf'],0,0,0);
    foreach ($funcionario as $key => $row) {}

    include '../components/head.php';

    if($_POST){
        $object->updateFuncionario($_GET['cnpj_cpf'],$_POST['situacao'],$_POST['tipo_funcionario']);
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
        <div class="form-group">
            <label>Ramal</label>
            <input type="text" disabled class="form-control" value="<?= $row['ramal'];?>"> 
        </div>
        <div class="form-group">
            <label>Telefone</label>
            <input type="text" disabled class="form-control" value="<?= $row['telefone'];?>"> 
        </div>
        <div class="form-group">
            <label>Negócio</label>
            <input type="text" disabled class="form-control" value="<?= $row['negocio'];?>"> 
        </div><div class="form-group">
            <label>Cargo</label>
            <input type="text" disabled class="form-control" value="<?= $row['cargo'];?>"> 
        </div>
        <div class="form-group btn">
            <label>Situação Funcionário</label>
            <select class="form-control" name="situacao">
                <?= '<option value='.$row['id_situacao'].'>'.$row['situacao'].'</option>';
                $array = $object->selectSituacaoFilter($row['id_situacao']);
                foreach ($array as $key => $column) {
                    echo '<option value='.$column['id'].'>'.$column['descricao'].'</option>';
                }?>
            </select>
        </div>
        <div class="form-group btn">
            <label>Tipo funcionário</label>
            <select class="form-control" name="tipo_funcionario">
                <?= '<option value='.$row['id_tipo_funcionario'].'>'.$row['tipo_funcionario'].'</option>';
                $array = $object->selectTipoFuncionario($row['id_tipo_funcionario']);
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
