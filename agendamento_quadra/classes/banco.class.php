<?php
class quadra
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

    public function readQuioesque()
    {
        $sql = 
        "SELECT a.* 
            ,l.local_origem
        from agendamento a
        left join local l on l.id = a.id_local  
        left join tipo_local t on t.id = l.id_tipo_local

        where t.descricao = 'Campos'
        and a.id_situacao = 1
        and a.data_agendamento >= CURDATE()
        order by a.data_agendamento, l.local_origem";

        //prepara o sql
        $statement = $this->conexao->prepare($sql);
        //executa
        $statement->execute();
        //tras um array completo do sql
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function readLocal()
    {
        $sql = 
        " SELECT 
            l.id
            ,l.local_origem
        from local l
        left join tipo_local t on t.id = l.id_tipo_local

        where t.descricao = 'Campos'
        order by 1

        ";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function validaAgendamento($id,$data,$hora){

        $sql = "SELECT * FROM agendamento where id_local = '$id' and data_agendamento = '$data' and hora = '$hora'";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        $rows = $statement->rowCount();

        if($rows){
            echo '<script>alert("Esse campo/quadra já esta registrado nesse horário");</script>';
            
        }   else{
            $cpf = $_SESSION['cnpj_cpf']; 

            $sql = "INSERT INTO agendamento VALUES (0,'$cpf','$data',$id,1,'$hora')";
            $statement = $this->conexao->prepare($sql);
            $resultado = $statement->execute();
            if ($resultado) {
                echo '<script>alert("Registrado com sucesso! Confira em Meus Agendamentos ");window.location.href="/afungaz/agendamento_quadra/agendamento.php";</script>';
                } else {
                echo '<script>alert("Erro no registro!");</script>';
                }
        }

    }

}

