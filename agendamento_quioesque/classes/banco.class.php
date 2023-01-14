<?php
class quioesque
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

        where t.descricao = 'Quiosque'
        order by 1

        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function Agendamento($id,$data){

        $sql = "SELECT * FROM agendamento where id_local = '$id' and data_agendamento = '$data' and id_situacao = 1";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        //$array = $statement->fetchAll(PDO::FETCH_ASSOC);
        $rows = $statement->rowCount();

        if($rows){
            echo '<script>alert("Essa data já está reservada para este Quioesque");</script>';
            
        }   else{
            $cpf = $_SESSION['cnpj_cpf']; 

            $sql = "INSERT INTO agendamento VALUES (0,'$cpf','$data',$id,1,0)";
            $statement = $this->conexao->prepare($sql);
            $resultado = $statement->execute();
            if ($resultado) {
                echo '<script>alert("Registrado com sucesso! Confira em Meus Agendamentos ");
                window.location.href="/afungaz/index.php";</script>';
                } else {
                echo '<script>alert("Erro no registro!");</script>';
                }
        }

    }

    public function readQuioesque()
    {
        $sql = 
        "SELECT a.id
            ,a.cnpj_cpf
            ,concat(LPAD(day(a.data_agendamento),2,'0'),'/',LPAD(month(data_agendamento),2,'0'),'/',year(data_agendamento)) as data_agendamento
            ,a.id_local
            ,a.id_situacao
            ,a.hora
            ,l.local_origem
        from agendamento a
        left join local l on l.id = a.id_local  
        left join tipo_local t on t.id = l.id_tipo_local

        where t.descricao = 'Quiosque'
        and a.id_situacao = 1
        and a.data_agendamento >= CURDATE()
        order by a.data_agendamento, l.local_origem";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function readQuioesqueFilter($local_origem_consulta,$data_agendamento_consulta_inicio,$data_agendamento_consulta_fim)
    {

        if($local_origem_consulta == 0){
            $var_aux = "";
        }else{
            $var_aux = "and a.id_local = $local_origem_consulta";
        }

        $sql = 
        "SELECT a.id
            ,a.cnpj_cpf
            ,concat(LPAD(day(a.data_agendamento),2,'0'),'/',LPAD(month(data_agendamento),2,'0'),'/',year(data_agendamento)) as data_agendamento
            ,a.id_local
            ,a.id_situacao
            ,a.hora
            ,l.local_origem
        from agendamento a
        left join local l on l.id = a.id_local  
        left join tipo_local t on t.id = l.id_tipo_local

        where a.id_situacao = 1
        and t.descricao = 'Quiosque'
        $var_aux
        and a.data_agendamento between '$data_agendamento_consulta_inicio' and '$data_agendamento_consulta_fim'
        order by a.data_agendamento, l.local_origem";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

}

