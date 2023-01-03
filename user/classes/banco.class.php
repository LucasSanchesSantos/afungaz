<?php
class quadra
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

    public function readLocal()
    {
        $sql = 
        " SELECT 
            l.id
            ,l.local_origem
        from local l
        left join tipo_local t on t.id = l.id_tipo_local

        order by 1

        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function readUser()
    {
        $var_aux = $_SESSION['cnpj_cpf'];

        $sql = 
        "SELECT 
            a.id
            ,a.data_agendamento
            ,case when a.hora = 0 then 'Período inegral' else CONCAT(a.hora,':00') end as hora
            ,l.local_origem
        from agendamento a
        left join local l on l.id = a.id_local  
        left join tipo_local t on t.id = l.id_tipo_local

        where a.id 
        and a.id_situacao = 1
        and a.data_agendamento >= CURDATE()
        and a.cnpj_cpf = '$var_aux'
        order by l.local_origem, a.data_agendamento";

        //prepara o sql
        $statement = $this->conexao->prepare($sql);
        //executa
        $statement->execute();
        //tras um array completo do sql
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function readUserFilter($local_origem_consulta,$data_agendamento_consulta_inicio,$data_agendamento_consulta_fim)
    {
        $var_aux2 = $_SESSION['cnpj_cpf'];

        if($local_origem_consulta == 0){
            $var_aux = "";
        }else{
            $var_aux = "and a.id_local = $local_origem_consulta";
        }

        $sql = 
        "SELECT 
            a.id
            ,a.data_agendamento
            ,case when a.hora = 0 then 'Período inegral' else CONCAT(a.hora,':00') end as hora
            ,l.local_origem
        from agendamento a
        left join local l on l.id = a.id_local  
        left join tipo_local t on t.id = l.id_tipo_local

        where a.id_situacao = 1
        and a.cnpj_cpf = '$var_aux2'
        $var_aux
        and a.data_agendamento between '$data_agendamento_consulta_inicio' and '$data_agendamento_consulta_fim'
        order by l.local_origem, a.data_agendamento";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function updateCancel($id,$cnpj_cpf){
        $sql = "UPDATE agendamento set id_situacao = 3 where id = $id" ;
        $statement = $this->conexao->prepare($sql);
        $update = $statement->execute();

        $sql = "INSERT INTO cancela_agendamento VALUES ($id,'$cnpj_cpf ',CURRENT_TIMESTAMP())" ;
        $statement = $this->conexao->prepare($sql);
        $update = $statement->execute();

        if($update){
            echo '<script> alert("Alterado com sucesso!");
            window.location.href="/afungaz/user/user.php";</script>';
        }else{
            echo '<script>alert("Erro ao alterar. Contate um administrador")</script>';
        }
    }
    
}

