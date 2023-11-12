<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}
//Funcion que revisa que el usuario este autenticado
function estaAutenticado()
{
    if (!isset($_SESSION['login'])) {
        header("location:/");
    }
}

function esUltimo($actual, $proximo)
{
    if ($actual !== $proximo) {
        return true;
    } else {
        return false;
    }
}

function esAdmin()
{

    if (!isset($_SESSION['admin'])) {
        header('location: /');
    }
}
