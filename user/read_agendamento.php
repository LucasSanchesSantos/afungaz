<?php
    include 'classes/banco.class.agendamento.php';
    $object = new agendamento;

    include '../class_start/banco.class.login.php';
    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    $obj->checkCadastroAfungaz();
    
    if(isset($_GET['logout'])){
        $obj->logout();
    }

    if($_POST){
        if(!isset($_POST['cancel'])){
            if(!isset($_POST['data_agendamento_consulta_inicio'])){
                $array_filter = $object->readUser();
            }else{
                $array_filter = $object->readUserFilter($_POST['local_origem_consulta'],$_POST['data_agendamento_consulta_inicio'],$_POST['data_agendamento_consulta_fim']);
            }
        }else{
            $object->updateCancel($_POST['cancel'],$_SESSION['cnpj_cpf']);
            $array_filter = $object->readUser();
        }
    }else{
        $array_filter = $object->readUser();
    }

    include '../components/head.php';

?>
<div class="h2 text-center mb-3 fw-bold">Agendamentos</div>

<div class="mt-2 p-2">
    <div class="bg-light px-4 py-2 border rounded shadow mb-3">
        <form action="" method="POST">
            <div class="row">
                <div class="form-group col-lg-4 mt-2 mb-3">
                    <label class="mb-2 fw-bold">Local</label>
                    <select class="form-control" type="number" name="local_origem_consulta">
                        <option value="0">Selecione</option>
                        <?php 
                            $array = $object->readLocal();

                            foreach ($array as $key => $row) {
                                echo '<option value=' . $row['id'] . '>' . $row['local_origem'] . '</option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group col-lg-3 mt-2 mb-3">
                    <label class="mb-2 fw-bold">De</label>
                    <input type="date" class="form-control" min="<?php echo date('Y-m-d') ?>" name="data_agendamento_consulta_inicio" value="<?php
                                                                                                                                            if (!isset($_POST['data_agendamento_consulta_inicio'])) {
                                                                                                                                                $date = date('Y-m-d');
                                                                                                                                                echo $date;
                                                                                                                                            } else
                                                                                                                                                echo $_POST['data_agendamento_consulta_inicio'];
                                                                                                                                            ?>">
                </div>

                <div class="form-group col-lg-3 mt-2 mb-3">
                    <label class="mb-2 fw-bold">Até</label>
                    <input type="date" class="form-control" min="<?php echo date('Y-m-d') ?>" name="data_agendamento_consulta_fim" value="<?php
                                                                                                                                            if (!isset($_POST['data_agendamento_consulta_fim'])) {
                                                                                                                                                $date = date('Y-m-d');
                                                                                                                                                echo $date;
                                                                                                                                            } else
                                                                                                                                                echo $_POST['data_agendamento_consulta_fim'];
                                                                                                                                            ?>">
                </div>

                <div class="col-lg-2 d-flex align-items-end mt-2 mb-3">
                    <button type="submit" class="btn btn-dark-blue w-100 fw-bold">
                        Consultar
                    </button>
                </div>
            </div>                                                                                                                               

            <div class="d-flex align-items-center justify-content-between mt-2" id="title">
                <table class="table table-hover">
                    <thead class="bg-grey text-dark">
                        <tr>
                            <th scope="col" class="text-center">Local</th>
                            <th scope="col" class="text-center">Data</th>
                            <th scope="col" class="text-center">Hora</th>
                            <th scope="col" class="text-center">Situação</th>
                            <th scope="col" class="text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (empty($array_filter)) {
                                echo '<tr class="bg-white">';
                                echo    '<td class="text-center align-middle" colspan=5>Nenhum registro encontrado.</td>';
                                echo '</tr>';
                            }

                            foreach ($array_filter as $key => $row) {
                                echo '<tr class="bg-white">';
                                echo    '<td class="text-center align-middle">' . $row['local_origem'] . '</td>';
                                echo    '<td class="text-center align-middle">' . $row['data_agendamento'] . '</td>';
                                echo    '<td class="text-center align-middle">' . $row['hora'] . '</td>';
                                echo    '<td class="text-center align-middle">Agendado</td>';
                                echo    '<td class="text-center align-middle">
                                            <a class="btn btn-warning" href="/afungaz/user/update_agendamento.php?id='.$row['id'].'&id_tipo_local='.$row['id_tipo_local'].'"><i class="bi bi-gear-fill"></i></a> 
                                           <button type="submit" class="btn btn-danger" name="cancel" value="' . $row['id'] . '"">
                                               <i class="bi bi-trash-fill"></i>
                                           </button>
                                        </td>';            
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>    

   <!-- echo '<a class="btn btn-warning" href="/afungaz/user/update_agendamento.php?id='.$row['id'].'">Editar</a>';              -->



</div>
<?php 
    include '../components/footer.php';
?> 