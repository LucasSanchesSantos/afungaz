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
            $this->conexao->exec("set names utf8mb4");
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

        order by 2
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
            ,t.id as id_tipo_local
            ,concat(LPAD(day(a.data_agendamento),2,'0'),'/',LPAD(month(data_agendamento),2,'0'),'/',year(data_agendamento)) as data_agendamento
            ,case when a.hora = 0 then 'Inegral' else CONCAT(a.hora,':00') end as hora
            ,l.local_origem
        from agendamento a
        left join local l on l.id = a.id_local  
        left join tipo_local t on t.id = l.id_tipo_local

        where a.id 
        and a.id_situacao = 1
        and a.data_agendamento >= CURDATE()
        and a.cnpj_cpf = '$var_aux'
        order by a.data_agendamento, l.local_origem";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
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
            ,t.id as id_tipo_local
            ,concat(LPAD(day(a.data_agendamento),2,'0'),'/',LPAD(month(data_agendamento),2,'0'),'/',year(data_agendamento)) as data_agendamento
            ,case when a.hora = 0 then 'inegral' else CONCAT(a.hora,':00') end as hora
            ,l.local_origem
        from agendamento a
        left join local l on l.id = a.id_local
        left join tipo_local t on t.id = l.id_tipo_local

        where a.id_situacao = 1
        and a.cnpj_cpf = '$var_aux2'
        $var_aux
        and a.data_agendamento between '$data_agendamento_consulta_inicio' and '$data_agendamento_consulta_fim'
        order by a.data_agendamento, l.local_origem";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function updateCancel($id,$cnpj_cpf){
        $sql = "UPDATE agendamento set id_situacao = 2 where id = $id" ;
        $statement = $this->conexao->prepare($sql);
        $update = $statement->execute();

        $sql = "INSERT INTO cancela_agendamento VALUES ($id,'$cnpj_cpf',CURRENT_TIMESTAMP())" ;
        $statement = $this->conexao->prepare($sql);
        $update = $statement->execute();

        if($update){
            echo '<script> alert("Alterado com sucesso!");
            window.location.href="/afungaz/user/read_agendamento.php";</script>';
        }else{
            echo '<script>alert("Erro ao alterar. Contate um administrador")</script>';
        }
    }

    public function readForUpdate($id)
    {
        $sql = 
        "SELECT 
            a.id
            ,a.cnpj_cpf
            ,a.data_agendamento
            ,a.id_local
            ,a.hora
            ,p.nome
            -- ,case when a.hora = 0 then 'Inegral' else CONCAT(a.hora,':00') end as hora
            ,l.local_origem
            ,l.id_tipo_local
        from agendamento a
        left join local l on l.id = a.id_local  
        left join tipo_local t on t.id = l.id_tipo_local
        left join pessoa p on p.cnpj_cpf = a.cnpj_cpf

        where a.id = $id
        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function hora(){
        $sql = 
        "SELECT * from hora_agendamento";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function current_local($id_local,$id_tipo_local)
    {
    
        $sql = 
        "SELECT 
        *
        from local l 
        where id not in ($id_local)
        and l.id_tipo_local = $id_tipo_local

        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }
    
    public function updateAgendamento($id,$id_local,$data_agendamento,$hora){
        $sql = "SELECT * FROM agendamento where id_local = $id_local and data_agendamento = '$data_agendamento' and hora = $hora and id_situacao = 1";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $rows = $statement->rowCount();

        if($rows){
            echo '<script>alert("Esse campo/quadra já esta registrado nesse horário");</script>';
        }else{
            $cpf = $_SESSION['cnpj_cpf']; 

            $sql = "UPDATE agendamento set id_local = $id_local, data_agendamento = '$data_agendamento', hora = $hora where id = $id";
            $statement = $this->conexao->prepare($sql);
            $resultado = $statement->execute();
            if ($resultado) {
                echo '<script>alert("Registrado com sucesso! Confira em Meus Agendamentos ");window.location.href="/afungaz/user/read_agendamento.php";</script>';
                } else {
                echo '<script>alert("Erro no registro!");</script>';
                }
        }
    }
}

