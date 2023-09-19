<?php
include_once('./db.php');

$db = new db();

// Testa a conexão com o banco de dados

$db->connect();
echo "[1] Cadastro \n[2] Estoque\n[3] Vender\n[4] Movimentação\nInsira: ";
$selecionarMenu = readline();

switch ($selecionarMenu) {
    case 1:
        cadastrar($db);
        break;
    case 2:
        lerDadosEstoque($db);
        break;
    case 3:
        vender($db);
        break;
    case 4:
        movimentacao($db);
        break;
    default:
        # code...
        break;
}
function cadastrar($db)
{
    echo "Insira o nome:   ";
    $nome_est = readline();

    echo "Insira a quantidade: ";
    $quantidade_est = readline();


    $db->cadastrar('estoque', ['nome_est' => $nome_est, 'quantidade_est' => $quantidade_est]);

}
function vender($db)
{
    echo "Insira qual item deseja vender: ";
    $id_est = readline();

    echo "Insira a quantidade: ";
    $quantidade_est = readline();

    $db->vender(
        ['quantidade_est' => $quantidade_est],
        $id_est
    );
}
function movimentacao($db)
{
    echo "Qual é o tipo da transação: \n[0] Entrada\n[1] Saída\nInsira:";
    $tipotransacao_mov = readline();
    if ($tipotransacao_mov == 1) {
        $tipotransacao_mov = "Saída";
    } else {
        $tipotransacao_mov = "Entrada";
    }

    $today = (date("F j, Y, g:i a"));

    echo "Insira a quantidade: ";
    $quantidade_mov = readline();
    $venda_mov = 0;
    echo "Insira qual item deseja: ";
    $fkItemEstoque_est = readline();
    $db->movimentar('movimentacao', ['tipotransacao_mov' => $tipotransacao_mov, 'data_mov' => $today, 'venda_mov' => $venda_mov, 'quantidade_mov' => $quantidade_mov, 'fkItemEstoque_est' => $fkItemEstoque_est], $fkItemEstoque_est);
}

function lerDadosEstoque($db)
{
    $db->lerEstoque('estoque');

}



function lerDadoEspecifico($db)
{
    $db->lerEspecifico('nomeProduto_est', 'estoque');
}