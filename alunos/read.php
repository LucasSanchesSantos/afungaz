<?php

?>

<head>
<section class="container p-2">
<table class="table table-striped">
    <a href="index.php">
        <button type="button" class="btn btn-secondary">Voltar</button>
    </a>
    <thead>
        
        <tr>
            <th scope="col">id</th>
            <th scope="col">Nome</th>
            <th scope="col">CPF</th>
            <th scope="col">Instituição</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $array = $obj->read('alunos');
    foreach ($array as $key => $row) {
        echo '<tr>';
        echo '<th>'. $row['id'].'</th>';
        echo '<td>'. $row['nome'].'</td>';
        echo '<td>'. $row['cpf'].'</td>';
        echo '<td>'. $row['id_instituicao'].'</td>';
        echo '<td width=250>';
        echo ' <a class="btn btn-warning" href="?dir=alunos&file=update_admin&id='.$row['id'].'">Editar</a>';
        echo ' <a class="btn btn-danger"  href="?dir=alunos&file=delete&id='.$row['id'].'">Apagar</a>';
        echo '</td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>



    </tbody>

</table>