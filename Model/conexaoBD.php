<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "site_de_vendas";
$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Connection failed: " . $conexao->connect_error);
}
