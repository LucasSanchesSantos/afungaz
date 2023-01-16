<?php
    include 'class_start/banco.class.create.php';
    $object = new create;

    include 'class_start/banco.class.login.php';
    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    
    if(isset($_GET['logout'])){
        $obj->logout();
    }

    if($_POST){
        $object->firstRegister($_SESSION['cnpj_cpf'],$_POST['ramal'],$_POST['telefone'],$_POST['negocio'],$_POST['cargo']);
    }

    include './components/head.php';
    
?>
<div class="h2 text-center mb-3 fw-bold">Cadastro Afungaz</div>

<div class="mt-2 p-2">
    <div class="bg-light px-4 py-2 border rounded shadow mb-3">
        <div class="mt-3 d-flex justify-content-center p-2">
            <form action="" method="POST" class="w-100">
                <div class="row">
                    <div class="form-group col-md-12 mb-3">
                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-2 fw-bold">CPF</label>
                            <input type="text" disabled class="form-control" name="cnpj_cpf"
                            value="<?php 
                                    echo $_SESSION['cnpj_cpf'];
                                    ?>"
                            >
                        </div>

                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-2 fw-bold">Nome</label>
                            <input type="text" disabled class="form-control" name="nome"
                            value="<?php 
                                    echo $_SESSION['nome'];
                                    ?>"
                            >
                        </div>

                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-2 fw-bold">Ramal</label>
                            <input type="number" maxlength="4" required class="form-control" maxlength="4" name="ramal" placeholder="Ramal"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                            value="<?php 
                                    if(!isset($_POST['ramal'])){
                                    }else
                                        echo $_POST['ramal'];
                                    ?>"
                            >
                        </div>

                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-2 fw-bold">Telefone</label>
                            <input type="number" maxlength="11" required class="form-control" name="telefone" id=telefone placeholder="Ex: 9 99999999"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                            value="<?php 
                                    if(!isset($_POST['telefone'])){
                                    }else
                                        echo $_POST['telefone'];
                                    ?>"
                            >
                        </div>

                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-2 fw-bold">Negócio</label>
                            <select required class="form-control" name="negocio">
                                <option value="0">Selecione</option>
                                <?php $array = $object->readNegocio();
                                
                                foreach ($array as $key => $row) {
                                    echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-12 mb-3">
                            <label class="mb-2 fw-bold">Cargo</label>
                            <select required class="form-control" name="cargo">
                                <option value="0">Selecione</option>
                                <?php $array = $object->readCargo();
                                
                                foreach ($array as $key => $row) {
                                    echo '<option value='.$row['id'].'>'.$row['descricao'].'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        </br>

                        <div class="d-flex align-items-end flex-row-reverse col-xl-12 col-lg-6 col-md-12 mt-3">
                            <button type="submit" class="btn btn-success">
                                Cadastrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

            



</body>

</html>     



<?php
    include './components/footer.php';
?>
    