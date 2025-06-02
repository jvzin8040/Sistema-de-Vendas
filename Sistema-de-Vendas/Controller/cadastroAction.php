<?php
session_start();
require_once('../Model/Pessoa.php');

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

$resultado = Pessoa::cadastrar($nome, $email, $telefone, $senha, $confirmar_senha);

if ($resultado['success']) {
    echo "<script>alert('{$resultado['message']}'); window.location.href='../View/pagina_login.php';</script>";
} else {
    echo "<script>alert('{$resultado['message']}'); window.location.href='../View/criar_conta.php';</script>";
}
?>