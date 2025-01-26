<?php
header('Content-Type: text/html; charset=UTF-8');

$debug = true;
$server = 'localhost';
$user = 'root';
$pw = '';
$db = 'freemaker_soul';

define('SALT', '@#$7:d@erR_er€');

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

$conn = new mysqli($server, $user, $pw, $db);
if ($conn->connect_error) {
    if ($debug)
        die("Erro ao ligar ao servidor de base de dados!<br>Detalhes: $conn->connect_error");
    else {
        echo 'Erro ao tentar ligar ao servidor!';
        exit;
    }
}

$conn->set_charset("utf8");
session_start();


 