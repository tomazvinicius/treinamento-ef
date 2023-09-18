<?php
if (!file_exists('data.json')) {
    palavrasDefault();
}

while (true) {
    echo "[1] Jogo\n[2] Adicionar palavra\n[3] Sair\nSelecione a opção:";
    $selecionar = readline();

    switch ($selecionar) {
        case 1:
            jogo();
            system('clear');
            break;
        case 2:
            adicionarPalavra();
            break;
        case 3:
            system('clear');
            break 2;
        default:
            echo "Caracter inválido, digite novamente!\n";
    }
}

function jogo()
{
    $nomesFixos = ["Wanderley Andrade", "Robson", "Ronaldo Fênomeno", "Zé Fernando"];
    $nomesSingle = $nomesFixos[array_rand($nomesFixos)];
    $validacaoDoisJogadores = false;
    echo "\n[1]Singleplayer \n[2]Multiplayer\nSelecione a opção:";
    $doisJogadores = readline();
    $jogador = $nomesSingle;
    switch ($doisJogadores) {
        case 1:
            $jogador = readline("Digite seu nome: ");
            if (trim($jogador) == "") {
                $jogador = $nomesSingle;
                echo "Jogador, como você não colocou nenhum nome, colocamos um pra você!\n";
                sleep(2);
            }
            system('clear');
            break;
        case 2:
            $validacaoDoisJogadores = true;
            $jogadorUm = strtolower(readline("Jogador 1: Digite seu nome: "));
            $jogadorDois = strtolower(readline("Jogador 2: Digite seu nome: "));
            if (trim($jogadorUm) == "") {
                $jogadorUm = "Jogador um";
                echo "Jogador um, como você não colocou nenhum nome, colocamos um pra você!\n";
            }
            if (trim($jogadorDois) == "") {
                $jogadorDois = "Jogador dois";
                echo "Jogador dois, como você não colocou nenhum nome, colocamos um pra você!\n";
            }
            sleep(2);
            system('clear');
            break;
    }

    do {
        if ($validacaoDoisJogadores) {
            $tentativasJogadorUm = 7;
            $tentativasJogadorDois = 7;
            $jogador = $jogadorUm;
            $tentativas = $tentativasJogadorUm;
        } else {
            $tentativas = 7;
        }
        $letrasUtilizadas = [];
        $verificacao = true;

        $dados = lerArquivoJson();

        $posicaoPalavra = array_rand($dados);
        $palavraGerada = $dados[$posicaoPalavra];

        $palavraSelecionada = $palavraGerada[0];
        $dicaPalavraSelecionada = $palavraGerada[1];

        $palavraCaracterAcento = mb_str_split($palavraSelecionada);
        $palavraCaracterSemAcento = str_split(tirarAcentos($palavraSelecionada));

        $quantidadeCaracter = mb_strlen($palavraSelecionada, encoding: 'UTF-8');
        $palavraComMascara = [];

        foreach ($palavraCaracterSemAcento as $posicao => $palavra) {
            if ($palavra == ' ') {
                $palavraComMascara[$posicao] = ' ';
            } elseif ($palavra == '-') {
                $palavraComMascara[$posicao] = '-';
            } elseif ($palavra == ':') {
                $palavraComMascara[$posicao] = ':';
            } else {
                $palavraComMascara[$posicao] = '_';
            }
        }

        $letrasUtilizadas = [];
        system('clear');

        while ($tentativas > 0) {
            $perderVida = true;
            /**
             * print informações
             */
            system('clear');
            echo "Dica: $dicaPalavraSelecionada \n";
            echo "Palavra com: $quantidadeCaracter caracteres";
            echo "\n$jogador você possui: $tentativas tentativas\n";
            echo exibirPalavra($palavraComMascara) . "\n";
            desenho($tentativas);
            echo "Você já utilizou as seguintes letras: ";
            foreach ($letrasUtilizadas as $letras) {
                echo "$letras, ";
            }
            echo "\n";

            $letraJogador = strtolower(readline("$jogador, digite uma letra: "));

            /**
             * verificações
             */
            if (trim($letraJogador) == "" || strlen($letraJogador) > 1) {
                system('clear');
                echo "Letra inválida! \n";
                continue;
            }

            if (in_array($letraJogador, $letrasUtilizadas)) {
                system('clear');
                echo "Letra já informada\n";
                continue;
            }


            if (!in_array($letraJogador, $letrasUtilizadas)) {
                $letrasUtilizadas[] = $letraJogador;
            }

            do {
                if (in_array($letraJogador, $palavraCaracterSemAcento)) {
                    $posicaoLetra = array_search($letraJogador, $palavraCaracterSemAcento);
                    $palavraComMascara[$posicaoLetra] = $palavraCaracterAcento[$posicaoLetra];
                    unset($palavraCaracterSemAcento[$posicaoLetra]);
                    $perderVida = false;

                } else {
                    break;
                }
            } while (true);

            if ($perderVida == true) {
                if ($validacaoDoisJogadores) {
                    if ($jogador == $jogadorUm) {
                        echo $jogadorDois;
                        $tentativasJogadorUm--;
                        $jogador = $jogadorDois;
                        $tentativas = $tentativasJogadorDois;
                        system('clear');
                    } else {
                        $tentativasJogadorDois--;
                        $jogador = $jogadorUm;
                        $tentativas = $tentativasJogadorUm;
                        system('clear');
                    }
                } else {
                    $tentativas--;
                    system('clear');
                }
            }

            if (!in_array('_', $palavraComMascara)) {
                system('clear');
                echo "$jogador, você ganhou, a palavra realmente é: $palavraSelecionada \n";
                break;
            }
            if ($tentativas == 0) {
                echo "Você perdeu, a palavra era: $palavraSelecionada\n";
                sleep(3);
                system('clear');
            }
        }

        do {
            $jogarNovamente = strtolower(readline("\nDeseja jogar novamente? Se sim, digite (S), caso contrario, digite (N) \n"));
            if ($jogarNovamente == "s") {
                $verificacao = true;
                $palavraSelecionada = '';
                $palavraComMascara = [];
                system('clear');
                break;
            } elseif ($jogarNovamente == "n") {
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
function adicionarPalavra()
{
    palavrasDefault();
    system("clear");
    echo "Qual palavra deseja adicionar?\n";
    $palavra = strtolower(readline("\n"));
    if (trim($palavra) == "") {
        $palavra = "arroz com frango";
        echo "Adicionamos uma palavra pra você jogar! ";
    }
    echo "Adicione uma dica:\n";
    $dica = strtolower(readline("\n"));
    if (trim($dica) == "") {
        $dica = "comida";
        echo "E uma dica para a mesma palavra! ";
    }
    escreverArquivoJson([$dica, $palavra]);
    system('clear');
}
function exibirPalavra(array $palavra)
{
    $palavraReescrita = '';

    foreach ($palavra as $p) {
        $palavraReescrita .= $p;
    }

    return $palavraReescrita;
}
function tirarAcentos($palavraSelecionada)
{
    return
        preg_replace(
            array("/(á|à|ã|â|ä)/", "/(é|è|ê|ë)/", "/(í|ì|î|ï)/", "/(ó|ò|õ|ô|ö)/", "/(ú|ù|û|ü)/", "/ç/"),
            explode(" ", "a e i o u c"),
            $palavraSelecionada
        );
}
function desenho($vida)
{
    switch ($vida) {
        case 7:
            echo "  __    \n";
            echo "|/   |    \n";
            echo "|         \n";
            echo "|         \n";
            echo "|         \n";
            echo "|         \n";
            echo "|         \n";
            echo "|_____    \n";
            echo "          \n";
            break;
        case 6:
            echo " __     \n";
            echo "|/   |    \n";
            echo "|   (_)   \n";
            echo "|         \n";
            echo "|         \n";
            echo "|         \n";
            echo "|         \n";
            echo "|_____    \n";
            echo "          \n";
            break;
        case 5:
            echo "          \n";
            echo " __     \n";
            echo "|/   |    \n";
            echo "|   (_)   \n";
            echo "|    |    \n";
            echo "|    |    \n";
            echo "|         \n";
            echo "|         \n";
            echo "|_____    \n";
            break;
        case 4:
            echo " __     \n";
            echo "|/   |    \n";
            echo "|   (_)   \n";
            echo "|   \|    \n";
            echo "|    |    \n";
            echo "|         \n";
            echo "|         \n";
            echo "|_____    \n";
            break;
        case 3:
            echo " __     \n";
            echo "|/   |    \n";
            echo "|   (_)   \n";
            echo "|   \|/   \n";
            echo "|    |    \n";
            echo "|         \n";
            echo "|         \n";
            echo "|_____    \n";
            break;
        case 2:
            echo " __     \n";
            echo "|/   |    \n";
            echo "|   (_)   \n";
            echo "|   \|/   \n";
            echo "|    |    \n";
            echo "|   /     \n";
            echo "|         \n";
            echo "|_____    \n";
            break;
        case 1:
            echo " __     \n";
            echo "|/   |    \n";
            echo "|   (_)   \n";
            echo "|   \|/   \n";
            echo "|    |    \n";
            echo "|   / \   \n";
            echo "|         \n";
            echo "|_____    \n";
            break;
    }
}
function palavrasDefault()
{
    $palavra = [
        ["navio", "meio de transporte marítimo"],
        ["parque", "área de recreação ao ar livre"],
        ["bolo", "sobremesa"],
        ["rádio", "dispositivo de transmissão de áudio"],
        ["teatro", "local de apresentações ao vivo"],
        ["violino", "instrumento musical de cordas"],
        ["lago", "corpo d'água natural"],
        ["castelo", "estrutura histórica fortificada"],
        ["óculos", "dispositivo ótico para correção de visão"],
        ["calendário", "sistema de organização de tempo"],
        ["pintura", "forma de expressão artística"],
        ["natação", "atividade aquática"],
        ["helicóptero", "meio de transporte aéreo"],
        ["saxofone", "instrumento musical de sopro"],
        ["parque de diversões", "local de entretenimento"],
        ["internet", "rede global de comunicação"],
        ["legume", "alimento natural"],
        ["rio", "curso d'água natural"],
        ["primavera", "estação do ano"],
        ["deserto", "região árida"],
        ["guarda-chuva", "objeto para se proteger da chuva"],
        ["avião de caça", "aeronave militar"],
        ["banho-maria", "método de cozimento"],
        ["carteira de motorista", "documento de habilitação"],
        ["guarda-roupa", "móvel para guardar roupas"],
        ["bola de basquete", "equipamento esportivo"],
        ["livro de receitas", "guia de culinária"],
        ["fim de semana", "período de descanso"],
        ["mundo animal", "reino dos seres vivos"],
        ["guarda-flores", "suporte para flores"],
        ["arco-íris", "fenômeno óptico"],
        ["cavalo-marinho", "espécie marinha"],
        ["avião a jato", "aeronave de alta velocidade"],
        ["carrinho de mão", "ferramenta de jardinagem"],
        ["amor-perfeito", "flor ornamental"],
        ["gota-d'água", "pequena quantidade de água"],
        ["banho de sol", "exposição ao sol"],
        ["livro de história", "obra literária"],
        ["bola de neve", "brinquedo de inverno"],
        ["cachorro-quente", "tipo de lanche"],
        ["ninho de pássaro", "estrutura de aves"],
        ["coração partido", "sentimento de tristeza"],
        ["guarda-costas", "segurança pessoal"],
        ["cara a cara", "encontro direto"],
        ["abacaxi", "fruta"],
        ["banana", "fruta"],
        ["carro", "veículo"],
        ["elefante", "animal"],
        ["girassol", "planta"],
        ["computador", "dispositivo"],
        ["laranja", "fruta"],
        ["piano", "instrumento"],
        ["morango", "fruta"],
        ["amarelo", "cor"],
        ["inverno", "estação"],
        ["verão", "estação"],
        ["outono", "estação"],
        ["eletricidade", "energia"],
        ["laptop", "computador"],
        ["teclado", "periférico"],
        ["jardim", "espaço"],
        ["floresta", "ecossistema"],
        ["oceanos", "massa d'água"],
        ["camelo", "animal"],
        ["gazela", "animal"],
        ["peixe", "animal aquático"],
        ["cachorro", "animal"],
        ["gato", "animal"],
        ["papagaio", "ave"],
        ["mamute", "animal pré-histórico"],
        ["dinossauro", "animal pré-histórico"],
        ["leão", "animal"],
        ["tigre", "animal"],
        ["girafa", "animal"],
        ["crocodilo", "réptil"],
        ["iguana", "réptil"],
        ["macaco", "animal"],
        ["coruja", "ave noturna"],
        ["vaca", "animal"],
        ["cavalo", "animal"],
        ["zebra", "animal"],
        ["rã", "anfíbio"],
        ["peixe-palhaço", "peixe tropical"],
        ["beija-flor", "ave"],
        ["borboleta", "inseto"],
        ["abelha", "inseto"]
    ];

    file_put_contents('data.json', json_encode($palavra));
    lerArquivoJson();
    return $palavra;
}
function escreverArquivoJson($array)
{
    $palavras = lerArquivoJson();

    $palavras[] = $array;

    file_put_contents('data.json', json_encode($palavras));
}
function lerArquivoJson()
{
    $palavrasJson = file_get_contents('data.json');
    $dados = json_decode($palavrasJson, true);

    return $dados;
}
