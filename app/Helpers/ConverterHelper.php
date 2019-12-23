<?php
use Carbon\Carbon;

//Datas
function converteDate($date)
{
    if ($date != '') {
        return Carbon::parse($date)->format('d/m/Y');
    } else {
        return '';
    }
}

function converteDateBD($date)
{
    if ($date != '') {
        $dia = substr($date, 0, 2);
        $mes = substr($date, 3, 2);
        $ano = substr($date, 6, 4);
        return $ano . '/' . $mes . '/' . $dia;
    } else {
        return '';
    }
}

function pegaDDDTelefoneOuCelular($tel)
{
    return substr($tel, 0, 2);
}

function pegaTelefoneOuCelularSemDDD($tel)
{
    return substr($tel, 2, 9);
}

function formatarCelular($tel)
{
    return "(" . substr($tel, 0, 2) . ") " . substr($tel, 2, -4) . "-" . substr($tel, -4);
}

function formatarCpf($cpf)
{
    return substr($cpf, 0, 3) . "." . substr($cpf, 3, -5) . "." . substr($cpf, -5, -2) . '-' . substr($cpf, -2);
}

function converteDataCompleta($date)
{
    if ($date != '') {
        return Carbon::parse($date)->format('d/m/Y H:i:s');
    } else {
        return '';
    }
}

function converteDateTimeBD($date, $tempo = null)
{
    if ($date != '') {
        if ($tempo != null) {
            $dia = substr($date, 0, 2);
            $mes = substr($date, 3, 2);
            $ano = substr($date, 6, 4);
            $segundo = '00';
            return $ano . '/' . $mes . '/' . $dia . ' ' . $tempo . ':' . $segundo;
        } else {
            $dia = substr($date, 0, 2);
            $mes = substr($date, 3, 2);
            $ano = substr($date, 6, 4);
            $hora = substr($date, 10, 2);
            $minuto = substr($date, 13, 2);
            $segundo = '00';
            return $ano . '/' . $mes . '/' . $dia . ' ' . $hora . ':' . $minuto . ':' . $segundo;
        }
    } else {
        return '';
    }
}
//Datas

function somenteNumeros($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}
