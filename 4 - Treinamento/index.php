<?php 
include_once('./db.php');

$db = new db();

// Testa a conexão com o banco de dados

$db->connect();
echo "[1] Cadastro \n[2] Ler \n[3] Ler dado específico\nInsira: ";
$selecionarMenu = readline();

switch ($selecionarMenu) {
    case 1:
        cadastrar($db);
        break;
    case 2:
        lerDados($db);
        break;
    case 3:
        vender($db);
        break;
    default:
        # code...
        break;
}
function cadastrar($db){
    echo "Insira o nome do livro:   ";
    $nomeProduto_est = readline();
    
    echo "Insira a quantidade: ";
    $quantidade_est = readline();
    
    
    $db->cadastrar('estoque', ['nomeProduto_est' => $nomeProduto_est, 'quantidade_est' => $quantidade_est]);
    
}

function vender($db){
    $today = (date("F j, Y, g:i a"));
    $tipoMovimentacao_mov = "venda";
    $quantidade_mov = 10;
    $db->cadastrar('movimentacao', ['tipoMovimentacao_mov' => $tipoMovimentacao_mov, 'quantidade_mov' =>  $quantidade_mov, 'data_mov' => $today ]);
}
function lerDados($db){
    $db->ler('estoque');

}
function lerDadoEspecifico($db){
    $db->lerEspecifico('nomeProduto_est', 'estoque' );
}
