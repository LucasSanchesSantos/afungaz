<?php
class UserUpdate
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

    public function readUser($cnpj_cpf)
    {
        $sql = 
        " SELECT c.*
            ,p.nome
            ,ca.descricao as desc_cargo
            ,n.descricao as desc_negocio
        from cadastro_afungaz c
        left join pessoa p on p.cnpj_cpf = c.cnpj_cpf
        left join cargo ca on ca.id = c.id_cargo
        left join negocio n on n.id = c.id_negocio

        where c.cnpj_cpf = $cnpj_cpf
        order by 1
        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function UpdateUser($cnpj_cpf,$ramal,$telefone,$id_negocio,$id_cargo){
        $sql = 
        " UPDATE cadastro_afungaz SET  
            ramal = $ramal
            ,telefone = $telefone
            ,id_negocio = $id_negocio
            ,id_cargo = $id_cargo
        where cnpj_cpf = $cnpj_cpf
        ";

        $statement = $this->conexao->prepare($sql);
        $update = $statement->execute();

        if($update){
            echo '<script> alert("Cadastro atualizado");
            window.location.href="/afungaz/index.php";</script>';
        }else{
            echo '<script>alert("Erro ao alterar. Contate um administrador")</script>';
        }
    }
    
}

