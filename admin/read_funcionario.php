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

    $array_filter = $object->readFuncionario();
    
    if($_POST){
        $array_filter = $object->readFuncionarioFilter($_POST['usuario'],$_POST['situacao'],$_POST['negocio'],$_POST['cargo']);
    }

    include '../components/head.php';
?>
    <div class="mt-3 d-flex justify-content-center p-2">
        <form action="" method="POST">
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
            <label>Situação Funcionário</label>
            <select class="form-control" name="situacao">
                <?php $array = $object->selectSituacao();
                foreach ($array as $key => $row) {
                    echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                }?>
                <option value="0">Todos</option>
            </select>
        </div>

        <div class="form-group btn">
            <label>Negócio</label>
            <select class="form-control" name="negocio">
                <option value="0">Todos</option>
                <?php $array = $object->selectNegocio();
                foreach ($array as $key => $row) {
                    echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                }?>
            </select>
        </div>

        <div class="form-group btn">
            <label>Cargo</label>
            <select class="form-control" name="cargo">
                <option value="0">Todos</option>
                <?php $array = $object->selectCargo();
                foreach ($array as $key => $row) {
                    echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                }?>
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
                    <th scope="col" class="text-center">Nome funcionário</th>
                    <th scope="col" class="text-center">Ramal</th>
                    <th scope="col" class="text-center">Telefone</th>
                    <th scope="col" class="text-center">Situação</th>
                    <th scope="col" class="text-center">Negócio</th>
                    <th scope="col" class="text-center">Cargo</th>
                    <th scope="col" class="text-center">Editar</th>
                </tr>
            </thead>    
            <tbody>
            <?php
                foreach ($array_filter as $key => $row) {
                    echo '<tr>';
                    echo '<th class="text-center">'. $row['nome'].'</th>';
                    echo '<th class="text-center">'. $row['ramal'].'</th>';
                    echo '<th class="text-center">'. $row['telefone'].'</th>';
                    echo '<th class="text-center">'. $row['situacao'].'</th>';
                    echo '<th class="text-center">'. $row['negocio'].'</th>';
                    echo '<th class="text-center">'. $row['cargo'].'</th>';
                    echo '<td width=90>';
                    echo ' <a class="btn btn-warning" href="/afungaz/admin/update_funcionario.php?cnpj_cpf='.$row['cnpj_cpf'].'">Editar</a>';             
                }
            ?>
            </tbody>
        </table>              
    </div>
<?php 
    include '../components/footer.php';
?> 