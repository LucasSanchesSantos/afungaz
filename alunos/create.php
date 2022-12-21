<?php 
include 'classes/banco.class.php';
$obj = new banco;
session_start();

if($_POST){
    $array = $obj->createAluno2('lucas.santos@gazin.com.br');        
        foreach ($array as $key => $value) {
            $value;
        }   

    if($value['email'] == $_POST['email'] or $value['cpf'] == $_POST['cpf']){
        echo '<script>alert("CPF ou email já cadastrado! Tente efetuar o login, ou contate alguém da comissão.");
        window.location.href="/contador_de_dedinhos/login.php";</script>';
    }else{
        $obj->createAluno($_POST['cpf'],$_POST['nome'],$_POST['telefone'],$_POST['instituicao'],$_POST['endereco'],$_POST['rg'],$_POST['email'],$_POST['senha'],$_POST['dias_semana']);
    }
}

?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/contador_de_dedinhos/css/style.css">


    <header class="d-flex">
        <div class="container d-flex align-items-center justify-content-between">
            <h1>Cadastro</h1>
            <div class="welcome">
                <a href="/contador_de_dedinhos/index.php" class="text-white">Voltar</a>
            </div>
        </div>
        
    </header>
    
<body>
<div class="mt-3 d-flex justify-content-center p-2">
    <form action="" method="POST">
        <div class="form-group">
        <label>Nome</label>
            <input type="nome"  required  class="form-control"
            name="nome" placeholder="Ex: Fulano da Silva" 
            value="<?php echo !empty($email)? $email : ''; ?>">
            
            <?php if(!empty($emailErro)): ?>
                <span class="text-danger">
                    <?php echo  $emailErro; ?>
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
                    <?php echo  $emailErro; ?>
                </span>
            <?php endif; ?> 
        </div>

        <div class="form-group">
            <label>Telefone</label>
            <input type="text" minlength="9" required class="form-control"
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
        <select required class="form-control" type="text" name="instituicao" value="<?php echo !empty($instituicao)? $instituicao : ''; ?>">
            <option value="0">Selecione</option>
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
                <option value="0">Selecione</option>
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
            <input type="text" maxlength="11" minlength="11" required  class="form-control"
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
            <input type="text" maxlength="9" minlength="9" required  class="form-control"
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

        
        <div class="form-actions p-2">
            <button type="submit" class="btn btn-success">
                Cadastrar
            </button>
            <a href="/contador_de_dedinhos/login.php">
                Já é cadastrado? Clique para logar!
            </a>
        </div>
        
    </form>
         
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</div>

</body>