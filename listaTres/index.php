<?php
function maiorValor($a, $b)
{
    return $a > $b ? $a : $b;
}
function menorValor($a, $b)
{
    return $a < $b ? $a : $b;
}
function atividadeUm($array)
{
    $valorMaior = $array[0];
    foreach ($array as $valor) {

        if ($valor > $valorMaior) {
            $valorMaior = $valor;
        }
    }
    return $valorMaior;
}
function atividadeDois($array)
{
    $soma = 0;
    foreach ($array as $somando) {
        $soma += $somando;
    }
    echo "\n\nsaída: $soma\n\n";
    return $soma;
}
function atividadeTres($arrayUm, $arrayDois)
{
    $contUm = 0;
    $contDois = 0;
    foreach ($arrayUm as $valorUm) {
        $contUm++;
    }
    foreach ($arrayDois as $valorDois) {
        $contDois++;
    }
    $contMaior = maiorValor($contUm, $contDois);

    for ($i = 0; $i < $contMaior; $i++) {
        if ($i < $contUm) {
            $resultado[] = $arrayUm[$i];
        }
        if ($i < $contDois) {
            $resultado[] = $arrayDois[$i];
        }
    }
    return $resultado;
}
function atividadeQuatro($arrayUm, $arrayDois)
{
    $contUm = 0;
    $contDois = 0;
    foreach ($arrayUm as $posicao => $valorUm) {
        if ($valorUm == $arrayUm[$posicao]) {
            $contUm++;
        }
    }
    foreach ($arrayDois as $posicao => $valorDois) {
        if ($valorDois == $arrayDois[$posicao]) {
            $contDois++;
        }
    }
    $arrayMenor = $contUm > $contDois ? $contDois : $contUm;

    for ($i = 0; $i < $arrayMenor; $i++) {
        $resultado[$i] = $arrayDois[$i] . $arrayUm[$i];
    }
    return $resultado;
}
function atividadeCinco($array, $repeat = 200)
{
    if ($repeat == 0) {
        return $array;
    }

    $arrayUm = [];
    $arrayDois = [];

    foreach ($array as $v) {
        $randomizar = rand(0, 1);
        if ($randomizar == 0) {
            $arrayUm[] = $v;
        } else if ($randomizar == 1) {
            $arrayDois[] = $v;
        }
    }

    return atividadeCinco([...$arrayUm, ...$arrayDois], $repeat - 1);
}
function atividadeSeis($arrayAssociativo, $filtro)
{
    $resultado = [];

    foreach ($arrayAssociativo as $primeiroDado => $segundoDado) {
        foreach ($filtro as $dadosFiltro) {
            if ($primeiroDado === $dadosFiltro) {
                $resultado[$primeiroDado] = $segundoDado;
                break;
            }
        }
    }
    return $resultado;
}
function atividadeSete($array)
{

    $trocou = true;

    while ($trocou) {
        $trocou = false;
        $contador = 0;
        $tamanho = 0;
        foreach ($array as $valorUm) {
            $tamanho++;
        }
        foreach ($array as $chave => $valor) {


            if ($chave < $tamanho - 1 && $valor > $array[$chave + 1]) {
                $temp = $array[$chave];
                $array[$chave] = $array[$chave + 1];
                $array[$chave + 1] = $temp;
                $trocou = true;
            }
            $contador++;
        }
    }
    return $array;
}
function atividadeOito($array)
{


    $arraySemRepetir = [];

    foreach ($array as $valor) {
        $existe = false;
        foreach ($arraySemRepetir as $item) {
            if ($item === $valor) {
                $existe = true;
                break;
            }
        }
        if (!$existe) {
            $arraySemRepetir[] = $valor;
        }
    }

    return $arraySemRepetir;
}
function atividadeNove($array)
{
    $cont = 1;
    foreach ($array as $posicao => $valor) {
        $cont++;
    }

    foreach ($array as $posicao => $value) {
        $arrayResultado[] = $array[($cont - 1) - $posicao - 1];
        print_r($posicao);
    }
    return $arrayResultado;
}
function atividadeDez($array)
{
    $resultado = [];

    foreach ($array as $elemento) {
        if ((array) $elemento == $elemento) {
            $resultado = [...$resultado, ...atividadeDez($elemento)];
        } else {
            $resultado[] = $elemento;
        }
    }

    return $resultado;
}