<?php
session_start();
require_once('conexaoBD.php');

// Recebe os dados do formulário
$registro = $_POST['registro'] ?? '';
$senha = $_POST['senha'] ?? '';

// Verifica se campos estão preenchidos
if (empty($registro) || empty($senha)) {
    echo "<script>alert('Preencha todos os campos.'); window.location.href='../View/area_restrita.php';</script>";
    exit();
}

// Consulta segura com prepared statement
$stmt = $conexao->prepare("SELECT ID_funcionario, senha FROM Funcionario WHERE registro = ?");
$stmt->bind_param("s", $registro);
$stmt->execute();
$result = $stmt->get_result();
$linha = $result->fetch_assoc();

if ($linha && password_verify($senha, $linha['senha'])) {
    $_SESSION['registro_funcionario'] = $registro;
    $_SESSION['id_funcionario'] = $linha['ID_funcionario'];

    echo "<script>alert('Login realizado com sucesso!'); window.location.href='../View/cadastro.php';</script>";
} else {
    echo "<script>alert('Registro ou senha inválidos!'); window.location.href='../View/area_restrita.php';</script>";
}

$stmt->close();
$conexao->close();
?>
