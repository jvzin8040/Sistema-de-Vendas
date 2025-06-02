<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: pagina_login.php");
    exit();
}

if (!isset($_SESSION['compra_pendente'])) {
    header("Location: index.php");
    exit();
}

require_once('../Model/conexaoBD.php');
$id_cliente = $_SESSION['id_cliente'];


$sql = "SELECT nome, sobrenome, cnpj FROM Pessoa WHERE ID_pessoa = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->bind_result($nome, $sobrenome, $cnpj);
$stmt->fetch();
$stmt->close();

$id_produto = $_SESSION['compra_pendente']['id_produto'];
$quantidade = $_SESSION['compra_pendente']['quantidade'];
$title = "EID Store";


$ufs = [
    "AC","AL","AP","AM","BA","CE","DF","ES","GO","MA","MT","MS","MG",
    "PA","PB","PR","PE","PI","RJ","RN","RS","RO","RR","SC","SP","SE","TO"
];