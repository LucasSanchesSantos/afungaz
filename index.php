<?php
    include 'class_start/banco.class.login.php';

    $obj = new banco;
    session_start();
    
    $obj->checkLogin();
    $obj->checkCadastroAfungaz();
    
    if(isset($_GET['logout'])){
        $obj->logout();
    }

    include './components/head.php';
?>

<h2 class="text-center">Sistema do BOI</h2>

<?php 
    include './components/footer.php';
?>