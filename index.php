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

<div class="container">
    <img src="images/afungaz.png"  width="80%">
</div>

<?php 
    include './components/footer.php';
?>