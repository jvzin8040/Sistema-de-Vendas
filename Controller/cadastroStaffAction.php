<?php
session_start();
require_once('../Model/Funcionario.php');

$nome = $_POST['nome'];
$registro = $_POST['registro'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

$result = Funcionario::cadastrar($nome, $registro, $telefone, $senha, $confirmar_senha);

if ($result['success']) {
    echo "<script>alert('{$result['message']}'); window.location.href='../View/area_restrita.php';</script>";
} else {
    echo "<script>alert('{$result['message']}'); window.history.back();</script>";
}
?>