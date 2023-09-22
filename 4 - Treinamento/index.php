<?php

include_once('./db.php');

$db = new db();

$db->connect();
while (true) {
    echo "\n[1] Cadastro \n[2] Movimentação\n[3] Gerar relatório\nInsira: ";
    $selecionarMenu = readline();

    system('clear');

    if ($selecionarMenu === '1' || $selecionarMenu === '2' || $selecionarMenu === '3') {
        switch ($selecionarMenu) {
            case '1':
                cadastrar($db);
                break;
            case '2':
                movimentacao($db);
                break;
            case '3':
                gerarRelatorio($db);
                break;
        }
    } else {
        echo "Entrada inválida. Insira apenas os valores 1, 2 ou 3.\n";
    }
}
function cadastrar($db)
{
    echo "-=-=-=-=-=-=-=-= Cadastrar produto -=-=-=-=-=-=-=-=\n";
    $nome_est = "";
    $quantidade_est = "";

    while (true) {
        echo "Insira o nome:   ";
        $nome_est = readline();

        if (ctype_alpha($nome_est)) {
            break;
        } else {
            echo "Erro: O nome deve conter apenas letras. Tente novamente.\n";
        }
    }
    while (true) {
        echo "Insira a quantidade: ";
        $quantidade_est = readline();

        if (ctype_digit($quantidade_est)) {
            $quantidade_est = intval($quantidade_est);
            break;
        } else {
            echo "Erro: A quantidade deve ser um número inteiro. Tente novamente.\n";
        }
    }

    $db->cadastrar('estoque', ['nome_est' => $nome_est, 'quantidade_est' => $quantidade_est]);
}
function movimentacao($db)
{
    while (true) {
        system('clear');
        $db->lerEstoque('estoque');

        $validInput = false;
        while (!$validInput) {
            echo "Qual é o tipo da transação: \n[0] Entrada [1] Saída [9] Voltar ao menu principal\nInsira:";
            $tipotransacao_mov = readline();

            if ($tipotransacao_mov === '0' || $tipotransacao_mov === '1' || $tipotransacao_mov === '9') {
                $validInput = true;
            } else {
                system('clear');
                $db->lerEstoque('estoque');
                echo "Entrada inválida. Apenas os valores 0, 1 ou 9 são permitidos.\n";
            }
        }

        if ($tipotransacao_mov === '9') {
            return; // Volta ao menu principal
        }

        $tipotransacao_mov = $tipotransacao_mov === '1' ? "Saída" : "Entrada";
        $today = (date("Y-m-d"));

        echo "Insira qual item deseja: ";
        $fkItemEstoque_est = readline();

        echo "Insira a quantidade: ";
        $quantidade_mov = readline();
        $venda_mov = 0;

        if (!is_numeric($fkItemEstoque_est) || !is_numeric($quantidade_mov)) {
            echo "Entrada inválida. Apenas números são permitidos.\n";
            return;
        }

        $db->movimentar('movimentacao', ['tipotransacao_mov' => $tipotransacao_mov, 'data_mov' => $today, 'quantidade_mov' => $quantidade_mov, 'fkItemEstoque_est' => $fkItemEstoque_est], $fkItemEstoque_est);
    }
}
function gerarRelatorio($db)
{
    while (true) {
        echo "[1] Relatório geral do estoque \n[2] Relatório especifico do estoque\n[3] Relatório geral do movimento\n[4] Relatório movimento com data\n[0] Voltar ao menu principal\nInsira: ";
        $selecionarMenu = readline();

        system('clear');

        switch ($selecionarMenu) {
            case 1:
                $db->relatorioTotal();
                break;
            case 2:
                $db->lerEstoque('estoque');
                $validInput = false;
                while (!$validInput) {
                    echo "Insira o id: ";
                    $id = readline();
                    if (is_numeric($id)) {
                        $validInput = true;
                    } else {
                        echo "Entrada inválida. Apenas números são permitidos.\n";
                    }
                }
                $db->relatorioEspecifico($id);
                break;
            case 3:
                $db->relatorioMovimentacao();
                break;
            case 4:
                $validInput = false;
                while (!$validInput) {
                    echo "Data inicial: ";
                    $dataInicial = readline();
                    echo "Data final: ";
                    $dataFinal = readline();
                    if (is_numeric($dataInicial) && is_numeric($dataFinal)) {
                        $validInput = true;
                    } else {
                        echo "Entrada inválida. Apenas números são permitidos.\n";
                    }
                }
                $db->relatorioMovimentoData($dataInicial, $dataFinal);
                break;
            case 0:
                return; // Volta ao menu principal
            default:
                echo "Opção inválida. Insira uma opção válida.\n";
        }
    }
}