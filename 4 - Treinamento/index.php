<?php
include_once('./db.php');

$db = new db();

// Testa a conexão com o banco de dados

$db->connect();
echo "[1] Cadastro \n[2] Estoque\n[3] Vender\nInsira: ";
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

    $today = (date("F j, Y, g:i a"));
    $db->cadastrar('estoque', ['nome_est' => $nome_est, 'quantidade_est' => $quantidade_est, 'data_ven' => $today]);

}
function vender($db)
{
    echo "Insira qual item deseja vender: ";
    $id_est = readline();

    echo "Insira a quantidade: ";
    $quantidade_est = readline();

    // echo "Insira o tipo de transaçao: ";
    // $tipo = readline();

    $db->atualizarEstoque(
        ['quantidade_est' => $quantidade_est],
        $id_est
    );
}
function lerDadosEstoque($db)
{
    $db->lerEstoque('estoque');

}

function lerDadoEspecifico($db)
{
    $db->lerEspecifico('nomeProduto_est', 'estoque');
}