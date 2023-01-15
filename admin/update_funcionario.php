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
<div class="h2 text-center mb-3 fw-bold">Alterar agendamento</div>
<div class="mt-2 p-2">
    <div class="bg-light px-4 py-2 border rounded shadow mb-3">
        <div class="mt-3 d-flex justify-content-center p-2">
            <form action="" method="POST" class="w-100">
                <div class="row">
                    <div class="form-group col-md-12 mb-3">
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">CPF</label>
                            <input type="text" disabled class="form-control" value="<?= $row['cnpj_cpf'];?>"> 
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">Nome</label>
                            <input type="text" disabled class="form-control" value="<?= $row['nome'];?>"> 
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">Ramal</label>
                            <input type="text" disabled class="form-control" value="<?= $row['ramal'];?>"> 
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">Telefone</label>
                            <input type="text" disabled class="form-control" value="<?= $row['telefone'];?>"> 
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">Negócio</label>
                            <input type="text" disabled class="form-control" value="<?= $row['negocio'];?>"> 
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">Cargo</label>
                            <input type="text" disabled class="form-control" value="<?= $row['cargo'];?>"> 
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">Situação Funcionário</label>
                            <select class="form-control" name="situacao">
                                <?= '<option value='.$row['id_situacao'].'>'.$row['situacao'].'</option>';
                                $array = $object->selectSituacaoFilter($row['id_situacao']);
                                foreach ($array as $key => $column) {
                                    echo '<option value='.$column['id'].'>'.$column['descricao'].'</option>';
                                }?>
                            </select>
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-1 fw-bold">Tipo funcionário</label>
                            <select class="form-control" name="tipo_funcionario">
                                <?= '<option value='.$row['id_tipo_funcionario'].'>'.$row['tipo_funcionario'].'</option>';
                                $array = $object->selectTipoFuncionario($row['id_tipo_funcionario']);
                                foreach ($array as $key => $column) {
                                    echo '<option value='.$column['id'].'>'.$column['descricao'].'</option>';
                                }?>
                            </select>
                        </div>
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
