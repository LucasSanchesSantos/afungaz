<?php
class banco
{
    private $host = "localhost";
    private $database = "afungaz";
    private $user = "root";
    private $password = "";
    private $conexao = null;

    public function __construct()
    {
        $this->conecta();
    }
    public function conecta()
    {
        try {
            $this->conexao = new PDO("mysql:host=$this->host;
            dbname=$this->database", "$this->user", "$this->password");
        } catch (\PDOException $e) {
            echo "Não foi possível estabelecer a conexão 
            com o banco de dados: Erro" . $e->getCode();
        }
    }

    public function create($cpf,$nome,$telefone,$instituicao,$endereco,$rg,$email,$senha,$dias_semana)
    {
        $sql = "INSERT INTO alunos VALUES (0,'{$cpf}','{$nome}','{$telefone}','{$instituicao}',1,'{$endereco}','{$rg}','{$email}','{$senha}',$dias_semana)";
       
        $statement = $this->conexao->prepare($sql);
        $resultado = $statement->execute();
        if ($resultado) {
            echo '<script>alert("Registrado com sucesso! Efetue seu login.");
         window.location.href="/contador_de_dedinhos/login.php";</script>';
        } else {
            echo '<script>alert("Erro no registro!");</script>;';
        }
    }

    public function read($tabela, $id = null)
    {

        if ($id != null) {
            $condicao = " where id = $id ";
        } else {
            $condicao = "";
        }

        $sql = "SELECT * FROM $tabela $condicao order by id desc";

        //prepara o sql
        $statement = $this->conexao->prepare($sql);
        //executa
        $statement->execute();
        //tras um array completo do sql
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }
    
    public function update($id_session,$cpf,$nome,$telefone,$instituicao,$endereco,$rg,$email,$senha,$dias_semana,$id_tipo_usuario)
    {
        $sql = "UPDATE alunos set id = $id_session,nome = '{$nome}',cpf = '{$cpf}',nome = '{$nome}',telefone = '{$telefone}',id_instituicao = $instituicao,id_tipo_usuario = $id_tipo_usuario,endereco = '{$endereco}',rg = '{$rg}',email = '{$email}',senha = '{$senha}',dias_semana = $dias_semana where id = $id_session" ;

        $statement = $this->conexao->prepare($sql);
        $update = $statement->execute();
        if($update){
            echo '<script> alert("Alterado com sucesso!");
            window.location.href="/contador_de_dedinhos/index.php";</script>';
        }else{
            echo '<script>alert("Erro no registro!")</script>';
        }
    }

    public function delete($table, $id){
        $sql = "delete from $table where id = $id";

        
        $statement = $this->conexao->prepare($sql);
        $delete = $statement->execute();
        if($delete){
            echo '<script> alert("Registro excluído com sucesso!");
            window.location.href="/contador_de_dedinhos";</script>';
        }else{
            echo '<script>alert("Erro na exclusão!")</script>';
        }
    }

    public function sigin($cpf, $password)
    {
        $sql = "SELECT * FROM pessoa where cnpj_cpf = '$cpf' and chavemd5 = '$password'";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        $rows = $statement->rowCount();
        //rowCount conta os resultados caso seja verdadeiro
        //var_dump($rows);

        if ($rows) {
            foreach ($array as $key => $value) {
                session_start();
                $_SESSION["nome"] = $value['nome'];
                $_SESSION["login"] = true;
                $_SESSION["cnpj_cpf"] = $value['cnpj_cpf'];
            }
            header('location: index.php');
            //funcao direcionar
        }else{
            echo '<script> alert("Login inválido!"); </script>';
        }
    }
    public function checkLogin(){
        if(!isset($_SESSION["login"]) or $_SESSION["login"] == false){
            header('Location: login.php');
        }
    }
    public function logout(){
        session_destroy();//destruir todas sessões
        $_SESSION['login'] = false;
        header('Location: login.php');
    }

    public function createAluno2($email){
        
        $sql = "SELECT * FROM alunos where email = '{$email}'";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
       
    }
    
    public function createAluno($cpf,$nome,$telefone,$instituicao,$endereco,$rg,$email,$senha,$dias_semana){

        $sql = "INSERT INTO alunos VALUES (0,'{$cpf}','{$nome}','{$telefone}','{$instituicao}',1,'{$endereco}','{$rg}','{$email}','{$senha}',$dias_semana)";
        $statement = $this->conexao->prepare($sql);
        $resultado = $statement->execute();
        if ($resultado) {
            echo '<script>alert("Registrado com sucesso! Efetue seu login.");
            window.location.href="/contador_de_dedinhos/login.php";</script>';
            } else {
               echo '<script>alert("Erro no registro!");</script>;';
            }
    }



}

