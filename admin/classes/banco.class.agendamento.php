<?php
class agendamento
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

    public function selectLocal()
    {
        $sql = 
        " SELECT 
            l.id
            ,l.local_origem
        from local l
        left join tipo_local t on t.id = l.id_tipo_local
        order by 2
        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
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
        from situacao_agendamento s
        where id in (1,2)
        order by descricao
        ";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function readAgendamento()
    {
        $sql = 
        "SELECT 
            p.nome
            ,n.descricao as negocio
            ,a.id
            ,a.data_agendamento
            ,case when a.hora = 0 then 'Período inegral' else CONCAT(a.hora,':00') end as hora
            ,l.local_origem
            ,s.descricao as situacao
            ,a.id_situacao
        from agendamento a
        left join local l on l.id = a.id_local  
        left join tipo_local t on t.id = l.id_tipo_local
        left join pessoa p on p.cnpj_cpf = a.cnpj_cpf
        left join cadastro_afungaz c on c.cnpj_cpf = a.cnpj_cpf
        left join negocio n on n.id = c.id_negocio
        left join situacao_agendamento s on s.id = a.id_situacao

        where a.id
        and a.id_situacao = 1
        and a.data_agendamento >= CURDATE()
        order by a.data_agendamento, l.local_origem";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function readAgendamentoFilter($local_origem_consulta,$usuario,$data_agendamento_consulta_inicio,$data_agendamento_consulta_fim,$hora,$situacao)
    {   
        //estabelecendo um valor de vazio para não precisar fazer vários else. Se elas não estiverem setadas como vazio da erro.
        $var_aux1 = ''; 
        $var_aux2 = ''; 
        $var_aux3 = ''; 
        $var_aux4 = '';
        
        if($local_origem_consulta <> 0){
            $var_aux1 = "and a.id_local = $local_origem_consulta";
        }
        if($usuario <> 0){
            $var_aux2 = "and a.cnpj_cpf = '$usuario'";
        }
        if($hora <> 0){
            $var_aux3 = "and a.hora = $hora";
        }
        if($situacao <> 0){
            $var_aux4 = "and a.id_situacao = $situacao";
        }
        
        $sql = 
        "SELECT 
            p.nome
            ,n.descricao as negocio
            ,a.id
            ,a.data_agendamento
            ,case when a.hora = 0 then 'Período inegral' else CONCAT(a.hora,':00') end as hora
            ,l.local_origem
            ,s.descricao as situacao
            ,a.id_situacao
        from agendamento a
        left join local l on l.id = a.id_local  
        left join tipo_local t on t.id = l.id_tipo_local
        left join pessoa p on p.cnpj_cpf = a.cnpj_cpf
        left join cadastro_afungaz c on c.cnpj_cpf = a.cnpj_cpf
        left join negocio n on n.id = c.id_negocio
        left join situacao_agendamento s on s.id = a.id_situacao

        where a.data_agendamento between '$data_agendamento_consulta_inicio' and '$data_agendamento_consulta_fim'
        $var_aux1
        $var_aux2
        $var_aux3
        $var_aux4
        order by a.data_agendamento, l.local_origem";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function cancelaAgendamento($id,$cnpj_cpf){
        $sql = "UPDATE agendamento set id_situacao = 2 where id = $id" ;
        $statement = $this->conexao->prepare($sql);
        $update = $statement->execute();

        $sql = "INSERT INTO cancela_agendamento VALUES ($id,'$cnpj_cpf ',CURRENT_TIMESTAMP())" ;
        $statement = $this->conexao->prepare($sql);
        $update = $statement->execute();

        if($update){
            echo '<script> alert("Alterado com sucesso!");
            window.location.href="/afungaz/admin/read_agendamento.php";</script>';
        }else{
            echo '<script>alert("Erro ao alterar. Contate um administrador")</script>';
        }
    }

}

