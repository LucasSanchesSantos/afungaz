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
        header('Location: ../../../afungaz/login.php');
    }
}

