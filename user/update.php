<?php
    include '../class_start/banco.class.create.php';
    $obj2 = new create;

    include 'classes/banco.class.update.php';
    $obj3 = new UserUpdate;


    include '../class_start/banco.class.login.php';
    $obj = new banco;
    session_start();
    $obj->checkLogin();
    if(isset($_GET['logout'])){
        $obj->logout();
    }
    
    $array = $obj3->readUser($_SESSION['cnpj_cpf']);
    foreach ($array as $key => $rowOrigin) {
    }

    if($_POST){
        $obj3->UpdateUser($_SESSION['cnpj_cpf'],$_POST['ramal'],$_POST['telefone'],$_POST['negocio'],$_POST['cargo']);
    }

    include '../components/head.php';

?>
<div class="h2 text-center mb-3 fw-bold">Usuário</div>

<div class="mt-2 p-2">
    <div class="bg-light px-4 py-2 border rounded shadow mb-3">
        <div class="mt-3 d-flex justify-content-center p-2">
            <form action="" method="POST" class="w-100">
                <div class="row">
                    <div class="form-group col-md-12 mb-3">
                        <label class="mb-1 fw-bold">CPF</label class="mb-1 fw-bold">
                        <input type="text" disabled class="form-control" name="cnpj_cpf"
                        value="<?php 
                                echo $rowOrigin['cnpj_cpf'];
                                ?>"
                        >
                    </div>
    
                    <div class="form-group col-md-12 mb-3">
                        <label class="mb-1 fw-bold">Nome</label class="mb-1 fw-bold">
                        <input type="text" disabled class="form-control" name="nome"
                        value="<?php 
                                echo $rowOrigin['nome'];
                                ?>"
                        >
                    </div>
    
                    <div class="form-group col-md-12 mb-3">
                        <label class="mb-1 fw-bold">Ramal</label class="mb-1 fw-bold">
                        <input type="number" required class="form-control" name="ramal" placeholder="Ramal"
                        value="<?php 
                                if(!isset($_POST['ramal'])){
                                    echo $rowOrigin['ramal'];
                                }else
                                    echo $_POST['ramal'];
                                ?>"
                        >
                    </div>
                            
                    <div class="form-group col-md-12 mb-3">
                        <label class="mb-1 fw-bold">Telefone</label class="mb-1 fw-bold">
                        <input type="number" required class="form-control" name="telefone" placeholder="Ex: 9 99999999"
                        value="<?php 
                                if(!isset($_POST['telefone'])){
                                    echo $rowOrigin['telefone'];
                                }else
                                    echo $_POST['telefone'];
                                ?>"
                        >
                    </div>
                            
                    <div class="form-group col-md-12 mb-3">
                        <label class="mb-1 fw-bold">Negócio</label class="mb-1 fw-bold">
                        <select required class="form-control" name="negocio">
                            <?php 
                            echo '<option value='.$rowOrigin['id_negocio'].'>'.$rowOrigin['desc_negocio'].'</option>';
                            
                            $array = $obj2->readNegocio();
                            foreach ($array as $key => $row) {
                                echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                        
                    <div class="form-group col-md-12 mb-3">
                        <label class="mb-1 fw-bold">Cargo</label class="mb-1 fw-bold">
                        <select required class="form-control" name="cargo">
                            <?php 
                            echo '<option value='.$rowOrigin['id_cargo'].'>'.$rowOrigin['desc_cargo'].'</option>';
                        
                            $array = $obj2->readCargo();
                            foreach ($array as $key => $row) {
                                echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                        
                    </br>
                        
                    <div class="form-actions mt-3 text-end">
                        <button type="submit" class="btn btn-success fw-bold">
                            Atualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>    
    </div>    
</div>    
<?php 
    include '../components/footer.php';
?>  