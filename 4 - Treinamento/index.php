<?php

include_once('./db.php');

$db = new db();

$db->connect();
while (true) {

    echo "\n[1] Cadastro \n[2] Movimentação\n[3] Gerar relatório\nInsira: ";
    $selecionarMenu = readline();

    system('clear');

    switch ($selecionarMenu) {
        case 1:
            cadastrar($db);
            break;
        case 2:
            movimentacao($db);
            break;
        case 3:
            gerarRelatorio($db);
            break;
    }
}
function cadastrar($db)
{
    echo "-=-=-=-=-=-=-=-= Cadastrar produto -=-=-=-=-=-=-=-=\n";
    echo "Insira o nome:   ";
    $nome_est = readline();

    echo "Insira a quantidade: ";
    $quantidade_est = readline();

    $db->cadastrar('estoque', ['nome_est' => $nome_est, 'quantidade_est' => $quantidade_est]);
}
function movimentacao($db)
{
    system('clear');
    $db->lerEstoque('estoque');
    echo "Qual é o tipo da transação: \n[0] Entrada [1] Saída\nInsira:";
    $tipotransacao_mov = readline();
    if ($tipotransacao_mov == 1) {

        $tipotransacao_mov = "Saída";
    } else {
        $tipotransacao_mov = "Entrada";
    }
    $today = (date("Y-m-d"));
    echo "Insira qual item deseja: ";
    $fkItemEstoque_est = readline();

    echo "Insira a quantidade: ";
    $quantidade_mov = readline();
    $venda_mov = 0;

    $db->movimentar('movimentacao', ['tipotransacao_mov' => $tipotransacao_mov, 'data_mov' => $today, 'quantidade_mov' => $quantidade_mov, 'fkItemEstoque_est' => $fkItemEstoque_est], $fkItemEstoque_est);
}
function gerarRelatorio($db)
{
    echo "[1] Relatório geral do estoque \n[2] Relatório especifico do estoque\n[3] Relatório geral do movimento\n[4] Relatório movimento com data\nInsira: ";
    $selecionarMenu = readline();

    system('clear');

    switch ($selecionarMenu) {
        case 1:
            $db->relatorioTotal();
            break;
        case 2:
            $db->lerEstoque('estoque');
            echo "Insira o id: ";
            $id = readline();
            $db->relatorioEspecifico($id);
            break;
        case 3:
            $db->movimentoGeral();
            echo "Insira o id: ";
            $id = readline();
            $db->lerMovimentacaoEspecifico($id);
            break;
        case 4:
            $db->movimentoGeral();
            echo "Insira o id: ";
            $id = readline();
            echo "Data inicial: ";
            $dataInicial = readline();
            echo "Data final: ";
            $dataFinal = readline();

            $db->relatorioMovimentoData($id, $dataInicial, $dataFinal);
            break;
    }
}