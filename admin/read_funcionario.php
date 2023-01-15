<?php
    $config = include("{$_SERVER['DOCUMENT_ROOT']}/afungaz/config.php");
    
    include 'classes/banco.class.funcionario.php';
    $object = new funcionario;

    include '../class_start/banco.class.login.php';
    $obj = new banco;
    session_start();
    $obj->checkLogin();
    $obj->checkCadastroAfungaz();

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
<div class="h2 text-center mb-3 fw-bold">Relatório de Funcionários</div>

<div class="mt-2 p-2">
    <div class="bg-light px-4 py-2 border rounded shadow mb-3">
        <div class="mt-3 d-flex justify-content-center p-2">
            <form action="" method="POST" class="w-100">
                <div class="row">
                    <div class="form-group col-xl-3 col-lg-6 mt-3">
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
                        
                    <div class="form-group col-xl-3 col-lg-6 mt-3">
                        <label class="mb-2 fw-bold">Situação Funcionário</label class="mb-2 fw-bold">
                        <select class="form-control" name="situacao">
                            <?php $array = $object->selectSituacao();
                            foreach ($array as $key => $row) {
                                echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                            }?>
                            <option value="0">Todos</option>
                        </select>
                    </div>
                        
                    <div class="form-group col-xl-3 col-lg-6 mt-3">
                        <label class="mb-2 fw-bold">Negócio</label class="mb-2 fw-bold">
                        <select class="form-control" name="negocio">
                            <option value="0">Todos</option>
                            <?php $array = $object->selectNegocio();
                            foreach ($array as $key => $row) {
                                echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                            }?>
                        </select>
                    </div>
                        
                    <div class="form-group col-xl-3 col-lg-6 mt-3">
                        <label class="mb-2 fw-bold">Cargo</label class="mb-2 fw-bold">
                        <select class="form-control" name="cargo">
                            <option value="0">Todos</option>
                            <?php $array = $object->selectCargo();
                            foreach ($array as $key => $row) {
                                echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                            }?>
                        </select>
                    </div>
                        
                    <div class="d-flex align-items-end flex-row-reverse col-xl-12 col-lg-12 mt-3">
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
                        <th scope="col" class="text-center">Nome funcionário</th>
                        <th scope="col" class="text-center">Ramal</th>
                        <th scope="col" class="text-center">Telefone</th>
                        <th scope="col" class="text-center">Situação</th>
                        <th scope="col" class="text-center">Tipo Funcionário</th>
                        <th scope="col" class="text-center">Negócio</th>
                        <th scope="col" class="text-center">Cargo</th>
                        <th scope="col" class="text-center">Ação</th>
                    </tr>
                </thead>    
                <tbody>
                <?php
                    foreach ($array_filter as $key => $row) {
                        echo '<tr>';
                        echo '<td class="align-middle text-center">'. $row['nome'].'</td>';
                        echo '<td class="align-middle text-center">'. $row['ramal'].'</td>';
                        echo '<td class="align-middle text-center">'. $row['telefone'].'</td>';
                        echo '<td class="align-middle text-center">'. $row['situacao'].'</td>';
                        echo '<td class="align-middle text-center">'. $row['tipo_funcionario'].'</td>';
                        echo '<td class="align-middle text-center">'. $row['negocio'].'</td>';
                        echo '<td class="align-middle text-center">'. $row['cargo'].'</td>';
                        echo '<td class="align-middle text-center">';
                        echo ' <a class="btn btn-warning" href="/afungaz/admin/update_funcionario.php?cnpj_cpf='.$row['cnpj_cpf'].'"><i class="bi bi-gear-fill"></i></a>';   
                        echo '</td>';
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