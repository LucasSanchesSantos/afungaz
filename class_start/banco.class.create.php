<?php
class create
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
            $this->conexao->exec("set names utf8mb4");

        } catch (\PDOException $e) {
            echo "Não foi possível estabelecer a conexão 
            com o banco de dados: Erro" . $e->getCode();
        }
    }
    
    public function readNegocio()
    {
        $sql = 
        " SELECT *
        from negocio n
        order by n.descricao
        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function readCargo()
    {
        $sql = 
        " SELECT *
        from cargo c
        order by c.descricao
        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }


    public function firstRegister($cpf,$ramal,$telefone,$negocio,$cargo){

    $sql = "INSERT INTO cadastro_afungaz VALUES ('$cpf',$ramal,$telefone,1,1,$negocio,$cargo)";
    $statement = $this->conexao->prepare($sql);
    $resultado = $statement->execute();
    if ($resultado) {
        echo '<script>alert("Registrado com sucesso! Confira em Meus Agendamentos ");
        window.location.href="/afungaz/index.php";</script>';
        $_SESSION['cadastro_afungaz'] = true;
        } else {
        echo '<script>alert("Erro no registro!");</script>';
        }
    }   

}

