<?php
class banco
{
    private $host = "afungaz.mysql.dbaas.com.br";
    private $database = "afungaz";
    private $user = "afungaz";
    private $password = "Informatica@10";
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
    
    public function sigin($cpf, $password)
    {
        $sql = 
        "SELECT 
            p.*
            ,c.*
        FROM pessoa p 
        left join cadastro_afungaz c on c.cnpj_cpf = p.cnpj_cpf
        where p.cnpj_cpf = '$cpf' 
            and p.chavemd5 = '$password'
        ";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        $rows = $statement->rowCount();
        
        if ($rows) {
            foreach ($array as $key => $value) {
                session_start();
                $_SESSION["nome"] = $value['nome'];
                $_SESSION["login"] = true;
                $_SESSION["cnpj_cpf"] = $value['cnpj_cpf'];
                $_SESSION["password"] = $value['chavemd5'];
                $_SESSION['id_tipo_funcionario'] = $value['id_tipo_funcionario'];
            }
            
            $sql = "SELECT * FROM cadastro_afungaz where cnpj_cpf = '$cpf'";
            $statement = $this->conexao->prepare($sql);
            $statement->execute();
            $array = $statement->fetchAll(PDO::FETCH_ASSOC);
            $rows2 = $statement->rowCount();
            
            if ($rows2) {
                header('location: index.php');
                $_SESSION['cadastro_afungaz'] = true;
            }else{
                header('location: primeiro_cadastro.php');
            }
        
        }else{
            echo '<script> alert("Login inválido!"); </script>';
        }
    }

    public function checkLogin(){
        if(!isset($_SESSION["login"]) or $_SESSION["login"] == false){
            header('location: login.php');
        }
    }

    public function checkCadastroAfungaz(){
        if(!isset($_SESSION["cadastro_afungaz"]) or $_SESSION["cadastro_afungaz"] == false){
            header('Location: primeiro_cadastro.php');
        }else{
            
        }
    }

    public function logout(){
        session_destroy();//destruir todas sessões
        $_SESSION['login'] = false;
        $_SESSION['cadastro_afungaz'] = false;
        header('Location: ../../../afungaz/login.php');
    }
    
}

