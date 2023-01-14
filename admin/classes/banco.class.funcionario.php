<?php
class funcionario
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

    public function selectUser()
    {
        $sql = 
        " SELECT 
            c.cnpj_cpf
            ,p.nome
        from cadastro_afungaz c
        left join pessoa p on p.cnpj_cpf = c.cnpj_cpf
        order by p.nome
        ";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function selectSituacao()
    {
        $sql = 
        "SELECT 
            *
        from situacao_funcionario s
        order by descricao
        ";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }
    
    public function selectSituacaoFilter($id_ignore)
    {
        $sql = 
        "SELECT 
            *
        from situacao_funcionario s
        where id <> $id_ignore
        order by descricao
        ";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function selectTipoFuncionario($id_ignore)
    {
        $sql = 
        "SELECT 
            *
        from tipo_funcionario t
        where id <> $id_ignore
        order by descricao
        ";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function selectNegocio()
    {
        $sql = 
        "SELECT * from negocio order by descricao";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function selectCargo()
    {
        $sql = 
        "SELECT * from cargo order by descricao";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function readFuncionario()
    {
        $sql = 
        "SELECT 
            c.cnpj_cpf
            ,c.ramal
            ,concat('(',left(c.telefone,2),') 9 ',left(right(c.telefone,8),4),'-',right(c.telefone,4)) as telefone
            ,c.id_tipo_funcionario
            ,c.id_situacao
            ,c.id_negocio
            ,c.id_cargo
            ,p.nome
            ,s.descricao as situacao
            ,n.descricao as negocio
            ,ca.descricao as cargo
            ,t.descricao as tipo_funcionario
        from cadastro_afungaz c
        left join pessoa p on p.cnpj_cpf = c.cnpj_cpf
        left join situacao_funcionario s on s.id = c.id_situacao
        left join negocio n on n.id = c.id_negocio
        left join cargo ca on ca.id = c.id_cargo
        left join tipo_funcionario t on t.id = c.id_tipo_funcionario

        where 
        c.id_situacao = 1
        order by p.nome
        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function readFuncionarioFilter($usuario,$situacao,$negocio,$cargo)
    {   
        //estabelecendo um valor de vazio para não precisar fazer vários else. Se elas não estiverem setadas como vazio da erro.
        $var_aux1 = '';
        $var_aux2 = '';
        $var_aux3 = '';
        $var_aux4 = '';
        
        if($usuario <> 0){
            $var_aux1 = "and c.cnpj_cpf = $usuario";
        }
        if($situacao <> 0){
            $var_aux2 = "and c.id_situacao = '$situacao'";
        }
        if($negocio <> 0){
            $var_aux3 = "and c.id_negocio = $negocio";
        }
        if($cargo <> 0){
            $var_aux4 = "and c.id_cargo = $cargo";
        }
        
        $sql = 
        "SELECT 
            c.cnpj_cpf
            ,c.ramal
            ,concat('(',left(c.telefone,2),') 9 ',left(right(c.telefone,8),4),'-',right(c.telefone,4)) as telefone
            ,c.id_tipo_funcionario
            ,c.id_situacao
            ,c.id_negocio
            ,c.id_cargo
            ,p.nome
            ,s.descricao as situacao
            ,n.descricao as negocio
            ,ca.descricao as cargo
            ,t.descricao as tipo_funcionario
        from cadastro_afungaz c
        left join pessoa p on p.cnpj_cpf = c.cnpj_cpf
        left join situacao_funcionario s on s.id = c.id_situacao
        left join negocio n on n.id = c.id_negocio
        left join cargo ca on ca.id = c.id_cargo
        left join tipo_funcionario t on t.id = c.id_tipo_funcionario

        where c.cnpj_cpf is not null
        $var_aux1
        $var_aux2
        $var_aux3
        $var_aux4
        order by p.nome";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function updateFuncionario($cnpj_cpf,$id_situacao,$id_tipo_funcionario){
        $sql = "UPDATE cadastro_afungaz set id_situacao = $id_situacao, id_tipo_funcionario = $id_tipo_funcionario where cnpj_cpf = '$cnpj_cpf'" ;
        $statement = $this->conexao->prepare($sql);
        $update = $statement->execute();

        if($update){
            echo '<script> alert("Alterado com sucesso!");
            window.location.href="/afungaz/admin/read_funcionario.php";</script>';
        }else{
            echo '<script>alert("Erro ao alterar. Contate um administrador")</script>';
        }
    }

}

