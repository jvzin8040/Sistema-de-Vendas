<?php
session_start();
session_unset();
session_destroy();
session_start();
require_once('../Model/Funcionario.php');

$registro = $_POST['registro'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($registro) || empty($senha)) {
    echo "<script>alert('Preencha todos os campos.'); window.location.href='../View/area_restrita.php';</script>";
    exit();
}

$result = Funcionario::autenticar($registro, $senha);

if ($result['success']) {
    $_SESSION['registro_funcionario'] = $registro;
    $_SESSION['id_funcionario'] = $result['id_funcionario'];
    echo "<script>alert('Login realizado com sucesso!'); window.location.href='../View/painelGestor.php';</script>";
} else {
    echo "<script>alert('Registro ou senha inválidos!'); window.location.href='../View/area_restrita.php';</script>";
}
?>