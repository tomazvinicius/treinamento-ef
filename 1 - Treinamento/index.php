<?php

if (!file_exists('data.json')) {
    $dados[] = [
        "pontuacao" => 800.03,
        "nome" => "default",
        "tempo" => "2.52",
    ];
    $json = json_encode($dados);
    $nomeArquivo = 'data.json';
    $arquivo = fopen($nomeArquivo, 'w');
    fwrite($arquivo, $json);
}

while (true) {
    $selecionar = readline("Escolha uma opção: [1] Game \n[2] Ranking \n [3] Sair: ");

    switch ($selecionar) {
        case 1:
            Game();
            break;
        case 2:
            Ranking();
            break;
        case 3:
            system('clear');
            break 2;
    }
}
function Game()
{
    system('clear');
    $pontuacaoMaxima = 1000;
    $pontuacao = 0;

    echo "-------------------------------JOGO DA ADIVINHAÇAO-------------------------------\n";

    do {
        $nome = readline("Qual seu nome: \n");
        system('clear');
        $timeInicial = microtime(true);
        $random = random_int(0, 100);
        for ($tentativa = 1; $tentativa <= 10; $tentativa++) {

            $valorTentativa = readline("\n $nome, tente adivinhar com valores entre 0 e 100:");

            if (!is_numeric($valorTentativa) || $valorTentativa < 0 || $valorTentativa > 100) {
                echo "Valor incorreto!\n";
                continue;
            } elseif ($valorTentativa < $random) {
                echo "Valor baixo, tente novamente: ";
                // echo "Valor sorteado " . $random . "\n"; // Ativar se precisar saber o random.

            } elseif ($valorTentativa > $random) {
                echo "Valor alto, tente novamente: ";

            } elseif ($random == $valorTentativa) {
                echo "\nVocê acertou! Número de tentativas $tentativa \n";
                $timeFinal = microtime(true);
                $timeTotal = number_format(($timeFinal - $timeInicial), 2);
                if ($tentativa < 3) {
                    $pontuacao = (($pontuacaoMaxima - 2) - $tentativa) - $timeTotal;
                } elseif ($tentativa >= 4 && $tentativa < 7) {
                    $pontuacao = (($pontuacaoMaxima - 8) - $tentativa) - $timeTotal;
                } else {
                    $pontuacao = (($pontuacaoMaxima - 10) - $tentativa) - $timeTotal;
                }
                break;
            }
        }
        $timeFinal = microtime(true);
        $timeTotal = number_format(($timeFinal - $timeInicial), 2);

        [$placar, $arquivo] = LerArquivo();

        $encontrado = false;
        $maiorPontuacao = null;

        foreach ($placar as &$data) {

            if ($data['pontuacao'] > $maiorPontuacao) {
                $maiorPontuacao = $data['pontuacao'];
            }

            if ($data['nome'] == $nome) {
                if ($data['pontuacao'] < $pontuacao) {
                    $data['pontuacao'] = $pontuacao;
                    echo "Você atingiu a sua maior pontuação: " . $data['pontuacao'] . "\n";
                }
                $encontrado = true;
            }
        }


        if ($pontuacao > $maiorPontuacao) {
            echo "Você atingiu a maior pontuação da maquina " . $pontuacao . "\n";
        } else
            echo "GAME OVER, a pontuação mais alta foi: " . $maiorPontuacao . " e a sua foi de: " . "$pontuacao" . "\n";
        echo "Tempo: " . $timeTotal . "\n";
        if (!$encontrado) {
            $placar[] = [
                'pontuacao' => $pontuacao,
                'nome' => $nome,
                'tempo' => $timeTotal,
            ];
        }
        $placarAtualizado = json_encode(($placar));
        $file = fopen($arquivo, 'w');
        fwrite($file, $placarAtualizado);
        $timeFinal = microtime(false);

        $verificacao = true;

        do {
            $jogarNovamente = readline("\nDeseja jogar novamente? Se sim, digite (S), caso contrario, digite (N) \n");
            if ($jogarNovamente == "S" || $jogarNovamente == "s") {
                $verificacao = true;
                break;
            } elseif ($jogarNovamente == "N" || $jogarNovamente == "n") {
                $verificacao = false;
                system('clear');
                break;
            } else {
                echo "Caracter inválido \n";
            }
            system('clear');
        } while (true);
        system('clear');
    } while ($verificacao);

}
function Ranking()
{
    system('clear');
    echo ("------------------------------- Ranking -------------------------------\n");
    $rankings = json_decode(file_get_contents('data.json'), true);

    if (is_null($rankings)) {
        $rankings[] = [
            "pontuacao" => 800.00,
            "nome" => "default",
            "tempo" => "2.52",
        ];
    }

    $placarAtualizado = json_encode(($rankings));
    $file = fopen('data.json', 'w');
    fwrite($file, $placarAtualizado);

    usort(
        $rankings,
        function ($a, $b) {
            $valor = $b['pontuacao'] - $a['pontuacao'];
            return $valor;
        }
    );
    foreach ($rankings as $ranking) {
        print_r("Nome: " . $ranking['nome'] . "\n" . "Pontuação: " . $ranking['pontuacao'] . " pontos" . "\n" . "Tempo: " . $ranking['tempo'] . "\n\n");
    }
}
function LerArquivo()
{
    $arquivo = 'data.json';
    $json = file_get_contents($arquivo);
    $placar = json_decode($json, true);

    if (is_null($placar)) {
        $placar[] = [
            "pontuacao" => 800.00,
            "nome" => "Vinicius",
            "tempo" => "2.52",
        ];
    }
    return [$placar, $arquivo];
}
