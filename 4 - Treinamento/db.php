<?php

class db
{
    private $host = "localhost";
    private $port = "5432";
    private $dbname = "livraria";
    private $user = "postgres";
    private $password = "root";
    private $connection;

    public function connect()
    {
        $this->connection = pg_connect("host=$this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->password");

        if (!$this->connection) {
            system('clear');

            print("Erro ao se conectar ao banco de dados \n \n");

            exit();
        }
    }
    private function prepararDadosQuery($values, $cadastrar = true)
    {
        $valores = '';
        $colunas = '';

        foreach ($values as $k => $v) {
            if ($k == array_key_last($values)) {
                $valores .= $cadastrar ? "'$v'" : "$v";
                $colunas .= $k;
            } else {
                $valores .= ($cadastrar ? "'$v'" : "$v") . ", ";
                $colunas .= $k . ", ";
            }
        }
        return [$colunas, $valores];
    }
    public function cadastrar($table, $values)
    {
        [$colunas, $valores] = $this->prepararDadosQuery($values);

        $ok = pg_query($this->connection, "INSERT INTO $table ($colunas) VALUES ($valores)");

        if (!$ok) {
            print("Falha ao tentar inserir no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function lerEstoque($table)
    {
        $ok = pg_query($this->connection, "SELECT * FROM $table");

        while ($row = pg_fetch_assoc($ok)) {
            echo "\n";
            echo "ID: " . $row['id_est'] . "\n";
            echo "Nome: " . $row['nome_est'] . "\n";
            echo "Quantidade: " . $row['quantidade_est'] . "\n";
            echo "\n";
        }
        if (!$ok) {
            print("Falha ao tentar ler no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }

    public function lerEspecifico($valor, $table)
    {
        $ok = pg_query($this->connection, "SELECT $valor FROM $table");
        while ($row = pg_fetch_assoc($ok)) {
            echo $row[$valor] . "\n";
        }
    }
    public function prepararDadosUpdate(array|string $colunas, array|string $valores)
    {
        $texto = "";

        if (is_array($colunas) && is_array($valores)) {
            $linhas = count($colunas) - 1;

            foreach ($colunas as $key => $coluna) {
                $texto .= "$coluna = '$valores[$key]'";
                $texto .= $key != $linhas ? ", " : "";
            }
        } else {
            $texto .= "$colunas = '$valores'";
        }

        return $texto;
    }
    public function vender($values, $id)
    {
        [$colunas, $valores] = $this->prepararDadosQuery($values, false);

        //quantia do banco de dados
        $ok = pg_query($this->connection, "SELECT quantidade_est, id_est FROM estoque WHERE id_est = $id");
        while ($row = pg_fetch_assoc($ok)) {
            $quant = $row['quantidade_est'] . "\n"; //string
        }
        $quantidade = intval($quant) - intval($valores);

        $registros = $this->prepararDadosUpdate($colunas, $quantidade);

        $ok = pg_query($this->connection, "UPDATE estoque SET $registros WHERE id_est = $id");

        if (!$ok) {
            print("Falha ao tentar inserir no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function movimentar($table, $values, $id)
    {
        [$colunas, $valores] = $this->prepararDadosQuery($values);

        $queryEstoque = pg_query($this->connection, "SELECT quantidade_est, id_est FROM estoque WHERE id_est = $id");
        $queryEstoque = pg_fetch_all($queryEstoque);

        if (!$queryEstoque[0]['quantidade_est']) {
            print("Falha ao tentar inserir no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }

        // Caso ele tente dar uma saida maior que a possivel, exemplo: estoque 0 - 50 - Implementar
        if ($values['tipotransacao_mov'] == 'Entrada') {
            $novaQuantidade = $queryEstoque[0]['quantidade_est'] + $values['quantidade_mov'];
        } else {
            $novaQuantidade = $queryEstoque[0]['quantidade_est'] - $novaQuantidade = $values['quantidade_mov'];
        }

        $okMov = pg_query($this->connection, "INSERT INTO $table ($colunas) VALUES ($valores)");
        $okUpdate = pg_query($this->connection, "UPDATE estoque SET quantidade_est = $novaQuantidade WHERE id_est = $id");

        if (!$okUpdate || $okMov) {
            print("Falha ao tentar inserir no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }

}