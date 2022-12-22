<?php
include 'classes/banco.class.php';
$obj = new banco;
session_start();
    
$read = $obj->readName("alunos", $_SESSION['cpf']);

//enviando tabela e id como paremetro para read

 if($_POST){
    $obj->update($_SESSION['id'],$_POST['cpf'],$_POST['nome'],$_POST['telefone']
    ,$_POST['id_instituicao'],$_POST['endereco'],$_POST['rg'],$_POST['email']
    ,$_POST['senha'],$_POST['dias_semana'],$_SESSION['id_tipo_usuario']);
 }


foreach ($read as $key => $read) {
$id = $read['id'];
$nome = $read['nome'];
$email = $read['email'];
$endereco = $read['endereco'];
$telefone = $read['telefone'];
$cpf = $read['cpf'];
$instituicao = $read['id_instituicao'];
$dias_semana = $read['dias_semana'];
$senha = $read['senha'];
$rg = $read['rg'];
$nome_instituicao = $read['nome_instituicao'];

}
?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/contador_de_dedinhos/css/style.css">

    <title>Painel Administrativo</title>
</head>

<body>
    <header class="d-flex">
        <div class="container d-flex align-items-center justify-content-between">
            <h1>Manutenção de cadastro</h1>
        </div>
        
    </header>

    <div class="d-flex justify-content-center">
        <div class="row w-50 ">
            <form action="" method="POST">
                
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text"  required maxlength="11" minlength="11" class="form-control"
                    name="cpf" placeholder="Ex: 07884784588" 
                    value="<?php echo !empty($cpf)? $cpf : ''; ?>">

                    <?php if(!empty($cpfErro)): ?>
                        <span class="text-danger">
                            <?php echo  $cpfErro; ?>
                        </span>
                    <?php endif; ?> 
                </div>

                <div class="form-actions ">
                    <button type="submit" class="btn btn-success">
                        Cadastrar
                    </button>
                    <a href="/contador_de_dedinhos/index.php">
                        <button type="button" class="btn btn-secondary">Voltar</button>
                    </a>   
                </div>
            </form>
        </div>
    </div>
</body>
