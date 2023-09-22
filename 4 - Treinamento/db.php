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
    private function prepararDadosUpdate(array|string $colunas, array|string $valores)
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
    public function cadastrar($table, $values)
    {
        [$colunas, $valores] = $this->prepararDadosQuery($values);

        $ok = pg_query($this->connection, "INSERT INTO $table ($colunas) VALUES ($valores) returning id_est");
        $ok = pg_fetch_all($ok);
        $tipoTransacao_mov = "Inicial";
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
            print("Falha ao tentar inserir no banco de dados \n \n");
            readline('Pressione qualquer tecla para continuar');
        }

        if ($values['tipotransacao_mov'] == 'Entrada') {
            $novaQuantidade = $queryEstoque[0]['quantidade_est'] + $values['quantidade_mov'];
        } else if ($queryEstoque[0]['quantidade_est'] > 0 || $values['tipotransacao_mov'] == 'Saida') {
            $novaQuantidade = $queryEstoque[0]['quantidade_est'] - $novaQuantidade = $values['quantidade_mov'];
        } else {
            $novaQuantidade = $queryEstoque[0]['quantidade_est'];
            echo "Não há itens suficientes no estoque, temos: $novaQuantidade itens\n";
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
        echo "-=-=-=-=-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=\n";
        echo "|  ID  |       Nome      | Quantidade |\n";
        echo "-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-\n\n";

        while ($row = pg_fetch_assoc($ok)) {
            echo "| " . str_pad($row["id_est"], 4, " ", STR_PAD_LEFT) . " | ";
            echo str_pad(substr($row["nome_est"], 0, 18), 15, " ", STR_PAD_RIGHT) . " | ";
            echo str_pad($row["quantidade_est"], 10, " ", STR_PAD_RIGHT) . " |\n";
            echo "_______________________________________\n\n";
        }
        if (!$ok) {
            print("Falha ao tentar ler no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function lerEstoqueEspecifico($table, $id)
    {
        $ok = pg_query($this->connection, "SELECT * FROM $table WHERE id_est = $id");
        system('clear');
        echo "-=-=-=-=-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=\n";
        echo "|  ID  |       Nome      | Quantidade |\n";
        echo "-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-\n\n";

        while ($row = pg_fetch_assoc($ok)) {
            echo "| " . str_pad($row["id_est"], 4, " ", STR_PAD_LEFT) . " | ";
            echo str_pad(substr($row["nome_est"], 0, 18), 15, " ", STR_PAD_RIGHT) . " | ";
            echo str_pad($row["quantidade_est"], 10, " ", STR_PAD_RIGHT) . " |\n";
            echo "_______________________________________\n\n";
        }
        if (!$ok) {
            print("Falha ao tentar ler no banco de dados \n \n");

            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function lerMovimentacaoEspecifico($id)
    {
        $query = pg_query($this->connection, "SELECT * FROM movimentacao WHERE fkitemestoque_est = $id");
        $ok = pg_query($this->connection, "SELECT * FROM estoque WHERE id_est = $id");
        $queryMovimentacao = pg_fetch_all($query);
        $ok = pg_fetch_all($ok);

        $this->relatorioMovimentacaoEspecifico($id);
        echo "O item selecionado é: " . $ok[0]['nome_est'];

        if (!$query) {
            echo "Falha ao tentar ler no banco de dados\n\n";

            readline('Pressione qualquer tecla para continuar');
        }
        echo "\nDeseja exportar o relatório?\n[1] Não\n[2] Exportar relatório\nDigite sua opção:    ";
        $exportar = readline();
        if ($exportar == 2) {
            $this->csv($queryMovimentacao);
        } else {
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
    public function relatorioMovimentacaoEspecifico($id)
    {

        $selectOne = pg_query($this->connection, "SELECT * FROM movimentacao WHERE  id_mov= $id ");
        $select = pg_fetch_all($selectOne);

        echo "\033c";
        echo "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
        echo "|  ID  |  Tipo de Transação  |  Quantidade  |  Data              |\n";
        echo "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n\n";
        while ($row = pg_fetch_assoc($selectOne)) {
            echo "| " . str_pad($row["id_mov"], 4, " ", STR_PAD_LEFT) . " | ";
            echo str_pad(substr($row["tipotransacao_mov"], 0, 18), 10, " ", STR_PAD_RIGHT) . " | ";
            echo str_pad($row["quantidade_mov"], 12, " ", STR_PAD_LEFT) . " | ";
            echo str_pad($row["data_mov"], 20, " ", STR_PAD_RIGHT) . " |\n";
        }
        echo "\nDeseja exportar o relatório?\n[1] Não\n[2] Exportar relatório\nDigite sua opção:    ";
        $exportar = readline();
        if ($exportar == 2) {
            $this->csv($select);
        } else {
            readline('Pressione qualquer tecla para continuar');
        }

    }
    public function relatorioMovimentoData($id, $dataInicial, $dataFinal)
    {
        $selectOne = pg_query($this->connection, "SELECT * FROM movimentacao WHERE fkItemEstoque_est = '$id' AND data_mov BETWEEN '$dataInicial' AND '$dataFinal'");

        $selectOne = pg_fetch_all($selectOne);
        $this->relatorioMovimentacaoEspecifico($id);
        echo "\nDeseja exportar o relatório?\n[1] Não\n[2] Exportar relatório\nDigite sua opção:    ";
        $exportar = readline();
        if ($exportar == 2) {
            $this->csv($selectOne);
        } else {
            readline('Pressione qualquer tecla para continuar');
        }
    }
    public function csv($dados, $nomeArquivo = 'dados')
    {
        $arquivo = fopen($nomeArquivo . "(" . random_string(5) . ').csv', 'w');

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

    function random_string($length)
    {
        $rand_string = '';
        for ($i = 0; $i < $length; $i++) {
            $number = random_int(0, 36);
            $character = base_convert($number, 10, 36);
            $rand_string .= $character;
        }

        return $rand_string;
    }
}