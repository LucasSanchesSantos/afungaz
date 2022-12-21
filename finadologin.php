<?php
    include 'alunos/classes/banco.class.php';

    // if($_POST){
    //     $obj = new banco;
    //     $email = $_POST['cpf'];
    //     $senha = $_POST['senha'];
    //     $obj->sigin($email, $senha);
    // }
?>

<!doctype html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css_bootstrap/bootstrap.min.css">
		
    <title>Insira seu usuário e senha</title>
</head>

<body>

<body>

<div class="box-parent-login">
	<div class="well bg-white box-login">
		<h1 class="ls-login-logo">locaweb</h1>
		<form role="form">
			<fieldset>
 
				<div class="form-group ls-login-user">
					<label for="userLogin">Usuário</label>
					<input class="form-control ls-login-bg-user input-lg" id="userLogin" type="text" aria-label="Usuário" placeholder="Usuário">
				</div>
 
				<div class="form-group ls-login-password">
					<label for="userPassword">Senha</label>
					<input class="form-control ls-login-bg-password input-lg" id="userPassword" type="password" aria-label="Senha" placeholder="Senha">
				</div>
 
				<a href="#" class="ls-login-forgot">Esqueci minha senha</a>
 
				<input type="submit" value="Entrar" class="btn btn-primary btn-lg btn-block">
				<p class="txt-center ls-login-signup">Não possui um usuário na Locaweb?
					<a href="#">Cadastre-se agora</a>
				</p>
 
			</fieldset>
		</form>
	</div>
</div>

</body>




    
</body> 
</html>


