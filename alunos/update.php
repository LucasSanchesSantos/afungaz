<?php
include 'classes/banco.class.php';
$obj = new banco;
session_start();
    
$read = $obj->readName("alunos", $_SESSION['id']);

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
                <div class="form-group ">
                    <label>Nome</label>
                    <input type="text" required class="form-control"
                    name="nome" placeholder="Nome completo"
                    value="<?php echo !empty($nome)? $nome : ''; ?>"> 
                    <?php if(!empty($nomeErro)): ?>
                        <span class="text-danger">
                            <?php echo  $nomeErro; ?>
                        </span>
                    <?php endif; ?> 
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email"  required  class="form-control"
                    name="email" placeholder="Ex: fulano@email.com" 
                    value="<?php echo !empty($email)? $email : ''; ?>">
                    <?php if(!empty($emailErro)): ?>
                        <span class="text-danger">
                            <?php echo  $$emailErro; ?>
                        </span>
                    <?php endif; ?> 
                </div>

                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" required class="form-control"
                    name="telefone" placeholder="Ex: 449998728973"
                    value="<?php echo !empty($telefone)? $telefone : ''; ?>"> 
                    <?php if(!empty($telefoneErro)): ?>
                        <span class="text-danger">
                            <?php echo  $telefoneErro; ?>
                        </span>
                    <?php endif; ?> 
                </div>

                <div class="form-group">
                    <label>Endereço</label>
                    <input type="text"  required  class="form-control"
                    name="endereco" placeholder="Ex: Rua são paulo, N°80, Centro" 
                    value="<?php echo !empty($endereco)? $endereco : ''; ?>">

                    <?php if(!empty($enderecoErro)): ?>
                        <span class="text-danger">
                            <?php echo  $enderecoErro; ?>
                        </span>
                    <?php endif; ?> 
                </div>

                <div class="form-group">
                <label>Selecione a sua instituição de ensino.</label>
                <select required class="form-control" type="text" name="id_instituicao" value="<?php echo !empty($pass)? $pass : ''; ?>">
                    <option value=<?php echo $instituicao?>><?php echo $nome_instituicao?></option>
                    <?php $array = $obj->read('instituicao');
                    
                    foreach ($array as $key => $row) {
                        echo '<option value='.$row['id'].'>'.$row['nome'].'</option>';
                    }
                    ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Quantidade de dias que você utilizará o transporte.</label>
                    <select required class="form-control" type="int" name="dias_semana" value="<?php echo !empty($dias_semana)? $dias_semana : ''; ?>">
                    <option value="<?php echo $read['dias_semana']?>"><?php echo $read['dias_semana']?></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    </select>
                </div>

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

                <div class="form-group">
                    <label>RG</label>
                    <input type="text"  required maxlength="9" minlength="9" class="form-control"
                    name="rg" placeholder="Ex: 999999999" 
                    value="<?php echo !empty($rg)? $rg : ''; ?>">

                    <?php if(!empty($rgErro)): ?>
                        <span class="text-danger">
                            <?php echo  $rgErro; ?>
                        </span>
                    <?php endif; ?> 
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" required  class="form-control"
                    name="senha" placeholder="Crie uma senha para acessar a plataforma."
                    value="<?php echo !empty($senha)? $senha : ''; ?>">
                    <?php if(!empty($senhaErro)): ?>
                        <span class="text-danger">
                            <?php echo  $senhaErro; ?>
                        </span>
                    <?php endif; ?> 
                </div>
                </br>
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
