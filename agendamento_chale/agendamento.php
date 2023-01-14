<?php
    include 'classes/banco.class.php';
    $object = new quiosque;

    include '../class_start/banco.class.login.php';
    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    
    if(isset($_GET['logout'])){
        $obj->logout();
    }
    
    if($_POST){
        if(!isset($_POST['data_agendamento_consulta_inicio'])){
            if(!isset($_POST['local_origem'])){
                $array_filter = $object->readChale();
            }else{
                if($_POST['local_origem'] == 0){
                    echo '<script>alert("Precisa selecionar pelomenos uma quadra e um horário!");</script>';
                    $array_filter = $object->readChale();
                }else{
                    $object->Agendamento($_POST['local_origem'],$_POST['data_agendamento']); 
                    $array_filter = $object->readChale();
                }
            }
        }else{
            $array_filter = $object->readChaleFilter($_POST['local_origem_consulta'],$_POST['data_agendamento_consulta_inicio'],$_POST['data_agendamento_consulta_fim']);
        }
    }else{
        $array_filter = $object->readChale();
    }
    
    include '../components/head.php';
?>  
<div class="h2 text-center mb-3 fw-bold">Controle de Chalés</div>

<div class="mt-2 p-2">
    <div class="bg-light px-4 py-2 border rounded shadow mb-3">
        <form action="" method="POST">
            <div class="row">
                <div class="form-group col-xl-6 col-lg-6 mt-2 mb-3">
                    <label class="mb-2 fw-bold">Chalé</label>
                    <select required class="form-control" type="integer" name="local_origem">
                        <option value="0">Selecione</option>
                        <?php $array = $object->readLocal();

                        foreach ($array as $key => $row) {
                            echo '<option value=' . $row['id'] . '>' . $row['local_origem'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-xl-4 col-lg-4 mt-2 mb-3">
                    <label class="mb-2 fw-bold">Data</label>
                    <input type="date" required class="form-control" min="<?php echo date('Y-m-d') ?>" name="data_agendamento" value="<?php $date = date('Y-m-d');
                                                                                                                                        echo $date; ?>">
                </div>

                <div class="d-flex align-items-end col-xl-2 col-lg-2 mt-2 mb-3">
                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        Cadastrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="mt-2 p-2">
    <div class="bg-light px-4 py-2 border rounded shadow mb-3">
        <form action="" method="POST">
            <div class="row">
                <div class="form-group col-lg-4 mt-2 mb-3">
                    <label class="mb-2 fw-bold">Chalé</label>
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
        </form>

        <div class="d-flex align-items-center justify-content-between mt-2" id="title">
            <table class="table table-hover">
                <thead class="bg-grey text-dark">
                    <tr>
                        <th scope="col" class="text-center">Número chalés</th>
                        <th scope="col" class="text-center">Data</th>
                        <th scope="col" class="text-center">Situação</th>
                        <!--<th scope="col" class="text-center">Ação</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (empty($array_filter)) {
                            echo '<tr class="bg-white">';
                            echo    '<td class="text-center align-middle" colspan=3>Nenhum registro encontrado.</td>';
                            echo '</tr>';
                        }

                        foreach ($array_filter as $key => $row) {
                            echo '<tr class="bg-white">';
                            echo    '<td class="text-center align-middle">' . $row['local_origem'] . '</td>';
                            echo    '<td class="text-center align-middle">' . $row['data_agendamento'] . '</td>';
                            echo    '<td class="text-center align-middle">Agendado</td>';
                            /*echo    '<td class="text-center align-middle">
                                       <button class="btn btn-danger">
                                           <i class="bi bi-trash-fill"></i>
                                       </button>
                                    </td>';*/
                            echo '</tr>';
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