<?php

class db {
    private $host = "localhost"; 
    private $port = "5432"; 
    private $dbname = "livraria"; 
    private $user = "postgres"; 
    private $password = "root"; 
    private $connection;

    public function connect(){
       $this->connection = pg_connect("host=$this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->password");
        
        if(!$this->connection){
            system('clear');

            print("Erro ao se conectar ao banco de dados \n \n");

            exit();
        }
    }  
    private function prepararDadosQuery($values){
        $valores = '';
        $colunas = '';

        foreach ($values as $k => $v) {
            if($k == array_key_last($values)){
                $valores .= "'$v'";
                $colunas .= $k;
            } else {
                $valores .= "'$v'" . ", ";
                $colunas .= $k . ", ";
            }
        }
        return [$colunas, $valores];
    }
    public function cadastrar($table, $values) {
        [$colunas, $valores] = $this->prepararDadosQuery($values);

        $ok = pg_query($this->connection, "INSERT INTO $table ($colunas) VALUES ($valores)");

        if(!$ok) {
            print("Falha ao tentar inserir no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function ler($table){
        $ok = pg_query($this->connection, "SELECT * FROM $table");
        
        while ($row = pg_fetch_assoc($ok)) {
            echo "ID: " . $row['id_est'] . "\n";
            echo "Nome: " . $row['nome_est'] . "\n";
            echo "Quantidade Inicial: " . $row['quantidade_est'] . "\n";
            echo "Situacao: " . ($row['situacao_est']  == 't' ? 'Entrada' : 'Saida') . "\n";
            echo "\n\n";
        }
        if(!$ok) {
            print("Falha ao tentar ler no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function lerEspecifico($valor, $table){
    $ok = pg_query($this->connection, "SELECT $valor FROM $table");
        while ($row = pg_fetch_assoc($ok)) {
            echo $row[$valor] . "\n";
        }
    }

    
}

