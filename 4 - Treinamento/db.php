<?php
include_once('./index.php');
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

        $ok = pg_query($this->connection, "INSERT INTO $table ($colunas) VALUES ($valores) returning id_est");
        $ok = pg_fetch_all($ok);
        $data_mov = (date("Y-m-d"));
        $quantidade_mov = $values['quantidade_est'];
        $id = $ok[0]['id_est'];
        $okMov = pg_query($this->connection, "INSERT INTO movimentacao (tipoTransacao_mov, data_mov, quantidade_mov, fkItemEstoque_est) VALUES ('Inicial', '$data_mov', $quantidade_mov, $id )");

        if (!$ok || !$okMov) {
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
            $novaQuantidade = $queryEstoque[0]['quantidade_est'];
        }
        if ($values['tipotransacao_mov'] == 'Entrada') {
            $novaQuantidade = $queryEstoque[0]['quantidade_est'] + $values['quantidade_mov'];
        } else if ($queryEstoque[0]['quantidade_est'] > 0 || $values['tipotransacao_mov'] == 'Saida') {
            $novaQuantidade = $queryEstoque[0]['quantidade_est'] - $values['quantidade_mov'];
            if ($novaQuantidade < 0) {
                $novaQuantidade = $queryEstoque[0]['quantidade_est'];

                echo "Quantidade inválida, não possuímos essa quantidade de itens no estoque!";
                sleep(4);
            }
        }

        $okMov = pg_query($this->connection, "INSERT INTO $table ($colunas) VALUES ($valores)");
        $okUpdate = pg_query($this->connection, "UPDATE estoque SET quantidade_est = $novaQuantidade WHERE id_est = $id");

        if (!$okUpdate || !$okMov) {
            print("Falha ao tentar inserir no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function lerEstoque($table)
    {
        $ok = pg_query($this->connection, "SELECT * FROM $table");
        system('clear');

        echo "+------+---------------------------------------------+---------------+\n";
        echo "|  ID  |                   Nome                      |     Estoque   |\n";
        echo "+------+---------------------------------------------+---------------+\n";
        $total = 0;
        while ($row = pg_fetch_assoc($ok)) {
            $nome = mb_strcut($row["nome_est"], 0, 42);
            echo "| " . str_pad($row["id_est"], 4, " ", STR_PAD_LEFT) . " | ";
            echo $nome . str_repeat(" ", 43 - mb_strlen($nome)) . " | ";
            echo str_pad($row["quantidade_est"], 13, " ", STR_PAD_LEFT) . " |\n";
            $total += $row["quantidade_est"];
        }
        echo "+------+---------------------------------------------*---------------+\n";
        if (!$ok) {
            print("Falha ao tentar ler no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function lerEstoqueEspecifico($table, $id)
    {
        $ok = pg_query($this->connection, "SELECT * FROM $table WHERE id_est = $id");
        system('clear');
        echo "+------+---------------------------------------------+---------------+\n";
        echo "|  ID  |                   Nome                      |     Estoque   |\n";
        echo "+------+---------------------------------------------+---------------+\n";
        $total = 0;
        while ($row = pg_fetch_assoc($ok)) {
            $nome = mb_strcut($row["nome_est"], 0, 42);
            echo "| " . str_pad($row["id_est"], 4, " ", STR_PAD_LEFT) . " | ";
            echo $nome . str_repeat(" ", 43 - mb_strlen($nome)) . " | ";
            echo str_pad($row["quantidade_est"], 13, " ", STR_PAD_LEFT) . " |\n";
            $total += $row["quantidade_est"];
        }
        echo "+------+---------------------------------------------*---------------+\n";
        if (!$ok) {
            print("Falha ao tentar ler no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }

    public function relatorioTotal()
    {
        $selectAll = pg_query($this->connection, "SELECT * FROM estoque");
        $selectAll = pg_fetch_all($selectAll);
        $this->lerEstoque('estoque');
        echo "\nDeseja exportar o relatório?\n[1] Não\n[2] Exportar relatório\nDigite sua opção:    ";
        $exportar = readline();
        if ($exportar == 2) {
            $this->csv($selectAll);
        } else {
            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function relatorioEspecifico($id)
    {
        $selectOne = pg_query($this->connection, "SELECT * FROM estoque WHERE  id_est = $id ");
        $selectOne = pg_fetch_all($selectOne);
        $this->lerEstoqueEspecifico('estoque', $id);
        echo "\nDeseja exportar o relatório?\n[1] Não\n[2] Exportar relatório\nDigite sua opção:    ";
        $exportar = readline();
        if ($exportar == 2) {
            $this->csv($selectOne);
        } else {
            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function relatorioMovimentacao()
    {

        $selectAll = pg_query($this->connection, "SELECT * FROM movimentacao ");
        $select = pg_fetch_all($selectAll);

        echo "+------+-------------------+----------------------+------------+\n";
        echo "|  ID  | Data de Movimento |   Tipo de Movimento  | Quantidade |\n";
        echo "+------+-------------------+----------------------+------------+\n";
        $total = 0;
        while ($row = pg_fetch_assoc($selectAll)) {
            echo "| " . str_pad($row["id_mov"], 4, " ", STR_PAD_LEFT) . " | ";
            echo str_pad(date_format(date_create($row["data_mov"]), "d/m/Y"), 17, " ", STR_PAD_RIGHT) . " | ";
            echo str_pad($row["tipotransacao_mov"], 27 - strlen($row["tipotransacao_mov"]), " ", STR_PAD_RIGHT) . " | ";
            echo str_pad($row["quantidade_mov"], 10, " ", STR_PAD_LEFT) . " |\n";
            $total += $row["quantidade_mov"];
        }
        echo "+------+-------------------+----------------------+------------+\n";
        echo "\nDeseja exportar o relatório?\n[1] Não\n[2] Exportar relatório\nDigite sua opção:    ";
        $exportar = readline();
        if ($exportar == 2) {
            $this->csv($select);
        } else {
            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function relatorioMovimentoData($dataInicial, $dataFinal)
    {
        $selectOne = pg_query($this->connection, "SELECT * FROM movimentacao WHERE data_mov BETWEEN '$dataInicial' AND '$dataFinal'");
        $select = pg_fetch_all($selectOne);
        echo "+------+-------------------+----------------------+------------+\n";
        echo "|  ID  | Data de Movimento |   Tipo de Movimento  | Quantidade |\n";
        echo "+------+-------------------+----------------------+------------+\n";
        $total = 0;
        while ($row = pg_fetch_assoc($selectOne)) {
            echo "| " . str_pad($row["id_mov"], 4, " ", STR_PAD_LEFT) . " | ";
            echo str_pad(date_format(date_create($row["data_mov"]), "d/m/Y"), 17, " ", STR_PAD_RIGHT) . " | ";
            echo str_pad($row["tipotransacao_mov"], 27 - strlen($row["tipotransacao_mov"]), " ", STR_PAD_RIGHT) . " | ";
            echo str_pad($row["quantidade_mov"], 10, " ", STR_PAD_LEFT) . " |\n";
            $total += $row["quantidade_mov"];
        }
        echo "+------+-------------------+----------------------+------------+\n";
        echo "\nDeseja exportar o relatório?\n[1] Não\n[2] Exportar relatório\nDigite sua opção:    ";
        $exportar = readline();
        if ($exportar == 2) {
            $this->csv($select);
        } else {
            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function csv($dados, $nomeArquivo = 'dados')
    {
        $arquivo = fopen($nomeArquivo . "(" . $this->random_string(5) . ').csv', 'w');

        if ($arquivo) {
            foreach ($dados as $linha) {
                fputcsv($arquivo, $linha, ";");
            }
            fclose($arquivo);
            echo "\nOs dados foram exportados! .\n";
        } else {
            echo "Erro ao abrir o arquivo para escrita.";
        }
    }
    public function random_string($length)
    {
        $rand_string = '';
        for ($i = 0; $i < $length; $i++) {
            $number = mt_rand(0, 36);
            $character = base_convert($number, 10, 36);
            $rand_string .= $character;
        }
        return $rand_string;
    }
}