<?php
 
    if($_POST){
        $obj->delete('alunos',$_GET['id']);
    }
?>
<section class="d-flex justify-content-center p-2">
        <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="alert alert-danger">
            Deseja realmente excluir esse contato?
        </div>
        <div class="form-actions">
                <button type="submit"  class="btn btn-success">
                    Sim
                </button>
                <a href="/contador_de_dedinhos/index.php?dir=alunos&file=read" class="btn btn-light">Não</a>
        </div>
        </form>
</section>