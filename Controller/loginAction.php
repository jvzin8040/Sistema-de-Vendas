<?php
session_start();
require_once('conexaoBD.php');

$email = $_POST['txtEmail'];
$senha = $_POST['txtSenha'];

// Consulta com prepared statement
$stmt = $conexao->prepare("SELECT nome, senha FROM pessoa WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$linha = $result->fetch_assoc();

if ($linha && password_verify($senha, $linha['senha'])) {
    $_SESSION['logado'] = $email;
    $nome = $linha['nome'];
    echo "<script>alert('$nome, Seja Bem-Vindo(a)!'); window.location.href='../View/index.php';</script>";
} else {
    echo "<script>alert('Usuário ou senha inválidos!'); window.location.href='../View/pagina_login.php';</script>";
}

$stmt->close();
$conexao->close();
?>
